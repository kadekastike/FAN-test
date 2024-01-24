<?php

namespace App\Http\Controllers;

use App\Models\Epresence;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EpresenceController extends Controller
{

    public function createPresence(Request $request)
    {
        $data = $request->only( 'type', 'waktu');
        $data = $request->validate([
            'type' => 'required',
        ]);

        $numberOfIn = Epresence::where('waktu', '>', Carbon::now()->subDays(1))->where('type', 'IN')->count();
        $numberOfOut = Epresence::where('waktu', '>', Carbon::now()->subDays(1))->where('type', 'OUT')->count();
        if ($numberOfIn > 1 && $data['type'] == 'IN') {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah absen masuk.'
            ], 400);
        } else if ($numberOfOut > 1 && $data['type'] == 'OUT') {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah absen pulang.'
            ], 400);
        } else {
            $presence = Epresence::create([
                'id_user' => Auth::user()->id,
                'type' => $data['type'],
                'waktu' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            return response()->json([
                'type' => $presence->type,
                'waktu' => $presence->waktu
            ], 200);
        }
    }

    public function getPresence()
    {
        $data = Epresence::select(DB::raw('DATE(waktu) as tanggal'), 'id_user')->groupBy('tanggal', 'id_user')->get();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'maaf, data absensi tidak ditemukan.'
            ], 400);
        }

        $data = $data->map(function ($val) {

            $waktuMasuk = Epresence::where('type', 'IN')->where('id_user', $val->id_user)->get('waktu')[0]->waktu;
            $waktuPulang = Epresence::where('type', 'OUT')->where('id_user', $val->id_user)->get('waktu')[0]->waktu;
            $statusMasuk = Epresence::where('type', 'IN')->where('id_user', $val->id_user)->get('is_approve')[0]->is_approve;
            $statusPulang = Epresence::where('type', 'OUT')->where('id_user', $val->id_user)->get('is_approve')[0]->is_approve;

            return [
                'id_user' => $val->id_user,
                'nama_user' => User::find($val->id_user)->name,
                'tanggal' => date('Y-m-d', strtotime($val->tanggal)),
                'waktu_masuk' => date('H:i:s', strtotime($waktuMasuk)),
                'waktu_pulang' => date('H:i:s', strtotime($waktuPulang)),
                'status_masuk' => $statusMasuk ? "APPROVE" : "REJECT",
                'status_pulang' => $statusPulang ? "APPROVE" : "REJECT"
            ];
        });

        return response()->json([
            'message' => 'Success get data',
            'data' => $data
        ]);
    }

    public function approvePresence($id)
    {

        $id_user = Epresence::where('id', $id)->get('id_user');
        $npp_supervisor = User::find($id_user)[0]->npp_supervisor;

        if (Auth::user()->npp == $npp_supervisor) {

            $data = Epresence::find($id);
            $data->update(['is_approve' => TRUE]);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'maaf, data gagal diubah.'
                ], 400);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'data berhasil diubah'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'maaf, anda bukan supervisor untuk user ini.'
            ], 400);
        }
    }
    public function rejectPresence($id)
    {
        $id_user = Epresence::where('id', $id)->get('id_user');
        $npp_supervisor = User::find($id_user)[0]->npp_supervisor;

        if (Auth::user()->npp == $npp_supervisor) {

            $data = Epresence::find($id);
            $data->update(['is_approve' => FALSE]);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'maaf, data gagal diubah.'
                ], 400);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'data berhasil diubah'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'maaf, anda bukan supervisor untuk user ini.'
            ], 400);
        }
    }
}

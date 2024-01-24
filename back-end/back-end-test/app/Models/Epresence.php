<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epresence extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $connection = 'presence';
    protected $table = 'epresences';
    public $timestamps = false;

    public function users()
    {
        $this->belongsTo(User::class);
    }
}

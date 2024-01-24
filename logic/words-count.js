function countWord(words) {
    const specialCharacterRegex = /[^a-zA-Z-\-\.\,\?\']/
    let wordsSplit = words.split(/\s+/);
    
    let wordsCount = 0;

    for (word of wordsSplit) {
        if (!specialCharacterRegex.test(word)) {
            console.log(word)
            wordsCount++
        }
    }
    
    return wordsCount;
}

const firstWords = "Saat meng*ecat tembok, Agung dib_antu oleh Raihan."
const firstOutput = countWord(firstWords)
console.log('Output:', firstOutput)

const secondWords = "Berapa u(mur minimal[ untuk !mengurus ktp?"
const secondOutput = countWord(secondWords)
console.log('Output:', secondOutput)

const thirdWords = "Masing-masing anak mendap(atkan uang jajan ya=ng be&rbeda."
const thirdOutput = countWord(thirdWords)
console.log('Output:', thirdOutput)
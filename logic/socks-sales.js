function sockSales(socksData) {
    let output = 0
    let outputCount = []

    socksData.forEach(count => {
        if (count in outputCount) {
            outputCount[count]++
        } else {
            outputCount[count] = 1
        }
    });

    for (let count in outputCount) {
        output += Math.floor(outputCount[count] / 2)
    }

    return output
}

// first question
const firstSockData = [10, 20, 20, 10, 10, 30, 50, 10, 20];
let firstOutput = sockSales(firstSockData);
console.log("Output yang diharapkan:", firstOutput);

// second question
const secondSockData = [6, 5, 2, 3, 5, 2, 2, 1, 1, 5, 1, 3, 3, 3, 5]
let secondOutput = sockSales(secondSockData);
console.log("Output yang diharapkan:", secondOutput);

// third question
const thirdSockData = [1, 1, 3, 1, 2, 1, 3, 3, 3, 3]
let thirdOutput = sockSales(thirdSockData);
console.log("Output yang diharapkan:", thirdOutput);

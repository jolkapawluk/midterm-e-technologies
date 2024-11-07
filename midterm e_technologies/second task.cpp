#include <iostream>
#include <vector>
#include <cstdlib>
#include <ctime>

bool isEvenSumAndEvenLength(int number) {
    int sum = 0;
    int length = 0;
    int temp = number;

    // calculating the sum of digirs
    while (temp > 0) {
        sum += temp % 10; // adding last digit to the sum
        temp /= 10;       // removing last digit
        length++;        // extending the length of a number
    }

    // Check if the length is even and the sum is even
    return (length % 2 == 0) && (sum % 2 == 0);
}

int main() {
    std::srand(static_cast<unsigned int>(std::time(0))); 
    std::vector<int> numbers;

    // generating random digits
    for (int i = 0; i < 8; ++i) {
        int number = std::rand() % 90000 + 10000;
        if (number < 1000) {
            number += 1000;
        }
        numbers.push_back(number);
    }


    std::cout << "Your generated numbers are:\n";
    for (int num : numbers) {
        std::cout << num << std::endl;
    }

   
    std::cout << "\n Numbers with an even sum of digits and an even number of digits:\n";
    for (int num : numbers) {
        if (isEvenSumAndEvenLength(num)) {
            std::cout << num << std::endl;
        }
    }

    return 0;
}
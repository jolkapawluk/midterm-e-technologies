<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palindrome Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .error {
            color: rgb(0, 174, 255);
        }
    </style>
</head>
<body>

<h1>Check for Polindrome</h1>
<form id="palindromeForm">
    <label for="number">Put a number (3-5):</label><br>
    <input type="text" id="number" name="number" required>
    <span class="error" id="error-message"></span><br><br>
    <input type="submit" value="Check">
</form>

<p id="result"></p>

<script>
    document.getElementById('palindromeForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const numberInput = document.getElementById('number').value;
        const errorMessage = document.getElementById('error-message');
        const result = document.getElementById('result');

       //error message form
        errorMessage.textContent = '';
        result.textContent = '';

        // checking if there are any null values
        if (!numberInput) {
            errorMessage.textContent = 'Please fill in the form.';
            return;
        }

        // checking how many numbers are put
        if (numberInput.length < 3 || numberInput.length > 5 || isNaN(numberInput)) {
            errorMessage.textContent = 'The number has to have at least 3 to 5 digits';
            return;
        }

        // checking Polindromw
        const isPalindrome = numberInput === numberInput.split('').reverse().join('');
        if (isPalindrome) {
            result.textContent = `Your given number ${numberInput} is Polindromic.`;
        } else {
            result.textContent = `Your given number ${numberInput} is not Polindromic.`;
        }
    });
</script>

</body>
</html>

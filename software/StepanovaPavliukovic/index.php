<?php
require('config/database.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 200px;
            height: auto;

        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            width: 100%;
        }

        .button-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="src/logo_index.png" alt="logo">
    </div>
    <h1>Lupus Nexus</h1>
    <div class="button-container">
        <form action="login.php" method="GET">
            <button type="submit">Log In</button>
        </form>
    </div>
    <div class="button-container">
        <form action="create_user.php" method="GET">
            <button type="submit">Sign Up</button>
        </form>
    </div>

</body>

</html>
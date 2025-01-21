<?php
session_abort();
session_start();
require('config/database.php');
require_once("config/permission.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: left;
        }

        label {
            display: flex;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Log in to the system</h1>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Log in">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $sql = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
            $sql->bind_param("ss", $username, $password);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            if ($result->num_rows > 0) {
                header("Location: main.php");
                exit;
            } else {
                echo "<div class='error-message'>Incorrect username or password!</div>";
            }
        }
        ?>
        <input style="padding-top: 10px;" type="submit" value="Sign up" onclick="window.location.href='create_user.php';">
    </div>
</body>

</html>
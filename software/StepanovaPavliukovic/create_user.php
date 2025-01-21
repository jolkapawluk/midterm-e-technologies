<?php
require('config/database.php');
require_once("faculty_list.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #007BFF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group select {
            appearance: none;
            -webkit-appearance: none;
        }

        .form-container p {
            text-align: center;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>User Registration</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="faculty">Faculty:</label>
                <select name="faculty" id="faculty" required>
                    <option value="">Choose</option>
                    <?php
                    foreach ($faculty_list as $key => $value) {
                        echo "<option value='$value'>$value</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="create">Create</button>
        </form>

        <?php
        if (isset($_POST['create'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $faculty = $_POST['faculty'];
            $name = $_POST['name'];

            $stmt = $conn->prepare("INSERT INTO user(name, faculty, username, password) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $name, $faculty, $username, $password);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "<p style='color: green; text-align: center;'>User successfully created!</p>";
        }
        ?>
    </div>

</body>

</html>

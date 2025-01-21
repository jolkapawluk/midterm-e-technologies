<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007BFF;
            padding: 10px 20px;
            color: white;
        }

        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: white;
        }

        .navbar .logo img {
            width: 50px;
            height: auto;
        }

        .navbar .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .navbar .nav-buttons button {
            background-color: transparent;
            color: white;
            border: 2px solid transparent;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-size: large;
        }

        .navbar .nav-buttons button:hover {
            background-color: white;
            color: #007BFF;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar .nav-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <img src="src/logo.png" alt="logo">
        </div>

        <div class="nav-buttons">
            <button onclick="window.location.href='main.php';">Main</button>
            <button onclick="window.location.href='event_list.php';">All Events</button>
            <button onclick="window.location.href='event_search.php';">Search</button>
            <button onclick="window.location.href='create_event.php';">Create Event</button>
            <form action="" method="POST">
                <button type="submit" name="logout">Log out</button>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    ?>

</body>
</html>

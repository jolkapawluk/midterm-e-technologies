<?php
session_start();
require('config/database.php');
require_once("config/permission.php");
require_once("src/navbar.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];
    $event_current_places = 0;
    $event_maximum_places = $_POST['event_maximum_places'];
    $event_location = $_POST['event_location'];
    $event_tag = $_POST['event_tag'];
    $event_creator = $_SESSION['user_id'];

    if (isset($_FILES['event_photo']) && $_FILES['event_photo']['error'] == 0) {
        $file = $_FILES['event_photo'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($file_tmp);

        // VALIDATION FILE TYPE
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_file_name = uniqid() . '.' . $file_extension;

            $upload_dir = 'photos/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_path = $upload_dir . $new_file_name;

            // PHOTO TO SAVE
            if (move_uploaded_file($file_tmp, $file_path)) {
                $sql = $conn->prepare("INSERT INTO events(name, date, description, location, max_places, current_places, creator, photo, tag) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $sql->bind_param("ssssiiiss", $event_name, $event_date, $event_description, $event_location, $event_maximum_places, $event_current_places, $event_creator, $file_path, $event_tag);

                if ($sql->execute()) {
                    echo "<p>Event created successfully!</p>";
                } else {
                    echo "<p>Error creating event: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>Error uploading photo.</p>";
            }
        } else {
            echo "<p>Invalid file type. Only JPG, PNG, and GIF are allowed.</p>";
        }
    } else {
        echo "<p>No photo uploaded or error with the upload.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
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
            display: flex;
            text-align: left;
            padding: 20px;

            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="datetime-local"],
        input[type="number"],
        input[type="file"] {
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
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Create Event</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" required>

            <label for="event_date">Event Date:</label>
            <input type="datetime-local" name="event_date" required>

            <label for="event_description">Description:</label>
            <input type="text" name="event_description" required>

            <label for="event_tag">Event Tag:</label>
            <input type="text" name="event_tag" placeholder="Add a tag for the event">

            <label for="event_location">Location:</label>
            <input type="text" name="event_location">

            <label for="event_maximum_places">Maximum places:</label>
            <input type="number" name="event_maximum_places" required>

            <label for="event_photo">Event Photo:</label>
            <input type="file" name="event_photo" accept="image/*" required>

            <input type="submit" value="Create Event">
        </form>
    </div>
</body>

</html>
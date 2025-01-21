<?php
session_start();
require('config/database.php');
require_once("config/permission.php");
require_once("src/navbar.php");
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
        }

        h1 {
            text-align: center;
            color: #333; 
            font-size: 2.5em; 
            margin-bottom: 20px; 
        }

        .form-container {
            max-width: 500px; 
            margin: 0 auto; 
            padding: 20px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            background-color: #f9f9f9; 
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
        }

        input[type="text"] {
            width: 100%; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }

        #knopochka {
            background-color: #007BFF; 
            color: white; 
            border: none; 
            padding: 10px 15px; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 1em; 
            width: 100%; 
            transition: background-color 0.3s; 
        }

        #knopochka:hover {
            background-color: #0056b3; 
        }

        .search-result {
            margin-top: 20px; 
            text-align: center; 
            font-size: 1.2em; 
            color: #333;
        }

        .event-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .event-card h3 {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }

        .event-card p {
            margin: 5px 0;
        }

        .view-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
        }

        .view-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Search Event by Tag</h1>
    <div class="form-container">
        <form action="" method="POST">
            <input type="text" name="tag" placeholder="Enter tag to search events..." required>
            <button id="knopochka" type="submit">Search</button>
        </form>

        <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $tag = $_POST['tag'];
            echo "<p class='search-result'>You searched for events with tag: <strong>$tag</strong></p>";

            $sql = "SELECT id, name, date, description, location, photo FROM events WHERE tag LIKE ?";
            $stmt = $conn->prepare($sql);
            $searchTag = "%$tag%";
            $stmt->bind_param("s", $searchTag);
            $stmt->execute();
            $result = $stmt->get_result();

            $current_date = date('Y-m-d H:i:s');

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $event_date = strtotime($row['date']);
                    $current_date_time = strtotime($current_date);

                    echo "
                    <div class='event-card'>
                        <h3>" . htmlspecialchars($row['name']) . "</h3>
                        <p><strong>Date:</strong> " . date("d-m-Y H:i", strtotime($row['date'])) . "</p>
                        <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>
                        <p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>
                        <p><img src='" . htmlspecialchars($row['photo']) . "' alt='Event photo' style='width: 100px;'></p>
                    ";

                    if ($event_date >= $current_date_time) {
                        echo "<button class='view-button' onclick='window.location.href=\"event_details.php?id=" . $row['id'] . "\"'>View Event</button>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No events found for this tag.</p>";
            }
        }
        ?>
    </div>

</body>
</html>

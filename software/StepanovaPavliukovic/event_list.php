<?php
session_start();
require('config/database.php');
require_once("src/navbar.php");
require_once("config/permission.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
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
            margin-bottom: 30px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 60px;
            justify-items: center;
            padding-left: 30px;
            padding-right: 30px;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            height: 450px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            transition: transform 0.3s;
            width: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card h2 {
            font-size: 1.8em;
            color: #007BFF;
            margin: 10px 0;
        }

        .card p {
            margin: 5px 0;
            font-size: 1.1em;
            line-height: 1.6;
        }

        .card .places,
        .card .location {
            font-weight: bold;
        }

        .button-container {
            text-align: right;
            margin-top: auto;
        }

        #view_button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #view_button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 1200px) {
            .card-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <h1>Event List</h1>

    <div class="card-container">
        <?php
        $current_date = date('Y-m-d H:i:s');

        $sql = "SELECT events.id, events.name, events.date, events.description, events.photo, 
                events.max_places, events.current_places, events.location, events.tag,
                user.name as creator 
                FROM events
                INNER JOIN user ON events.creator = user.id
                WHERE events.date >= ? 
                ORDER BY events.date ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $current_date);
        $stmt->execute();
        $result = $stmt->get_result();

        foreach ($result as $value) {
            echo "<div class='card'>";
            echo "<img src='" . $value['photo'] . "' alt='Event photo'>";
            echo "<h2>" . $value['name'] . "</h2>";
            echo "<p><strong>Date & Time:</strong> " . date("d-m-Y", strtotime($value['date'])) . " at " . date("H:i", strtotime($value['date'])) . "</p>";
            echo "<p><strong>Description:</strong> " . $value['description'] . "</p>";
            echo "<p><strong>Creator:</strong> " . $value['creator'] . "</p>";
            echo "<p class='places'><strong>Places:</strong> " . $value['current_places'] . "/" . $value['max_places'] . "</p>";
            echo "<p class='location'><strong>Location:</strong> " . $value['location'] . "</p>";
            if (!empty($value['tag'])) {
                echo "<p><strong>Tag:</strong> " . $value['tag'] . "</p>";
            }
            echo "<div class='button-container'>"; 
            echo "<button type='button' id='view_button' onclick='window.location.href=\"event_details.php?id=" . $value['id'] . "\"'>View event</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>

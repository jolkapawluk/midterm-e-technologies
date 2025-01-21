<?php
session_start();
require('config/database.php');
require_once("config/permission.php");
require_once("src/navbar.php");

$event_id = $_GET['id'];

if (!isset($event_id)) {
    echo "<p>No event ID provided.</p>";
    exit;
}

$sql = "SELECT events.name, events.date, events.description, events.photo, events.creator, 
        events.max_places, events.current_places, events.location, events.tag,
        user.name as creator
        FROM events 
        INNER JOIN user ON events.creator = user.id 
        WHERE events.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Event not found.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST["name"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $datetime = DateTime::createFromFormat('d-m-Y H:i', $date . ' ' . $time);
    $formatted_datetime = $datetime->format('Y-m-d H:i');
    $location = $_POST["location"];
    $description = $_POST["description"];
    $max_places = $_POST["max_places"];
    $tag = $_POST["tag"];

    $update_sql = "UPDATE events SET name = ?, date = ?, description = ?, max_places = ?, location = ?, tag = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssissi", $name, $formatted_datetime, $description, $max_places, $location, $tag, $event_id);

    if ($stmt->execute()) {
        header("Location: event_details.php?id=$event_id");
        exit;
    } else {
        echo "<p>Error updating event: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 50%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .event-image {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }

        .event-details {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        .event-details p {
            margin: 0;
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Edit Event: <?php echo htmlspecialchars($row["name"]); ?></h1>

        <form action="event_edit.php?id=<?php echo $event_id; ?>" method="POST">

            <div class="form-group">
                <label for="name">Event Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="text" name="date" value="<?php echo date("d-m-Y", strtotime($row["date"])); ?>" required>
            </div>

            <div class="form-group">
                <label for="time">Time:</label>
                <input type="text" name="time" value="<?php echo date("H:i", strtotime($row["date"])); ?>" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" required value="<?php echo htmlspecialchars($row['description']); ?>">
            </div>

            <div class="form-group">
                <label for="tag">Tag:</label>
                <input type="text" name="tag" value="<?php echo htmlspecialchars($row['tag']); ?>">
            </div>

            <div class="form-group">
                <label for="max_places">Max Places:</label>
                <input type="number" name="max_places" value="<?php echo htmlspecialchars($row['max_places']); ?>" required>
            </div>

            <div class="form-group">
                <label for="current_places">Spots Left:</label>
                <input type="text" value="<?php echo $row['current_places'] . " / " . $row['max_places']; ?>" disabled>
            </div>

            <div class="form-actions">
                <button type="submit">Save Changes</button>
                <a href="event_details.php?id=<?php echo $event_id; ?>" style="text-decoration: none;">
                    <button type="button">Cancel</button>
                </a>
            </div>
        </form>
    </div>
</body>

</html>
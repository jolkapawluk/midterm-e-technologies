<?php
session_start();
require("config/database.php");
require_once("config/permission.php");
require_once("src/navbar.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, events_participating FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$events_participating = explode(',', $row['events_participating']);
$events_participating = array_filter($events_participating, function ($value) {
    return !empty($value);
});

$current_date = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupus Nexus</title>
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

        h2 {
            text-align: center;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 60px;
            justify-items: center;
            padding: 30px;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            height: 250px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            transition: transform 0.3s;
            width: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 1.8em;
            color: #007BFF;
            margin: 10px 0;
        }

        .card p {
            margin: 5px 0;
            font-size: 1.1em;
            line-height: 1.6;
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

    <h2>Welcome back, <?php echo htmlspecialchars($row['name']); ?></h2>

    <h2>Upcoming Events</h2>
    <div class="card-container">
        <?php
        foreach ($events_participating as $event_id) {
            $event_id = trim($event_id);
            $event_sql = "SELECT id, name, date, location, tag FROM events WHERE id = ? AND date >= ?";
            $event_stmt = $conn->prepare($event_sql);
            $event_stmt->bind_param("is", $event_id, $current_date);
            $event_stmt->execute();
            $event_result = $event_stmt->get_result();

            if ($event_row = $event_result->fetch_assoc()) {
                ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($event_row['name']); ?></h3>
                    <p><strong>Date and Time:</strong> <?php echo date("d-m-Y H:i", strtotime($event_row['date'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event_row['location']); ?></p>
                    <?php if (!empty($event_row['tag'])) : ?>
                        <p><strong>Tag:</strong> <?php echo htmlspecialchars($event_row['tag']); ?></p>
                    <?php endif; ?>
                    <div class="button-container">
                        <button type="button" id="view_button" onclick="window.location.href='event_details.php?id=<?php echo $event_row['id']; ?>'">View event</button>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>


    <h2>Past Events</h2>
    <div class="card-container">
        <?php
        foreach ($events_participating as $event_id) {
            $event_id = trim($event_id);

            $event_sql = "SELECT id, name, date, location, tag FROM events WHERE id = ? AND date < ?";
            $event_stmt = $conn->prepare($event_sql);
            $event_stmt->bind_param("is", $event_id, $current_date);
            $event_stmt->execute();
            $event_result = $event_stmt->get_result();

            if ($event_row = $event_result->fetch_assoc()) {
                ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($event_row['name']); ?></h3>
                    <p><strong>Date and Time:</strong> <?php echo date("d-m-Y H:i", strtotime($event_row['date'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event_row['location']); ?></p>
                    <?php if (!empty($event_row['tag'])) : ?>
                        <p><strong>Tag:</strong> <?php echo htmlspecialchars($event_row['tag']); ?></p>
                    <?php endif; ?>
                    <div class="button-container">
                        <button type="button" id="view_button" onclick="window.location.href='event_details.php?id=<?php echo $event_row['id']; ?>'">View event</button>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

</body>

</html>

<?php
session_start();
require('config/database.php');
require_once("config/permission.php");
require_once("src/navbar.php");


$user_id = $_SESSION['user_id'];
$event_id = $_GET['id'];
$sql = "SELECT events.name, events.date, events.description, events.photo, events.creator, 
        events.max_places, events.current_places, events.location, events.users_participating, events.tag,
        user.id as creator_id, user.name as creator, user.events_participating 
        FROM events 
        INNER JOIN user ON events.creator = user.id 
        WHERE events.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Buttons
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['attend_event'])) {
        $users_participating = explode(',', $row['users_participating'] ?? '');
        $user_events_participating = explode(',', $row['events_participating'] ?? '');

        if (!in_array($user_id, $users_participating)) {
            $users_participating[] = $user_id;
            $updated_users = implode(',', $users_participating);

            if (!in_array($event_id, $user_events_participating)) {
                $user_events_participating[] = $event_id;
                $updated_user_events = implode(',', $user_events_participating);

                $update_user_sql = "UPDATE user SET events_participating = ? WHERE id = ?";
                $update_user_stmt = $conn->prepare($update_user_sql);
                $update_user_stmt->bind_param("si", $updated_user_events, $user_id);
                $update_user_stmt->execute();
            }

            $update_sql = "UPDATE events SET users_participating = ?, current_places = current_places + 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $updated_users, $event_id);
            $update_stmt->execute();
        }
    }
    elseif (isset($_POST['cancel_event'])) {
        $users_participating = explode(',', $row['users_participating'] ?? '');
        $user_events_participating = explode(',', $row['events_participating'] ?? '');

        if (in_array($user_id, $users_participating)) {
            $users_participating = array_diff($users_participating, [$user_id]);
            $updated_users = implode(',', $users_participating);

            $user_events_participating = array_diff($user_events_participating, [$event_id]);
            $updated_user_events = implode(',', $user_events_participating);

            //USER
            $update_user_sql = "UPDATE user SET events_participating = ? WHERE id = ?";
            $update_user_stmt = $conn->prepare($update_user_sql);
            $update_user_stmt->bind_param("si", $updated_user_events, $user_id);
            $update_user_stmt->execute();

            //EVENTS
            $update_sql = "UPDATE events SET users_participating = ?, current_places = current_places - 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $updated_users, $event_id);
            $update_stmt->execute();
        }
    }

    header("Location: event_details.php?id=$event_id");
    exit;
}

$users_participating = explode(',', $row['users_participating'] ?? '');
$user_already_attending = in_array($user_id, $users_participating);
$creator = $row['creator_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row["name"]); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .event-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .button-group button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="event-container">
        <h1><?php echo htmlspecialchars($row["name"]); ?></h1>

        <img style="width:100%; height:100%;" src="<?php echo htmlspecialchars($row["photo"]); ?>" alt="Event photo">

        <p>The event will be held on <?php echo date("d-m-Y", strtotime($row["date"])); ?> at <?php echo date("H:i", strtotime($row["date"])); ?> in <?php echo htmlspecialchars($row["location"]); ?>.</p>

        <h2>What will be there?</h2>
        <p><?php echo htmlspecialchars($row["description"]); ?></p>
        <h3>Event Tag:</h3>
        <p><?php echo htmlspecialchars($row["tag"]); ?></p>
        <div>
            <strong>Spots left:</strong> <?php echo $row['max_places'] - $row['current_places'] . "/" . $row['max_places']; ?>
        </div>

        <div class="button-group">
            <form method="POST" action="">
                <button type="submit" name="attend_event" <?php echo $user_already_attending ? 'style="display:none;"' : ''; ?>>
                    I will be attending
                </button>
                <button type="submit" name="cancel_event" <?php echo !$user_already_attending ? 'style="display:none;"' : ''; ?>>
                    Cancel Participating
                </button>
            </form>

            <?php if ($user_id == $row['creator_id']) { ?>
                <form action="event_edit.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo $event_id; ?>">
                    <button type="submit" name="edit_event">Edit Event</button>
                </form>
            <?php } ?>

        </div>

        <p>Event held by: <?php echo htmlspecialchars($row["creator"]); ?></p>
    </div>
</body>

</html>

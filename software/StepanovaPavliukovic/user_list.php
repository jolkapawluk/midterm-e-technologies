<?php
require('config/database.php');
require_once("config/permission.php");
require_once("src/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <h1>User list</h1><br>
    <table>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Faculty</th>
        </tr>
        <?php
        $sql = "SELECT * FROM user";
        $result = $conn->query($sql);
        foreach ($result as $row => $value) {
            echo "<tr>";
            echo "<th>" . $value['name'] . "</th>";
            echo "<th>" . $value['username'] . "</th>";
            echo "<th>" . $value['faculty'] . "</th>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
</html>
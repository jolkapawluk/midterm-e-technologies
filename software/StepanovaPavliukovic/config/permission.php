<?php

if (!isset($_SESSION['user_id'])) {
    if (basename($_SERVER['REQUEST_URI']) != "index.php" && basename($_SERVER['REQUEST_URI']) != "login.php") {
        header("Location: login.php");
        exit();
    }
}

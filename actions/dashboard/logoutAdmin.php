<?php
    session_start();
    if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "admin") {
        header('Location: /im/actions/addon/hecker.php');
        exit;
    }
    session_destroy();
    header("Location: /im/index.php")

?>
<?php

require_once __DIR__ . '/../includes/security.php';

mysqli_report(MYSQLI_REPORT_OFF);

$localhost = "localhost";
$username = "root";
$password = "";
$database = "utang_system";

$conn = new mysqli($localhost, $username, $password, $database);

if ($conn->connect_error) {
    app_json_response([
        "success" => false,
        "message" => "Database connection failed. Please try again later."
    ], 500);
    exit;
}
?>

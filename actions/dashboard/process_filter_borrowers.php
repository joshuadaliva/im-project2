<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
require_once("../../database/config.php");

app_require_role('admin');
app_require_post();

$searchTerm = trim(strip_tags((string) filter_var($_POST['sex'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));

if ($searchTerm === "") {
    $stmt = $conn->prepare("SELECT borrower_id, name, sex, mobile_number, email FROM borrowers");
} else {
    $stmt = $conn->prepare("SELECT borrower_id, name, sex, mobile_number, email FROM borrowers WHERE LOWER(sex) = LOWER(?)");
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

$borrowers = [];
while ($row = $result->fetch_assoc()) {
    $borrowers[] = $row;
}

if (count($borrowers) > 0) {
    app_json_response(["success" => true, "message" => "borrowers found", "data" => $borrowers]);
} else {
    app_json_response(["success" => false, "message" => "no borrowers found", "data" => []]);
}
?>

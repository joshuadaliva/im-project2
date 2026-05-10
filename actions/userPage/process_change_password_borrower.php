<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
require_once("../../database/config.php");

app_require_role('borrower');
app_require_post();

$currentPassword = (string) ($_POST['current_password'] ?? '');
$newPassword = (string) ($_POST['new_password'] ?? '');
$confirmPassword = (string) ($_POST['confirm_password'] ?? '');

if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
    app_json_response(["success" => false, "message" => "All fields are required."], 400);
    exit;
}

if ($newPassword !== $confirmPassword) {
    app_json_response(["success" => false, "message" => "New password and confirm password do not match."], 400);
    exit;
}

$userId = (int) ($_SESSION['id'] ?? 0);
$stmt = $conn->prepare("SELECT password FROM borrowers WHERE borrower_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashedPassword);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($currentPassword, $hashedPassword)) {
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateStmt = $conn->prepare("UPDATE borrowers SET password = ? WHERE borrower_id = ?");
    $updateStmt->bind_param("si", $newPasswordHash, $userId);

    if ($updateStmt->execute()) {
        app_json_response(["success" => true, "message" => "password changed successfully"]);
    } else {
        app_json_response(["success" => false, "message" => "No changes made or an error occurred."], 500);
    }
    $updateStmt->close();
} else {
    app_json_response(["success" => false, "message" => "Current password is incorrect."], 400);
}

$stmt->close();
$conn->close();
?>

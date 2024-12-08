<?php
session_start();
if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "borrower") {
    header('Location: /im/actions/addon/hecker.php');
    exit;
}
require_once("../../database/config.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function sanitizerInt($data)
    {
        $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }
    function sanitizerString($data)
    {
        $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }

    $currentPassword = sanitizerString($_POST['current_password']);
    $newPassword = sanitizerString($_POST['new_password']);
    $confirmPassword = sanitizerString($_POST['confirm_password']);

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $res = [
            "success" => false,
            "message" => "All fields are required."
        ];
        echo json_encode($res);
    } elseif ($newPassword !== $confirmPassword) {
        $res = [
            "success" => false,
            "message" => "New password and confirm password do not match."
        ];
        echo json_encode($res);
    } else {
        $userId = sanitizerInt($_SESSION['id']);
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
            $updateStmt->execute();
            if ($updateStmt->affected_rows > 0) {
                $res = [
                    "success" => true,
                    "message" => "password changed successfully"
                ];
                echo json_encode($res);
            } else {
                $res = [
                    "success" => false,
                    "message" => "No changes made or an error occurred."
                ];
                echo json_encode($res);
            }
            $updateStmt->close();
        } else {
            $res = [
                "success" => false,
                "message" => "Current password is incorrect."
            ];
            echo json_encode($res);
        }

        $stmt->close();
    }
}

$conn->close();

?>
<?php
require_once("../../database/config.php");
session_start();
if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "admin") {
    header('Location: /im/actions/addon/hecker.php');
    exit;
}
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

    $loanId = sanitizerInt($_POST['loan_id']);
    $amount = sanitizerString($_POST['amount']);
    $startDate = sanitizerString($_POST['start_date']);
    $dueDate = sanitizerString($_POST['due_date']);
    $status = sanitizerString($_POST['status']);

    $stmt = $conn->prepare("UPDATE Loans SET amount = ?, start_date = ?, due_date = ?, status = ? WHERE loan_id = ?");
    $stmt->bind_param("ssssi", $amount, $startDate, $dueDate, $status, $loanId);
    if ($stmt->execute()) {
        $res = [
            "success" => true,
            "message" => "Loan updated successfully.",
        ];
        echo json_encode($res);
        exit;
    } else {
        $res = [
            "success" => false,
            "message" => "Error updating loan.",
        ];
        echo json_encode($res);
        exit;
    }
}
?>
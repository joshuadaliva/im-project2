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

    $loanId = sanitizerInt($_POST["loan_id"]);
    $stmt = $conn->prepare("DELETE FROM Loans WHERE loan_id = ? && admin_id = ?");
    $stmt->bind_param("ii", $loanId, $_SESSION["id"]);
    if ($stmt->execute()) {
        $res = [
            "success" => true,
            "message" => "Loan deleted successfully.",
        ];
        echo json_encode($res);
        exit;
    } else {
        $res = [
            "success" => false,
            "message" => "Loan not deleted.",
        ];
        echo json_encode($res);
        exit;
    }
}

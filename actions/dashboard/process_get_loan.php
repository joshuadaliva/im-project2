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

    $loanId = sanitizerInt($_POST['loan_id']);
    $stmt = $conn->prepare("SELECT * FROM Loans WHERE loan_id = ? && admin_id = ?");
    $stmt->bind_param("ii", $loanId, $_SESSION["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result -> num_rows > 0){
        $loanData = $result->fetch_assoc();
        $res = [
            "success" => true,
            "message" => "user found",
            "data" => $loanData
        ];
        echo json_encode($res);
        exit;
    }
    else{
        $res = [
            "success" => false,
            "message" => "user not found",
        ];
        echo json_encode($loanData);
        exit;
    }
}
?>
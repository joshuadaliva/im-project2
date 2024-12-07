<?php

    require_once("../../database/config.php");
    session_start();
    if($_SESSION["userType"] != "admin"){
        header("Location: /im/actions/addon/hecker.php");
        exit();
    }

    $checkBorrowerStmt = $conn->prepare("SELECT * FROM borrowers WHERE borrower_id = ?");
    $checkBorrowerStmt->bind_param("i", $_POST["borrower_id"]);
    $checkBorrowerStmt->execute();
    $borrowerResult = $checkBorrowerStmt->get_result();

    if ($borrowerResult->num_rows === 0) {
        $res = [
            "success" => false,
            "message" => "Borrower ID does not exist."
        ];
        echo json_encode($res);
        exit();
    }

    if (!empty($_POST["borrower_id"]) && !empty($_POST["amount"]) && !empty($_POST["start_date"]) && !empty($_POST["due_date"]) && !empty($_POST["status"])) {
        function sanitizerInt($data){
            $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
            $data = trim($data);
            $data = strip_tags($data);
            return $data;
        }
        function sanitizerString($data){
            $data = filter_var($data , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = trim($data);
            $data = strip_tags($data);
            return $data;
        }
    
        $borrower_id = $_POST["borrower_id"];
        $adminID = sanitizerInt($_SESSION["id"]);
        $amount = sanitizerInt($_POST["amount"]);
        $start_date = sanitizerString($_POST["start_date"]);
        $due_date = sanitizerString($_POST["due_date"]);
        $status = sanitizerString($_POST["status"]);

        $stmt = $conn -> prepare("INSERT INTO Loans(borrower_id, admin_id, amount, start_date, due_date, status) VALUES (?,?,?,?,?,?)");
        $stmt -> bind_param("iissss", $borrower_id, $adminID, $amount, $start_date, $due_date , $status);
        if($stmt -> execute()){
            $res = [
                "success" => true,
                "message" => "Loan added successfully"
            ];
            echo json_encode($res);
        }
        else{
            $res = [
                "success" => false,
                "message" => "Loan not added" . $stmt -> error
            ];
            echo json_encode($res);
        }

    }
    else{
        $res = [
            "success" => false,
            "message" => "Empty fields"
        ];
        echo json_encode($res);
    }

?>
<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
require_once("../../database/config.php");

app_require_role('admin');
app_require_post();

function sanitizerInt($data){
    return trim(strip_tags((string) filter_var($data, FILTER_SANITIZE_NUMBER_INT)));
}
function sanitizerString($data){
    return trim(strip_tags((string) filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
}

$borrower_id = (int) sanitizerInt($_POST["borrower_id"] ?? '');
$adminID = (int) sanitizerInt($_SESSION["id"] ?? '');
$amount = sanitizerInt($_POST["amount"] ?? '');
$start_date = sanitizerString($_POST["start_date"] ?? '');
$due_date = sanitizerString($_POST["due_date"] ?? '');
$status = sanitizerString($_POST["status"] ?? '');

if ($borrower_id <= 0 || $adminID <= 0 || $amount === '' || $start_date === '' || $due_date === '' || $status === '') {
    app_json_response(["success" => false, "message" => "Empty fields"], 400);
    exit;
}

$checkBorrowerStmt = $conn->prepare("SELECT borrower_id FROM borrowers WHERE borrower_id = ?");
$checkBorrowerStmt->bind_param("i", $borrower_id);
$checkBorrowerStmt->execute();
$borrowerResult = $checkBorrowerStmt->get_result();

if ($borrowerResult->num_rows === 0) {
    app_json_response(["success" => false, "message" => "Borrower ID does not exist."], 404);
    exit;
}

$stmt = $conn->prepare("INSERT INTO Loans(borrower_id, admin_id, amount, start_date, due_date, status) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("iissss", $borrower_id, $adminID, $amount, $start_date, $due_date, $status);

if ($stmt->execute()) {
    app_json_response(["success" => true, "message" => "Loan added successfully"]);
} else {
    app_json_response(["success" => false, "message" => "Loan not added"], 500);
}
?>

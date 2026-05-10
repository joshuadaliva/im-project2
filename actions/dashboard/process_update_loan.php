<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
require_once("../../database/config.php");

app_require_role('admin');
app_require_post();

function sanitizerString($data)
{
    return trim(strip_tags((string) filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
}

$loanId = (int) filter_var($_POST['loan_id'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
$amount = sanitizerString($_POST['amount'] ?? '');
$startDate = sanitizerString($_POST['start_date'] ?? '');
$dueDate = sanitizerString($_POST['due_date'] ?? '');
$status = sanitizerString($_POST['status'] ?? '');
$adminId = (int) ($_SESSION['id'] ?? 0);

if ($loanId <= 0 || $adminId <= 0 || $amount === '' || $startDate === '' || $dueDate === '' || $status === '') {
    app_json_response(["success" => false, "message" => "Invalid loan details."], 400);
    exit;
}

$stmt = $conn->prepare("UPDATE Loans SET amount = ?, start_date = ?, due_date = ?, status = ? WHERE loan_id = ? AND admin_id = ?");
$stmt->bind_param("ssssii", $amount, $startDate, $dueDate, $status, $loanId, $adminId);

if ($stmt->execute()) {
    app_json_response(["success" => true, "message" => "Loan updated successfully."]);
} else {
    app_json_response(["success" => false, "message" => "Error updating loan."], 500);
}
?>

<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
require_once("../../database/config.php");

app_require_role('admin');
app_require_post();

$loanId = (int) filter_var($_POST["loan_id"] ?? 0, FILTER_SANITIZE_NUMBER_INT);
$adminId = (int) ($_SESSION["id"] ?? 0);

if ($loanId <= 0 || $adminId <= 0) {
    app_json_response(["success" => false, "message" => "Invalid loan."], 400);
    exit;
}

$stmt = $conn->prepare("DELETE FROM Loans WHERE loan_id = ? AND admin_id = ?");
$stmt->bind_param("ii", $loanId, $adminId);

if ($stmt->execute()) {
    app_json_response(["success" => true, "message" => "Loan deleted successfully."]);
} else {
    app_json_response(["success" => false, "message" => "Loan not deleted."], 500);
}
?>

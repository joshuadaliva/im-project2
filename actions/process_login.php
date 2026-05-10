<?php
require_once __DIR__ . "/../includes/security.php";
app_secure_session_start();
require_once("../database/config.php");

app_require_post();

function sanitizerString($data){
    $data = filter_var($data , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $data = trim($data);
    $data = strip_tags($data);
    return $data;
}

$userType = sanitizerString($_POST["userType"] ?? '');
$email = sanitizerString($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password) || empty($userType)) {
    app_json_response(['success' => false, 'message' => 'Usertype, Email and password are required.']);
    exit;
}

if (!in_array($userType, ['borrower', 'admin'], true)) {
    app_json_response(['success' => false, 'message' => 'Invalid email or password.']);
    exit;
}

$table = $userType === 'borrower' ? 'borrowers' : 'admins';
$idColumn = $userType === 'borrower' ? 'borrower_id' : 'admin_id';
$location = $userType === 'borrower' ? 'userPage.php' : 'dashboard.php';

$stmt = $conn->prepare("SELECT {$idColumn}, password FROM {$table} WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION["userType"] = $userType;
        $_SESSION["id"] = $user[$idColumn];
        app_json_response(['success' => true, 'message' => 'Login successful!', 'location' => $location]);
    } else {
        app_json_response(['success' => false, 'message' => 'Invalid email or password.']);
    }
} else {
    app_json_response(['success' => false, 'message' => 'Invalid email or password.']);
}

$stmt->close();
$conn->close();
?>

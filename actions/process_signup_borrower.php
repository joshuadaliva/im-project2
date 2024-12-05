<?php


if (!empty($name) && !empty($gender) && !empty($mobile_number) && !empty($userType) && !empty($email) && !empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO borrowers (name, sex, mobile_number, email , password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $gender, $mobile_number, $email, $hashedPassword);

    if ($stmt->execute()) {
        $res = [
            'success' => true,
            'message' => "Signup successful! You can now log in."
        ];
        echo json_encode($res);
    } else {
        if ($stmt->errno === 1062) {
            $res = [
                'success' => false,
                'message' => "This email address is already registered. Please use a different email."
            ];
        } else {
            $res = [
                'success' => false,
                'message' => "An error occured."
            ];
        }
        echo json_encode($res);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => "Please fill all fields."]);
}


?>
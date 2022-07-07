<?php

include '../includes/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
            $user = json_decode(file_get_contents('php://input'));


            $firstName = $user->firstName;
            $lastName = $user->lastName;
            $email = $user->email;
            $hashed = password_hash($user->password, PASSWORD_DEFAULT);
        
            $stmt = $db->prepare("insert into users(firstName, lastName, email, password) values (?, ?, ?, ?);");
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashed);
            
            if($stmt->execute()) {
                $data = ['status' => 1, 'message' => "Record successfully created"];
            } else {
                $data = ['status' => 0, 'message' => "Failed to create record."];
            }
            echo json_encode($data);
            break;
}

?>
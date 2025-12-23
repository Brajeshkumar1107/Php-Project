<?php

function checkValidation($name, $email, $age, $gender)
{
    if (empty($name) || strlen($name) > 100) {
        echo json_encode(['error' => 'Name must be 1-100 characters']);
        exit;
    }

    if (!is_numeric($age) || $age < 0 || $age > 120) {
        echo json_encode(['error' => 'Age must be 0-120']);
        exit;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email address']);
        exit;
    }

    if (empty($gender)) {
        echo json_encode(['error' => 'Gender is required']);
        exit;
    }
}

?>
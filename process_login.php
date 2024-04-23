<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // validasi email dan password di sisi server
    if (validateEmail($email) && validatePassword($password)) {
        // cek email dan password benar (tentukan sendiri)
        if ($email == 'example@gmail.com' && $password == 'Password@123') {
            $_SESSION['email'] = $email;
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email or password is incorrect.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password format.']);
    }
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password)
{
    // validasi password
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSymbol = preg_match('/[!@#$%^&*()_+.-]/', $password);
    return $hasLowercase && $hasUppercase && $hasNumber && $hasSymbol && strlen($password) >= 8;
}

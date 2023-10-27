<?php
    function validate_register_form(mysqli $conn, string $email, string $username, string $password, string $confirm_password){
        $data_valid = true;
        $errors = [];

        if (strlen($email) > 256){
            $data_valid = false;
            $errors['email_error'] = "This email address is too long.";
        } else if(check_if_email_used($conn, $email)){
            $data_valid = false;
            $errors['email_error'] = "This email address is already used.";
        }

        if (strlen($username) > 25){
            $data_valid = false;
            $errors['username_error'] = "This username is too long (max 25 characters).";
        } else if(check_if_username_used($conn, $username)){
            $data_valid = false;
            $errors['username_error'] = "This username is already used.";
        }

        if (strlen($password) < 8){
            $data_valid = false;
            $errors['password_error'] = "This password is too short (min 8 characters).";
        }

        if ($password != $confirm_password){
            $data_valid = false;
            $errors['password_error'] = "Passwords needs to be identical.";
            $errors['confirm_password_error'] = "Passwords need to be identical.";
        }

        return ['success'=>$data_valid, 'errors'=>$errors];
    }
?>
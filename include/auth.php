<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/database.php');
    session_start();

    # Checks if user with provided email and password exists, if not returns -1
    function user_login(string $email, string $password){
        $conn = open_db_connection();
        $active_users_query = "SELECT * FROM users WHERE email = '{$email}' AND is_deleted = false";
        $users = mysqli_query($conn, $active_users_query);
        if (mysqli_num_rows($users) > 0)
            $user = mysqli_fetch_assoc($users);
            mysqli_close($conn);
            if (password_verify($password, $user['password'])){
                session_start();
                $_SESSION['logged'] = true;
                $_SESSION['logged_user'] = $user;
                header("Location: home.php");
                exit;
            }
        mysqli_close($conn);
        return -1;
    }

    # Checks if provided email address is available to use
    function check_if_email_used(mysqli $conn, string $email){
        $used_emails_query = "SELECT email FROM users WHERE is_deleted = false AND email = '{$email}'";
        $query_result = mysqli_query($conn, $used_emails_query);
        if (mysqli_num_rows($query_result) > 0)
            return true;
        return false;
    }

    # Checks if provided username is available to use
    function check_if_username_used(mysqli $conn, string $username){
        $used_usernames_query = "SELECT username FROM users WHERE is_deleted = false AND username = '{$username}'";
        $query_result = mysqli_query($conn, $used_usernames_query);
        if (mysqli_num_rows($query_result) > 0)
            return true;
        return false;
    }

    # Creates user in the database
    function create_user(string $username, string $email, string $password){
        $conn = open_db_connection();
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $insert_user = "INSERT INTO users (username, password, email) VALUES ('{$username}', '{$password_hash}', '{$email}')";
        mysqli_query($conn, $insert_user);
        mysqli_close($conn);
        user_login($email, $password);
    }

    # Validates data provided in register form
    function validate_register_form(string $email, string $username, string $password, string $confirm_password){
        $conn = open_db_connection();
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
        mysqli_close($conn);
        return ['success'=>$data_valid, 'errors'=>$errors];
    }
?>
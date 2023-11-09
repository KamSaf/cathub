<?php

    include($_SERVER['DOCUMENT_ROOT']. '/blog/include/utils.php');

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "cathubdb";
    $conn = "";

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    } catch(mysqli_sql_exception){
        show_database_error_modal();
    }

    # Checks if user with provided email and password exists, if not returns -1
    function user_login(mysqli $conn, string $email, string $password){
        $active_users_query = "SELECT * FROM users WHERE email = '{$email}' AND is_deleted = false";
        $users = mysqli_query($conn, $active_users_query);
        if (mysqli_num_rows($users) > 0)
            $user = mysqli_fetch_assoc($users);
            if (password_verify($password, $user['password'])){
                session_start();
                $_SESSION['logged'] = true;
                $_SESSION['logged_user'] = $user;
                header("Location: home.php");
                exit;
            }
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
    function create_user(mysqli $conn, string $username, string $email, string $password){
        echo "success!";
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $insert_user = "INSERT INTO users (username, password, email) VALUES ('{$username}', '{$password_hash}', '{$email}')";
        mysqli_query($conn, $insert_user);
        user_login($conn, $email, $password);
    }

    # Gets posts (either all posts or created by chosen user) from database
    function load_posts(mysqli $conn, string $user_id=null){
        if ($user_id)
            $posts_query = "SELECT * FROM posts WHERE is_deleted = false AND author_id = '{$user_id}' ORDER BY create_date DESC";
        else
            $posts_query = "SELECT * FROM posts WHERE is_deleted = false ORDER BY create_date DESC";
        return mysqli_query($conn, $posts_query);
    }

?>
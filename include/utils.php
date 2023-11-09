<?php
    # Validates data provided in register form
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

    # Displays error modal if there is no database connection
    function show_database_error_modal(){
        include($_SERVER['DOCUMENT_ROOT']. '/blog/include/html/database_error_modal.html');
    }

    # Displays provided post
    function display_post(array $post){
        echo "
            <div style='margin-bottom: 60px; background-color: #f8f9fa;' class='card text-center'>
                <div class='card-header'>
                    <h5 class='card-title'>{$post['title']}</h5>
                </div>
                <div class='card-body'>
                    <img src='{$post['image_url']}' alt='post_image' width='500' height='500'>
                    <p style='margin-top: 50px;' class='card-text'>{$post['description']}</p>
                    <span class='float-start'>
                        <a href='#' style='margin-right: 5px;' class='btn btn-sm btn-outline-success'>I like it! 😻</a>
                        <b>{$post['reactions']}</b>
                    </span>
                    <a href='#' class='btn btn-primary float-end'>Comment</a>
                </div>
                <div class='card-footer text-muted'>
                    Posted on: {$post['create_date']} by {$post['author_id']}
                </div>
            </div>
        ";
    }

    # Get user from database based on id
    function get_user_by_id(mysqli $conn, int $user_id){

    }

    # Checks if user reacted to a post
    function user_post_relation_exists(mysqli $conn, int $user_id, int $post_id){

    }

    ?>
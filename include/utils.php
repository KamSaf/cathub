<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/database.php');
    session_start();
    
    # Gets posts (either all posts or created by chosen user) from database
    function load_posts(string $user_id=null){
        $conn = open_db_connection();
        if ($user_id)
            $posts_query = "SELECT * FROM posts WHERE is_deleted = false AND author_id = '{$user_id}' ORDER BY create_date DESC";
        else
            $posts_query = "SELECT * FROM posts WHERE is_deleted = false ORDER BY create_date DESC";
        $posts = mysqli_query($conn, $posts_query);
        mysqli_close($conn);
        return $posts;
    }

    # Displays provided post
    function display_post(array $post){
        $conn = open_db_connection();
        $author = get_user_by_id($conn, $post['author_id']);
        $output = '';
        $output .= "
            <div id='post_{$post['id']}' style='margin-bottom: 60px; background-color: #f8f9fa;' class='card text-center'>
                <div class='card-header'>
                    <h5 class='card-title'>{$post['title']}</h5>
                </div>
                <div class='card-body'>
                    <img src='{$post['image_url']}' alt='post_image' width='500' height='310'>
                    <p style='margin-top: 50px;' class='card-text'>{$post['description']}</p>
                    <span class='float-start'>
        ";
        if($_SESSION['logged_user'] && user_post_reaction_exists($conn, $_SESSION['logged_user']['id'], $post['id'])){
            $output .= "<a href='#' style='margin-right: 5px;' class='btn btn-sm btn-success'>I like it! 😻</a>";
        } else{
            $output .= "<a href='#' style='margin-right: 5px;' class='btn btn-sm btn-outline-success'>I like it! 😻</a>";
        }
        $output .= "
                        <b>{$post['reactions']}</b>
                    </span>
                    <a href='#' class='btn btn-primary float-end'>Comments</a>
                </div>
                <div class='card-footer text-muted'>
            ";
        if($_SESSION['logged_user'] && ($_SESSION['logged_user']['id'] === $author['id'] || $_SESSION['logged_user']['is_admin']))
            $output .= "
                <a class='btn btn-danger btn-sm float-start delete-post-button' data-post-id='{$post['id']}'>Delete post</a>
                <a style='margin-left: 15px;' href='new_post.php?post_id={$post['id']}' class='btn btn-secondary btn-sm float-start' data-post-id='{$post['id']}'>Edit post</a>
                ";
        $output .= "
                    Posted on: {$post['create_date']} by <a href='user_posts.php?user={$author['id']}'>{$author['username']}</a>
                </div>
            </div>
        ";
        mysqli_close($conn);
        echo $output;
    }

    # Get user from database based on id
    function get_user_by_id(mysqli $conn, string $user_id){
        $user_query = "SELECT * FROM  users WHERE id = '{$user_id}' AND is_deleted = false";
        $query_result = mysqli_query($conn, $user_query);
        if (mysqli_num_rows($query_result) > 0)
            return mysqli_fetch_assoc($query_result);
        return null;
    }

    # Get post from database based on id
    function get_post_by_id(mysqli $conn, string $post_id){
        $post_query = "SELECT * FROM  posts WHERE id = '{$post_id}' AND is_deleted = false";
        $query_result = mysqli_query($conn, $post_query);
        if (mysqli_num_rows($query_result) > 0)
            return mysqli_fetch_assoc($query_result);
        return null;
    }

    # Checks if user reacted to a post, if yes returns true
    function user_post_reaction_exists(mysqli $conn, string $user_id, string $post_id){
        $user_post_reaction_query = "SELECT * FROM  post_user_reaction WHERE user_id = '{$user_id}' AND post_id = '{$post_id}'";
        $query_result = mysqli_query($conn, $user_post_reaction_query);
        if (mysqli_num_rows($query_result) > 0)
            return true;
        return false;
    }

    # Validates data entered by user when creating new post
    function validate_post_data(string $post_title, string $post_description){
        if(strlen($post_title) > 100)
            return false;
        else if(strlen($post_description) > 500)
            return false;
        return true;
    }

    # Saves uploaded image to /media/images, returns url to saved image
    function save_image(){
        if (isset($_POST["submit"])) {
            $target_dir = "/cathub/media/images/";
            $image_file_type = strtolower(pathinfo($_FILES["post_image"]["name"], PATHINFO_EXTENSION));
            $new_file_name = uniqid() . "." . $image_file_type;
            $target_file = $_SERVER['DOCUMENT_ROOT']. $target_dir . $new_file_name;

            if (isset($_FILES["post_image"]) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
                if (exif_imagetype($_FILES["post_image"]["tmp_name"])){
                    move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file);
                    return $target_dir. $new_file_name;               
                }
            }
        }
        return null;
    }

    # Creates new post
    function create_post(string $post_title, string $post_description){
        $conn = open_db_connection();
        $user_id = (int)$_SESSION['logged_user']['id'];
        $image_url = save_image();
        if ($user_id){
            if ($image_url){
                $insert_post = "INSERT INTO posts (author_id, title, description, image_url) VALUES ('{$user_id}', '{$post_title}', '{$post_description}', '{$image_url}')";
            }
            else{
                $insert_post = "INSERT INTO posts (author_id, title, description) VALUES ('{$user_id}', '{$post_title}', '{$post_description}')";    
            }
            mysqli_query($conn, $insert_post);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else{
            show_not_authorised_error_modal();
        }
    }

    # Edits post
    function edit_post(string $post_title, string $post_description, string $old_post_id){
        $conn = open_db_connection();
        $user_id = (int)$_SESSION['logged_user']['id'];
        $image_url = save_image();
        if ($user_id){
            if ($image_url){
                $update_post = "UPDATE posts SET title = '{$post_title}', description = '{$post_description}', image_url = '{$image_url}' WHERE id = {$old_post_id}"; 
            }
            else{
                $update_post = "UPDATE posts SET title = '{$post_title}', description = '{$post_description}', image_url = '' WHERE id = {$old_post_id}";    
            }
            mysqli_query($conn, $update_post);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else{
            show_not_authorised_error_modal();
        }
    }

    # Shows modal when user tries to upload file in wrong format
    function show_file_format_error_modal(){
        include($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/file_format_error_modal.html');
    }

    # Shows modal when not user has no permission to perform an action
    function show_not_authorised_error_modal(){
        include($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/no_permission_modal.html');
    }

?>
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

    # Gets comments for chosen post from database
    function load_comments(string $post_id){
        $conn = open_db_connection();
        $comments_query = "SELECT * FROM comments WHERE post_id = '{$post_id}' ORDER BY comment_date DESC";
        $comments = mysqli_query($conn, $comments_query);
        mysqli_close($conn);
        return $comments;
    }

    # Returns comment in nice template
    function comment_template(array $comment, mysqli $conn){
        $author = get_user_by_id($conn, $comment['author_id']);

        $comments_output = "
            <span id='comment_{$comment['id']}' style='border'>
                <b class='float-start'><a href='user_posts.php?user={$author['id']}'>{$author['username']}</a> on {$comment['comment_date']}</b>
        ";

        if ($_SESSION['logged_user']['id'] === $author['id'] || $_SESSION['logged_user']['is_admin'])
            $comments_output .= "<button class='btn btn-danger float-start delete-comment-button' style='margin-left: 10px; padding: 0.25rem 0.25rem; font-size: 0.520rem;' data-comment-id='{$comment['id']}'>Delete</button>";

        $comments_output .= "
                </br>
                <p class='float-start'>{$comment['content']}</p>
            </span>
        ";

        return $comments_output;
    }

    # Displays provided post
    function display_post(array $post){
        $conn = open_db_connection();
        $author = get_user_by_id($conn, $post['author_id']);
        $comments = load_comments($post['id']);
        $self_url = htmlspecialchars($_SERVER["PHP_SELF"]);

        $output = '';
        $output .= "
            <div id='post_{$post['id']}' style='margin-bottom: 60px; background-color: #f8f9fa;' class='card text-center'>
                <div class='card-header'>
                    <h5 class='card-title'>{$post['title']}</h5>
                </div>
                <div class='card-body'>
        ";
        if ($post['image_url']){
            $output .= "
                <img src='{$post['image_url']}' alt='post_image' width='500' height='310'>
                <p style='margin-top: 50px;' class='card-text'>{$post['description']}</p>
                <span class='float-start'>
            ";
        } else {
            $output .= "
                <p style='margin-top: 50px;' class='card-text'>{$post['description']}</p>
                <span class='float-start'>
            ";
        }

        if($_SESSION['logged_user'] && user_post_reaction_exists($conn, $_SESSION['logged_user']['id'], $post['id'])){
            $output .= "<a style='margin-right: 5px;' class='btn btn-sm btn-success react-button' data-post-id='{$post['id']}'>I like it! 😻</a>";
        } else if($_SESSION['logged']){
            $output .= "<a style='margin-right: 5px;' class='btn btn-sm btn-outline-success react-button' data-post-id='{$post['id']}'>I like it! 😻</a>";
        } else{
            $output .= "<a style='margin-right: 5px;' class='btn btn-sm btn-outline-success disabled' data-post-id='{$post['id']}' >I like it! 😻</a>";
        }

        $output .= "
                    <b id='reactions_{$post['id']}'>{$post['reactions']}</b>
                </span>
                <button type='button' data-bs-toggle='collapse' data-bs-target='#comments_{$post['id']}' aria-expanded='false' aria-controls='comments_{$post['id']}' class='btn btn-primary float-end'>Comments</button>
            </div>
            <div class='card-footer text-muted'>
        ";

        if($_SESSION['logged_user'] && ($_SESSION['logged_user']['id'] === $author['id'] || $_SESSION['logged_user']['is_admin'])){
            $output .= "
                <a class='btn btn-danger btn-sm float-start delete-post-button' data-post-id='{$post['id']}'>Delete post</a>
                <a style='margin-left: 15px;' href='new_post.php?post_id={$post['id']}' class='btn btn-secondary btn-sm float-start' data-post-id='{$post['id']}'>Edit post</a>
            ";
        }

        $output .= "
                    Posted on: {$post['create_date']} by <a href='user_posts.php?user={$author['id']}'>{$author['username']}</a>
                </div>
                <div class='collapse' id='comments_{$post['id']}'>
                    <div class='card card-body'>
        ";
        if($_SESSION['logged']){
            $output .= "

                    <div class='container text-center'>
                        <button style='margin-top: 5px; margin-bottom: 20px; width: 30%;' class='btn btn-primary btn-sm' type='button' data-bs-toggle='collapse' data-bs-target='#comment_box_{$post['id']}' aria-expanded='false' aria-controls='comment_box_{$post['id']}'>
                            Comment
                            <i class='bi bi-pencil-square'></i>
                        </button>
                    </div>
                <div style='margin-bottom: 20px;' class='collapse' id='comment_box_{$post['id']}'>
                    <div class='card card-body'>
                    <form action='{$self_url}' method='POST' enctype='multipart/form-data'>
                        <input type='hidden' name='post_id' value='{$post['id']}'>
                        <textarea name='comment_content' type='text' maxlength='150' cols='50' rows='5' required></textarea></br>
                        <button name='publish' style='margin-top: 15px; margin-bottom: 15px;' class='btn btn-secondary' type='submit'>Publish</button>
                    </form>
                    </div>
                </div>
            ";
        }

        if ($comments && mysqli_num_rows($comments) > 0) {
            while ($comment = mysqli_fetch_assoc($comments)) {
                $output .= comment_template($comment, $conn);
            }  
        }

        $output .= "
            </div>
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

    # Get comment from database based on id
    function get_comment_by_id(mysqli $conn, string $comment_id){
        $comment_query = "SELECT * FROM  comments WHERE id = '{$comment_id}'";
        $query_result = mysqli_query($conn, $comment_query);
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
        if (isset($_POST["add"]) || isset($_POST["edit"])) {
            $target_dir = "/cathub/media/images/";
            $image_file_type = strtolower(pathinfo($_FILES["post_image"]["name"], PATHINFO_EXTENSION));
            $new_file_name = uniqid() . "." . $image_file_type;
            $target_file = $_SERVER['DOCUMENT_ROOT']. $target_dir . $new_file_name;
            if (isset($_FILES["post_image"])) {
                if ($_FILES["post_image"]["tmp_name"] && exif_imagetype($_FILES["post_image"]["tmp_name"])){
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
        mysqli_close($conn);
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
        mysqli_close($conn);
    }

    # Creates new comment
    function create_comment(string $content, string $post_id){
        $conn = open_db_connection();
        $user_id = $_SESSION['logged_user']['id'];
        if ($user_id){
            $insert_comment = "INSERT INTO comments (author_id, post_id, content) VALUES ('{$user_id}', '{$post_id}', '{$content}')";    
            mysqli_query($conn, $insert_comment);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else{
            show_not_authorised_error_modal();
        }
        mysqli_close($conn);
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
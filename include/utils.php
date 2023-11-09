<?php

    # Gets posts (either all posts or created by chosen user) from database
    function load_posts(mysqli $conn, string $user_id=null){
        if ($user_id)
            $posts_query = "SELECT * FROM posts WHERE is_deleted = false AND author_id = '{$user_id}' ORDER BY create_date DESC";
        else
            $posts_query = "SELECT * FROM posts WHERE is_deleted = false ORDER BY create_date DESC";
        return mysqli_query($conn, $posts_query);
    }

    # Displays provided post
    function display_post(array $post, mysqli $conn){
        $author = get_user_by_id($conn, $post['author_id']);
        echo "
            <div style='margin-bottom: 60px; background-color: #f8f9fa;' class='card text-center'>
                <div class='card-header'>
                    <h5 class='card-title'>{$post['title']}</h5>
                </div>
                <div class='card-body'>
                    <img src='{$post['image_url']}' alt='post_image' width='500' height='310'>
                    <p style='margin-top: 50px;' class='card-text'>{$post['description']}</p>
                    <span class='float-start'>
        ";
        if(user_post_reaction_exists($conn, $post['author_id'], $post['id'])){
            echo "<a href='#' style='margin-right: 5px;' class='btn btn-sm btn-success'>I like it! 😻</a>";
        } else{
            echo "<a href='#' style='margin-right: 5px;' class='btn btn-sm btn-outline-success'>I like it! 😻</a>";
        }
        echo "
                        
                        <b>{$post['reactions']}</b>
                    </span>
                    <a href='#' class='btn btn-primary float-end'>Comments</a>
                </div>
                <div class='card-footer text-muted'>
                    Posted on: {$post['create_date']} by <a href='#'>{$author['username']}</a>
                </div>
            </div>
        ";
    }

    # Get user from database based on id
    function get_user_by_id(mysqli $conn, string $user_id){
        $user_query = "SELECT * FROM  users WHERE id = '{$user_id}' AND is_deleted = false";
        $query_result = mysqli_query($conn, $user_query);
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

    ?>
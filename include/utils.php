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
        echo "
            <div style='margin-bottom: 60px; background-color: #f8f9fa;' class='card text-center'>
                <div class='card-header'>
                    <h5 class='card-title'>{$post['title']}</h5>
                </div>
                <div class='card-body'>
                    <img src='{$post['image_url']}' alt='post_image' width='500' height='500'>
                    <p style='margin-top: 50px;' class='card-text'>{$post['description']}</p>
                    <span class='float-start'>
        ";
        if(user_post_relation_exists($conn, $post['author_id'], $post['id'])){
            echo "<a href='#' style='margin-right: 5px;' class='btn btn-sm btn-success'>I like it! 😻</a>";
        } else{
            echo "<a href='#' style='margin-right: 5px;' class='btn btn-sm btn-outline-success'>I like it! 😻</a>";
        }
        echo "
                        
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

    # Checks if user reacted to a post, if yes returns true
    function user_post_relation_exists(mysqli $conn, int $user_id, int $post_id){

    }

    ?>
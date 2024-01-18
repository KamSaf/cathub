<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $comment_content = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_SPECIAL_CHARS);
        $post_id = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_SPECIAL_CHARS);
        if (strlen($comment_content) <= 150){
            create_comment($comment_content, $post_id);
        }
    }
?>
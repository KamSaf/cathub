<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    session_start();
    $post_id = $_GET['postId'] ? $_GET['postId'] : null;

    if (isset($post_id)){
        $conn = open_db_connection();
        $comments = load_comments($post_id);

        if ($comments && mysqli_num_rows($comments) > 0) {
            while ($comment = mysqli_fetch_assoc($comments)) {
                $output .= comment_template($comment, $conn);
            }  
        }
        mysqli_close($conn);
    }
    echo $output;
?>
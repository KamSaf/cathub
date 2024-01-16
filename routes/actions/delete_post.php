<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["postId"])) {
                $post_id = $_POST["postId"];    

                $conn = open_db_connection();
                $post = get_post_by_id($conn, $post_id);
                $user = $_SESSION['logged_user'];
                if ($user && ($post['author_id'] === $user['id'] || $user['is_admin'])){
                    $delete_post = "UPDATE posts SET is_deleted = '1' WHERE id = {$post['id']}";    
                    mysqli_query($conn, $delete_post);
                } else{
                    show_not_authorised_error_modal();
                }
                mysqli_close($conn);
            }
        }
?>
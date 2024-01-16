<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["commentId"])) {
                $comment_id = $_POST["commentId"];    

                $conn = open_db_connection();
                $comment = get_comment_by_id($conn, $comment_id);
                $user = $_SESSION['logged_user'];
                if ($user && ($comment['author_id'] === $user['id'] || $user['is_admin'])){
                    $delete_comment = "DELETE FROM comments WHERE id = '{$comment_id}'";    
                    mysqli_query($conn, $delete_comment);
                } else{
                    show_not_authorised_error_modal();
                }
                mysqli_close($conn);
                echo json_encode(array('result'=>'false'));
            }
        }
?>
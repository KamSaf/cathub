<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["postId"])) {
                $post_id = $_POST["postId"];

                $conn = open_db_connection();
                $post = get_post_by_id($conn, $post_id);
                $user = $_SESSION['logged_user'];
                $post_user_reaction_query = "SELECT * FROM post_user_reaction WHERE user_id = '{$user['id']}' AND post_id = '{$post['id']}'";
                $reactions = (int)$post['reactions'];


                if ($user){
                    $query_result = mysqli_query($conn, $post_user_reaction_query);
                    if (mysqli_num_rows($query_result) > 0){
                        $reactions = $reactions - 1;
                        $delete_post_user_reaction_query = "DELETE FROM post_user_reaction WHERE user_id = '{$user['id']}' AND post_id = '{$post['id']}'";
                        $update_post = "UPDATE posts SET reactions = '{$reactions}' WHERE id = {$post['id']}";
                        
                        try{
                            mysqli_begin_transaction($conn);
                            mysqli_query($conn, $delete_post_user_reaction_query);
                            mysqli_query($conn, $update_post);
                            mysqli_commit($conn);    
                        } catch(mysqli_sql_exception $exception){
                            mysqli_rollback($conn);
                            throw $exception;
                        }
                        mysqli_close($conn);

                        echo json_encode(array('result'=>'false'));
                    } else {
                        $reactions = $reactions + 1;
                        $insert_post_user_reaction_query = "INSERT INTO post_user_reaction (user_id, post_id) VALUES ('{$user['id']}', '{$post['id']}')";
                        $update_post = "UPDATE posts SET reactions = '{$reactions}' WHERE  id = {$post['id']}";

                        try{
                            mysqli_begin_transaction($conn);
                            mysqli_query($conn, $insert_post_user_reaction_query);
                            mysqli_query($conn, $update_post);
                            mysqli_commit($conn);    
                        } catch(mysqli_sql_exception $exception){
                            mysqli_rollback($conn);
                            throw $exception;
                        }
                        mysqli_close($conn);

                        echo json_encode(array('result'=>'true'));
                    }
                }

            }
        }
?>
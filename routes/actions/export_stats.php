<?php
    header('Content-type:application/rtf');
    require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
            if (isset($_GET["user"])) {
                $user_id = $_GET["user"];    
                $conn = new PDO ('mysql:host=localhost;dbname=cathub','root','');
                $select_user_query = "SELECT * FROM users WHERE id = :user_id";
                $prep = $conn->prepare($select_user_query);
                $prep->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $prep->execute();
                $user = $prep->fetch(PDO::FETCH_ASSOC);

                $select_posts_query = "SELECT * FROM posts WHERE author_id = :user_id AND is_deleted = false";
                $prep = $conn->prepare($select_posts_query);
                $prep->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $prep->execute();
                $posts = $prep->fetchAll(PDO::FETCH_ASSOC);
                $posts_count = count($posts);

                $post_reactions_count = 0;
                for ($i=0; $i < $posts_count; $i++){
                    $select_reactions_query = "SELECT id FROM post_user_reaction WHERE post_id = :post_id";
                    $prep = $conn->prepare($select_reactions_query);
                    $prep->bindParam(':post_id', $posts[$i]['id'], PDO::PARAM_INT);
                    $prep->execute();
                    $reactions = $prep->fetchAll(PDO::FETCH_ASSOC);
                    $posts_reactions += count($reactions);
                }


                $select_this_user_reactions_query = "SELECT id FROM post_user_reaction WHERE user_id = :user_id";
                $prep = $conn->prepare($select_this_user_reactions_query);
                $prep->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $prep->execute();
                $this_user_reactions = $prep->fetchAll(PDO::FETCH_ASSOC);
                $this_user_reactions_count = count($this_user_reactions);

                $select_posted_comments_query = "SELECT id FROM comments WHERE author_id = :user_id AND is_deleted = false";
                $prep = $conn->prepare($select_posted_comments_query);
                $prep->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $prep->execute();
                $posted_comments = $prep->fetchAll(PDO::FETCH_ASSOC);
                $posted_comments_count = count($posted_comments);

                $conn = null;

                $file_path = $_SERVER['DOCUMENT_ROOT']. '/cathub/rtf_template/exported_data.rtf';            
                $file_template = fopen($file_path, 'r');            
                $output = fread($file_template, filesize($file_path));
                
                $output = str_replace('<USERNAME>', $user['username'], $output);
                $output = str_replace('<EMAIL>', $user['email'], $output);
                $output = str_replace('<REGISTER_DATE>', $user['reg_date'], $output);
                $output = str_replace('<POSTS_CREATED>', $posts_count, $output);
                $output = str_replace('<POSTS_REACTIONS>', $posts_reactions, $output);
                $output = str_replace('<POSTS_REACTED_TO>', $this_user_reactions_count, $output);
                $output = str_replace('<POSTED_COMMENTS>', $posted_comments_count, $output);            
            
                echo $output;
            }
        }
?>
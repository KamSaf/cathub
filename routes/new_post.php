<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <title>CatHub 🐱</title>
        <!-- <link rel="icon" href="images/facivon.ico" type="image/x-icon"> -->
    </head>

    <?php
        
        session_start();
        require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
        require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/database.php');

        if (isset($_GET['post_id'])){
            $db_conn = open_db_connection();
            $old_post = get_post_by_id($db_conn, $_GET['post_id']);
            mysqli_close($db_conn);    
        }

        if (isset($_POST['add']) || isset($_POST['edit'])){
            $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_SPECIAL_CHARS);
            $post_description = filter_input(INPUT_POST, 'post_description', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($_FILES["post_image"] && $_FILES["post_image"]["tmp_name"] && !exif_imagetype($_FILES["post_image"]["tmp_name"])){
                show_file_format_error_modal();
            }
            else if (validate_post_data($post_title, $post_description)){
                if (isset($_POST['add']))
                    create_post($post_title, $post_description);
                else if(isset($_POST['edit']))
                    edit_post($post_title, $post_description, $old_post['id']);               
            }
        }
    ?>

    <header>
        <?php require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/header.php'); ?>
    </header>

    <body>
        <div style="margin-top: 60px;" class="d-flex justify-content-between">
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
            <div style="width: 40%;" class="p-2 bd-highlight">
                <?php
                    if($_GET['post_id']){
                        include($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/edit_post_form.html'); 
                    }
                    else{
                        include($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/new_post_form.html');
                    }
                ?>
            </div>
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
        </div>
        
    </body>

    <footer>
        <?php require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/footer.html'); ?>
    </footer>
</html>
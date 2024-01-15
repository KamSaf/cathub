<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="/cathub/static/common.js"></script>
        <title>CatHub 🐱</title>
        <link rel="icon" href="images/facivon.ico" type="image/x-icon">
    </head>

    <?php 
        session_start();
        require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/utils.php');
    ?>

    <header>
        <?php 
            require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/header.php');

            if (isset($_POST['publish'])){
                $comment_content = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_SPECIAL_CHARS);
                $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_SPECIAL_CHARS);
                if (strlen($comment_content) <= 150){
                    create_comment($comment_content, $post_id);
                }
            }

        ?>
    </header>

    <body>
        <div style="margin-top: 60px;" class="d-flex justify-content-between">
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
            <div style="width: 40%;" class="p-2 bd-highlight">
                <?php
                    $posts = load_posts();
                    if ($posts && mysqli_num_rows($posts) > 0) {
                        while ($post = mysqli_fetch_assoc($posts)) {
                            display_post($post);
                        }
                    }
                ?>
            </div>
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
        </div>
    </body>

    <footer>
        
        <?php
            require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/footer.html');
            include_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/delete_modal.html');
        ?>
    </footer>

</html>
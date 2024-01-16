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
        <?php require_once($_SERVER['DOCUMENT_ROOT']. '/cathub/include/header.php'); ?>

        <div style='margin-top: 25px;' class="d-flex justify-content-between">
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
            <div style="width: 40%;" class="p-2 bd-highlight">
                <?php
                    if ($_SESSION['logged_user']['id'] == $_GET['user']){
                        echo "<div style='margin-bottom: 60px; background-color: #f8f9fa;' class='card text-center'>
                                <a class='btn btn-secondary btn-sm' href='/cathub/routes/actions/export_stats.php?user={$_GET['user']}'>Export statistics to .rtf file</a>
                            </div>";
                    }
                ?>
            </div>
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
        </div>
    </header>

    <body>
        <div style="margin-top: 60px;" class="d-flex justify-content-between">
            <div style="width: 30%;" class="p-2 bd-highlight"></div>
            <div style="width: 40%;" class="p-2 bd-highlight">
                <?php
                    if (isset($_GET['user'])) {
                        $posts = load_posts($_GET['user']);
                        if ($posts && mysqli_num_rows($posts) > 0) {
                            while ($post = mysqli_fetch_assoc($posts)) {
                                display_post($post);
                            }
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
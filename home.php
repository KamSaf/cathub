<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <title>CatHub 🐱</title>
        <link rel="icon" href="images/facivon.ico" type="image/x-icon">
    </head>

    <?php include($_SERVER['DOCUMENT_ROOT']. '/blog/include/database.php'); ?>

    <header>
        <?php include($_SERVER['DOCUMENT_ROOT']. '/blog/include/header.php'); ?>
    </header>

    <body>
        <center><h1 style="margin-top: 100px;">Hello!</h1></center>
    </body>

    <footer>
        
        <?php
            mysqli_close($conn);
            include($_SERVER['DOCUMENT_ROOT']. '/blog/include/footer.html');
        ?>
    </footer>
</html>
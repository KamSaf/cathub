<?php
// if ($_SERVER["REQUESTED_METHOD"] == "POST" && isset($_POST['submit'])) {
//     $email = filter_input(INPUT_POST, 'email_input', FILTER_SANITIZE_SPECIAL_CHARS);
//     $password = filter_input(INPUT_POST, 'password_input', FILTER_SANITIZE_SPECIAL_CHARS);

//     echo $email;
//     echo '<br>';
//     echo $password;

    // if ($wpisane_dane === "1234") {
    //     // Przekierowanie na inną stronę
    //     header("Location: inna_strona.php");
    //     exit;
    // }
// }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>PHP Blog</title>
</head>
<header>
    <?php include($_SERVER['DOCUMENT_ROOT']. '/blog/templates/header.html'); ?>
</header>
<body>
    
<div class="d-flex justify-content-center">
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" style="margin-top: 90px;" >
        <div class="mb-3">
            <label for="email_input" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email_input" name="email_input">
        </div>
        <div class="mb-3">
            <label for="password_input" class="form-label">Password</label>
            <input type="password" class="form-control" id="password_input" name="password_input">
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-success align-center" value="login" name="submit">Log in</button>
        </div>
        <div style="margin-top: 15px;" class="pt-3">
                <small class="text-muted">Need an account? <a class="ml-2" href="#">Join now!</a></small>
        </div>
    </form>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email_input', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password_input', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($password == "test123") {
        header("Location: home.php");
        exit;
        // echo 'welcome!';
    } else{
        echo 'incorrect password!';
    }
}

?>

    
</body>
<footer>
    <?php include($_SERVER['DOCUMENT_ROOT']. '/blog/templates/footer.html'); ?>
</footer>
</html>
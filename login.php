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

    <?php
        include($_SERVER['DOCUMENT_ROOT']. '/blog/import/database.php');

        if($conn){
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
                $email = filter_input(INPUT_POST, 'email_input', FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, 'password_input', FILTER_SANITIZE_SPECIAL_CHARS);
                $login_result = user_login($conn, $email, $password);
    
                if ($login_result){
                    session_start();
                    $_SESSION['logged'] = true;
                    $_SESSION['logged_user'] = $login_result;
                    header("Location: home.php");
                    exit;
                } else{
                    $provided_email = $email;
                    $wrong_email = (!$email) ? true : false;
                    $wrong_password = ($password != $user[1]) ? true : false;
                }
            }
        } else{
            show_database_error_modal();
        }
    ?>

    <header>
        <?php include($_SERVER['DOCUMENT_ROOT']. '/blog/import/header.php'); ?>
    </header>

    <body>
        <div class="d-flex justify-content-center">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" style="margin-top: 90px;">
                <div id="email_box" class="mb-3">
                    <label for="email_input" class="form-label">Email address</label>
                    <?php
                        $email_input = "<input type='email' class='form-control ";
                        if ($wrong_email)
                            $email_input .="is-invalid' ";
                        else if ($provided_email)
                            $email_input .="' value='{$provided_email}' ";
                        $email_input .="id='email_input' name='email_input' required>";
                        echo $email_input;
                    ?>
                </div>
                <div id="password_box" class="mb-3">
                    <label for="password_input" class="form-label">Password</label>
                    <?php
                        $password_input = "<input type='password' class='form-control"; 
                        if ($wrong_password)
                            $password_input .= " is-invalid";
                        $password_input .= "' id='password_input' name='password_input'>";
                        echo $password_input;
                    ?>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success align-center" value="login" name="submit">Log in</button>
                </div>
                <div style="margin-top: 15px;" class="pt-3">
                        <small class="text-muted">Need an account? <a class="ml-2" href="#">Join now!</a></small>
                </div>
            </form>
        </div>
    </body>

    <footer>
        <?php
            mysqli_close($conn);
            include($_SERVER['DOCUMENT_ROOT']. '/blog/import/footer.html'); 
        ?>
    </footer>
</html>
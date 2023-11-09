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
        require_once($_SERVER['DOCUMENT_ROOT']. '/blog/include/database.php');
        require_once($_SERVER['DOCUMENT_ROOT']. '/blog/include/auth.php');

        if($conn){
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
                $email = filter_input(INPUT_POST, 'email_input', FILTER_SANITIZE_SPECIAL_CHARS);
                $username = filter_input(INPUT_POST, 'username_input', FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, 'password_input', FILTER_SANITIZE_SPECIAL_CHARS);
                $confirm_password = filter_input(INPUT_POST, 'confirm_password_input', FILTER_SANITIZE_SPECIAL_CHARS);

                $data_validation_result = validate_register_form($conn, $email, $username, $password, $confirm_password);

                if ($data_validation_result['success']){
                    create_user($conn, $username, $email, $password);
                }
            }
        }
    ?>

    <header>
        <?php require_once($_SERVER['DOCUMENT_ROOT']. '/blog/include/header.php'); ?>
    </header>

    <body>
        <div class="d-flex justify-content-center">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" style="margin-top: 90px;">
                <div id="email_box" class="mb-3">
                    <label for="email_input" class="form-label">Email address</label>
                    <?php
                        $email_input = "<input type='email' class='form-control ";
                        if ($data_validation_result['errors']['email_error'])
                            $email_input .="is-invalid' ";
                        $email_input .="id='email_input' name='email_input' required value='{$email}'>";
                        echo $email_input. "<small class='text-danger'>{$data_validation_result['errors']['email_error']}</small>";
                    ?>
                </div>
                <div id="username_box" class="mb-3">
                    <label for="username_input" class="form-label">Username</label>
                    <?php
                        $username_input = "<input type='username' class='form-control"; 
                        if ($data_validation_result['errors']['username_error'])
                            $username_input .= " is-invalid";
                        $username_input .= "' id='username_input' name='username_input' value='{$username}' required>";
                        echo $username_input. "<small class='text-danger'>{$data_validation_result['errors']['username_error']}</small>";
                    ?>
                </div>
                <div id="password_box" class="mb-3">
                    <label for="password_input" class="form-label">Password</label>
                    <?php
                        $password_input = "<input type='password' class='form-control"; 
                        if ($data_validation_result['errors']['password_error'])
                            $password_input .= " is-invalid";
                        $password_input .= "' id='password_input' name='password_input' required>";
                        echo $password_input. "<small class='text-danger'>{$data_validation_result['errors']['password_error']}</small>";
                    ?>
                </div>

                <div id="confirm_password_box" class="mb-3">
                    <label for="confirm_password_box" class="form-label">Confirm password</label>
                    <?php
                        $confirm_password_input = "<input type='password' class='form-control"; 
                        if ($data_validation_result['errors']['confirm_password_error'])
                            $confirm_password_input .= " is-invalid";
                        $confirm_password_input .= "' id='confirm_password_input' name='confirm_password_input' required>";
                        echo $confirm_password_input. "<small class='text-danger'>{$data_validation_result['errors']['confirm_password_error']}</small>";
                    ?>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success align-center" value="login" name="submit">Create account</button>
                </div>
                <div style="margin-top: 15px;" class="pt-3">
                        <small class="text-muted">Already have an account? <a class="ml-2" href='login.php'>Log in</a></small>
                </div>
            </form>
        </div>
    </body>

    <footer>
        <?php
            mysqli_close($conn);
            require_once($_SERVER['DOCUMENT_ROOT']. '/blog/include/html/footer.html'); 
        ?>
    </footer>
</html>
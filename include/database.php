<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "cathubdb";
    $conn = "";

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    } catch(mysqli_sql_exception){
        show_database_error_modal();
    }



    function user_login(mysqli $conn, string $email, string $password){
        $active_users_query = "SELECT * FROM users WHERE email = '{$email}' AND is_deleted = false";
        $users = mysqli_query($conn, $active_users_query);
        if (mysqli_num_rows($users) > 0)
            $user = mysqli_fetch_assoc($users);
            if (password_verify($password, $user['password'])){
                session_start();
                $_SESSION['logged'] = true;
                $_SESSION['logged_user'] = $user;
                header("Location: home.php");
                exit;
            }
        return true; // if logging in didn't succeed
    }

    function show_database_error_modal(){
        echo '
            <div class="modal fade" id="db_error_modal" tabindex="-1" aria-labelledby="db_error_modal_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="db_error_modal_label">Database connection error</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Error occured when trying to connect to database.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var modal = new bootstrap.Modal(document.getElementById("db_error_modal"));
                modal.show();
            </script>
        ';
    }

    function check_if_email_used(mysqli $conn, string $email){
        $used_emails_query = "SELECT email FROM users WHERE is_deleted = false AND email = '{$email}'";
        $query_result = mysqli_query($conn, $used_emails_query);
        if (mysqli_num_rows($query_result) > 0)
            return true;
        return false;
    }

    function check_if_username_used(mysqli $conn, string $username){
        $used_usernames_query = "SELECT username FROM users WHERE is_deleted = false AND username = '{$username}'";
        $query_result = mysqli_query($conn, $used_usernames_query);
        if (mysqli_num_rows($query_result) > 0)
            return true;
        return false;
    }

    function create_user(mysqli $conn, string $username, string $email, string $password){
        echo "success!"; // stworzenie usera w bazie danych, przekierowanie do strony home.php i automatyczne zalogowanie
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $insert_user = "INSERT INTO users (username, password, email) VALUES ('{$username}', '{$password_hash}', '{$email}')";
        mysqli_query($conn, $insert_user);
        user_login($conn, $email, $password);
    }

?>
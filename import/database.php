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
            if (password_verify($password, $user['password']))
                return $user;
        return null;
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
?>
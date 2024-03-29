<?php

    function open_db_connection(){
        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "cathub";
        $conn = "";

        try{
            $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
            return $conn;
        } catch(mysqli_sql_exception){
            show_database_error_modal();
        }
    }

    # Displays error modal if there is no database connection
    function show_database_error_modal(){
        include($_SERVER['DOCUMENT_ROOT']. '/cathub/include/html/database_error_modal.html');
    }

?>
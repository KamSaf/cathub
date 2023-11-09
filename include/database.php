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

    # Displays error modal if there is no database connection
    function show_database_error_modal(){
        include($_SERVER['DOCUMENT_ROOT']. '/blog/include/html/database_error_modal.html');
    }

?>
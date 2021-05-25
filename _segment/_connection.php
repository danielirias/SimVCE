<?php
    $logTime = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
    $path = "log/_log_connection.log";

    //=====================================================================================
    //CONEXIÓN
    //=====================================================================================

    $host = "db5002131193.hosting-data.io";
    $user = "dbu842103";
    $pass = "passAdminCE@1979";
    $data = "dbs1729084";
    $port = "3306";

    $connection = new mysqli($host, $user, $pass, $data, $port);
    // Check connection
    if ($connection->connect_error)
    {
        error_log(
            "=============================================================================================================================".
            "\nDATE TIME    :  ".$logTime.
            "\nERROR NUMBER :  ".$connection->connect_errno.
            "\nERROR        :  ".$connection->error.
            "\nINFO         :  ".$connection->info.
            "\nSTATE        :  ".$connection->sqlstate.
            "\nMESSAGE      :  ".$connection->connect_error."\n\n", 3, $path);
    }

    $char_set = $connection->query("SET NAMES 'utf8'");
<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    require_once ("../_class/DataInterface.php");
    $MainConn = new DataInterface();
    $hashPWD = hash("sha256", trim($_GET["password"]), false);
    $SQL_QUERY = "SELECT * FROM usuario WHERE user_email = '".$_GET["email"]."' AND user_pass = '".$hashPWD."';";

    $data = $MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);

    if(count($data) == 0)
    {
        $data = array();
    }
    else
    {
        $_SESSION["SESSION_USER_ID"] = $data[0]["user_id"];
        $_SESSION["USER_EMAIL"] = $data[0]["user_email"];
        $_SESSION["USER_PASSWORD"] = $data[0]["user_pass"];
        $_SESSION["SESSION_USER_TYPE"] = $data[0]["user_type"];
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
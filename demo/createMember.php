<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //include("_segment/_session-control.php");
    include("_segment/_connection.php");
    include("_segment/functions.php");

    $_DEF_SQL = '';
    $strRow = '';

    $_SQL_DROP = "DELETE FROM mer_member WHERE member_dni <> 'ABC';";
    $connection->query("SET NAMES 'utf8'");
    $connection->query($_SQL_DROP) === TRUE;

    $_QUERY_SQL = "SELECT * FROM mer LIMIT 2;";
    $query_mer= $connection->query($_QUERY_SQL);
    while($mer = mysqli_fetch_array($query_mer))
    {
        $_QUERY_SQL = "SELECT * FROM view_member_random;";
        $queryMember = $connection->query($_QUERY_SQL);
        $member = mysqli_fetch_array($queryMember);

        //Roles
        //101: Presiendete Propietario
        //102: Secretario Propietario
        //103: Escrutador Propietario

        //201: Presiendete Suplente
        //202: Secretario Suplente
        //203: Escrutador Suplente

        //301: Vocal I
        //302: Vocal II
        //303: Vocal III

        $memberRole = 101;

        $_DEF_SQL = "INSERT INTO mer_member 
                                (
                                    member_dni, 
                                    member_firstname, 
                                    member_secondname, 
                                    member_surname, 
                                    member_lastname, 
                                    member_photo_profile, 
                                    member_photo_dni,
                                    mer_id, 
                                    member_role
                                )
                                VALUES
                                (
                                    '".$member["persona_dni"]."', 
                                    '".$member["persona_nombre_1"]."', 
                                    '".$member["persona_nombre_2"]."', 
                                    '".$member["persona_apellido_1"]."', 
                                    '".$member["persona_apellido_2"]."', 
                                    'profile_photo.jpg', 
                                    'dni_photo.jpg', 
                                    '".$member["mer_id"]."', 
                                    ".$memberRole."
                                ); ";

        $connection->query("SET NAMES 'utf8'");
        $connection->query($_DEF_SQL) === TRUE;
    }
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("_segment/_session-control.php");
include("_segment/_connection.php");
include("_segment/functions.php");

?>

<table>
    <thead>
        <th>ID</th>
        <th>Centro de votación</th>
    </thead>
    <tbody>
        <?php
            $merID = 0;
            $strRow = '';
            $_DEF_SQL = '';

            $_SQL_DROP = "DELETE FROM mer WHERE mer_id <> 'ABC';";
            $connection->query("SET NAMES 'utf8'");
            $connection->query($_SQL_DROP) === TRUE;

            $_QUERY_SQL = "SELECT * FROM vote_center;";
            $query_center= $connection->query($_QUERY_SQL);
            while($center = mysqli_fetch_array($query_center))
            {
                for ($i = 1; $i <= 5; $i++)
                {
                    $merID = $merID + 1;
                    $merID = str_pad ($merID, 6, '0', STR_PAD_LEFT);

                    $_DEF_SQL = "INSERT INTO mer 
                                            (
                                                mer_id, 
                                                center_id
                                            )
                                            VALUES
                                            (
                                                '".$merID."', 
                                                '".$center["center_id"]."'
                                            );";
                    $connection->query("SET NAMES 'utf8'");
                    $connection->query($_DEF_SQL) === TRUE;
                }
            }
            //$connection->close();
            echo 'Total->'.$merID;
        ?>
    </tbody>
</table>


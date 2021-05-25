<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

//include("_segment/_session-control.php");
include("_segment/_connection.php");
include("_segment/functions.php");

function createID()
{
    include("_segment/_connection.php");
    //Creo el Municipio
    $_QUERY_SQL = "SELECT municipio_id FROM municipio ORDER BY RAND() LIMIT 1;";
    $query = $connection->query($_QUERY_SQL);
    $municipio = mysqli_fetch_array($query);

    $municipioID = $municipio["municipio_id"];

    $currentYear = date("Y");
    $minYear = $currentYear - 100;
    $maxYear = $currentYear - 18;
    $yearID = rand ( $minYear ,  $maxYear);

    $recordID = str_pad ( rand ( 100 ,  9999) , 5 , '0' , STR_PAD_LEFT );

    $fakeDNI = $municipioID.'-'.$yearID.'-'.$recordID;

    return $fakeDNI;
}


function createCenter($mixed)
{
    $tipo = array("escuela", "centro escolar", "instituto");
    $arboles = array("abedul", "abeto", "acacia", "acebo", "álamo", "arce", "baobab", "caoba", "castaño", "cedro", "cerezo", "chopo", "ciprés", "ciruelo", "ébano", "fresno", "granado", "haya", "higuera", "manzano", "naranjo", "nogal", "olivo", "olmo", "ombú", "palmera", "pino", "roble", "sabina albar", "sauce", "secuoya", "sicomoro");
    $colores = array("amarillo", "ámbar", "añil", "azul", "azul claro", "azul eléctrico", "azul marino", "beis", "bermellón", "blanco", "blanco marfil", "burdeos", "café", "caoba", "caqui", "carmesí", "castaño", "celeste", "cereza", "champán", "chartreuse o cartujo", "cian", "cobre", "color terracota o teja", "coral", "crema", "fucsia", "granate", "gris", "gris perla", "gris zinc", "gualdo", "hueso", "lavanda", "lila", "magenta", "marrón", "marrón chocolate", "morado", "naranja", "negro", "ocre", "ocre claro", "ocre oscuro", "oro o dorado", "pardo", "plata", "púrpura", "rojo", "rojo carmín", "rosa", "salmón", "turquesa", "verde", "verde botella", "verde esmeralda", "verde lima", "verde manzana", "verde musgo", "verde oliva", "verde pistacho", "verdeagua", "violeta", "vino");
    $cardinal = array("", "del norte", "del sur", "del este", "del oeste");
    $segmento = array("calle", "avenida", "bloque");

    if ($mixed = 1)
    {
        $rndAddress = ucfirst($tipo[rand(0 , count($tipo) -1)]).' '.ucfirst($arboles[rand(0 , count($arboles) -1)]);
    }
    if ($mixed = 2)
    {
        $rndAddress = ucfirst($tipo[rand(0 , count($tipo) -1)]).' '.ucfirst($arboles[rand(0 , count($arboles) -1)]).' '.ucfirst($colores[rand(0 , count($colores) -1)]);
    }

    $rndAddress = $rndAddress;

    return $rndAddress;
}
?>

<table>
    <thead>
        <th>MER ID</th>
        <th>Linea</th>
    </thead>
    <tbody>
        <?php

            $strRow = '';
            $_DEF_SQL = '';

            $_SQL_DROP = "DELETE FROM mer_linea WHERE linea_id <> 'ABC';";
            $connection->query("SET NAMES 'utf8'");
            //$connection->query($_SQL_DROP) === TRUE;

            //$connection->close();

            //$_QUERY_SQL = "SELECT * FROM mer;";

            //$_QUERY_SQL = "SELECT * FROM mer WHERE (mer_id >= 0 AND mer_id <= 7450);";      //22350
            //$_QUERY_SQL = "SELECT * FROM mer WHERE (mer_id >= 7451 AND mer_id <= 14900);";  //44700
            //$_QUERY_SQL = "SELECT * FROM mer WHERE (mer_id >= 14901 AND mer_id <= 22350);";   //67050
            //$_QUERY_SQL = "SELECT * FROM mer WHERE (mer_id >= 22351 AND mer_id <= 29800);"; //89400
            $_QUERY_SQL = "SELECT * FROM mer WHERE (mer_id >= 29801 AND mer_id <= 37250);"; //98250

            $lineaID = 89400;

            $query_mer= $connection->query($_QUERY_SQL);
            while($mer = mysqli_fetch_array($query_mer))
            {
                for ($i = 1; $i <= 3; $i++)
                {
                    $lineaID = $lineaID + 1;
                    $lineaID = str_pad ($lineaID, 6, '0', STR_PAD_LEFT);

                    $_DEF_SQL = "INSERT INTO mer_linea 
                                            (
                                                mer_id, 
                                                linea_id
                                            )
                                            VALUES
                                            (
                                                '".$mer["mer_id"]."', 
                                                '".$lineaID."'
                                            );";
                    $connection->query("SET NAMES 'utf8'");
                    $connection->query($_DEF_SQL) === TRUE;
                }
            }
            //$connection->close();
            echo 'Total->'.$lineaID;
        ?>
    </tbody>
</table>


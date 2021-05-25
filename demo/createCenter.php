<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    include("_segment/_session-control.php");
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
        <th>ID</th>
        <th>Depto</th>
        <th>Munic</th>
        <th>Centro de votación</th>
    </thead>
    <tbody>
        <?php
            $_DEF_SQL = '';
            $strRow = '';

            $_SQL_DROP = "DELETE FROM vote_center WHERE center_id <> 'ABC';";
            $connection->query("SET NAMES 'utf8'");
            $connection->query($_SQL_DROP) === TRUE;

            $centerID = 0;
            $_QUERY_SQL = "SELECT * FROM departamento;";
            $query_depto = $connection->query($_QUERY_SQL);
            while($departamento = mysqli_fetch_array($query_depto))
            {

                $_QUERY_SQL = "SELECT * FROM municipio WHERE departamento_id = '".$departamento["departamento_id"]."';";
                $query = $connection->query($_QUERY_SQL);
                while($municipio = mysqli_fetch_array($query))
                {
                    for ($i = 1; $i <= 25; $i++)
                    {
                        $centerID = $centerID + 1;

                        //$centerID = $municipio["municipio_id"].'-'.str_pad ( $i , 4 , '0' , STR_PAD_LEFT );
                        //$centerName = 'Centro de votación '.str_pad ( $i , 4 , '0' , STR_PAD_LEFT ).' en '.$municipio["municipio_nombre"].', '.$departamento["departamento_nombre"];

                        $centerID = str_pad ($centerID, 5, '0', STR_PAD_LEFT);

                        $mixed = rand (1 ,  2);
                        $centerName = createCenter($mixed);

                        $strRow = $strRow.
                        '<tr>
                            <td>'.$centerID.'</td>
                            <td>'.$departamento["departamento_id"].'</td>
                            <td>'.$municipio["municipio_id"].'</td>
                            <td>'.$centerName.'</td>
                        </tr>';

                        $_DEF_SQL = "INSERT INTO vote_center 
                                    (
                                        center_id, 
                                        departamento_id,
                                        municipio_id, 
                                        center_name
                                    )
                                    VALUES
                                    (
                                        '".$centerID."', 
                                        '".$departamento["departamento_id"]."', 
                                        '".$municipio["municipio_id"]."', 
                                        '".$centerName."'
                                    );";

                        $connection->query("SET NAMES 'utf8'");
                        $connection->query($_DEF_SQL) === TRUE;
                    }
                }
            }

            echo $strRow;

            $connection->close();
        ?>
    </tbody>
</table>


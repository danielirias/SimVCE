<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //include("_segment/_session-control.php");
    include("../_segment/_connection.php");
    include("../_segment/functions.php");

    header("Content-Type: application/json; charset=UTF-8");

    function createID()
    {
        include("../_segment/_connection.php");
        //Creo el Municipio
        $_QUERY_SQL = "SELECT municipio_id FROM municipio ORDER BY RAND() LIMIT 1;";
        $query = $connection->query($_QUERY_SQL);
        $municipio = mysqli_fetch_array($query);

        $municipioID = $municipio["municipio_id"];

        $currentYear = date("Y");
        $minYear = $currentYear - 50;
        $maxYear = $currentYear - 18;
        $yearID = rand ( $minYear ,  $maxYear);

        $recordID = str_pad ( rand ( 100 ,  9999) , 5 , '0' , STR_PAD_LEFT );

        $fakeDNI = $municipioID.'-'.$yearID.'-'.$recordID;
        //$fakeDNI = $municipioID.$yearID.$recordID;

        //Mes
        $birthMonth = rand(1 ,  12);

        //Días
        $diasMes = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        $birthDay = rand(1, $diasMes[$birthMonth - 1]);

        $birthMonth = str_pad($birthMonth, 2 , '0' , STR_PAD_LEFT );
        $birthDay = str_pad($birthDay, 2 , '0' , STR_PAD_LEFT );

        $fechaNacimiento = $yearID.'-'.$birthMonth.'-'.$birthDay;

        $data = array(
            "dni"=>$fakeDNI,
            "fechaNacimiento"=>$fechaNacimiento
        );

        //echo var_dump($data);

        return $data;
    }

    function getLocationData()
    {
        include("../_segment/_connection.php");

        $_QUERY_SQL = "SELECT departamento_id FROM departamento ORDER BY RAND() LIMIT 1;";
        $query_depto = $connection->query($_QUERY_SQL);
        $departamento = mysqli_fetch_array($query_depto);

        $_QUERY_SQL = "SELECT municipio_id FROM municipio WHERE departamento_id = '".$departamento["departamento_id"]."' ORDER BY RAND() LIMIT 1;";
        $query_munic = $connection->query($_QUERY_SQL);
        $municipio = mysqli_fetch_array($query_munic);

        $_QUERY_SQL = "SELECT center_id FROM vote_center WHERE municipio_id = '".$municipio["municipio_id"]."' ORDER BY RAND() LIMIT 1;";
        $query_center = $connection->query($_QUERY_SQL);
        $vote_center = mysqli_fetch_array($query_center);

        $_QUERY_SQL = "SELECT mer_id FROM mer WHERE center_id = '".$vote_center["center_id"]."' ORDER BY RAND() LIMIT 1;";
        $query_mer = $connection->query($_QUERY_SQL);
        $mer = mysqli_fetch_array($query_mer);

        $_QUERY_SQL = "SELECT linea_id FROM mer_linea WHERE mer_id = '".$mer["mer_id"]."' ORDER BY RAND() LIMIT 1;";
        $query_linea = $connection->query($_QUERY_SQL);
        $linea = mysqli_fetch_array($query_linea);

        $mixedAddress = rand (1 , 3);

        $data = array(
                "departamentoID"=>$departamento["departamento_id"],
                "municipioID"=>$municipio["municipio_id"],
                "homeAddress"=>createAddress($mixedAddress),
                "centerID"=>$vote_center["center_id"],
                "merID" => $mer["mer_id"],
                "lineaID" => $linea["linea_id"]
                );

        //echo var_dump($data);

        return $data;
    }

    function createAddress($mixedAddress)
    {
        $tipo = array("caserio", "barrio", "colonia", "residencial", "apartamentos", "condominios");
        $arboles = array("abedul", "abeto", "acacia", "acebo", "álamo", "arce", "baobab", "caoba", "castaño", "cedro", "cerezo", "chopo", "ciprés", "ciruelo", "ébano", "fresno", "granado", "haya", "higuera", "manzano", "naranjo", "nogal", "olivo", "olmo", "ombú", "palmera", "pino", "roble", "sabina albar", "sauce", "secuoya", "sicomoro");
        $colores = array("amarillo", "ámbar", "añil", "azul", "azul claro", "azul eléctrico", "azul marino", "beis", "bermellón", "blanco", "blanco marfil", "burdeos", "café", "caoba", "caqui", "carmesí", "castaño", "celeste", "cereza", "champán", "chartreuse o cartujo", "cian", "cobre", "color terracota o teja", "coral", "crema", "fucsia", "granate", "gris", "gris perla", "gris zinc", "gualdo", "hueso", "lavanda", "lila", "magenta", "marrón", "marrón chocolate", "morado", "naranja", "negro", "ocre", "ocre claro", "ocre oscuro", "oro o dorado", "pardo", "plata", "púrpura", "rojo", "rojo carmín", "rosa", "salmón", "turquesa", "verde", "verde botella", "verde esmeralda", "verde lima", "verde manzana", "verde musgo", "verde oliva", "verde pistacho", "verdeagua", "violeta", "vino");
        $cardinal = array("", "del norte", "del sur", "del este", "del oeste");
        $segmento = array("calle", "avenida", "bloque");

        if ($mixedAddress = 1)
        {
            $rndAddress = ucfirst($tipo[rand(0 , count($tipo) -1)]).' '.ucfirst($arboles[rand(0 , count($arboles) -1)]);
        }
        if ($mixedAddress = 2)
        {
            $rndAddress = ucfirst($tipo[rand(0 , count($tipo) -1)]).' '.ucfirst($arboles[rand(0 , count($arboles) -1)]).' '.ucfirst($colores[rand(0 , count($colores) -1)]);
        }
        if ($mixedAddress = 3)
        {
            $rndAddress = ucfirst($tipo[rand(0 , count($tipo) -1)]).' '.ucfirst($arboles[rand(0 , count($arboles) -1)]).' '.ucfirst($colores[rand(0 , count($colores) -1)]).' '.$cardinal[rand(0 , count($cardinal) -1)];
        }

        $rndAddress = $rndAddress.', '.ucfirst($segmento[rand(0 , count($segmento) -1)]).' '.rand(1 , 99).', casa #'. rand(1 , 2999);

        return $rndAddress;
    }

    $_DEF_SQL = '';
    $strRow = '';

    $_SQL_DROP = "DELETE FROM persona WHERE persona_dni <> 'ABC';";
    $connection->query("SET NAMES 'utf8'");
    //$connection->query($_SQL_DROP) === TRUE;

    $_QUERY_SQL = "SELECT DISTINCT lead_firstname, lead_lastname FROM source_person WHERE lead_firstname <> '';";
    $queryLead = $connection->query($_QUERY_SQL);
    $total = 0;
    while ($lead = mysqli_fetch_array($queryLead)) {
        $dniData = createID();
        $dni = $dniData["dni"];
        $fechaNacimiento = $dniData["fechaNacimiento"];

        $firstname = '';
        $secondname = '';
        $surname = '';
        $lastname = 'Apellido_2';

        $nombres = explode(' ', trim($lead["lead_firstname"]));
        $firstname = trim($nombres[0]);
        if (count($nombres) > 1) {
            $secondname = trim($nombres[1]);
        }

        $apellidos = explode(' ', trim($lead["lead_lastname"]));
        $surname = trim($apellidos[0]);
        if (count($apellidos) > 1) {
            if (trim($apellidos[1]) == '') {
                $lastname = 'Apellido_2';
            } else {
                $lastname = trim($apellidos[1]);
            }
        }

        $dataLocation = getLocationData();
        $departamentoID = $dataLocation["departamentoID"];
        $municipioID = $dataLocation["municipioID"];
        $homeAddress = $dataLocation["homeAddress"];
        $centerID = $dataLocation["centerID"];
        $merID = $dataLocation["merID"];
        $lineaID = $dataLocation["lineaID"];

        $_DEF_SQL = "INSERT INTO persona 
                                        (
                                            persona_dni, 
                                            persona_fecha_nacimiento, 
                                            persona_nombre_1, 
                                            persona_nombre_2, 
                                            persona_apellido_1, 
                                            persona_apellido_2, 
                                            persona_domicilio_departamento_id, 
                                            persona_domicilio_municipio_id,
                                            persona_domicilio_direccion,  
                                            center_id, 
                                            mer_id, 
                                            linea_id
                                        )
                                        VALUES
                                        (
                                            '" . $dni . "', 
                                            '" . $fechaNacimiento . "', 
                                            '" . ucfirst($firstname) . "', 
                                            '" . ucfirst($secondname) . "', 
                                            '" . ucfirst($surname) . "', 
                                            '" . ucfirst($lastname) . "', 
                                            '" . $departamentoID . "', 
                                            '" . $municipioID . "', 
                                            '" . $homeAddress . "', 
                                            '" . $centerID . "', 
                                            '" . $merID . "', 
                                            '" . $lineaID . "'
                                        ); ";

        $connection->query("SET NAMES 'utf8'");
        $connection->query($_DEF_SQL) === TRUE;

        $total = $total + 1;
    }

    $connection->close();

    $data = array("total"=>$total);

    echo json_encode($data, JSON_PRETTY_PRINT);
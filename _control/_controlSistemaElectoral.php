<?php
    require_once("../_control/MainLoader.php");

    header('Access-Control-Allow-Origin: '.getWebDomain());
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header("Content-Type: application/json; charset=UTF-8");

    require_once("../_class/SistemaElectoral.php");
    $SistemaElectoral = new SistemaElectoral();

    if($_GET["action"] == 'add_center')
    {
        $SistemaElectoral->DepartamentoID = filter_var(strip_tags($_POST["departamento_id"]), FILTER_SANITIZE_STRING);
        $SistemaElectoral->MunicipioID    = filter_var(strip_tags($_POST["municipio_id"]), FILTER_SANITIZE_STRING);
        $SistemaElectoral->CenterName     = filter_var(strip_tags($_POST["center_name"]), FILTER_SANITIZE_STRING);

        $SistemaElectoral->createVoteCenter();
    }

    if($_GET["action"] == 'add_mer')
    {
        $SistemaElectoral->createMER($_GET["center_id"]);
        header("Location: detail.php?view=mer&center_id=".$_GET["center_id"]);
    }

    if($_GET["action"] == 'search_member')
    {
        $data = array();

        //1. verifico que la persona exista en la tabla de población
        $data = $SistemaElectoral->getPersonaInfo($_GET["dni"]);
        if(count($data) == 0)
        {
            //NO existe en la poblacion
            //Dejo el array vacío
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
        else
        {
            //SÏ existe en la población
            $data = $SistemaElectoral->getPersonaInfo($_GET["dni"]);
            echo json_encode($data, JSON_PRETTY_PRINT);
        }

    }

    if($_GET["action"] == 'check_member')
    {
        $data = array();

        //1. verifico que la persona no exista en otra MER
        $data = $SistemaElectoral->checkMemberOnMER($_GET["dni"]);
        if(count($data) == 0)
        {
            //NO existe en la poblacion
            //Dejo el array vacío
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
        else
        {
            //Si existe en la población
            $data = $SistemaElectoral->getPersonaInfo($_GET["dni"]);
            echo json_encode($data, JSON_PRETTY_PRINT);
        }

    }

    if($_GET["action"] == 'add_member')
    {
        $SistemaElectoral->memberDNI    = filter_var(strip_tags($_POST["member_dni"]), FILTER_SANITIZE_STRING);
        $SistemaElectoral->memberRoleID = filter_var(strip_tags($_POST["member_role"]), FILTER_SANITIZE_STRING);
        $SistemaElectoral->merID        = filter_var(strip_tags($_GET["mer_id"]), FILTER_SANITIZE_STRING);

        $SistemaElectoral->addMERMember();
    }

    if($_GET["action"] == 'remove_member')
    {
        $SistemaElectoral->memberDNI    = filter_var(strip_tags($_POST["member_dni"]), FILTER_SANITIZE_STRING);
        $SistemaElectoral->removeMERMember();
    }

    if($_GET["action"] == 'login_mer_member')
    {
        $SistemaElectoral->memberPassword = $_GET["password"];

        //1. verifico que la persona no exista en otra MER
        $data = $SistemaElectoral->checkMemberRegistered($_GET["dni"]);
        if(count($data) == 0)
        {
            //NO existe en la poblacion
            //Dejo el array vacío
            $data = array();
        }
        else
        {
            //Si existe en la población
            $_SESSION["SESSION_MEMBER_DNI"]       = $data[0]["member_dni"];
            $_SESSION["SESSION_MEMBER_MER_ID"]    = $data[0]["mer_id"];
            $_SESSION["SESSION_MEMBER_CENTER_ID"] = $data[0]["center_id"];
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    if($_GET["action"] == 'search_voter')
    {
        $data = array();

        //1. verifico que la persona exista en la tabla de población
        $data = $SistemaElectoral->getVoterInfo($_GET["dni"], $_GET["token"]);
        if(count($data) == 0)
        {
            //NO existe en la poblacion
            //Dejo el array vacío
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
        else
        {
            //Si existe en la población
            //1. verifico que no esté marcado como VOTO REALIZADO
            $votante = $SistemaElectoral->checkVoterDone($_GET["dni"]);

            if(count($votante) == 0)
            {
                //La persona no ha realizado su voto entonces enviamos sus datos para que vote
                echo json_encode($data, JSON_PRETTY_PRINT);
            }
            else
            {
                $data = array();
                $used = array("persona_dni"=>'used');
                array_push($data, $used);
                echo json_encode($data, JSON_PRETTY_PRINT);
            }

        }

    }

    if($_GET["action"] == 'create_log_record')
    {
        $SistemaElectoral->memberDNI = $_SESSION["SESSION_MEMBER_DNI"];
        $SistemaElectoral->merID = $_SESSION["SESSION_MEMBER_MER_ID"];
        $SistemaElectoral->actionID = $_POST["action_id"];
        $SistemaElectoral->personaDNI = $_POST["persona_dni"];

        $SistemaElectoral->createActionLog();
    }

    if($_GET["action"] == 'logout_mer_member')
    {
        $SistemaElectoral->memberDNI = $_SESSION["SESSION_MEMBER_DNI"];
        $SistemaElectoral->actionID = 102;
        $SistemaElectoral->personaDNI = '';

        $SistemaElectoral->createActionLog();

        $_SESSION["SESSION_MEMBER_DNI"]       = '';
        $_SESSION["SESSION_MEMBER_MER_ID"]    = '';
        $_SESSION["SESSION_MEMBER_CENTER_ID"] = '';

        header('Location: '.getWebDomain().'runapp/');
    }

    if($_GET["action"] == 'compare_mer_person')
    {
        $SistemaElectoral->personaDNI = $_GET["persona_dni"];
        $SistemaElectoral->merID = $_SESSION["SESSION_MEMBER_MER_ID"];

        $data = $SistemaElectoral->comparePersonOnMER();

        if(count($data) == 0)
        {
            //No pertenece a la misma MER
            //Dejo el array vacío
            $data = array();
        }
        else
        {
            //Si pertenece a la misma MER

        }
        echo json_encode($data, JSON_PRETTY_PRINT);

    }

    if($_GET["action"] == 'check_person_voting')
    {
        $SistemaElectoral->personaDNI = $_GET["persona_dni"];
        $data = $SistemaElectoral->checkPersonVoting();

        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    if($_GET["action"] == 'check_person_vote_done')
    {
        $SistemaElectoral->personaDNI = $_GET["persona_dni"];
        $data = $SistemaElectoral->checkPersonVoteDone();

        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    if($_GET["action"] == 'check_available_space')
    {
        $SistemaElectoral->memberDNI = $_SESSION["SESSION_MEMBER_DNI"];
        $data = $SistemaElectoral->checkAvailableSpace();

        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    if($_GET["action"] == 'add_person_voting')
    {
        $SistemaElectoral->memberDNI = $_SESSION["SESSION_MEMBER_DNI"];
        $SistemaElectoral->merID = $_SESSION["SESSION_MEMBER_MER_ID"];
        $SistemaElectoral->personaDNI = $_POST["persona_dni"];

        $SistemaElectoral->addPersonVoting();
    }

    if($_GET["action"] == 'finish_vote')
    {
        $SistemaElectoral->personaDNI = $_GET["persona_dni"];
        $SistemaElectoral->memberDNI = $_SESSION["SESSION_MEMBER_DNI"];
        $SistemaElectoral->merID = $_SESSION["SESSION_MEMBER_MER_ID"];
        $SistemaElectoral->CenterID = $_SESSION["SESSION_MEMBER_CENTER_ID"];


        $SistemaElectoral->finishVote();

        $_SESSION["FINISH_VOTE"] = 1;

        header('Location: '.getWebDomain().'runapp/memberPanel.php');
    }

    if($_GET["action"] == 'get_rnd_member')
    {
        $data = $SistemaElectoral->getRndMERMember();
        echo json_encode($data, JSON_PRETTY_PRINT);
    }


<?php
session_start();

require_once ("DataInterface.php");

class SistemaElectoral
{
    private $dataResult;
    public $MainConn;

    public $totalPoblacion;
    public $totalCentros;
    public $totalMER;
    public $totalLineas;

    public $personaDNI;

    public $DepartamentoID;
    public $MunicipioID;
    public $CenterID;
    public $CenterName;

    public $memberDNI;
    public $merID;
    public $memberRoleID;
    public $memberPassword;

    public $actionID;

    public $totalBusquedas;
    public $totalVotantesAdmitidos;
    public $totalVotantesRechazados;

    public function __construct()
    {
        $this->MainConn = new DataInterface();
    }

    public function getDepartamentos()
    {

    }

    public function getMunicipios()
    {
        $SQL_QUERY = "SELECT * FROM viewMunicipioList;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getValues()
    {
        $SQL_QUERY = "SELECT count(center_id) AS total_center FROM vote_center;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalCentros = $this->dataResult[0]["total_center"];

        $SQL_QUERY = "SELECT count(mer_id) AS total_mer FROM mer;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalMER = $this->dataResult[0]["total_mer"];

        $SQL_QUERY = "SELECT count(linea_id) AS total_linea FROM mer_linea;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalLineas = $this->dataResult[0]["total_linea"];

        $SQL_QUERY = "SELECT count(persona_dni) AS total_poblacion FROM persona;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalPoblacion = $this->dataResult[0]["total_poblacion"];
    }

    public function getBasicCenterInfo($centerID)
    {
        $SQL_QUERY = "SELECT * FROM viewBasicCenterInfo WHERE center_id = '".$centerID."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getGeoListResume()
    {
        $SQL_QUERY = "SELECT * FROM viewGeoListResume;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getVoteCenterList($municipioID = false)
    {
        if($municipioID)
        {
            $SQL_QUERY = "SELECT * FROM viewCenterListDetailed WHERE municipio_id = '".$municipioID."';";
            $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
            return $this->dataResult;
        }
        else
        {
            $SQL_QUERY = "SELECT * FROM viewCenterListDetailed;";
            $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
            return $this->dataResult;
        }
    }

    public function getMERList($CenterID)
    {
        $SQL_QUERY = "SELECT * FROM viewMERListDetailed WHERE center_id = '".$CenterID."' AND mer_id IS NOT NULL;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getMERInfo($MER_ID)
    {
        $SQL_QUERY = "SELECT * FROM viewMERInfo WHERE mer_id = '".$MER_ID."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getMERInfoDetail($MER_ID)
    {
        $SQL_QUERY = "SELECT * FROM viewMERInfo WHERE mer_id = '".$MER_ID."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getMERMembers($MER_ID)
    {
        $SQL_QUERY = "SELECT * FROM viewMERMember WHERE mer_id = '".$MER_ID."' ORDER BY role_id ASC;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function createMERMember()
    {
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
    }

    public function checkMemberOnMER($prmDNI)
    {
        $SQL_QUERY = "SELECT * FROM mer_member WHERE member_dni = '".$prmDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getPersonaInfo($prmDNI)
    {
        $SQL_QUERY = "SELECT * FROM viewPersona WHERE persona_dni = '".$prmDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getVoterInfo($prmDNI, $prmToken)
    {
        $hashToken = hash("sha256", $prmToken, false); ;
        $SQL_QUERY = "SELECT * FROM viewPersona WHERE persona_dni = '".$prmDNI."' AND persona_token = '".$hashToken."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function addMERMember()
    {
        $member = $this->getPersonaInfo($this->memberDNI);

        $SQL_QUERY = "INSERT INTO mer_member 
                                    (
                                        member_dni, 
                                        member_firstname, 
                                        member_secondname, 
                                        member_surname, 
                                        member_lastname, 
                                        mer_id, 
                                        role_id
                                    )
                                    VALUES
                                    (
                                        '".$member[0]["persona_dni"]."', 
                                        '".$member[0]["persona_nombre_1"]."', 
                                        '".$member[0]["persona_nombre_2"]."', 
                                        '".$member[0]["persona_apellido_1"]."', 
                                        '".$member[0]["persona_apellido_2"]."', 
                                        '".$this->merID."', 
                                        '".$this->memberRoleID."'
                                    );";

        $this->MainConn->DoCUD($SQL_QUERY);

        $_SESSION["MEMBER_CREATED"] = 1;
    }

    public function getMERMemberInfo($prmDNI)
    {
        $SQL_QUERY = "SELECT * FROM viewMERMember WHERE member_dni = '".$prmDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function removeMERMember()
    {
        $SQL_QUERY = "DELETE FROM mer_member WHERE member_dni = '".$this->memberDNI."';";
        $this->MainConn->DoCUD($SQL_QUERY);
    }

    public function checkMemberRegistered($prmDNI)
    {
        $hashPWD = hash("sha256", trim($this->memberPassword), false);
        $SQL_QUERY = "SELECT * FROM viewMERMember WHERE member_dni = '".$prmDNI."' AND member_password ='".$hashPWD."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getMemberRoleList()
    {
        $SQL_QUERY = "SELECT * FROM mer_member_role ORDER BY role_id ASC;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getFreeMemberRole($MER_ID)
    {
        $SQL_QUERY = "SELECT 
                        mer_member_role.role_id, 
                        mer_member_role.role_name 
                    FROM 
                        mer_member_role AS mer_member_role
                    WHERE NOT EXISTS (
                        SELECT 
                            mer_member.role_id
                        FROM 
                            mer_member AS mer_member
                        WHERE mer_member_role.role_id = mer_member.role_id AND mer_member.mer_id = ".$MER_ID.");";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function createVoteCenter()
    {
        $SQL_QUERY = "INSERT INTO vote_center 
                                    (
                                        departamento_id,
                                        municipio_id, 
                                        center_name
                                    )
                                    VALUES
                                    (
                                        '".$this->DepartamentoID."', 
                                        '".$this->MunicipioID."', 
                                        '".$this->CenterName."'
                                    );";

        $this->MainConn->DoCUD($SQL_QUERY);

        $_SESSION["CENTER_CREATED"] = 1;
    }

    public function createMER($currentCenterID)
    {
        $SQL_QUERY = "INSERT INTO mer 
                                    (
                                        center_id
                                    )
                                    VALUES
                                    (
                                        ".$currentCenterID."
                                    );";

        $this->MainConn->DoCUD($SQL_QUERY);

        $_SESSION["MER_CREATED"] = 1;
    }

    public function checkVoterDone($prmDNI)
    {
        //$SQL_QUERY = "SELECT * FROM voter_success WHERE voter_dni = '".$prmDNI."';";
        $SQL_QUERY = "SELECT * FROM viewMERMemberLog WHERE persona_dni = '".$prmDNI."' AND action_id = 203;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function createActionLog()
    {
        ini_set('date.timezone','America/Tegucigalpa');
        $dateHND = date("Y-m-d H:i");

        $SQL_QUERY = "INSERT INTO
                        log_action
                        (
                            member_dni, 
                            mer_id, 
                            action_id, 
                            persona_dni, 
                            action_datetime
                        )
                        VALUES
                        (
                            '".$this->memberDNI."', 
                            '".$this->merID."', 
                            '".$this->actionID."', 
                            '".$this->personaDNI."', 
                            '".$dateHND."'
                        );";

        $this->MainConn->DoCUD($SQL_QUERY);
    }

    public function getVotingPerson($memberDNI)
    {
        $SQL_QUERY = "SELECT * FROM viewVoterVoting WHERE member_dni = '".$memberDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function comparePersonOnMER()
    {
        $SQL_QUERY = "SELECT * FROM persona WHERE persona_dni = '".$this->personaDNI."' AND mer_id = '".$this->merID."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function checkAvailableSpace()
    {
        $SQL_QUERY = "SELECT * FROM voter_voting WHERE member_dni = '".$this->memberDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function checkPersonVoting()
    {
        $SQL_QUERY = "SELECT * FROM viewVoterVoting WHERE persona_dni = '".$this->personaDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function checkPersonVoteDone()
    {
        $SQL_QUERY = "SELECT * FROM viewVoterSuccess WHERE persona_dni = '".$this->personaDNI."';";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function addPersonVoting()
    {
        ini_set('date.timezone','America/Tegucigalpa');
        $dateHND = date("Y-m-d H:i");

        $SQL_QUERY = "INSERT INTO
                        voter_voting
                        (
                            persona_dni, 
                            mer_id, 
                            member_dni, 
                            voting_datetime
                        )
                        VALUES
                        (
                            '".$this->personaDNI."', 
                            '".$this->merID."', 
                            '".$this->memberDNI."', 
                            '".$dateHND."'
                        );";

        $this->MainConn->DoCUD($SQL_QUERY);
    }

    public function finishVote()
    {
        ini_set('date.timezone','America/Tegucigalpa');
        $dateHND = date("Y-m-d H:i");

        $SQL_QUERY = "INSERT INTO
                        voter_success
                        (
                            persona_dni, 
                            center_id, 
                            mer_id, 
                            member_dni, 
                            voting_datetime
                        )
                        VALUES
                        (
                            '".$this->personaDNI."', 
                            '".$this->CenterID."', 
                            '".$this->merID."', 
                            '".$this->memberDNI."',
                            '".$dateHND."'
                        );";

        $this->MainConn->DoCUD($SQL_QUERY);

        $SQL_QUERY = "DELETE FROM voter_voting WHERE persona_dni = '".$this->personaDNI."';";
        $this->MainConn->DoCUD($SQL_QUERY);

        $this->actionID = 203;
        $this->createActionLog();
    }

    public function getLogValuesForMER($MER_ID)
    {
        $SQL_QUERY = "SELECT count(action_id) AS totalBusquedas FROM viewMERMemberLog WHERE mer_id = ".$MER_ID." AND (action_id = 201 OR action_id = 204 OR action_id = 205 OR action_id = 206);";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalBusquedas = $this->dataResult[0]["totalBusquedas"];

        $SQL_QUERY = "SELECT count(action_id) AS totalVotantesAdmitidos FROM viewMERMemberLog WHERE mer_id = ".$MER_ID." AND action_id = 203;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalVotantesAdmitidos = $this->dataResult[0]["totalVotantesAdmitidos"];

        $SQL_QUERY = "SELECT count(action_id) AS totalVotantesRechazados  FROM viewMERMemberLog WHERE mer_id = ".$MER_ID." AND (action_id = 204 OR action_id = 205 OR action_id = 206);";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        $this->totalVotantesRechazados = $this->dataResult[0]["totalVotantesRechazados"];
    }

    public function getLogForMER($MER_ID)
    {
        $SQL_QUERY = "SELECT * FROM viewMERMemberLog WHERE mer_id = '".$MER_ID."' ORDER BY action_datetime DESC;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }

    public function getRndMERMember()
    {
        $SQL_QUERY = "SELECT * FROM mer_member ORDER BY RAND() LIMIT 1;";
        $this->dataResult = $this->MainConn->DoSelect($SQL_QUERY, DataInterface::SIMPLE_ARRAY);
        return $this->dataResult;
    }
}
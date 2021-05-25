<table class="table table-responsive table-striped"
    <thead>
        <th>DNI</th>
        <th>Nombre</th>
        <th>Hora</th>
        <th></th>
    </thead>
    <tbody>
        <?php
            require_once("../_control/functions.php");
            require_once("../_class/SistemaElectoral.php");
            $SistemaElectoral = new SistemaElectoral();
            if(isset($_GET["member_dni"]))
            {
                $memberDNI = $_GET["member_dni"];
            }
            else
            {
                $memberDNI = $_SESSION["SESSION_MEMBER_DNI"];
            }

            $Votantes = $SistemaElectoral->getVotingPerson($memberDNI);
            foreach($Votantes as &$votante)
            {
                $votingTime = new DateTime($votante["action_datetime"]);
                echo
                '<tr>
                    <td>'.$votante["persona_dni"].'</td>
                    <td>'.$votante["personaFullName"].'</td>
                    <td>'.$votingTime->format('H:i:s').'</td>
                    <td class="text-right">
                        <a href="'.getWebDomain().'_control/_controlSistemaElectoral.php?action=finish_vote&persona_dni='.$votante["persona_dni"].'" class="btn btn-md btn-success add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Finalizar votación">
                            <i class="fas fa-user-check"></i>
                        </a>
                    </td>
                </tr>';
            }
        ?>
    </tbody>
</table>


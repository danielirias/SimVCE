<?php
    require_once("_control/MainLoader.php");

    require_once("_class/SistemaElectoral.php");
    $GeoDetail = new SistemaElectoral();
?>

<!DOCTYPE html>
<html lang="en">

	<head>
        <?php require_once("_segment/style.php"); ?>
		<title><?php echo $_SESSION["APP_NAME"]; ?></title>
	</head>

	<!--TIPS-->
	<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
	<body>
		<div id="container" class="navbar-fixed">
			<?php
                $showMenuButtom = 0;
				require_once("_segment/topbar.php");
			?>
			<div class="boxed">
				<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container" style="padding-left: 0px;">
					<div id="page-head">

						<!--Page Title-->
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<div id="page-title">
							<h1 class="page-header text-overflow"><?php echo $_SESSION["APP_NAME"]; ?></h1>
						</div>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<!--End page title-->
					</div>

					<!--Page content-->
					<!--===================================================-->
					<div id="page-content">
						<div class="row">
							<div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?php
                                                    if(isset($_GET["view"]) == 'center' && isset($_GET["m_id"]))
                                                    {
                                                        $centroVotacion = $GeoDetail->getVoteCenterList($_GET["m_id"]);
                                                        echo
                                                        '<h2>Listado de centros de votación</h2>
                                                        <table class="table table-responsive">
                                                            <tr>
                                                                <td class="text-semibold col-md-3">Departamento:</td>
                                                                <td class="col-md-9">'.$centroVotacion[0]["departamento_nombre"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold">Municipio:</td>
                                                                <td>'.$centroVotacion[0]["municipio_nombre"].'</td>
                                                            </tr>
                                                        </table>
                                                        <hr>';

                                                        echo
                                                        '<table id="tableDetail" class="table table-responsive table-striped">';

                                                        echo
                                                        '<thead>
                                                            <th>ID Centro</th>
                                                            <th>Nombre del centro</th>
                                                            <th>Total MER</th>
                                                        </thead>
                                                        <tbody>';

                                                        foreach ($centroVotacion as &$centro)
                                                        {
                                                            echo
                                                                '<tr>
                                                                <td><a href="detail.php?view=mer&center_id=' . $centro["center_id"] . '">' . str_pad( $centro["center_id"], 5, "0", STR_PAD_LEFT) . '</a></td>
                                                                <td><a href="detail.php?view=mer&center_id=' . $centro["center_id"] . '">' . $centro["center_name"] . '</a></td>
                                                                <td class="text-right">
                                                                    <a href="detail.php?view=mer&center_id=' . $centro["center_id"] . '">
                                                                        <span class="badge badge-default">' . $centro["total_mer"] . '</span>
                                                                    </a>
                                                                </td>
                                                            </tr>';
                                                        }
                                                    }

                                                    if(isset($_GET["view"]) == 'mer' && isset($_GET["center_id"]))
                                                    {
                                                        $centroVotacion = $GeoDetail->getMERList($_GET["center_id"]);
                                                        echo
                                                        '<h2>Listado de Mesas Electorales Receptoras</h2>
                                                        <table class="table table-responsive">
                                                            <tr>
                                                                <td class="text-semibold col-md-3">Centro ID:</td>
                                                                <td class="col-md-9">'.$centroVotacion[0]["center_id"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold col-md-3">Centro de votación:</td>
                                                                <td class="col-md-9">'.$centroVotacion[0]["center_name"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold">Departamento:</td>
                                                                <td>'.$centroVotacion[0]["departamento_nombre"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold">Municipio:</td>
                                                                <td>'.$centroVotacion[0]["municipio_nombre"].'</td>
                                                            </tr>
                                                        </table>
                                                        <hr>';

                                                        echo
                                                        '<table id="tableDetail" class="table table-responsive table-striped">';

                                                        echo
                                                        '<thead>
                                                            <th>MER ID</th>
                                                            <th class="text-right">Personas que votaron</th>
                                                            <th class="text-right">Personas no admitidas</th>
                                                        </thead>
                                                        <tbody>';

                                                        foreach ($centroVotacion as &$MER)
                                                        {
                                                            $GeoDetail->getLogValuesForMER($MER["mer_id"]);

                                                            echo
                                                            '<tr>
                                                                <td><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '">' . str_pad( $MER["mer_id"], 6, "0", STR_PAD_LEFT) . '</a></td>
                                                                <td class="text-right"><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '"><span class="pull-right badge badge-info">' . $GeoDetail->totalVotantesAdmitidos . '</span></a></td>
                                                                <td class="text-right"><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '"><span class="pull-right badge badge-warning">' . $GeoDetail->totalVotantesRechazados . '</span></a></td>
                                                            </tr>';
                                                        }

                                                        echo
                                                        '</table>';
                                                    }

                                                    if(isset($_GET["view"]) == 'history' && isset($_GET["mer_id"]))
                                                    {
                                                        $logRecord = $GeoDetail->getLogForMER($_GET["mer_id"]);

                                                        echo
                                                        '<table id="tableDetail" class="table table-responsive table-hover">
                                                            <thead>
                                                                <th>Hora</th>
                                                                <th>Miembro MER</th>
                                                                <th>Acción realizada</th>
                                                            </thead>
                                                            <tbody>';
                                                                foreach($logRecord as &$log)
                                                                {
                                                                    $date = new DateTime($log["action_datetime"]);

                                                                    $action_def =  $log["action_description"];
                                                                    if(trim($log["personaFullName"]) == '')
                                                                    {
                                                                        $str_persona = '<b>'.$log["persona_dni"].'</b>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $str_persona = '<b>'.$log["personaFullName"].'</b> con D.N.I. <b>'.$log["persona_dni"].'</b>';
                                                                    }

                                                                    $icons = array(
                                                                            101=>'<i class="far fa-circle add-tooltip text-default" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Información"></i>',
                                                                            102=>'<i class="far fa-circle add-tooltip text-default" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Información"></i>',
                                                                            103=>'<i class="far fa-circle add-tooltip text-warning" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Advertencia"></i>',

                                                                            201=>'<i class="far fa-circle add-tooltip text-info" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Información"></i>',
                                                                            202=>'<i class="far fa-circle add-tooltip text-info" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Información"></i>',
                                                                            203=>'<i class="fas fa-circle add-tooltip text-success" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Proceso completo"></i>',
                                                                            204=>'<i class="fas fa-circle add-tooltip text-danger" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Alerta"></i>',
                                                                            205=>'<i class="fas fa-circle add-tooltip text-warning" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Advertencia"></i>',
                                                                            206=>'<i class="fas fa-circle add-tooltip text-danger" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Alerta"></i>'
                                                                    );

                                                                    $action_def = str_replace('[persona]', $str_persona, $action_def);


                                                                    echo
                                                                    '<tr>
                                                                        <td>'.$icons[$log["action_id"]].' '.$date->format('H:i:s').'</td>
                                                                        <td>'.$log["memberFullName"].'<br><small>(D.N.I.: '.$log["member_dni"].')</small></td>
                                                                        <td>'.$action_def.'</td>
                                                                    </tr>';
                                                                }
                                                            echo
                                                            '</tbody>
                                                        </table>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">

                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<!--===================================================-->
					<!--End page content-->
				</div>
				<!--===================================================-->
				<!--END CONTENT CONTAINER-->
			</div>
            
			<?php 
				require_once("_segment/footer.php");
			?>
		</div>
		<!--===================================================-->
		<!-- END OF CONTAINER -->

		<?php 
			require_once("_segment/script.php");
		?>

        <script>
            $(document).ready(function() {
                $('#tableDetail').DataTable( {
                    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
                    "language": {
                        "search": "Buscar:"
                    }
                } );
            } );

        </script>
	</body>
</html>

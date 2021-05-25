<?php
    require_once("_control/MainLoader.php");

    require_once("_class/SistemaElectoral.php");
    $SistemaElectoral = new SistemaElectoral();
    $SistemaElectoral->getValues();
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
                                                <table class="table table-responsive table-striped">
                                                    <thead>
                                                        <th>Elemento</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Centros de votación:</td>
                                                            <td class="text-right"><?php echo number_format($SistemaElectoral->totalCentros); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mesas electorales Receptoras (MER):</td>
                                                            <td class="text-right"><?php echo number_format($SistemaElectoral->totalMER); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Líneas:</td>
                                                            <td class="text-right"><?php echo number_format($SistemaElectoral->totalLineas); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Población habilitada:</td>
                                                            <td class="text-right"><?php echo number_format($SistemaElectoral->totalPoblacion); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h3>Información por departamento y municipio</h3>
                                                <table id="tableDepartamento" class="table table-responsive table-striped">
                                                    <thead>
                                                        <th>Departamento</th>
                                                        <th>Municipio ID</th>
                                                        <th>Municipio</th>
                                                        <th>Total de centros</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $SistemaElectoral = $SistemaElectoral->getGeoListResume();
                                                            foreach($SistemaElectoral as &$GeoInfo)
                                                            {
                                                                echo
                                                                '<tr>
                                                                    <td class="text-left">'.$GeoInfo["departamento_nombre"].'</td>
                                                                    <td class="text-left"><a href="detail.php?view=center&m_id='.$GeoInfo["municipio_id"].'">'.$GeoInfo["municipio_id"].'</a></td>
                                                                    <td class="text-left"><a href="detail.php?view=center&m_id='.$GeoInfo["municipio_id"].'">'.$GeoInfo["municipio_nombre"].'</a></td>
                                                                    <td class="text-right">
                                                                        <a href="detail.php?view=center&m_id='.$GeoInfo["municipio_id"].'">
                                                                            <span class="badge badge-default">'.$GeoInfo["total_center"].'</span>
                                                                        </a>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel">

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
            var groupColumn = 0;
            var table = $('#tableDepartamento').DataTable({
                "columnDefs": [
                    { "visible": false, "targets": groupColumn }
                ],
                "order": [[ groupColumn, 'asc' ]],
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group" style="background-color: #55b4b0; color: white;"><td colspan="4">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                },
                "language": {
                    "search": "Buscar:"
                }
            } );

            // Order by the grouping
            $('#tableDepartamento tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                    table.order( [ groupColumn, 'desc' ] ).draw();
                }
                else {
                    table.order( [ groupColumn, 'asc' ] ).draw();
                }
            } );
        } );
    </script>
	</body>
</html>

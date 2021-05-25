<?php
    require_once("_control/MainLoader.php");
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
							<div class="col-md-12 text-center">
                                <div class="panel">
                                    <div class="panel-body">
                                        <span class="text-primary" style="font-size: 86px; font-weight: bolder;">403</span>
                                        <div class="clearfix"></div>
                                        <h2 class="text-muted">
                                            Acceso denegado. jeje
                                        </h2>
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

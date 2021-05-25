<?php
    require_once("../_control/MainLoader.php");
    if($_SESSION["SESSION_USER_ID"] == '')
    {
        sendCustomError404();
    }

    require_once("../_class/SistemaElectoral.php");
    $SistemaElectoral = new SistemaElectoral();

    $menuID = 'main-panel';
?>

<!DOCTYPE html>
<html lang="en">

	<head>
        <?php require_once("../_segment/style.php"); ?>
		<title><?php echo $_SESSION["APP_NAME"]; ?></title>
	</head>

	<!--TIPS-->
	<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
	<body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg navbar-fixed mainnav-fixed">
			<?php
                $showMenuButtom = 1;
				require_once("../_segment/topbar.php");
			?>
			<div class="boxed">
				<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
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
                                                    //==================================================================
                                                    // CENTROS DE VOTACIÓN
                                                    //==================================================================
                                                    if(isset($_GET["view"]) == 'center' && isset($_GET["m_id"]))
                                                    {
                                                        $centroVotacion = $SistemaElectoral->getVoteCenterList($_GET["m_id"]);
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
                                                            <tr>
                                                                <td class="text-semibold">Total centros de votación:</td>
                                                                <td>'.count($centroVotacion).'</td>
                                                            </tr>
                                                        </table>
                                                        
                                                        <div class="clearfix"></div>
                                                        <button data-target="#modalAddCenter" data-toggle="modal" class="btn btn-md btn-primary">Agregar un nuevo Centro de votación</button>
                                                        
                                                        <!--===================================================-->
                                                        <div class="modal fade" id="modalAddCenter" role="dialog" tabindex="-1" aria-labelledby="modalAddCenter" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form id="formAddVoteCenter" method="post" action="#">
                                                                        <!--Modal header-->
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                                                                            <h4 class="modal-title">Agregar un nuevo Centro de votación</h4>
                                                                        </div>
                                                        
                                                                        <!--Modal body-->
                                                                        <div class="modal-body">
                                                                            <h4>Ubicación: '.$centroVotacion[0]["departamento_nombre"].', '.$centroVotacion[0]["municipio_nombre"].'</h4>
                                                                            
                                                                            <div class="form-group">
                                                                                <input type="hidden" id="departamento_id" value="'.$centroVotacion[0]["departamento_id"].'">
                                                                                <input type="hidden" id="municipio_id" value="'.$centroVotacion[0]["municipio_id"].'">
                                                                                <label class="control-label">Nombre del centro de votación</label>
                                                                                <input id="center_name" name="center_name" type="text" class="form-control" autofocus="true" required aria-required="true"  minlength="6" maxlength="255" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHA_NUMERIC_WITH_SPACE(event);">
                                                                            </div>
                                                                        </div>
                                                        
                                                                        <!--Modal footer-->
                                                                        <div class="modal-footer">
                                                                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                                                                            <button type="button" id="buttonAddVoteCenter" class="btn btn-primary">Aceptar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <!--===================================================-->
                                                        
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
                                                                <td><a href="detail.php?view=mer&center_id=' .$centro["center_id"] . '">' . str_pad( $centro["center_id"], 5, "0", STR_PAD_LEFT) . '</a></td>
                                                                <td><a href="detail.php?view=mer&center_id=' . $centro["center_id"] . '">' . $centro["center_name"] . '</a></td>
                                                                <td class="text-right">
                                                                    <a href="detail.php?view=mer&center_id=' . $centro["center_id"] . '">
                                                                        <span class="badge badge-default">' . $centro["total_mer"] . '</span>
                                                                    </a>
                                                                </td>
                                                            </tr>';
                                                        }
                                                    }

                                                    //==================================================================
                                                    // MER
                                                    //==================================================================

                                                    if(isset($_GET["view"]) == 'mer' && isset($_GET["center_id"]))
                                                    {
                                                        $centerInfo = $SistemaElectoral->getBasicCenterInfo($_GET["center_id"]);
                                                        $MER = $SistemaElectoral->getMERList($_GET["center_id"]);

                                                        echo
                                                        '<h2>Listado de Mesas Electorales Receptoras</h2>
                                                        <table class="table table-responsive">
                                                            <tr>
                                                                <td class="text-semibold col-md-3">Centro ID:</td>
                                                                <td class="col-md-9">'.str_pad( $centerInfo[0]["center_id"], 5, "0", STR_PAD_LEFT).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold col-md-3">Centro de votación:</td>
                                                                <td class="col-md-9">'.$centerInfo[0]["center_name"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold">Departamento:</td>
                                                                <td>'.$centerInfo[0]["departamento_nombre"].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold">Municipio:</td>
                                                                <td><a href="detail.php?view=center&m_id='.$centerInfo[0]["municipio_id"].'" class="badge badge-info">'.$centerInfo[0]["municipio_nombre"].'</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-semibold">Total de Mesas Electorales Receptoras:</td>
                                                                <td>'.count($MER).'</td>
                                                            </tr>
                                                        </table>
                                                        
                                                        <div class="clearfix"></div>
                                                        <button data-target="#modalAddMER" data-toggle="modal" class="btn btn-md btn-primary">Agregar una nueva MER</button>
                                                        
                                                        <!--===================================================-->
                                                        <div class="modal fade" id="modalAddMER" role="dialog" tabindex="-1" aria-labelledby="modalAddMER" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form id="formAddMER" method="post" action="_controlSistemaElectoral.php?action=add_mer&center_id='.$centerInfo[0]["center_id"].'">
                                                                        <!--Modal header-->
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                                                                            <h4 class="modal-title">Agregar una nueva MER</h4>
                                                                        </div>
                                                        
                                                                        <!--Modal body-->
                                                                        <div class="modal-body">
                                                                            <h4>Centro de votación: '.$centerInfo[0]["center_name"].'</h4>
                                                                            <h4>Ubicación: '.$centerInfo[0]["departamento_nombre"].', '.$centerInfo[0]["municipio_nombre"].'</h4>
                                                                            
                                                                            <div class="form-group">
                                                                                <input type="hidden" id="departamento_id" value="'.$centerInfo[0]["departamento_id"].'">
                                                                                <input type="hidden" id="municipio_id" value="'.$centerInfo[0]["municipio_id"].'">
                                                                            </div>
                                                                            
                                                                            <p>Esta acción creará una nueva Mesa Electoral Receptora asignada al actual Centro de Votación.</p>
                                                                        </div>
                                                        
                                                                        <!--Modal footer-->
                                                                        <div class="modal-footer">
                                                                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                                                                            <button type="submit" id="buttonAddMER" class="btn btn-primary">Continuar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <!--===================================================-->
                                                        
                                                        <hr>';


                                                        echo
                                                        '<table id="tableDetail" class="table table-responsive table-striped">';

                                                        echo
                                                        '<thead>
                                                            <th>MER ID</th>
                                                            <th>Votantes recibidos</th>
                                                            <th>Votantes admitidos</th>
                                                            <th>Votantes rechazados</th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>';


                                                        foreach ($MER as &$MER)
                                                        {
                                                            $MemberList = $SistemaElectoral->getMERMembers($MER["mer_id"]);

                                                            if(count($MemberList) < 9)
                                                            {
                                                                $strButton = '<a class="btn btn-md btn-block btn-primary" href="setMer.php?mer_id='.$MER["mer_id"].'">
                                                                                <i class="fas fa-users"></i>&nbsp;Asignar miembros
                                                                            </a>';
                                                            }
                                                            else
                                                            {
                                                                $strButton = '<a class="btn btn-md btn-block btn-info" href="setMer.php?mer_id='.$MER["mer_id"].'">
                                                                                <i class="fas fa-list"></i>&nbsp;Ver detalles
                                                                            </a>';
                                                            }
                                                            echo
                                                            '<tr>
                                                                <td class="text-left"><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '">' . str_pad( $MER["mer_id"], 6, "0", STR_PAD_LEFT) . '</a></td>
                                                                <td class="text-right"><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '">##</a></td>
                                                                <td class="text-right"><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '">##</a></td>
                                                                <td class="text-right"><a href="detail.php?view=history&mer_id=' . $MER["mer_id"] . '">##</a></td>
                                                                <td class="text-right">
                                                                    '.$strButton.'
                                                                </td>
                                                            </tr>';
                                                        }
                                                    }
                                                ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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

                <?php
                include("_segment/menu-left.php");
                ?>

			</div>
            
			<?php 
				require_once("../_segment/footer.php");
			?>
		</div>
		<!--===================================================-->
		<!-- END OF CONTAINER -->

		<?php 
			require_once("../_segment/script.php");
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

        <?php
            if ($_SESSION["CENTER_CREATED"] == 1)
            {
                echo
                '<script>
                    $(document).ready(function() {
                        var strHTML = \'<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="far fa-check-circle"></i></span></div><div class="media-body"><h4 class="alert-title">¡Listo!</h4><p class="alert-message">Se creó el centro de votación.</p><div class="mar-top"></div>\';
        
                        $.niftyNoty({
                            type: "success",
                            container: "floating",
                            html: strHTML,
                            closeBtn: 1,
                            floating: {
                                position: "center-center",
                                animationIn: "jellyIn", //jellyIn, wobble, etc..
                                animationOut: "fadeOut"
                            },
                            focus: true,
                            timer: 3000
                        });
                    } );
                </script>';

                $_SESSION["CENTER_CREATED"] = 0;
            }

            if ($_SESSION["MER_CREATED"] == 1)
            {
                echo
                '<script>
                        $(document).ready(function() {
                            var strHTML = \'<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="far fa-check-circle"></i></span></div><div class="media-body"><h4 class="alert-title">¡Listo!</h4><p class="alert-message">Se creó una nueva MER.</p><div class="mar-top"></div>\';
            
                            $.niftyNoty({
                                type: "success",
                                container: "floating",
                                html: strHTML,
                                closeBtn: 1,
                                floating: {
                                    position: "center-center",
                                    animationIn: "jellyIn", //jellyIn, wobble, etc..
                                    animationOut: "fadeOut"
                                },
                                focus: true,
                                timer: 3000
                            });
                        } );
                    </script>';

                $_SESSION["MER_CREATED"] = 0;
            }
        ?>
	</body>
</html>

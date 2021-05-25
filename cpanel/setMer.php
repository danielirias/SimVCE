<?php
    require_once("../_control/MainLoader.php");
    if($_SESSION["SESSION_USER_ID"] == '')
    {
        sendCustomError404();
    }

    require_once("../_class/SistemaElectoral.php");
    $SistemaElectoral = new SistemaElectoral();
    $MERInfo = $SistemaElectoral->getMERInfo($_GET["mer_id"]);
    $MemberList = $SistemaElectoral->getMERMembers($_GET["mer_id"]);

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
                            <div class="col-md-8">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <table class="table table-responsive table-striped">
                                                <tr>
                                                    <td class="text-semibold" width="30%">Número MER:</td>
                                                    <td><?php echo str_pad($MERInfo[0]["mer_id"], 6, '0', STR_PAD_LEFT); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Número Centro de votación:</td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            <a href="detail.php?view=mer&center_id=<?php echo $MERInfo[0]["center_id"]; ?>" class="text-white"><?php echo $MERInfo[0]["center_id"]; ?></a>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Nombre del centro de votación:</td>
                                                    <td>
                                                        <a href="detail.php?view=mer&center_id=<?php echo $MERInfo[0]["center_id"]; ?>">
                                                            <?php echo $MERInfo[0]["center_name"]; ?>
                                                        </a>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Municipio:</td>
                                                    <td><?php echo $MERInfo[0]["municipio_nombre"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Departamento:</td>
                                                    <td><?php echo $MERInfo[0]["departamento_nombre"]; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel">
                                    <div class="panel-body text-center">
                                        <span class="text-primary" style="font-size: 40px; font-weight: bolder;"><?php echo count($MemberList); ?></span>
                                        <h3 class="text-muted">miembros asignados</h3>
                                    </div>
                                    <div class="panel-footer text-center">
                                        <?php
                                            if(count($MemberList) < 9)
                                            {
                                                echo '<button data-target="#modalAddMERMember" data-toggle="modal" class="btn btn-md btn-primary">Asignar Miembro de MER</button>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--===================================================-->
                        <div class="modal fade" id="modalAddMERMember" role="dialog" tabindex="-1" aria-labelledby="modalAddMERMember" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="formAddMERMember" method="post" action="../_control/_controlSistemaElectoral.php?action=add_mer&center_id=">
                                        <!--Modal header-->
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                                            <h4 class="modal-title">Asignar Miembro en MER <?php echo str_pad($MERInfo[0]["mer_id"], 6, '0', STR_PAD_LEFT); ?></h4>
                                            <input type="hidden" id="txtMERId" value="<?php echo $MERInfo[0]["mer_id"]; ?>">
                                        </div>

                                        <!--Modal body-->
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div id="data-loader" class="load8 text-center" style="height: auto; width: 100%;">
                                                    <h4>Por favor espera...</h4>
                                                    <div class="loader"></div>
                                                </div>
                                                <div id="userAlert"></div>
                                                <label class="control-label">Buscar Número de Identidad</label>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input id="member_dni" name="member_dni" type="text" class="form-control" placeholder="____-____-_____" autofocus="true" required aria-required="true"  minlength="15" maxlength="15" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return INTEGER(event);">
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-md btn-block btn-primary" onclick="getPersonaInfo()">Buscar miembro</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <h4>Datos del miembro MER</h4>

                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label class="control-label">Primer nombre</label>
                                                    <input id="member_firstname" name="member_firstname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                </div>
                                                <div class="col-xs-6">
                                                    <label class="control-label">Segundo nombre</label>
                                                    <input id="member_secondname" name="member_secondname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label class="control-label">Primer apellido</label>
                                                    <input id="member_surname" name="member_surname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                </div>
                                                <div class="col-xs-6">
                                                    <label class="control-label">Segundo apellido</label>
                                                    <input id="member_lastname" name="member_lastname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label class="control-label">Departamento domicilio</label>
                                                    <input id="member_departamento" name="member_departamento" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                </div>
                                                <div class="col-xs-6">
                                                    <label class="control-label">Municipio domicilio</label>
                                                    <input id="member_municipio" name="member_municipio" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Cargo en la MER</label>
                                                        <select id="member_role" name="member_role" class="selectpicker" autofocus="true" required aria-required="true" title="Seleccione un cargo">
                                                            <?php
                                                                $roleList = $SistemaElectoral->getFreeMemberRole($MERInfo[0]["mer_id"]);
                                                                foreach($roleList as &$role)
                                                                {
                                                                    echo
                                                                    '<option value="'.$role["role_id"].'">'.$role["role_name"].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Modal footer-->
                                        <div id="divFooter" class="modal-footer" style="display: none;">
                                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                                            <button type="button" id="buttonAddMERMember" name="buttonAddMERMember" class="btn btn-success">Continuar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--===================================================-->

                        <div class="row">
                            <?php
                                foreach($MemberList as &$Member)
                                {
                                    if(substr( $Member["role_id"], 0, 1) == 1) { $classLevel = 'bg-info'; }
                                    if(substr( $Member["role_id"], 0, 1) == 2) { $classLevel = 'bg-warning'; }
                                    if(substr( $Member["role_id"], 0, 1) == 3) { $classLevel = 'bg-purple'; }
                                    echo
                                    '<div id="member_'.$Member["member_dni"].'" class="col-sm-4">
                                        <div class="panel widget">
                                            <div class="widget-header '.$classLevel.' text-center">
                                                <img class="img-lg img-circle img-border mar-btm" src="'.getWebDomain().'res/img/profile-photos/8.png">
					                            <h3 class="mar-no text-white">'.$Member["member_firstname"].' '.$Member["member_secondname"].' '.$Member["member_surname"].' '.$Member["member_lastname"].'</h3>
                                                <h4 class="mar-no text-white">'.$Member["member_dni"].'</h4>
                                                <h4 class="mar-no text-white">'.$Member["role_name"].'</h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="list-group bg-trans mar-no">
                                                    <a class="list-group-item list-item-sm" href="#">
                                                        <span class="label label-info pull-right">15</span>
                                                        Votantes recibidos
                                                    </a>
                                                    <a class="list-group-item list-item-sm" href="#">
                                                        <span class="label label-success pull-right">100</span>
                                                        Votantes admitidos
                                                    </a>
                                                    <a class="list-group-item list-item-sm" href="#">
                                                        <span class="label label-danger pull-right">300</span>
                                                        Votantes rechazados
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="panel-footer text-right">
                                                <button type="button" class="btn btn-md btn-danger" onclick="dropMember(\''.$Member["member_firstname"].' '.$Member["member_secondname"].' '.$Member["member_surname"].' '.$Member["member_lastname"].'\', \''.$Member["member_dni"].'\')">Eliminar a este miembro</button>
                                            </div>
                                        </div>
                                        
                                    </div>';
                                }
                            ?>
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
            $("#member_dni").mask("9999-9999-99999");
        </script>

        <?php
        if ($_SESSION["MEMBER_CREATED"] == 1)
        {
            echo
            '<script>
                $(document).ready(function() {
                    var strHTML = \'<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="far fa-check-circle"></i></span></div><div class="media-body"><h4 class="alert-title">¡Listo!</h4><p class="alert-message">Se asignó un nuevo miembro a la MER.</p><div class="mar-top"></div>\';
    
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

            $_SESSION["MEMBER_CREATED"] = 0;
        }
        ?>
	</body>
</html>

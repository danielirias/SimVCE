<?php
    require_once("../_control/MainLoader.php");
    if($_SESSION["SESSION_MEMBER_DNI"] == '')
    {
        sendCustomError403();
    }

    require_once("../_class/SistemaElectoral.php");
    $SistemaElectoral = new SistemaElectoral();
    $Member = $SistemaElectoral->getMERMemberInfo($_SESSION["SESSION_MEMBER_DNI"]);
    $SistemaElectoral->memberDNI = $_SESSION["SESSION_MEMBER_DNI"];

    $SistemaElectoral->getLogValuesForMER($_SESSION["SESSION_MEMBER_MER_ID"]);

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
		<div id="container" class="effect navbar-fixed mainnav-fixed">
			<?php
                $showMenuButtom = 0;
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
                            <div class="col-md-6">
                                <div class="panel widget">
                                    <?php
                                    if(substr( $Member[0]["role_id"], 0, 1) == 1) { $classLevel = 'bg-info'; }
                                    if(substr( $Member[0]["role_id"], 0, 1) == 2) { $classLevel = 'bg-warning'; }
                                    if(substr( $Member[0]["role_id"], 0, 1) == 3) { $classLevel = 'bg-purple'; }
                                    echo
                                    '<div class="widget-header '.$classLevel.' text-center">
                                        <img class="img-lg img-circle img-border mar-btm" src="'.getWebDomain().'res/img/profile-photos/8.png">
                                        <h3 class="mar-no text-white">'.$Member[0]["member_firstname"].' '.$Member[0]["member_secondname"].' '.$Member[0]["member_surname"].' '.$Member[0]["member_lastname"].'</h3>
                                        <h4 id="memberDNI" class="mar-no text-white">'.$Member[0]["member_dni"].'</h4>
                                        <h4 class="mar-no text-white">'.$Member[0]["role_name"].'</h4>
                                    </div>'
                                    ?>
                                    <div class="widget-body">
                                        <div class="list-group bg-trans mar-no">
                                            <a class="list-group-item list-item-sm" href="#" style="display: none;">
                                                <span class="label label-info pull-right"><?php echo $SistemaElectoral->totalBusquedas; ?></span>
                                                Votantes buscados en MER
                                            </a>
                                            <a class="list-group-item list-item-sm" href="#">
                                                <span class="label label-success pull-right"><?php echo $SistemaElectoral->totalVotantesAdmitidos; ?></span>
                                                Personas que votaron en esta MER
                                            </a>
                                            <a class="list-group-item list-item-sm" href="#">
                                                <span class="label label-danger pull-right"><?php echo $SistemaElectoral->totalVotantesRechazados; ?></span>
                                                Personas que no admitidas en esta MER
                                            </a>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="button" class="btn btn-md btn-block btn-default" onclick="logOutMERMember()" >Cerrar sesión</button>
                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <table class="table table-responsive table-striped">
                                                <tr>
                                                    <td class="text-semibold" width="50%">Número MER:</td>
                                                    <td><?php echo str_pad($Member[0]["mer_id"], 6, '0', STR_PAD_LEFT); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Número Centro de votación:</td>
                                                    <td>
                                                        <?php echo $Member[0]["center_id"]; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Nombre del centro de votación:</td>
                                                    <td>
                                                        <?php echo $Member[0]["center_name"]; ?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Municipio:</td>
                                                    <td><?php echo $Member[0]["municipio_nombre"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-semibold">Departamento:</td>
                                                    <td><?php echo $Member[0]["departamento_nombre"]; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div id="data-loader" class="load8 text-center">
                                    <h4>Por favor espera...</h4>
                                    <div class="loader"></div>
                                </div>
                                <div class="panel">
                                    <form id="formGetVotante" method="post" action="#">
                                        <div class="panel-body">

                                            <h3>Buscar un votante</h3>
                                            <div class="form-group">
                                                <label class="control-label">Número de identidad</label>
                                                <input type="text" id="persona_dni" name="persona_dni" class="form-control" placeholder="____-____-_____" autofocus="true" required aria-required="true"  minlength="6" maxlength="255" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Token</label>
                                                <input type="text" id="persona_token" name="persona_token" class="form-control" placeholder="____-____" autofocus="true" required aria-required="true"  minlength="6" maxlength="255" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                                            </div>

                                            <div id="personaInfo" style="display: none;">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <label class="control-label">Primer nombre</label>
                                                        <input id="persona_firstname" name="persona_firstname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label class="control-label">Segundo nombre</label>
                                                        <input id="persona_secondname" name="persona_secondname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <label class="control-label">Primer apellido</label>
                                                        <input id="persona_surname" name="persona_surname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label class="control-label">Segundo apellido</label>
                                                        <input id="persona_lastname" name="persona_lastname" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <label class="control-label">Departamento domicilio</label>
                                                        <input id="persona_departamento" name="persona_departamento" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label class="control-label">Municipio domicilio</label>
                                                        <input id="persona_municipio" name="persona_municipio" type="text" class="form-control" readonly autofocus="true" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false"  onkeypress="return ALPHABETIC_WITH_SPACE(event);">
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>

                                                <div id="alertStatus">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <div id="userAlert"></div>
                                            <div class="clearfix"></div>
                                            <button type="button" id="btnGetVotante" class="btn btn-md btn-block btn-success">Buscar</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="panel">
                                    <div class="panel-body">
                                        <h3>Personas realizando voto</h3>
                                        <div id="votingPerson">
                                            <?php include "votingPerson.php"; ?>
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
                    //include("_segment/menu-left.php");
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
            $("#persona_dni").mask("9999-9999-99999");
            $.mask.definitions['h'] = "[A-Z0-9]";
            $("#persona_token").mask("hhhh-hhhh");
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

        if ($_SESSION["FINISH_VOTE"] == 1)
        {
            echo
            '<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: "success",
                        title: "¡Todo bien!",
                        text: "Se registró un nuevo voto en la MER.",
                    });
                } );
            </script>';

            $_SESSION["FINISH_VOTE"] = 0;
        }
        ?>
	</body>
</html>

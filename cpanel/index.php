<?php
    require_once("../_control/MainLoader.php");
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
		<div id="container" class="navbar-fixed">
			<?php
                $showMenuButtom = 0;
				require_once("../_segment/topbar.php");
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
							<div class="col-md-6 col-md-offset-3">
                                <form id="formSignInUser" method="post" action="mainPanel.php">
                                    <div class="panel">
                                        <div id="data-loader" class="load8 text-center">
                                            <h4>Por favor espera...</h4>
                                            <div class="loader"></div>
                                        </div>
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Iniciar sesión</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="userAlert"></div>
                                            <div class="clearfix"></div>

                                            <div class="form-group">
                                                <input type="text" id="login_email" name="login_email" class="form-control" placeholder="Correo electrónico" autofocus="true" required aria-required="true"  minlength="6" maxlength="255" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
                                                <!--<input type="text" id="login_email" name="login_email" class="form-control" placeholder="Núm. de Identidad" autofocus="true" required aria-required="true"  minlength="13" maxlength="13" onCut="return false" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" onkeypress="return INTEGER(event);">-->
                                            </div>

                                            <div class="form-group">
                                                <input type="password" id="login_password" name="login_password" type="password" class="form-control" placeholder="Contraseña" required aria-required="true" minlength="8" maxlength="255">
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <button type="button" id="buttonSignInUser" name="buttonSignIn" class="btn btn-success">Iniciar sesión</button>
                                        </div>
                                    </div>
                                </form>
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
				require_once("../_segment/footer.php");
			?>
		</div>
		<!--===================================================-->
		<!-- END OF CONTAINER -->

		<?php 
			require_once("../_segment/script.php");
		?>
	</body>
</html>

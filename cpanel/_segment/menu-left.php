<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container" class="affix-top">
	<div id="mainnav">

		<!--OPTIONAL : ADD YOUR LOGO TO THE NAVIGATION-->
		<!--It will only appear on small screen devices.-->
		<!--================================
		<div class="mainnav-brand">
			<a href="index.html" class="brand">
				<img src="img/logo.png" alt="Nifty Logo" class="brand-icon">
				<span class="brand-text">Nifty</span>
			</a>
			<a href="forms-validation.html#" class="mainnav-toggle"><i class="pci-cross pci-circle icon-lg"></i></a>
		</div>
		-->

        <!--Menu-->
		<!--================================-->
		<div id="mainnav-menu-wrap">
			<div class="nano">
				<div class="nano-content"  style="display: block">

					<!--Profile Widget-->
					<!--================================-->
					<div id="mainnav-profile" class="mainnav-profile">
						<div class="profile-wrap text-center">
							<div class="pad-btm">
								<a href="<?php echo getWebDomain(); ?>"><img class="img-circle img-md" src="../../res/img/flag-hn.jpg" alt="Honduras"></a>
                            </div>
							<a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
								<span class="pull-right dropdown-toggle">
									<i class="dropdown-caret"></i>
								</span>
								<p class="mnp-name">
									<?php echo $_SESSION["USER_EMAIL"]; ?>
								</p>
								<span class="mnp-desc"><?php echo $_SESSION["USER_EMAIL"]; ?></span>
							</a>
						</div>
						<div id="profile-nav" class="collapse list-group bg-trans">
							<!--<a href="my-account.php" class="list-group-item">
								<i class="demo-pli-male icon-lg icon-fw"></i> Mi perfil
							</a>-->
							
							<a href="log-out.php" class="list-group-item">
								<i class="demo-pli-unlock icon-lg icon-fw"></i> Cerrar sesión
							</a>
						</div>
					</div>

					<ul id="mainnav-menu" class="list-group">
						<!--Category name-->
						<li class="list-header">Menú</li>
                        <!--============= M E N U  I T E M =============-->
                        <?php
                            if($GLOBALS["menuID"] == 'main-panel'){$strClass = 'active-sub active';}else{$strClass = '';}
                        ?>
                        <li class="<?php echo $strClass; ?>">
                            <a href="mainPanel.php">
                                <i class="fas fa-tachometer-alt"></i>
                                <span class="menu-title">
                                    Panel principal
                                    <span class="label label-success pull-right">23</span>
                                </span>
                            </a>
                        </li>

                        <!--============= M E N U  I T E M =============-->
                        <?php
                            if($GLOBALS["menuID"] == 'center-list'){$strClass = 'active-sub active';}else{$strClass = '';}
                        ?>
                        <li class="<?php echo $strClass; ?>">
                            <a href="program-list.php">
                                <i class="fas fa-vote-yea"></i>
                                <span class="menu-title">
                                    Mesas Electorales Receptoras
                                    <span class="label label-success pull-right">23</span>
                                </span>
                            </a>
                        </li>

					</ul>
				</div>
			</div>
		</div>
		<!--================================-->
		<!--End menu-->

	</div>
</nav>
<!--===================================================-->
<!--END MAIN NAVIGATION-->
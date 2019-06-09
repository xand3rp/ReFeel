<nav class="navbar navbar-expand-lg bg-danger" style="color: white;">
	<img src="../public/assets/logo-w.png" style="width: 150px;" />
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<!--<h4 class="h4">Donor Dashboard</h4>-->
			<li class="nav-item active">
				<a class="nav-link btn btn-danger m-sm-1" href="clientHome.php">Donations</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link btn btn-danger m-sm-1" href="clientProfile.php">Profile</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link btn btn-danger m-sm-1" href="clientIntSheet.php">Survey</a>
			</li>
			<!--
			<li class="nav-item active">
				<a class="nav-link btn btn-danger m-sm-1" href="clientAcc.php">Account</a>
			</li>
			-->
		</ul>
		<div class="form-inline my-2 my-lg-0 text-center">
			<ul class="navbar-nav m-auto">
				<li class="nav-item pt-1 pr-1">
					<img src="../public/img/<?php echo $varImg;?>" style="width: 50px; border-radius: 25px;" />
				</li>
				<li class="nav-item dropdown">
					<button type="button" class="btn btn-danger text-right">
						<?php
							echo "Welcome, " . $varFname . "!";
						?>
						<br>
						<span style="font-size: 14px;">
						<?php
							echo $varRole . "&nbsp;";
						?>
						</span>
					</button>
					<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					</button>

					<div class="dropdown-menu">
						<!--
						<a class="dropdown-item" href="#">Profile</a>
						<a class="dropdown-item" href="#">Settings</a>
						<a class="dropdown-item" href="#">Help</a>
						<div class="dropdown-divider"></div>
						-->
						<a class="dropdown-item" href="valClientLogout.php">Log out</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="assets/images/blood.ico">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="assets/fa/css/all.min.css" type="text/css">
		<link rel="stylesheet" href="assets/css/bs-override.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="assets/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="assets/swal/sweetalert.min.js" type="text/javascript"></script>
		<title>ReFeel - Profile</title>
	</head>
	<?php
		include "checkSession.php";
		include "fetchClientAcc.php";
		// include "fetchClientDonStats.php";
		// include "fetchClientMedStats.php";
	?>
	<body>
		<!-- Navigation bar -->
		<?php
			include "clientNavBar.php";
		?>

		<div class="container border mt-sm-4 mb-sm-4">
			<div class="col-10 m-auto mt-sm-4 p-4 text-center">
				<div>
					<img src="../img/<?php echo $varImg;?>" id='idClntImg' style="width: 150px; border-radius: 75px;" />
				</div>
				<h4 class="h4 mt-sm-4">
				<?php
					if($varMname == "")	{
						echo "$varFname $varLname";
					}
					else	{
						$varMidInit = substr($varMname, 0, 1);

						if(substr_count($varMname, " ") != 0)	{
							$varMidInit .= substr($varMname, strpos($varMname, " ")+1, 1);
						}

						echo "$varFname $varMidInit. $varLname";
					}
				?>
				</h1>
				<h6 class="h6"><?php echo "$varRole"; ?></h1>
			</div>
			<hr />
			<div class="container">
				<div class="card-deck">
					<div class="card mb-4" style="border-radius: 25px 25px 0px 0px">
						<div class="card-header bg-danger text-white" style="border-radius: 25px 25px 0px 0px;">
							<span class="float-left p-1">
								Personal Information
							</span>
							<button class="btn btn-danger float-right p-1" title="Edit your personal information." data-toggle="modal" data-target="#modalPerInfo">
								<i class="fa fa-pen"></i>
							</button>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="w-50 px-2 py-1 font-weight-bold">Name:</div>
								<div class="w-50 px-2 py-1">
									<?php
										echo $varLname . ', ' . $varFname . ' ' . $varMname;
									?>
								</div>
							</div>
							<div class="row">
								<div class="w-50 px-2 py-1 font-weight-bold">Sex:</div>
								<div class="w-50 px-2 py-1">
									<?php
										echo $varSex;
									?>
								</div>
							</div>
							<div class="row">
								<div class="w-50 px-2 py-1 font-weight-bold">Birthday:</div>
								<div class="w-50 px-2 py-1">
									<?php
										echo date_format(date_create($varBday), "F d, Y");
									?>
								</div>
							</div>
							<div class="row">
								<div class="w-50 px-2 py-1 font-weight-bold">Age:</div>
								<div class="w-50 px-2 py-1">
									<?php
										echo $varAge;
									?>
								</div>
							</div>
							<div class="row">
								<div class="w-50 px-2 py-1 font-weight-bold">Civil Status:</div>
								<div class="w-50 px-2 py-1">
									<?php
										echo $varCvlStat;
									?>
								</div>
							</div>
							<div class="row">
								<div class="w-50 px-2 py-1 font-weight-bold">Occupation:</div>
								<div class="w-50 px-2 py-1">
									<?php
										echo $varOcc;
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="card mb-4 border-0" style="border-radius: 25px 25px 0px 0px">
						<div class="card-body">
							<div class="card mb-4" style="border-radius: 25px 25px 0px 0px">
								<div class="card-header bg-danger text-white" style="border-radius: 25px 25px 0px 0px;">
									<span class="float-left p-1">
										Contact Information
									</span>
									<button class="btn btn-danger float-right p-1" title="Edit your contact information." data-toggle="modal" data-target="#modalContInfo">
										<i class="fa fa-pen"></i>
									</button>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="w-50 px-2 py-1 font-weight-bold">Phone Number:</div>
										<div class="w-50 px-2 py-1">
											<?php
												echo $varContNo;
											?>
										</div>
									</div>
									<div class="row">
										<div class="w-50 px-2 py-1 font-weight-bold">E-mail Address:</div>
										<div class="w-50 px-2 py-1">
											<?php
												echo $varEmail;
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="card mb-4" style="border-radius: 25px 25px 0px 0px">
								<div class="card-header bg-danger text-white" style="border-radius: 25px 25px 0px 0px;">
									<span class="float-left p-1">
										Account Credentials
									</span>
									<button class="btn btn-danger float-right p-1" title="Edit your account credentials." data-toggle="modal" data-target="#modalAccInfo">
										<i class="fa fa-pen"></i>
									</button>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="w-50 px-2 py-1 font-weight-bold">Username:</div>
										<div class="w-50 px-2 py-1">
											<?php
												echo $varUn;
											?>
										</div>
									</div>
									<div class="row">
										<div class="w-50 px-2 py-1 font-weight-bold">Password:</div>
										<div class="w-50 px-2 py-1">
											**********
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					include "clientPersonalInfo.php";
					include "clientContactInfo.php";
					include "clientAccountInfo.php";
				?>
			</div>
		</div>
	</body>
</html>

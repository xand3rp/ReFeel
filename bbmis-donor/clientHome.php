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
		<title>ReFeel - Donor Donations</title>
	</head>
	<?php
		include "checkSession.php";
		include "fetchClientAcc.php";
	?>
	<body>
		<?php
			include "clientNavBar.php";
		?>
		<div class="container">
			<div class="card my-4" style="border-radius: 25px">
				<div class="card-header bg-danger text-white text-center p-2" style="border-radius: 25px 25px 0px 0px; cursor: pointer;" href="#divDonRec">
					Donation Progress
				</div>
				<div class="card-body">
					<div class="card-deck">
						<div class="card border text-center p-4">
							<div id='idMeBtn' class="btn btn-outline-danger m-auto" style="border-radius: 75px;">
								<i class="fa fa-4x fa-notes-medical p-4"></i>
							</div>
							<div class="mt-4 h5">Step 1</div>
							<div class="h6">Medical Exam</div>
							<div id="idMeRemarks">&nbsp;</div>
						</div>
						<div class="card border text-center p-4">
							<div id='idPeBtn' class="btn btn-outline-danger m-auto" style="border-radius: 100px;">
								<i class="fa fa-4x fa-stethoscope p-4"></i>
							</div>
							<div class="mt-4 h5">Step 2</div>
							<div class="h6">Physical Exam</div>
							<div id="idPeRemarks">&nbsp;</div>
						</div>
						<div class="card border text-center p-4">
							<div id='idIsBtn' class="btn btn-outline-danger m-auto" style="border-radius: 100px;">
								<i class="fa fa-4x fa-vial p-4"></i>
							</div>
							<div class="mt-4 h5">Step 3</div>
							<div class="h6">Initial Screening</div>
							<div id="idIsRemarks">&nbsp;</div>
						</div>
						<div class="card border text-center p-4">
							<div id='idSsBtn' class="btn btn-outline-danger m-auto" style="border-radius: 100px;">
								<i class="fa fa-4x fa-microscope p-4"></i>
							</div>
							<div class="mt-4 h5">Step 4</div>
							<div class="h6">Serological Screening</div>
							<div id="idSsRemarks">&nbsp;</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-center p-2" style="border-radius: 0px 0px 25px 25px">
					<?php
						include "fetchDonationCode.php";
					?>
				</div>
			</div>
			
			<div class="card my-4" style="border-radius: 25px">
				<div class="card-header bg-danger text-white text-center p-2" style="border-radius: 25px 25px 0px 0px; cursor: pointer;" data-toggle="collapse" href="#divDonRec" role="button" aria-expanded="false" aria-controls="collapseExample">
					Donation Record
				</div>
				<div class="card-body" id="divDonRec">
					<?php
						include "fetchClientDonations.php";
					?>
				</div>
				<div class="card-footer text-center p-2" style="border-radius: 0px 0px 25px 25px">
					Total Donations: <?php echo $varDonations;?>
				</div>
			</div>
		</div>
	</body>
	<script>
		$(document).ready(function()	{
			var styles = $(this).serialize();
			$.ajax	({
				url: "clientDonationDetail.php",
				data: {styles:styles},
				success: function(data)	{
					console.log(data);
					var varObj = jQuery.parseJSON(data);
					
					//No donation record
					if(varObj.me == '0')	{
						$("#idMeRemarks, #idPeRemarks, #idIsRemarks, #idSsRemarks").addClass("font-weight-bold");
						$("#idMeRemarks, #idPeRemarks, #idIsRemarks, #idSsRemarks").css("color", "#46B8DA");
						$("#idMeRemarks").text("Unanswered");
						$("#idPeRemarks, #idIsRemarks, #idSsRemarks").text("Unscreened");
					}
					
					//Medical Exam
					if(varObj.me == '1')	{
						$("#idMeBtn").addClass("active");
						$("#idMeRemarks").addClass("font-weight-bold");
						$("#idMeRemarks").text("Passed");
						$("#idMeRemarks").css("color", "#5CB85C");
					}
					else if(varObj.me == '2')	{
						$("#idMeBtn").addClass("active");
						$("#idMeRemarks").addClass("font-weight-bold");
						$("#idMeRemarks").text("Failed");
						$("#idMeRemarks").css("color", "#D4403B");
					}
					else if(varObj.me == '3')	{
						//Male - Unchecked
						$("#idMeBtn").addClass("active");
						$("#idMeRemarks").addClass("font-weight-bold");
						$("#idMeRemarks").text("Unchecked");
						$("#idMeRemarks").css("color", "#46B8DA");
					}
					else if(varObj.me == '4')	{
						//Female - Checking Error
						$("#idMeBtn").addClass("active");
						$("#idMeRemarks").addClass("font-weight-bold");
						$("#idMeRemarks").text("Checking Error");
						$("#idMeRemarks").css("color", "#46B8DA");
					}
					else if(varObj.me == '5')	{
						$("#idMeBtn").addClass("active");
						$("#idMeRemarks").addClass("font-weight-bold");
						$("#idMeRemarks").text("Unchecked");
						$("#idMeRemarks").css("color", "#46B8DA");
					}
					else if(varObj.me == '6')	{
						$("#idMeBtn").addClass("active");
						$("#idMeRemarks").addClass("font-weight-bold");
						$("#idMeRemarks").text("Expired");
						$("#idMeRemarks").css("color", "#46B8DA");
					}
					
					//Physical Exam
					if(varObj.pe == '0')	{
						$("#idPeRemarks").addClass("font-weight-bold");
						$("#idPeRemarks").text("Unscreened");
						$("#idPeRemarks").css("color", "#46B8DA");
					}
					else if(varObj.pe == '1')	{
						$("#idPeBtn").addClass("active");
						$("#idPeRemarks").addClass("font-weight-bold");
						$("#idPeRemarks").text("Passed");
						$("#idPeRemarks").css("color", "#5CB85C");
					}
					else if(varObj.pe == '2')	{
						$("#idPeBtn").addClass("active");
						$("#idPeRemarks").addClass("font-weight-bold");
						$("#idPeRemarks").text("Failed");
						$("#idPeRemarks").css("color", "#D4403B");
					}
					
					//Initial Screening
					if(varObj.is == '0')	{
						$("#idIsRemarks").addClass("font-weight-bold");
						$("#idIsRemarks").text("Unscreened");
						$("#idIsRemarks").css("color", "#46B8DA");
					}
					else if(varObj.is == '1')	{
						$("#idIsBtn").addClass("active");
						$("#idIsRemarks").addClass("font-weight-bold");
						$("#idIsRemarks").text("Passed");
						$("#idIsRemarks").css("color", "#5CB85C");
					}
					else if(varObj.is == '2')	{
						$("#idIsBtn").addClass("active");
						$("#idIsRemarks").addClass("font-weight-bold");
						$("#idIsRemarks").text("Failed");
						$("#idIsRemarks").css("color", "#D4403B");
					}
					
					//Serological Screening
					if(varObj.ss == '0')	{
						$("#idSsRemarks").addClass("font-weight-bold");
						$("#idSsRemarks").text("Unscreened");
						$("#idSsRemarks").css("color", "#46B8DA");
					}
					else if(varObj.ss == '1')	{
						$("#idSsBtn").addClass("active");
						$("#idSsRemarks").addClass("font-weight-bold");
						$("#idSsRemarks").text("Passed");
						$("#idSsRemarks").css("color", "#5CB85C");
					}
					else if(varObj.ss == '2')	{
						$("#idSsBtn").addClass("active");
						$("#idSsRemarks").addClass("font-weight-bold");
						$("#idSsRemarks").text("Failed");
						$("#idSsRemarks").css("color", "#D4403B");
					}
				}
			});
		});
	</script>
</html>
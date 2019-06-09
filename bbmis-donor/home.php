<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="../public/assets/blood.ico">
		<link rel="stylesheet" href="../public/css/bs-override.css" type="text/css">
		<link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="../public/fa/css/all.min.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Welcome to ReFeel!</title>
	</head>
	<body>
		<?php
			include "checkSessionOut.php";
		?>
		<!-- Navigation bar -->
		<nav class="navbar navbar-expand-lg border-bottom">
			<a class="navbar-brand" href="#">
				<img src="../public/assets/logo-a2.png" style="width: 200px;" />
			</a>
			<button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link btn text-dark m-sm-1" href="https://time.is" target="_blank">
							<?php
								date_default_timezone_set("Asia/Hong_Kong");
								echo date("l, F d, Y, h:iA")
							?>
						</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link btn text-danger border-danger m-sm-1" data-toggle="modal" data-target="#modalLogin">Log In</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link btn text-danger border-danger m-sm-1" data-toggle="modal" data-target="#modalSignUp">Sign up</a>
					</li>
				</ul>
			</div>
		</nav>
		<?php
			include "clientLogin.php";
			include "clientSignup.php";
			// include "clientSignupImg.php";
		?>
		<!-- Carousel/Slideshow -->
		<div class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="../public/assets/carousel/ss0.png">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="../public/assets/carousel/ss1.jpg">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="../public/assets/carousel/ss2.jpg">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="../public/assets/carousel/ss3.jpg">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="../public/assets/carousel/ss4.jpg">
				</div>
			</div>
		</div>                                   
		<div class="container">
			<h1 class="display-4 text-center pt-4" id="jumpHome">Welcome to <b>ReFeel!</b></h1>
			<div class="container">
				<p class="pt-4 text-justify">
					The blood bank serves as the main source of blood needed for the operations done in the hospital. They are capable of accepting blood donations, platelet donations and storing the bloods that they gathered in the donation. They are also capable of performing tests with the blood they collected. It is a blood service facility responsible for donor screening and selection, blood collection, testing, preparation, handling, storage, release, and dispatch of all its blood products.
					<br>
					<br>
					<b>ReFeel</b> is a Blood Bank Monitoring and Inventory System that is designed to store, process, retrieve, and analyze information concerned with the administration, inventory, and monitoring within the blood bank.
					<br>
					<br>
					The system also gives them the capability to view their past records of the donor with ease which is useful for maintaining good quality of blood that they collect. The purpose of the system is to make the information easier to retrieve and relevant to their needs. The system will be having an online appointment system, database of the bloods collected, and database of medical history of the donor and its donation records.
				</p>
			</div>
		</div>
		<footer class="page-footer font-small pt-4 mt-4" style="background-color:#C03D43; color: white;">
			<div class="footer-copyright text-center py-3">
				<img src="../public/assets/logo-w.png" style="width: 200px;">
				<p>
					Copyright from bloodbois&trade;
					<?php echo "2017-" . date("Y") . '.';?>
				</p>
				<p>All rights reserved.</p>
			</div>
		</footer>
	</body>
	<script src="../public/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="../public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../public/swal/sweetalert.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#frmClientLogin").submit(function(e)	{
			e.preventDefault();
			var formdata = $(this).serialize();
			console.log(formdata);
			$.ajax({
				url:"valClientLogin.php",
				type:"POST",
				data:{formdata:formdata},
				success:function(data){
					console.log(data);
					if(data == 1){
						window.location.href = "clientHome.php";
					}
					else if (data == 2) {
						swal("Oops!", "Donor and applicants are only allowed to access the donor side page.", "error");
					}
					else if (data == 3) {
						swal("Oops!", "Password is incorrect.", "error");
					}
					else if (data == 4) {
						swal("Oops!", "Account is not existing, please register first.", "error");
					}
				}
			})
		});
		
		$("#frmClientSignup").submit(function(e){
			e.preventDefault();
			var formdata2 = $(this).serialize();
			console.log(formdata2);
			
			swal({
				title: "Warning.",
				text: "Are you sure you want to submit your information?",
				icon: "info",
				buttons: ['No', 'Yes'],
			}).then((willSignup) => {
				if(willSignup)	{
					$.ajax	({
						url:"valClientSignup.php",
						type:"POST",
						data:{formdata2:formdata2},
						success:function(data)	{
							console.log(data);
							if(data == 1)	{
								swal({
									title: 'Done!',
									text: 'You successfully signed up! Please login your account.',
									icon: 'success'
								}).then(() => {
									$("#modalSignUp").modal("hide");
									$("#modalLogin").modal("show");
								});
							}
							else if (data == 2) {
								swal("Oops!", "Account is already existing. Please signup again.", "error");
							}
						}
					});
				}
			});
		});
	</script>
</html>
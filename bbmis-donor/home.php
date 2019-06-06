<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="assets/blood.ico">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="assets/css/bs-override.css" type="text/css">
		<link href="assets/images/blood.ico" rel="icon">
		<link href="assets/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
		<link href="assets/css/bs-override.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="assets/fa/css/all.min.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="assets/swal/sweetalert.min.js" type="text/javascript"></script>
		<script src="assets/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<title>Welcome to ReFeel!</title>
	</head>
	<body>
		<?php
			include "checkSessionOut.php";
		?>
		<!-- Navigation bar -->
		<nav class="navbar navbar-expand-lg border-bottom">
			<a class="navbar-brand" href="#">
				<img src="assets/images/logo-a2.png" style="width: 200px;" />
			</a>

			<!-- All button transformed into single button when the width is congested. -->
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

		<!-- Modal for Login -->
		<?php
			include "clientLogin.php";
		?>

		<!-- Modal for Signup -->
		<?php
			include "clientSignup.php";
			include "clientSignupImg.php";
		?>

		<!-- Carousel/Slideshow -->
		<div class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="assets/images/carousel/ss0.png">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="assets/images/carousel/ss1.jpg">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="assets/images/carousel/ss2.jpg">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="assets/images/carousel/ss3.jpg">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="assets/images/carousel/ss4.jpg">
				</div>
			</div>
		</div>

		<!-- Main Content -->                                      
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

			<!-- Feature Card Deck -->
			<!--h1 class="display-4 text-center pt-4" id="jumpFeat">Features</h1>
			<div class="container">
				<div class="row pt-4 text-center">
					<div class="card-deck m-auto">
						<div class="card">
							<img class="card-img" src="assets/images/blood2.png">
							<div class="card-header">
								Set Donation Appointment
							</div>
							<div class="card-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisis tortor nec pharetra blandit. Aliquam erat volutpat. Nam aliquet, nisi vitae eleifend fermentum, eros orci convallis diam, sit amet congue erat turpis vitae quam. Nunc ut velit in nunc rutrum pulvinar. Aliquam sagittis risus orci, vel lacinia quam ullamcorper quis. Aenean augue justo, venenatis nec varius quis, pretium eu orci. In sed lectus id sem consectetur malesuada. Sed sed tincidunt odio.
							</div>
						</div>
						<div class="card">
							<img class="card-img" src="assets/images/blood2.png">
							<div class="card-header">
								Manage Blood Inventory
							</div>
							<div class="card-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisis tortor nec pharetra blandit. Aliquam erat volutpat. Nam aliquet, nisi vitae eleifend fermentum, eros orci convallis diam, sit amet congue erat turpis vitae quam. Nunc ut velit in nunc rutrum pulvinar. Aliquam sagittis risus orci, vel lacinia quam ullamcorper quis. Aenean augue justo, venenatis nec varius quis, pretium eu orci. In sed lectus id sem consectetur malesuada. Sed sed tincidunt odio.
							</div>
						</div>
						<div class="card">
							<img class="card-img" src="assets/images/blood2.png">
							<div class="card-header">
								Manage Donor Records
							</div>
							<div class="card-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisis tortor nec pharetra blandit. Aliquam erat volutpat. Nam aliquet, nisi vitae eleifend fermentum, eros orci convallis diam, sit amet congue erat turpis vitae quam. Nunc ut velit in nunc rutrum pulvinar. Aliquam sagittis risus orci, vel lacinia quam ullamcorper quis. Aenean augue justo, venenatis nec varius quis, pretium eu orci. In sed lectus id sem consectetur malesuada. Sed sed tincidunt odio.
							</div>
						</div>
					</div>
				</div>
			</div-->
			<!--h1 class="display-4 text-center pt-4" id="jumpAbout">About Us</h1>
			<div class="container">
				<p class="pt-4">
					Etiam volutpat leo at sapien aliquet accumsan. In congue pulvinar nulla, eu molestie ex varius a. Aliquam erat volutpat. Pellentesque vulputate sed lectus vel bibendum. Pellentesque in orci libero. Aliquam finibus lectus quis rhoncus dapibus. Cras non lacus ipsum. Nullam luctus est mauris, vitae posuere turpis convallis sit amet. Ut eget nulla eu felis ultricies imperdiet. Mauris id nisi ac quam vulputate ultrices. Nunc a risus sapien.
					<br>
					<br>
					Quisque quis accumsan lorem, et interdum dolor. Duis maximus urna sit amet egestas lacinia. Morbi mattis velit quis magna egestas aliquet. Nullam pretium, sapien id ultricies dictum, eros libero congue nibh, sollicitudin pharetra dui neque egestas lectus. Nullam eu tincidunt orci. Donec lobortis vestibulum lacus et aliquam. Aliquam turpis lorem, convallis a erat ut, volutpat accumsan odio. Suspendisse sed felis laoreet, feugiat quam non, molestie nisl. Quisque pharetra laoreet neque, eget eleifend metus feugiat nec. Integer velit ipsum, tristique ut ipsum vitae, tempus sagittis ipsum. Fusce a tortor fringilla, blandit urna ac, laoreet ligula. Nullam ac orci nisl. Sed vehicula lacus nunc, ut finibus lacus lacinia eget. Proin aliquet odio nibh, sed laoreet justo varius vel.
				</p>
			</div-->
			<!--h1 class="display-4 text-center pt-4" id="jumpCont">Contact Us</h1>
			<div class="container">
				<p class="pt-4">
					If you have any questions, suggestions, or something you need to tell about the blood bank, please contact us by filling the fields here. Your feedback will be highly appreciated.
				</p>
				<div class="container w-50 pt-4">
					<form>
						<div class="form-group">
							<label for="">Name (optional)</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group">
							<label for="">E-mail address (optional)</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group">
							<label for="">Message</label>
							<textarea class="form-control" rows="5"></textarea>
						</div>
						<button class="btn btn-outline-danger m-sm-1" type="submit">Submit</button>
					</form>
				</div>
			</div-->
		</div>
		<footer class="page-footer font-small pt-4 mt-4" style="background-color:#C03D43; color: white;">
			<div class="footer-copyright text-center py-3">
				<img src="assets/images/logo-w.png" style="width: 200px;">
				<p>Copyright from bloodbois&trade; 2017-<?php echo date("Y");?>.</p>
				<p>All rights reserved.</p>
			</div>
		</footer>
	</body>
	<script src="assets/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</html>
</html>
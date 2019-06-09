<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>ReFeel - Donor</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="../public/img/blood.ico">
		<link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/all.css">
		<link rel="stylesheet" href="../public/css/datatables.min.css">
		<link rel="stylesheet" href="../public/css/bs-override.css">
	</head>
	<body>
		<?php include "components/loader.php"; ?>
		<div class="wrapper">
			<?php include "components/sidebar.php"; ?>
			<div class="mainpanel">
				<?php include "components/header.php"; ?>
				<div class="page-title">
					<h3 class="p-2">Donor</h3>
				</div>
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 col-lg-12 p-0">
								<div class="content-container" style="padding-bottom: 5rem;">
									<h4 class="py-2">Current Applicant/Donors</h4>
									<table id="tblDonor" class="table table-hover table-bordered text-center">
										<thead>
											<tr class="bg-danger text-white">
											<!--
												<td>First Name</td>
												<td>Middle Name</td>
												<td>Last Name</td>
											-->
												<td>Name</td>
												<td>Type</td>
												<td>Action</td>
											</tr>
										</thead>
									</table>
									<button type="button" class="btn btn-outline-danger float-right mt-3 mx-4" data-toggle="modal" data-target="#modalSignUp">
										<i class="fas fa-user-plus mr-1"></i> 
										Add Donor
									</button>
								</div>
							</div>
							<div class="col-md-12 col-lg-12 p-0 mt-2">
								<div class="content-container">
									<h4 class="py-2">Banned Donors</h4>
									<table id="tblBannedDonor" class="table table-hover table-bordered text-center">
										<thead>
											<tr class="bg-danger text-white">
												<!--
												<td>First Name</td>
												<td>Middle Name</td>
												<td>Last Name</td>
												-->
												<td style="width: 50%">Name</td>
												<td style="width: 50%">Action</td>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- modals -->
		<!-- Applicant Register modal -->
		 <div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
					<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
						<h5 class="modal-title text-white">
							<i class="fa fa-user-plus px-2 fa-sm"></i> 
							Applicant Register
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" class='text-white'>&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<form action="../controller/donor/valClientSignup.php" method="POST" id="client_signup" enctype="multipart/form-data">
								<p class="text-muted"><small><strong>PERSONAL INFORMATION</strong></small></p>
								<hr style="margin-top: -15px;" />
								
								<div class="row">
									<div class="form-group w-50 p-2">
										<div>
											<label for="clientimage">Image</label>
										</div>
										<img id="imageprev" class="mx-auto d-block mt-2 mb-4 border" style = "width:200px; height:200px" src="" alt="your image" />
										<input type="file" class="form-control-file" id='clientimage' name ='clientimage'>
									</div>
									<div class="w-50 p-2 my-auto">
										<!-- Name -->
										<div class="form-group">
											<label for="lblFirstName" class="col-form-label">First Name</label>
											<span style="color: red;">*</span>
											<input type="text" class="form-control" id="lblFirstName" name="txtFname" required="required" />
										</div>
										<div class="form-group">
											<label for="lblMiddleName" class="col-form-label">Middle Name (if any)</label>
											<input type="text" class="form-control" id="lblMiddleName" name="txtMname" />
										</div>
										<div class="form-group">
											<label for="lblLastName" class="col-form-label">Last Name</label>
											<span style="color: red;">*</span>
											<input type="text" class="form-control" id="lblLastName" name="txtLname" required="required" />
										</div>
									</div>
								</div>

								<!-- Contact No. -->
								<div class="form-group">
									<label for="lblContactNo" class="col-form-label">Contact No.</label>
									<span style="color: red;">*</span>
									<input type="text" class="form-control" id="lblContactNo" name="txtContNo" required="required" />
								</div>

								<div class="row">
									<!-- Sex -->
									<div class="form-group col-6">
										<label for="lblSex" class="col-form-label">Sex</label>
										<span style="color: red;">*</span>
										<select class="form-control" name="optSex" required="required">
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>

									<!-- Civil Status -->
									<div class="form-group col-6">
										<label for="lblCvlStat" class="col-form-label">Civil Status</label>
										<span style="color: red;">*</span>
										<select class="form-control" name="optCvlStat" required="required">
											<option value="Single">Single</option>
											<option value="Married">Married</option>
											<option value="Divorced">Divorced</option>
											<option value="Separated">Separated</option>
											<option value="Widowed">Widowed</option>
										</select>
									</div>
								</div>

								<!-- Birthdate -->
								<div class="row">
									<div class="form-group col-4">
										<label for="lblBdate" class="col-form-label">Birthmonth</label>
										<span style="color: red;">*</span>
										<select class="form-control" name="txtBm" required="required">

										<!-- Fetch months -->
										<?php
											for($m=1; $m<=12; $m++) {
												$month = date("F", mktime(0,0,0,$m, 1, date("Y")));
												echo "<option value='$m'>$month</option>";
											}
										?>

										</select>
									</div>

									<div class="form-group col-4">
										<label for="lblBdate" class="col-form-label">Birthday</label>
										<span style="color: red;">*</span>
										<select class="form-control" name="txtBd" required="required">";
										<?php
											for($d=1; $d<=31; $d++)	{
												echo "<option value='$d'>$d</option>";
                      }
										?>
										</select>
									</div>

									<div class="form-group col-4">
										<label for="lblBdate" class="col-form-label">Birthyear</label>
										<span style="color: red;">*</span>
										<select class="form-control" name="txtBy" required="required">
										<?php
											$curYear = date("Y");
											for($y=($curYear-($curYear-18)); $y<=($curYear-($curYear-60)); $y++)	{
												$z = $curYear-$y;
												echo "<option value='$z'>$z</option>";
											}
										?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="lblOcc" class="col-form-label">Occupation</label>
									<span style="color: red">*</span>
									<input type="text" class="form-control" name="txtOcc" required="required" />
								</div>

								<p class="text-muted"><small><strong>ACCOUNT CREDENTIALS</strong></small></p>
								<hr style="margin-top: -15px;" />

								<!-- Username -->
								<div class="form-group">
									<label for="lblUn" class="col-form-label">Username</label>
									<span style="color: red">*</span>
									<input type="text" class="form-control" name="txtUn" required="required">
								</div>

								<!-- Password -->
								<div class="form-group">
									<label for="lblPw" class="col-form-label">Password</label>
									<span style="color: red">*</span>
									<input type="password" class="form-control" name="txtPw" required="required">
								</div>

								<div class="modal-footer">
									<span style="color: red">Fields with asterisk(*) are required.</span>
									<button type="submit" class="btn btn-outline-danger">Register</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Edit Applicant/Donor modal -->
		<div class="modal fade" id="editdonorinfo" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
					<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
						<h5 class="modal-title text-white" id="editdonorinfo">
							<i class="fa fa-user-edit px-2 fa-sm"></i> 
							Edit Donor Info
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-close="Close">
							<span aria-hidden="true" class='text-white'>&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<form action="../controller/donor/editDonorRecord.php" method="post" name="editdonor" enctype="multipart/form-data">
								<div class="row">
									<div class="form-group w-50 p-2">
										<div>
											<label for="clientimage">Image</label>
										</div>
										<img id="imageprev2" class="mx-auto d-block mt-2 mb-4 border" style = "width:200px; height:200px" src="" alt="your image" />
										<input type="file" class="form-control-file" id='clientimage2' name ='clientimage2'>
									</div>
									<div class="w-50 p-2 my-auto">
										<div class="form-group">
											<input type = "hidden" id ='clientId' name ='clientId'>
											<label for="clientfname">First Name</label>
											<input type="text" class="form-control" id='clientfname'name ='clientfname' >
										</div>
										<div class="form-group">
											<label for="clientminit">Middle Name</label>
											<input type="text" class="form-control" id='clientminit' name ='clientminit' >
										</div>
										<div class="form-group">
											<label for="clientlname">Last Name</label>
											<input type="text" class="form-control" id='clientlname' name ='clientlname'>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="clientocc">Occupation</label>
									<input type="text" class="form-control" id='clientocc' name ='clientocc'>
								</div>
								<div class="form-group">
									<label for="clientcontact">Contact</label>
									<input type="number" class="form-control" id='clientcontact' name="clientcontact">
								</div>
								<!--
								<div class="form-group">
									<label for="clientsex">Sex</label>
									<select class ='form-control' name='clientsex' id = 'clientsex' disabled>
										<option value='Male'>Male</option>
										<option value='Male'>Female</option>
									</select>
								</div>
								-->
								<div class="form-group">
									<label for="clientcivstat">Civil Status</label>
									<select name="clientcivstat" class="form-control" id="clientcivstat">
										<option value="Married">Married</option>
										<option value="Widowed">Widowed</option>
										<option value="Separated">Separated</option>
										<option value="Divorced">Divorced</option>
										<option value="Single">Single</option>
									</select>
								</div>
								<div class="form-group">
									<label for="clientbday">Age</label>
									<input type="text" class="form-control" id='clientbday' disabled>
								</div>
								<div class="form-group">
									<label for="clientbloodtype">Blood Type</label>
									<select class="form-control" name="clientbloodtype" id="clientbloodtype">
										<?php
											include("connections.php");

											$fetch_bloodtype = mysqli_query($connections, "
												SELECT *
												FROM tblbloodtype
												WHERE stfBloodTypeStatus = 'Active'
											");

											if(mysqli_num_rows($fetch_bloodtype) > 0 ){
												while($row = mysqli_fetch_assoc($fetch_bloodtype)){
													$blood_typeid = $row["intBloodTypeId"];
													$blood_type = $row["stfBloodType"];
													$rhesus = $row["stfBloodTypeRhesus"];
										?>
												<!--
												<option value="<?php echo $blood_typeid ?>"><?php echo $blood_type . " " . $rhesus ?></option>
												-->
												<option value="<?php echo $blood_typeid ?>"><?php echo $blood_type; echo ($rhesus == 'Negative' || $rhesus == 'Positive') ? ($rhesus == 'Positive' ? '+' : '-') : " " . $rhesus ?></option>
										<?php
												}
											}
										?>
									</select>
								</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="mr-4">
							<button type="button" class="mx-1 btn btn-outline-secondary" data-dismiss="modal">
								<i class="fa fa-times fa-sm mr-1"></i>
								Close
							</button>
							<button type="submit" class="mx-1 btn btn-success" id="submit_editdonor">
								<i class="fa fa-save fa-sm mr-1"></i>
								Save
							</button>
						</div>
					</div>
							</form>
				</div>
			</div>
		</div>
		<?php include "components/core-script.php"; ?>
		<script src="../public/js/datatables.min.js"></script>
		<script src="../public/js/notification.js"></script>
		<script src="../public/js/sweetalert.min.js"></script>
		<script>
			$('#maintenance').addClass('active');
			$('#donor').addClass('active');
			$('.loader').hide();

			checkExpiringBloodBags();

			function checkExpiringBloodBags() {
				$.ajax({
					type: "POST",
					url: "../controller/blood/checkExpiringBloodBags.php",
					complete: function(){
						setTimeout(checkExpiringBloodBags, 60000);
					}
				});
			}
			
			// $(document).ajaxStart(function() {
			//   $('.loader').show();
			// });

			// $(document).ajaxComplete(function() {
			//   $('.loader').hide();
			// });

			//fetch donors
			let fetchDonor = 'fetchDonor';
			$('#tblDonor').DataTable({
				'processing': true,
				'serverSide': true,
				// 'ordering': false,
				'columnDefs': [{
					'orderable': false,
					'targets': 2
				}],
				'ajax': {
					url: '../controller/donor/datatables.php',
					type: 'POST',
					data: { type: fetchDonor }
				}
			});

			//fetch banned donors
			let bannedDonor = 'bannedDonor';
			$('#tblBannedDonor').DataTable({
				'processing': true,
				'serverSide': true,
				'columnDefs': [{
					'orderable': false,
					'targets': 1
				}],
				'ajax': {
					url: '../controller/donor/datatables.php',
					type: 'POST',
					data: { type: bannedDonor }
				}
			});

			$('#editdonorinfo').on('show.bs.modal', function(e) {
				var rowid = $(e.relatedTarget).data('id');
				var fname = $(e.relatedTarget).data('fname');
				var mname = $(e.relatedTarget).data('mname');
				var lname = $(e.relatedTarget).data('lname');
				var occ = $(e.relatedTarget).data('occ');
				var contact = $(e.relatedTarget).data('contact');
				var sex = $(e.relatedTarget).data('sex');
				var btype = $(e.relatedTarget).data('btype');
				var status = $(e.relatedTarget).data('status');
				var age = $(e.relatedTarget).data('age');
				var imagedir = $(e.relatedTarget).attr('data-image');
				console.log(imagedir);
			//  alert(btype);
				$("#clientId").val(rowid);
				$("#clientfname").val(fname);
				$("#clientminit").val(mname);
				$("#clientlname").val(lname);
				$("#clientocc").val(occ);
				$("#clientcontact").val(contact);
				$("#clientsex").val(sex);
				$("#clientbloodtype").val(btype);
				$("#clientcivstat").val(status);
				$("#clientbday").val(age);
				$('#imageprev2').attr('src', "../public/img/" + imagedir);
				
				var bbtype = $('#clientbloodtype').val();
				console.log(bbtype);
			});
			
			/*
			$("form[name='editdonor'").submit(function(e)	{
				e.preventDefault();
				var formdata = $(this).serialize();
				
				// console.log(formdata);
				
				swal({
					title: 'Notice.',
					text: "Are you sure you want to update the user's information?",
					icon: 'info',
					buttons: ['No', 'Update'],
				}).then((willRequest) => {
					if(willRequest)	{
						$.ajax	({
							url:"../controller/donor/editDonorRecord.php",
							type:"POST",
							data:{formdata:formdata},
							success:function(data)	{
								console.log(data);
								if(data == '1')	{
									swal({
										title: 'Done!',
										text: "User's information has been updated.",
										icon: 'success'
									}).then(() => {
										$("#editdonorinfo").modal('hide');
										// window.location.href = 'clientProfile.php'
									});
								}
							}
						});
					}
					else	{
						swal('Okay.', 'Nothing is updated.', 'success');
					}
				});
			});
			
			*/

			function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function(e) {
						$('#imageprev').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}

			$("#clientimage").change(function() {
				readURL(this);
			});

			function readURL2(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function(e) {
						$('#imageprev2').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}

			$("#clientimage2").change(function() {
				readURL2(this);
			});
		</script>
	</body>
</html>
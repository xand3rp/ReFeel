<div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
			<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
				<h5 class="modal-title text-white">Sign Up</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class='text-white'>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="valClientSignup.php" method="POST" id="frmClientSignup">

					<p class="text-muted"><small><strong>PERSONAL INFORMATION</strong></small></p>
					<hr style="margin-top: -15px;" />

					<div class="row">
						<!-- Name -->
						<div class="form-group col-4">
							<!--i class="fa fa-user"></i-->
							<label for="lblFirstName" class="col-form-label">First Name</label>
							<span style="color: red;">*</span>
							<input type="text" class="form-control" id="lblFirstName" name="txtFname" required="required" />
						</div>
						<div class="form-group col-4">
							<label for="lblMiddleName" class="col-form-label">Middle Name (if any)</label>
							<input type="text" class="form-control" id="lblMiddleName" name="txtMname" />
						</div>
						<div class="form-group col-4">
							<label for="lblLastName" class="col-form-label">Last Name</label>
							<span style="color: red;">*</span>
							<input type="text" class="form-control" id="lblLastName" name="txtLname" required="required" />
						</div>
					</div>

					<!-- Contact No. -->
					<div class="form-group">
						<label for="lblContactNo" class="col-form-label">Contact No.</label>
						<span style="color: red;">*</span>
						<input type="text" class="form-control" id="lblContactNo" name="txtContNo" minlength=7 required="required" />
					</div>
					
					<div class="form-group">
						<label for="lblEmail" class="col-form-label">E-mail Address</label>
						<input type="email" class="form-control" id="lblEmail" name="txtEmail" />
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
							<select class="form-control" name="txtBd" required="required">
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
						<input type="text" class="form-control" name="txtUn" minlength=8 required="required">
					</div>

					<!-- Password -->
					<div class="form-group">
						<label for="lblPw" class="col-form-label">Password</label>
						<span style="color: red">*</span>
						<input type="password" class="form-control" name="txtPw" minlength=8 required="required">
					</div>

					<div class="modal-footer pb-1">
						<span style="color: red">Fields with asterisk(*) are required.</span>
						<button type="submit" class="btn btn-outline-danger">Sign Up</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
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
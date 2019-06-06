<div class="modal fade" id="modalPerInfo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
			<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
				<i class="fa fa-user-edit p-2" style="color: white;"></i>
				<h5 class="modal-title text-white" style=" vertical-align: middle;">Personal Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class='text-white'>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" id="frmClientPersInfo">
					<!-- Name -->
					<div class="row">
						<div class="form-group col-4">
							<label for="lblFirstName" class="col-form-label">First Name</label>
							<input type="text" class="form-control" id="lblFirstName" name="txtNewFname" value="<?php echo $varFname;?>" />
						</div>
						<div class="form-group col-4">
							<label for="lblMiddleName" class="col-form-label">Middle Name</label>
							<input type="text" class="form-control" id="lblMiddleName" name="txtNewMname" value="<?php echo $varMname;?>" />
						</div>
						<div class="form-group col-4">
							<label for="lblLastName" class="col-form-label">Last Name</label>
							<input type="text" class="form-control" id="lblLastName" name="txtNewLname" value="<?php echo $varLname;?>" />
						</div>
					</div>
					
					<!-- Sex, Civil Status -->
					<div class="row">
						<div class="form-group col-6">
							<label for="lblSex" class="col-form-label">Sex</label>
							<!--input type="text" class="form-control" id="lblSex" /-->
							<select class="form-control" name="optNewSex" id="lblSex" value="<?php echo $varSex;?>" required="required">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
						</div>
						
						<div class="form-group col-6">
							<label for="lblCvlStat" class="col-form-label">Civil Status</label>
							<!--input type="text" class="form-control" id="lblCvlStat" /-->
							<select class="form-control" id="lblCvlStat" name="optNewCvlStat" value="<?php echo $varCvlStat;?>" required="required">
									<option value="Single">Single</option>
									<option value="Married">Married</option>
									<option value="Divorced">Divorced</option>
									<option value="Separated">Separated</option>
									<option value="Widowed">Widowed</option>
								</select>
						</div>
					</div>
					
					<!-- Birthday -->
					<div class="row">
						<div class="form-group col-4">
							<label for="lblBdate" class="col-form-label">Birthmonth</label>
							<select class="form-control" name="optNewBm" value="<?php $varBmo = date_create($varBday); echo date_format($varBmo, 'n');?>" required="required">

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
							<select class="form-control" name="optNewBd" value="<?php $varDate = date_create($varBday); echo date_format($varDate, 'j');?>" required="required">
								<?php
									for($d=1; $d<=31; $d++)	{
										echo "<option value='$d'>$d</option>";
									}
								?>
							</select>
						</div>

						<div class="form-group col-4">
							<label for="lblBdate" class="col-form-label">Birthyear</label>
							<select class="form-control" name="optNewBy" value="<?php $varDate = date_create($varBday); echo date_format($varDate, 'Y');?>" required="required">
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
					
					<!-- Occupation -->
					<div class="form-group">
						<label for="lblOcc" class="col-form-label">Occupation</label>
						<input type="text" class="form-control" name="txtNewOcc" value="<?php echo $varOcc;?>" required="required" />
					</div>
					
					<div class="modal-footer pb-1">
						<?php
							include "fetchUpdateBtn.php";
						?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(e)	{
		var varSetSex = $("select[name='optNewSex']").attr("value");
		var varSetCvlStat = $("select[name='optNewCvlStat']").attr("value");
		var varSetBm = $("select[name='optNewBm']").attr("value");
		var varSetBd = $("select[name='optNewBd']").attr("value");
		var varSetBy = $("select[name='optNewBy']").attr("value");
		
		$("select[name='optNewSex'] option[value='" + varSetSex + "']").prop('selected', true);
		$("select[name='optNewCvlStat'] option[value='" + varSetCvlStat + "']").prop('selected', true);
		$("select[name='optNewBm'] option[value='" + varSetBm + "']").prop('selected', true);
		$("select[name='optNewBd'] option[value='" + varSetBd + "']").prop('selected', true);
		$("select[name='optNewBy'] option[value='" + varSetBy + "']").prop('selected', true);
	});
	
	$("#btnReq").click(function(e)	{
		$("#frmClientPersInfo").submit(function(e){
			e.preventDefault();
			var formdata = $(this).serialize();
			console.log(formdata);
			
			swal({
				title: 'Notice.',
				text: 'Are you sure you want to send a request?',
				icon: 'info',
				buttons: ['No', 'Send Request'],
			}).then((willRequest) => {
				if(willRequest)	{
					$.ajax	({
						url:"updateClientAcc.php",
						type:"POST",
						data:{formdata:formdata},
						success:function(data)	{
							console.log(data);
							if(data == '1')	{
								swal({
									title: 'Got it!',
									text: 'Your request has been sent.',
									icon: 'success'
								}).then(() => {
									$("#modalPerInfo").modal('hide');
									window.location.href = 'clientProfile.php'
								});
							}
						}
					});
				}
				else	{
					swal('Okay.', 'Your request is cancelled.', 'success');
				}
			});
		});
	});
	
	$("#btnUpd").click(function(e)	{
		$("#frmClientPersInfo").submit(function(e){
			e.preventDefault();
			var formdata = $(this).serialize();
			console.log(formdata);
			
			swal({
				title: 'Notice.',
				text: 'Are you sure you want to update your personal information?',
				icon: 'info',
				buttons: ['No', 'Update'],
			}).then((willRequest) => {
				if(willRequest)	{
					$.ajax	({
						url:"updateClientAcc.php",
						type:"POST",
						data:{formdata:formdata},
						success:function(data)	{
							console.log(data);
							if(data == '2')	{
								swal({
									title: 'Done!',
									text: 'Your personal information has been updated.',
									icon: 'success'
								}).then(() => {
									$("#modalPerInfo").modal('hide');
									window.location.href = 'clientProfile.php'
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
	});
</script>
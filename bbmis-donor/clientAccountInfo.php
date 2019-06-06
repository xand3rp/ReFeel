<div class="modal fade" id="modalAccInfo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
			<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
				<i class="fa fa-key p-2" style="color: white;"></i>
				<h5 class="modal-title text-white" style=" vertical-align: middle;">Account Credentials</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class='text-white'>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" id="frmClientAccInfo">
					<div class="form-group">
						<label for="lblUn" class="col-form-label">Username</label>
						<input type="text" class="form-control" name="txtNewUn" value="<?php echo $varUn;?>" required="required" />
					</div>
					<div class="form-group">
						<label for="lblOldPw" class="col-form-label">Recent Password</label>
						<input type="password" class="form-control" name="txtOldPw" required="required" />
					</div>
					<div class="form-group">
						<label for="lblNewPw" class="col-form-label">New Password</label>
						<input type="password" class="form-control" name="txtNewPw" minlength=8 required="required" />
					</div>
					<div class="form-group">
						<label for="lblConfNewPw" class="col-form-label">Confirm New Password</label>
						<input type="password" class="form-control" name="txtConfNewPw" minlength=8 required="required" />
					</div>
					
					<div class="modal-footer pb-1">
						<input type='hidden' name='btnAct' value='Account' />
						<input type='submit' value='Update' id='btnAcc' class='btn btn-outline-danger' />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	var varCounter = 0;
	
	$("#btnAcc").click(function(e)	{
		$("#frmClientAccInfo").submit(function(e){
			e.preventDefault();
			var formdata = $(this).serialize();
			console.log(formdata);
			
			swal({
				title: 'Notice.',
				text: 'Are you sure you want to update your account information?',
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
							if(data == '1')	{
								swal({
									title: 'Got it!',
									text: 'Your account information has been updated.',
									icon: 'success'
								}).then(() => {
									$("#modalAccInfo").modal('hide');
									window.location.href = 'clientProfile.php'
								});
							}
							else if(data == '2')	{
								swal({
									title: 'Oops.',
									text: 'Your password fields does not match. Please try again.',
									icon: 'error'
								}).then(() => {
									varCounter++;
									if(varCounter == 3)	{
										swal('Oh no.', 'You entered the credentials wrong 3 consecutive times. Please try again later.', 'error');
										$("#modalAccInfo").modal('hide');
										varCounter = 0;
									}
								});
							}
							else if(data == '3')	{
								swal({
									title: 'Oops.',
									text: 'Your current password is incorrect. Please try again.',
									icon: 'error'
								}).then(() => {
									varCounter++;
									if(varCounter == 3)	{
										swal('Oh no.', 'You entered the credentials wrong 3 consecutive times. Please try again later.', 'error');
										$("#modalAccInfo").modal('hide');
										varCounter = 0;
									}
								});
							}
						}
					});
				}
				else	{
					swal('Okay.', 'Nothing is changed.', 'success');
				}
			});
		});
	});
</script>
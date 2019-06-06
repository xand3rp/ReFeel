<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
			<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
				<h5 class="modal-title text-white text-capitalize">Log In</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class='text-white'>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="valClientLogin.php" method="POST" id="frmClientLogin">
					<div class="form-group">
						<label for="lblUn" class="col-form-label">Username</label>
						<input type="text" class="form-control" name="txtUn" required="required" />
					</div>
					<div class="form-group">
						<label for="lblPw" class="col-form-label">Password</label>
						<input type="password" class="form-control" name="txtPw" required="required" />
					</div>
					<div class="modal-footer pb-1">
						<button type="submit" class="btn btn-outline-danger">Log In</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$("#frmClientLogin").submit(function(e){
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
</script>
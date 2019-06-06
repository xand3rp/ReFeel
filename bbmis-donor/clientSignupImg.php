<div class="modal fade" id="modalSignupImg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style='border-radius: 30px 30px 25px 25px;'>
			<div class="modal-header bg-danger" style='border-radius: 25px 25px 0px 0px;'>
				<h5 class="modal-title text-white text-capitalize">Signup: Upload Picture</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class='text-white'>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="valClientSignupImg.php" method="POST" id="frmClientSignupImg" enctype="multipart/form-data">
					<div class="form-group">
						<label for="fileimg" class="col-form-label">Picture</label>
						<input type="file" class="form-control-file" name="fileimg" id="fileimg" required="required" />
					</div>
					<div class="modal-footer pb-1">
						<button type="submit" class="btn btn-outline-danger">Upload</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
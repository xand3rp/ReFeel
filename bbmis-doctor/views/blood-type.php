<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Blood Type</title>
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
        <h3 class="p-2">Blood Type</h3>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Active Blood Type</h4>
                <table id="tblActiveBloodType" class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 30%">Blood Type</td>
                      <td style="width: 30%">Rhesus</td>
                      <td style="width: 40%">Action</td>
                    </tr>
                  </thead>
                </table>
								<button type="button" class="btn btn-outline-danger float-right my-2 mx-4" data-toggle="modal" data-target="#addBloodTypeModal">
									<i class="fas fa-plus mr-1"></i>
									Add Blood Type
								</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12 p-0 mt-2">
							<div class="content-container" style="padding-bottom: 4rem;">
								<h4 class="py-2">Inactive Blood Type</h4>
								<table id="tblInactiveBloodType" class="table table-bordered table-hover text-center">
									<thead>
										<tr class="bg-danger text-white">
											<td style="width: 30%">Blood Type</td>
											<td style="width: 30%">Rhesus</td>
											<td style="width: 40%">Action</td>
										</tr>
									</thead>
								</table>
								<button type="button" class="btn btn-outline-danger float-right my-2 mx-4" data-toggle="modal" data-target="#addBloodTypeModal">
									<i class="fas fa-plus mr-1"></i>
									Add Blood Type
								</button>
							</div>
						</div>
					</div>
        </div>
      </div>
    </div>
  </div>
	
  <!-- modals -->
	<!--Modal: Add Blood Type-->
	<div class="modal fade" id="addBloodTypeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="addnewbloodcomponentTitle">
						<i class="fa fa-plus px-2 fa-sm"></i> 
						Add Blood Type
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<form method="POST" action ="addnewbloodtype.php" name="form_addnewbloodtype">
					<div class="modal-body">
						<div class="form-group">
							<label for="newBloodTypeName">ABO Type</label>
							<input type="text" class="form-control" id='newBloodTypeName' name ='newBloodTypeName' required>
						</div>
						<div class="form-group">
							<label for="newBloodComponentName"> Rhesus</label>
							<select class="form-control" id='newBloodRhesusName' name ='newBloodRhesusName' required>
								<option value = 'Positive'>Positive</option>
								<option value = 'Negative'>Negative</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="reset" class="btn btn-outline-danger">
							<i class="fa fa-eraser pr-1 fa-sm"></i> 
							Clear
						</button>
						<button type="submit" class="btn btn-success" id="btnsavenewbloodtype">
							<i class="fa fa-plus pr-1 fa-sm"></i> 
							Add
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!--Modal: Edit Blood Type-->
	<div class="modal fade" id="editBloodTypeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="editnewbloodcomponentTitle">
						<i class="fa fa-edit px-2 fa-sm"></i> 
						Edit Blood Type
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class='text-white'>&times;</span>
					</button>
				</div>
				<form method="POST" action ="editbloodType.php" name="form_editbloodType">
					<div class="modal-body">
						<div class="form-group">
							<label for="editBloodComponentName">ABO Type</label>
							<input type="hidden" name = "bloodtype_ID" id = "bloodtype_ID">
							<input type="text" class="form-control" id='editBloodTypeName' name ='editBloodTypeName' required>
						</div>
						<div class="form-group">
							<label for="editBloodComponentName">Rhesus</label>
							<input type="hidden" name = "bloodrhesus_ID" id = "bloodrhesus_ID">
							<select class="form-control" id='editBloodTypeRhesus' name ='editBloodTypeRhesus' required>
								<option value = 'Positive'>Positive</option>
								<option value = 'Negative'>Negative</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-success" id="btnsaveeditbloodtype">
							<i class="fa fa-save pr-1 fa-sm"></i> 
							Save
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!--Modal: View/Disable Blood Type-->
	<div class="modal fade" id="viewBloodTypeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewnewbloodcomponentTitle">
						<i class="fa fa-toggle-off px-2 fa-sm"></i> 
						Blood Type
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class='text-white'>&times;</span>
					</button>
				</div>
				<form method="POST" action ="deletebloodtype.php" name="form_viewbloodtype">
					<div class="modal-body">
						<div class="form-group">
							<label for="editBloodComponentName">ABO Type</label>
							<input type="hidden" name = "viewbloodtype_ID" id = "viewbloodtype_ID">
							<input type="text" class="form-control" id='viewBloodTypeName' name ='viewBloodTypeName' readonly>
						</div>
						<div class="form-group">
							<label for="editBloodComponentName">Rhesus</label>
							<input type="hidden" name = "viewbloodrhesus_ID" id = "viewbloodrhesus_ID">
							<input type="text" class="form-control" id='viewBloodRhesusName' name ='viewBloodRhesusName' readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-danger" id="btnsavedeletebloodtype">
							<i class="fa fa-toggle-off pr-1 fa-sm"></i> 
							Disable
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!--Modal: View/Enable Blood Type-->
	<div class="modal fade" id="viewBloodTypeModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewnewbloodcomponentTitle">
						<i class="fa fa-toggle-on px-2 fa-sm"></i> 
						Blood Type
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action ="enablebloodtype.php" name="form_viewbloodtype_enable">
					<div class="modal-body">
						<div class="form-group">
							<label for="editBloodComponentName">ABO Type</label>
							<input type="hidden" name = "viewbloodtype_ID_enable" id = "viewbloodtype_ID_enable">
							<input type="text" class="form-control" id='viewBloodTypeName_enable' name ='viewBloodTypeName_enable' readonly>
						</div>
						<div class="form-group">
							<label for="editBloodComponentName">Rhesus</label>
							<input type="hidden" name = "viewbloodrhesus_ID_enable" id = "viewbloodrhesus_ID_enable">
							<input type="text" class="form-control" id='viewBloodRhesusName_enable' name ='viewBloodRhesusName_enable' readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-success" id="btnsaveenablebloodtype">
							<i class="fa fa-toggle-on pr-1 fa-sm"></i> 
							Enable
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
  <?php include "components/core-script.php"; ?>
  <script src="../public/js/datatables.min.js"></script>
  <script src="../public/js/sweetalert.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#maintenance').addClass('active');
    $('#blood-type').addClass('active');
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

    //show active blood type
    let activeBloodType = 'activeBloodType';
    $('#tblActiveBloodType').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 2
			}],
      'ajax': {
        url: '../controller/blood/datatables.php',
        type: 'POST',
        data: { type: activeBloodType }
      },
      'language': {
        'emptyTable': 'No active blood type to show'
      }
    });

    //show inactive blood type
    let inactiveBloodType = 'inactiveBloodType';
    $('#tblInactiveBloodType').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 2
			}],
      'ajax': {
        url: '../controller/blood/datatables.php',
        type: 'POST',
        data: { type: inactiveBloodType }
      },
      'language': {
        'emptyTable': 'No inactive blood type to show'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });
		
    $(document).on("show.bs.modal", "#editBloodTypeModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/blood/fetchBloodTypeDetails.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#bloodtype_ID').val(data.intBloodTypeId);
          $('#editBloodTypeName').val(data.stfBloodType);
          $('#editBloodTypeRhesus').val(data.stfBloodTypeRhesus);
          console.log(data);
        }
      });
    });

    $(document).on("show.bs.modal","#viewBloodTypeModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/blood/fetchBloodTypeDetails.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewbloodtype_ID').val(data.intBloodTypeId);
          $('#viewBloodTypeName').val(data.stfBloodType);
          $('#viewBloodRhesusName').val(data.stfBloodTypeRhesus);
          console.log(data);
        }
      });
    });

    $(document).on("show.bs.modal", "#viewBloodTypeModal_enable", function(e){
      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/blood/fetchBloodTypeDetails.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewbloodtype_ID_enable').val(data.intBloodTypeId);
          $('#viewBloodTypeName_enable').val(data.stfBloodType);
          $('#viewBloodRhesusName_enable').val(data.stfBloodTypeRhesus);
          console.log(data);
        }
      });
    });

		$(document).on("submit", "form[name='form_addnewbloodtype']", function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_addnewbloodtype']").serialize();

			swal({
				title: 'Notice.',
				text: 'Do you want to add this blood type?',
				icon: 'warning',
				buttons: ['No', 'Add'],
				dangerMode: true
			}).then((willRequest) => {
				if(willRequest)	{
					$.ajax	({
						url:"../controller/blood/addNewBloodType.php",
						type:"POST",
						data:{formdata:formdata},
						success:function(data)	{
							console.log(data);
							if(data == '1')	{
								swal({
									title: 'Done!',
									text: 'The blood type has been added.',
									icon: 'success'
								}).then(() => {
									$("#addBloodTypeModal").modal('hide');
									$("#addBloodTypeModal .modal-body input").val("");
									window.location.href = "blood-type.php";
									// $('#divdonoraddsero').show(600);
								});
							}
							else if(data == '2')	{
								swal('Oops.', 'The blood type is already existing and/or currently inactive. Please refer to Inactive Blood Types panel.', 'error');
							}
							else if(data == '3')	{
								swal('Oops.', 'The blood type is not saved.', 'error');
							}
						}
					});
				}
				else	{
					swal('', 'The confirmation is cancelled.', '');
				}
			});
    });
	
    $(document).on("submit", "form[name='form_editbloodType']", function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_editbloodType']").serialize();
      console.log(formdata);
			
			swal({
				title: 'Notice.',
				text: 'Do you want to update this blood type?',
				icon: 'warning',
				buttons: ['No', 'Update'],
				dangerMode: true
			}).then((willRequest) => {
				if(willRequest)	{
					$.ajax	({
						url:"../controller/blood/editBloodType.php",
						type:"POST",
						data:{formdata:formdata},
						success:function(data)	{
							console.log(data);
							if(data == '1')	{
								swal({
									title: 'Done!',
									text: 'The blood type has been updated.',
									icon: 'success'
								}).then(() => {
									$("#addBloodTypeModal").modal('hide');
									$("#addBloodTypeModal .modal-body input").val("");
									window.location.href = "blood-type.php";
									// $('#divdonoraddsero').show(600);
								});
							}
							else if(data == '2')	{
								swal('Oops.', 'The blood type is already existing and/or currently inactive. Please refer to Inactive Blood Types panel.', 'error');
							}
							else if(data == '3')	{
								swal('Oops.', 'The blood type is not updated.', 'error');
							}
						}
					});
				}
				else	{
					swal('', 'The confirmation is cancelled.', '');
				}
			});
    });

    $(document).on("click", "#btnsavedeletebloodtype", function(e){
      e.preventDefault();
      var id = $("#viewbloodtype_ID").val();
			
      swal({
        title: "Notice.",
        text: "Do you want to disable this blood type?",
        icon: "warning",
        buttons: ['No', 'Disable'],
				dangerMode: true
			})
			.then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/blood/disableBloodType.php',
            data: {id:id},
            success:function(data)	{
              if(data == "deleted")	{
                swal({
                  title: "Okay.",
                  text: "The blood type is now disabled.",
                  icon: "success"
                  // buttons: {text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
										$("#viewBloodTypeModal").modal('hide');
                    window.location.href = "blood-type.php";
                  }
                });
              }
							else	{
                swal({
                  title: "Oops.",
                  text: "The blood type cannot be disabled because " + data + " record/s uses this.",
                  icon: "error"
                  // buttons: {text:"Okay"},
                })
                // .then((willApprove) => {
                  // if (willApprove) {
                    // window.location.href = "blood-type.php";
                  // }
                // });
              }
            }
          });
        }
        else {
          swal("","The confirmation is cancelled.","");
        }
      });
    });

    $(document).on("click","#btnsaveenablebloodtype", function(e)	{
      e.preventDefault();
      var id = $("#viewbloodtype_ID_enable").val();
      // var confirm_enable = confirm("Are you sure?");
      // if(confirm_enable == true){
        // $.ajax({
          // type: "POST",
          // url: '../controller/blood/enableBloodType.php',
          // data: {id:id},
          // success:function(data){
            // alert("Blood Type has been enabled");
            // window.location.href = "blood-type.php";
          // }
        // });
      // }
      // else{
        // alert("Confirmation Cancelled");
        // return false;
      // }
			
			swal({
        title: "Notice.",
        text: "Do you want to enable this blood type?",
        icon: "warning",
        buttons: ['No', 'Enable'],
				dangerMode: true
      }).then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/blood/enableBloodType.php',
            data: {id:id},
            success:function(data)	{
							swal({
								title: "Okay.",
								text: "The blood type is now enabled.",
								icon: "success"
								// buttons: {text:"Okay"},
							}).then((willApprove) => {
								if (willApprove) {
									$("#viewBloodTypeModal_enable").modal('hide');
									window.location.href = "blood-type.php";
								}
							});
            }
          });
        }
        else {
          swal("","The confirmation is cancelled.","");
        }
			});
    });
  </script>
	</body>
</html>
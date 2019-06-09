<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Blood Component</title>
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
    <main class="mainpanel">
      <?php include "components/header.php"; ?>
      <div class="page-title">
        <h3 class="p-2">Blood Component</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Active Blood Component</h4>
                <table id='tblActiveBloodComponent' class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style='width: 50%'>Blood Component</td>
                      <td style='width: 50%'>Action</td>
                    </tr>
                  </thead>
                </table>
                <button type='button' class='btn btn-outline-danger float-right my-2 mx-4' data-toggle='modal' data-target='#addBloodComponentModal'>
									<i class="fas fa-plus mr-1"></i>
									Add Blood Component
								</button>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Inactive Blood Component</h4>
                <table id='tblInactiveBloodComponent' class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style='width: 50%'>Blood Component</td>
                      <td style='width: 50%'>Action</td>
                    </tr>
                  </thead>
                </table>
								<button type='button' class='btn btn-outline-danger float-right my-2 mx-4' data-toggle='modal' data-target='#addBloodComponentModal'>
									<i class="fas fa-plus mr-1"></i>
									Add Blood Component
								</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
  <!--Modal: Add Blood Component-->
  <div class="modal fade" id="addBloodComponentModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="addnewbloodcomponentTitle">
						<i class="fa fa-plus px-2 fa-sm"></i> 
						Add Blood Component
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewbloodcomponent.php" name="form_addnewbloodcomponent">
          <div class="modal-body">
            <div class="form-group">
              <label for="newBloodComponentName">Blood Component</label>
              <input type="text" class="form-control" id='newBloodComponentName' name ='newBloodComponentName' required="required">
            </div>
            <div class="form-group">
              <label for="newBloodComponentDeferral">Deferral Day/s</label>
              <input type="number" class="form-control" id='newBloodComponentDeferral' name ='newBloodComponentDeferral' required="required">
            </div>
						<label>Acceptable Value Range (Male)</label>
						<div class="row">
							<div class="form-group mx-auto">
								<!--<label for="newBloodComponentML">Least Accepted Value (Male)</label>-->
								<input type="number" step = 'any' class="form-control" id='newBloodComponentML' name ='newBloodComponentML' placeholder="Minimum" min=0 required="required">
							</div>
							<div class="form-group mx-auto">
								<!--<label for="newBloodComponentMM">Max Accepted Value (Male)</label>-->
								<input type="number" step = 'any' class="form-control" id='newBloodComponentMM' name ='newBloodComponentMM' placeholder="Maximum" min=0 required="required">
							</div>
            </div>
						<label>Acceptable Value Range (Female)</label>
						<div class="row">
							<div class="form-group mx-auto">
								<!--<label for="newBloodComponentFL">Least Accepted Value (Female)</label>-->
								<input type="number" step = 'any' class="form-control" id='newBloodComponentFL' name ='newBloodComponentFL' placeholder="Minimum" min=0 required="required">
							</div>
							<div class="form-group mx-auto">
								<!--<label for="newBloodComponentFL">Max Accepted Value (Female)</label>-->
								<input type="number" step = 'any' class="form-control" id='newBloodComponentFM' name ='newBloodComponentFM' placeholder="Maximum" min=0 required="required">
							</div>
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
            <button type="submit" class="btn btn-success" id="btnsavenewbloodcomponent">
							<i class="fa fa-plus pr-1 fa-sm"></i>
							Add
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
	<!--Edit Blood Component Modal-->
  <div class="modal fade" id="editBloodComponentModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editnewbloodcomponentTitle">
						<i class="fa fa-edit px-2 fa-sm"></i> 
						Edit Blood Component
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editbloodcomponent.php" name="form_editbloodcomponent">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodComponentName">Blood Component</label>
              <input type="hidden" name = "bloodcomp_ID" id = "bloodcomp_ID">
              <input type="text" class="form-control" id='editBloodComponentName' name ='editBloodComponentName' required="required">
            </div>
            <div class="form-group">
              <label for="editBloodComponentDeferral">Deferral Day/s</label>
              <input type="number" class="form-control" id='editBloodComponentDeferral' name ='editBloodComponentDeferral' required="required">
            </div>
						<label>Acceptable Value Range (Male)</label>
            <div class="row">
							<div class="form-group mx-auto">
								<input type="number" step = 'any'class="form-control" id='editBloodComponentML' name ='editBloodComponentML' required="required">
							</div>
							<div class="form-group mx-auto">
								<input type="number" step = 'any' class="form-control" id='editBloodComponentMM' name ='editBloodComponentMM' required="required">
							</div>
            </div>
						<label>Acceptable Value Range (Female)</label>
            <div class="row">
							<div class="form-group mx-auto">
								<input type="number" step = 'any' class="form-control" id='editBloodComponentFL' name ='editBloodComponentFL' required="required">
							</div>
							<div class="form-group mx-auto">
								<input type="number" step = 'any' class="form-control" id='editBloodComponentFM' name ='editBloodComponentFM' required="required">
							</div>
						</div>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveeditbloodcomponent">
							<i class="fa fa-save pr-1 fa-sm"></i>
							Save
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
	
  <!--view details-->
	<div class="modal fade" id="viewBloodComponentModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewnewbloodcomponentTitle">
						<i class="fa fa-toggle-off px-2 fa-sm"></i> 
						Blood Component
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class=" text-white">&times;</span>
					</button>
				</div>
				<form method="POST" action ="deletecomponent.php" name="form_viewbloodcomponent">
					<div class="modal-body">
						<div class="form-group">
							<label for="editBloodComponentName">Blood Component</label>
							<input type="hidden" name = "viewbloodcomp_ID" id = "viewbloodcomp_ID">
							<input type="text" class="form-control" id='viewBloodComponentName' name ='viewBloodComponentName' readonly>
						</div>
						<div class="form-group">
							<label for="viewBloodComponentDeferral">Deferral Day/s</label>
							<input type="number"  class="form-control" id='viewBloodComponentDeferral' name ='viewBloodComponentDeferral' readonly>
						</div>
						<label>Acceptable Value Range (Male)</label>
						<div class="row">
							<div class="form-group mx-auto">
								<input type="number" step = 'any' class="form-control" id='viewBloodComponentML' name ='editBloodComponentML' readonly>
							</div>
							<div class="form-group mx-auto">
								<input type="number" step = 'any' class="form-control" id='viewBloodComponentMM' name ='editBloodComponentMM' readonly>
							</div>
						</div>
						<label>Acceptable Value Range (Female)</label>
						<div class="row">
							<div class="form-group mx-auto">
								<input type="number" step = 'any' class="form-control" id='viewBloodComponentFL' name ='editBloodComponentFL' readonly>
							</div>
							<div class="form-group mx-auto">
								<label for="editBloodComponentFM">
								<input type="number" step = 'any' class="form-control" id='viewBloodComponentFM' name ='editBloodComponentFM' readonly>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-danger" id="btnsavedeletebloodcomponent">
							<i class="fa fa-toggle-off pr-1 fa-sm"></i> 
							Disable
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- enable blood component -->
	<div class="modal fade" id="viewBloodComponentModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewnewbloodcomponentTitle">
						<i class="fa fa-toggle-on px-2 fa-sm"></i> 
						Blood Component
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class=" text-white">&times;</span>
					</button>
				</div>
				<form method="POST" action ="enablecomponent.php" name="form_viewbloodcomponent_enable">
					<div class="modal-body">
						<div class="form-group">
							<label for="editBloodComponentName">Blood Component</label>
							<input type="hidden" name = "viewbloodcomp_ID_enable" id = "viewbloodcomp_ID_enable">
							<input type="text" class="form-control" id='viewBloodComponentName_enable' name ='viewBloodComponentName_enable' readonly>
						</div>
						<div class="form-group">
							<label for="viewBloodComponentDeferral">Blood Component</label>
							<input type="number" class="form-control" id='viewBloodComponentDeferral_enable' name ='viewBloodComponentDeferral' readonly>
						</div>
						<label>Acceptable Value Range (Male)</label>
						<div class="row">
							<div class="form-group mx-auto">
								<input type="number" class="form-control" id='viewBloodComponentML_enable' name ='editBloodComponentML' readonly>
							</div>
							<div class="form-group mx-auto">
								<input type="number" class="form-control" id='viewBloodComponentMM_enable' name ='editBloodComponentMM' readonly>
							</div>
						</div>
						<label>Acceptable Value Range (Female)</label>
						<div class="row">
							<div class="form-group mx-auto">
								<input type="number" class="form-control" id='viewBloodComponentFL_enable' name ='editBloodComponentFL' readonly>
							</div>
							<div class="form-group mx-auto">
								<input type="number" class="form-control" id='viewBloodComponentFM_enable' name ='editBloodComponentFM' readonly>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						 <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-success" id="btnsaveenablebloodcomponent">
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
    $('#blood-component').addClass('active');
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

    //show active blood component
    let activeBloodComponent = 'activeBloodComponent';
    $('#tblActiveBloodComponent').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/blood/datatables.php',
        type: 'POST',
        data: { type: activeBloodComponent }
      },
      'language': {
        'emptyTable': 'No active blood component to show'
      }
    });

    //show inactive blood component
    let inactiveBloodComponent = 'inactiveBloodComponent';
    $('#tblInactiveBloodComponent').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/blood/datatables.php',
        type: 'POST',
        data: { type: inactiveBloodComponent }
      },
      'language': {
        'emptyTable': 'No inactive blood component to show'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $(document).on("submit","form[name='form_addnewbloodcomponent']", function(e){
    e.preventDefault();
    // var confirm_input = confirm("Are you sure?");
    var formdata = $("form[name='form_addnewbloodcomponent']").serialize();

    swal({
      // title: "Are you sure?",
      title: "Notice.",
      // text: "You are about to add a blood component",
      text: "Are you sure you want to add this blood component?",
      icon: 'warning',
			buttons: ['No', 'Add'],
			dangerMode: true
    })
    .then((willApprove) => {
      if (willApprove){
        $.ajax({
          type: "POST",
          url: '../controller/blood/addNewBloodComponent.php',
          data: {formdata,formdata},
          success:function(data){
            console.log(data);
            if(data == 1){
              // alert("Blood Component Added");
              swal({
                title: "Success!",
                text: "The blood component has been added.",
                icon: "success"
                // buttons: {text:"Close"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  $('#addBloodComponentModal').modal('hide');
                  $("#addBloodComponentModal .modal-body input").val("");
                  window.location.href = "blood-component.php";
                }
              });
              // $('#addBloodComponentModal').modal('hide');
              // $("#addBloodComponentModal .modal-body input").val("");
              // window.location.href = "bloodcomponent-tab.php";
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              // swal("","The Blood Component You Entered Already Exists","info");
              swal({
                title: "",
                text: "The blood component you're trying to add already exists, Please refer to Inactive Blood Components panel.",
                icon: "warning",
                // buttons:{text:"Okay"},
              })
              // .then((willApprove) => {
                // if(willApprove) {
                  // window.location.href = "blood-component.php";
                // }
              // });
            }
            else if (data == 3) {
              // swal("","Blood Component is not saved","info");
              swal('Oops.', 'The blood type is not saved.', 'error');
              // .then((willApprove) => {
                // if (willApprove) {
                  // window.location.href = "blood-component.php";
                // }
              // });
            }
            else if (data == 4) {
              swal({
                title: "Oops.",
                text: "Blood Component is not added. Minimum values must be lesser than maximum values.",
                icon: "error",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  //window.location.href = "bloodcomponent-tab.php";
                }
              });
              // alert("Blood Component is not Edited");

            }
          }
        });
      }
      else {
        // swal("","Cancelled","info");
				swal('', 'The confirmation is cancelled.', '');
      }
    });
  });

  $(document).on("show.bs.modal", "#editBloodComponentModal", function(e){
    var rowid = $(e.relatedTarget).data('id');
    // alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/blood/fetchBloodComponentDetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#bloodcomp_ID').val(data.intBloodComponentId);
        $('#editBloodComponentName').val(data.strBloodComponent);
        $('#editBloodComponentDeferral').val(data.intDeferralDay);
        $('#editBloodComponentML').val(data.decMaleLeastVal);
        $('#editBloodComponentMM').val(data.decMaleMaxVal);
        $('#editBloodComponentFL').val(data.decFemaleLeastVal);
        $('#editBloodComponentFM').val(data.decFemaleMaxVal);

      }
    });
  });

  $(document).on("show.bs.modal", "#viewBloodComponentModal", function(e){
    var rowid = $(e.relatedTarget).data('id');
    // alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/blood/fetchBloodComponentDetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#viewbloodcomp_ID').val(data.intBloodComponentId);
        $('#viewBloodComponentName').val(data.strBloodComponent);
        $('#viewBloodComponentDeferral').val(data.intDeferralDay);
        $('#viewBloodComponentML').val(data.decMaleLeastVal);
        $('#viewBloodComponentMM').val(data.decMaleMaxVal);
        $('#viewBloodComponentFL').val(data.decFemaleLeastVal);
        $('#viewBloodComponentFM').val(data.decFemaleMaxVal);
      }
    });
  });

  $(document).on("show.bs.modal", "#viewBloodComponentModal_enable", function(e){
    var rowid = $(e.relatedTarget).data('id');
    // alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/blood/fetchBloodComponentDetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#viewbloodcomp_ID_enable').val(data.intBloodComponentId);
        $('#viewBloodComponentName_enable').val(data.strBloodComponent);
        $('#viewBloodComponentDeferral_enable').val(data.intDeferralDay);
        $('#viewBloodComponentML_enable').val(data.decMaleLeastVal);
        $('#viewBloodComponentMM_enable').val(data.decMaleMaxVal);
        $('#viewBloodComponentFL_enable').val(data.decFemaleLeastVal);
        $('#viewBloodComponentFM_enable').val(data.decFemaleMaxVal);
      }
    });
  });

  $(document).on("submit", "form[name='form_editbloodcomponent']", function(e){
    e.preventDefault();
    // var confirm_input = confirm("Are you sure?");

    var formdata = $("form[name='form_editbloodcomponent']").serialize();
    swal({
      // title: "Are you sure?",
      title: "Notice.",
      // text: "You are about to edit this blood component",
      text: "Are you sure you want to update this blood component?",
      icon: "warning",
      buttons: ["No", "Update"],
			dangerMode: true
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: '../controller/blood/editBloodComponent.php',
          data: {formdata,formdata},
          success:function(data){
            if(data == 1){
              swal({
                title: "Okay!",
                text: "The blood component has been updated.",
                icon: "success",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                $('#editBloodComponentModal').modal('hide');
                $("#editBloodComponentModal .modal-body input").val("");
                window.location.href = "blood-component.php";
              });
              // alert("Blood Component Succesfully Edited");
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              swal('Oops.', 'The blood type is already existing and/or currently inactive. Please refer to Inactive Blood Types panel.', 'error');
              // alert("The Blood Component You Entered Already Exists");
            }
            else if (data == 3) {
              swal('Oops.', 'The blood type is not updated.', 'error');
              // alert("Blood Component is not Edited");

            }
            else if (data == 4) {
              swal('Oops.', 'The blood component is not added. Minimum values must be less than maximum values.', 'error');
              // alert("Blood Component is not Edited");
            }
          }
        });
      }
      else {
        // swal("","Cancelled","info");
				swal('', 'The confirmation is cancelled.', '');
      }
    });
  });

  $(document).on("click", "#btnsavedeletebloodcomponent", function(e)	{
    e.preventDefault();
    var id = $("#viewbloodcomp_ID").val();
    // var confirm_enable = confirm("Are you sure?");
    swal({
      title: "Notice.",
			text: "Do you want to disable this blood component?",
			icon: "warning",
			buttons: ['No', 'Disable'],
			dangerMode: true
    })
    .then((willApprove) =>	{
      if(willApprove) {
        $.ajax({
          type: "POST",
          url: '../controller/blood/disableBloodComponent.php',
          data: {id:id},
          success:function(data)	{
            // alert("Blood Component has been enabled");
           if(data == "deleted")	{
            swal({
              title: "Okay.",
              text: "The blood component is now disabled.",
              icons: "success",
              // buttons:{text:"Okay"},
            })
            .then((willApprove) => {
              if(willApprove) {
                window.location.href = "blood-component.php";
              }
            });
          }
					else	{
            swal({
              title: "Oops.",
              text: "The blood component is not disabled because " + data + " record/s uses this.",
              icon: "error",
              // buttons:{text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "blood-component.php";
              }
            });
          }
          }
        });
      }
      else {
        // swal("","Cancelled","info");
				swal('', 'The confirmation is cancelled.', '');
      }
    });
  });

  $(document).on("click", "#btnsaveenablebloodcomponent", function(e){
    e.preventDefault();
    var id = $("#viewbloodcomp_ID_enable").val();
    // var confirm_enable = confirm("Are you sure?");
    swal({
     title: "Notice.",
			text: "Do you want to enable this blood component?",
			icon: "warning",
			buttons: ['No', 'Enable'],
			dangerMode: true
    })
    .then((willApprove) =>{
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: '../controller/blood/enableBloodComponent.php',
          data: {id:id},
          success:function(data){
            // alert("Blood Component has been enabled");
            swal({
              title: "Okay.",
              text: "The blood component is now enabled.",
              icons: "success",
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "blood-component.php";
              }
            });
          }
        });
      }
      else {
        // swal("","Cancelled","info");
				swal('', 'The confirmation is cancelled.', '');
      }
    });
  });
//new------------------------------------------------------------------------------------
  $("#newBloodComponentML").on('change',function(){
    var ml = parseFloat($('#newBloodComponentML').val());
    var mm = parseFloat($('#newBloodComponentMM').val());
    var fl = parseFloat($('#newBloodComponentFL').val());
    var fm = parseFloat($('#newBloodComponentFM').val());

    if(ml > mm){
      alert("Least value must be less than max value.");
    }
  });

  $("#newBloodComponentMM").on('change',function(){
    var ml = parseFloat($('#newBloodComponentML').val());
    var mm = parseFloat($('#newBloodComponentMM').val());
    var fl = parseFloat($('#newBloodComponentFL').val());
    var fm = parseFloat($('#newBloodComponentFM').val());

    if(ml > mm){
      alert("Least value must be less than max value.");
    }
  });

  $("#newBloodComponentFL").on('change',function(){
    var ml = parseFloat($('#newBloodComponentML').val());
    var mm = parseFloat($('#newBloodComponentMM').val());
    var fl = parseFloat($('#newBloodComponentFL').val());
    var fm = parseFloat($('#newBloodComponentFM').val());

    if(fl > fm){
      alert("Least value must be less than max value.");
    }
  });

  $("#newBloodComponentFM").on('change',function(){
    var ml = parseFloat($('#newBloodComponentML').val());
    var mm = parseFloat($('#newBloodComponentMM').val());
    var fl = parseFloat($('#newBloodComponentFL').val());
    var fm = parseFloat($('#newBloodComponentFM').val());

    if(fl > fm){
      alert("Least value must be less than max value.");
    }
  });
  //new------------------------------------------------------------------------------------
  //edit------------------------------------------------------------------------------------
  $("#editBloodComponentML").on('change',function(){
    var ml = parseFloat($('#editBloodComponentML').val());
    var mm = parseFloat($('#editBloodComponentMM').val());
    var fl = parseFloat($('#editBloodComponentFL').val());
    var fm = parseFloat($('#editBloodComponentFM').val());

    if(ml > mm){
      alert("Least value must be less than max value.");
    }
  });

  $("#editBloodComponentMM").on('change',function(){
    var ml = parseFloat($('#editBloodComponentML').val());
    var mm = parseFloat($('#editBloodComponentMM').val());
    var fl = parseFloat($('#editBloodComponentFL').val());
    var fm = parseFloat($('#editBloodComponentFM').val());

    if(ml > mm){
      alert("Least value must be less than max value.");
    }
  });

  $("#editBloodComponentFL").on('change',function(){
    var ml = parseFloat($('#editBloodComponentML').val());
    var mm = parseFloat($('#editBloodComponentMM').val());
    var fl = parseFloat($('#editBloodComponentFL').val());
    var fm = parseFloat($('#editBloodComponentFM').val());

    if(fl > fm){
      alert("Least value must be less than max value.");
    }
  });

  $("#editBloodComponentFM").on('change',function(){
    var ml = parseFloat($('#editBloodComponentML').val());
    var mm = parseFloat($('#editBloodComponentMM').val());
    var fl = parseFloat($('#editBloodComponentFL').val());
    var fm = parseFlaot($('#editBloodComponentFM').val());

    if(fl > fm){
      alert("Least value must be less than max value.");
    }
  });
  </script>
	</body>
</html>
<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Disease</title>
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
        <h3 class="p-2">Disease</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Active Diseases</h4>
                <table id='tblActiveDisease' class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 50%">Disease</td>
                      <td style="width: 50%">Action</td>
                    </tr>
                  </thead>
                </table>
                <button type='button' class='btn btn-outline-danger float-right my-2 mx-3' data-toggle='modal' data-target='#addnewdiseaseModal' id='btntbl'>
									<i class="fas fa-plus mr-1"></i> 
									Add Disease
								</button>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Inactive Disease</h4>
                <table id='tblInactiveDisease' class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 50%">Disease</td>
                      <td style="width: 50%">Action</td>
                    </tr>
                  </thead>
                </table>
								<button type='button' class='btn btn-outline-danger float-right my-2 mx-3' data-toggle='modal' data-target='#addnewdiseaseModal' id='btntbl'>
									<i class="fas fa-plus mr-1"></i> 
									Add Disease
								</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
  <!--Add Disease Modal-->
  <div class="modal fade" id="addnewdiseaseModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="addnewdiseaseTitle">
						<i class="fa fa-plus px-2"></i>
						Add Disease
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="disease-related/addnewdisease.php" name="form_adddisease">
          <div class="modal-body">
            <div class="form-group">
              <label for="newDiseaseName">Disease Name</label>
              <input type="text" class="form-control" id='newDiseaseName' name ='newDiseaseName' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times mr-1"></i>
							Close
						</button>
						<button type="reset" class="btn btn-outline-danger">
							<i class="fa fa-eraser mr-1"></i>
							Clear
						</button>
            <button type="submit" class="btn btn-success" id="btnsavenewdisease">
							<i class="fa fa-plus mr-1"></i>
							Add
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit disease modal -->
  <div class="modal fade" id="editDiseaseModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editDiseaseTitle">
						<i class="fa fa-edit px-2 fa-sm"></i> 
						Edit Disease
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editdisease.php" name="form_editdisease">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDiseaseName">Disease Name</label>
              <input type="hidden" name = "disease_ID" id = "disease_ID">
              <input type="text" class="form-control" id='editDiseaseName' name ='editDiseaseName' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveeditdisease">
							<i class="fa fa-save pr-1 fa-sm"></i> 
							Save
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- view record -->
  <div class="modal fade" id="viewDiseaseModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewDiseaseTitle">
						<i class="fa fa-toggle-off px-2 fa-sm"></i>
						Disease
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="deletedisease.php" name="form_viewdisease">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDiseaseName">Disease Name</label>
              <input type="hidden" name = "viewdisease_ID" id = "viewdisease_ID">
              <input type="text" class="form-control" id='viewDiseaseName' name ='viewDiseaseName' readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-danger" id="btnsavedeletedisease">
							<i class="fa fa-toggle-off pr-1 fa-sm"></i>
							Disable
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- enable disease modal -->
  <div class="modal fade" id="viewDiseaseModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewDiseaseTitle">
						<i class="fa fa-toggle-on px-2 fa-sm"></i>
						Disease
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="enabledisease.php" name="form_viewdisease_enable">
          <div class="modal-body">
            <div class="form-group">
              <label for="editDiseaseName">Disease Name</label>
              <input type="hidden" name = "viewdisease_ID_enable" id = "viewdisease_ID_enable">
              <input type="text" class="form-control" id='viewDiseaseName_enable' name ='viewDiseaseName_enable' readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveenabledisease">
							<i class="fa fa-toggle-on pr-1 fa-sm"></i>
							Enable
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end modal declaration -->
  <?php include "components/core-script.php"; ?>
  <script src="../public/js/datatables.min.js"></script>
  <script src="../public/js/sweetalert.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#maintenance').addClass('active');
    $('#disease').addClass('active');
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

    //show active disease
    let activeDisease = 'activeDisease';
    $('#tblActiveDisease').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/disease/datatables.php',
        type: 'POST',
        data: { type: activeDisease }
      },
      'language': {
        'emptyTable': 'No active disease to show'
      }
    });

    //show inactive disease
    let inactiveDisease = 'inactiveDisease';
    $('#tblInactiveDisease').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/disease/datatables.php',
        type: 'POST',
        data: { type: inactiveDisease }
      },
      'language': {
        'emptyTable': 'No inactive disease to show'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $(document).on("submit", "form[name='form_adddisease']", function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_adddisease']").serialize();
      swal({
        title: "Notice.",
        text: "Are you sure you want to add this disease?",
        icon: "warning",
        buttons: ['No', 'Add'],
				dangerMode: true
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/disease/addNewDisease.php',
            data: {formdata,formdata},
            success:function(data)	{
              if(data == 1)	{
                // alert("Blood Component Added");
                swal({
                  title:"Good!",
                  text: "The disease has been added.",
                  icon: "success",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    $('#addnewdiseaseModal').modal('hide');
                    $("#addnewdiseaseModal .modal-body input").val("");
                    window.location.href = "disease.php";
                  }
                });
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2)	{
                swal({
                  title: "Oops.",
                  text: "The disease is already existing. Please check the Inactive Diseases panel.",
                  icon: "error",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "disease.php";
                  }
                });
              }
              else if (data == 3) {
                swal({
                  title: "Oops.",
                  text: "The disease is not saved.",
                  icon: "error",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "disease.php";
                  }
                });
              }
            }
          });
        }
        else {
          swal("","The action has been cancelled.","");
        }
      });
    });

    $(document).on("show.bs.modal", "#editDiseaseModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      // alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/disease/fetchDiseaseDetails.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#disease_ID').val(data.intDiseaseId);
          $('#editDiseaseName').val(data.strDisease);
        }
      });
    });

    $(document).on("show.bs.modal", "#viewDiseaseModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      // alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/disease/fetchDiseaseDetails.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewdisease_ID').val(data.intDiseaseId);
          $('#viewDiseaseName').val(data.strDisease);
        }
      });
    });

    $(document).on("show.bs.modal", "#viewDiseaseModal_enable", function(e){
      var rowid = $(e.relatedTarget).data('id');
      // alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/disease/fetchDiseaseDetails.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewdisease_ID_enable').val(data.intDiseaseId);
          $('#viewDiseaseName_enable').val(data.strDisease);
        }
      });
    });

    $(document).on("submit", "form[name='form_editdisease']", function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_editdisease']").serialize();
      console.log(formdata);
      swal({
        title: "Notice.",
        text: "Are you sure you want to update this disease?",
        icon: "warning",
        buttons: ['No', 'Update'],
				dangerMode: true
			})
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/disease/editDisease.php',
            data: {formdata,formdata},
            success:function(data){
              if(data == 1){
                // alert("Disease Succesfully Edited");
                swal({
                  title: "Good!",
                  text: "The disease has been updated.",
                  icon: "success",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    $('#editDiseaseModal').modal('hide');
                    $("#editDiseaseModal .modal-body input").val("");
                    window.location.href = "disease.php";
                  }
                });
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2){
                swal({
                  title: "Oops.",
                  text: "The disease is already existing.",
                  icon: "error",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "disease.php";
                  }
                });
                // alert("The Disease You Entered Already Exists");
              }
              else if (data == 3) {
                swal({
                  title: "Oops.",
                  text: "The disease is not edited.",
                  icon: "error",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "disease.php";
                  }
                });
                // alert("Disease is not Edited");
              }
            }
          });
        }
        else {
          swal("","The action has been cancelled.","");
        }
      });
    });

    $(document).on("click", "#btnsavedeletedisease", function(e){
      e.preventDefault();
      var id = $("#viewdisease_ID").val();
      // var confirm_delete = confirm("Are you sure?");
      swal({
        title: "Notice.",
        text: "Are you sure you want to disable this disease?",
        icon: "warning",
        buttons: ['No', 'Disable'],
				dangerMode: true
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/disease/disableDisease.php',
            data: {id:id},
            success:function(data){
              if(data == "deleted"){
              swal({
                title: "Good!",
                text: "The disease is now disabled.",
                icon: "success",
                // buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "disease.php";
                }
              });
            }else{
              swal({
                title: "Oops.",
                text: "The disease is not disabled because " + data + " record/s uses this.",
                icon: "error",
                // buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "disease.php";
                }
              });
            }
            }
          });
        }
        else {
          swal("","The action has been cancelled.","");
        }
      });
    });

    $(document).on("click", "#btnsaveenabledisease", function(e){
      e.preventDefault();
      var id = $("#viewdisease_ID_enable").val();
      // var confirm_enable = confirm("Are you sure?");
      swal({
        title: "Notice.",
        text: "Are you sure you want to enable this disease?",
        icon: "warning",
        buttons: ['No', 'Enable'],
				dangerMode: true
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/disease/enableDisease.php',
            data: {id:id},
            success:function(data){
              swal({
                title:"Good!",
                text: "The disease is now enabled.",
                icon: "success",
                // buttons:{text:"Okay"}
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "disease.php";
                }
              });
              // alert("Disease has been enabled");
            }
          });
        }
        else {
          swal("","The action has been cancelled.","");
        }
      });
    });
  </script>
</body>
</html>
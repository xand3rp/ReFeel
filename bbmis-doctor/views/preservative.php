<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Preservative</title>
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
        <h3 class="p-2">Preservatives</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Active Preservatives</h4>
                <table id='tblActivePreservatives' class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 35%">Preservative</td>
                      <td style="width: 10%">Lifespan</td>
                      <td style="width: 10%">Fresh</td>
                      <td style="width: 10%">Neutral</td>
                      <td style="width: 10%">Critical</td>
                      <td style="width: 25%">Action</td>
                    </tr>
                  </thead>
                </table>
                <button type='button' class='btn btn-outline-danger float-right my-2 mx-3' data-toggle='modal' data-target='#addpreservativeModal'>
									<i class="fas fa-plus mr-1"></i>
									Add Preservative
								</button>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Inactive Preservatives</h4>
                <table id='tblInactivePreservatives' class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 35%">Preservative</td>
                      <td style="width: 10%">Lifespan</td>
                      <td style="width: 10%">Fresh</td>
                      <td style="width: 10%">Neutral</td>
                      <td style="width: 10%">Critical</td>
                      <td style="width: 25%">Action</td>
                    </tr>
                  </thead>
                </table>
								<button type='button' class='btn btn-outline-danger float-right my-2 mx-3' data-toggle='modal' data-target='#addpreservativeModal'>
									<i class="fas fa-plus mr-1"></i>
									Add Preservative
								</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
  <!--Add Preservative Modal-->
  <div class="modal fade" id="addpreservativeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="addnewpreservativeTitle">
						<i class="fa fa-plus px-2"></i>
						Add Preservative
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewpreservative.php" name="form_addnewpreservative">
          <div class="modal-body">
            <div class="form-group">
              <label for="newpreservativeName">Preservative Name</label>
              <input type="text" class="form-control" id='newpreservativeName' name ='newpreservativeName' required>
            </div>
            <div class="form-group">
              <label for="newpreservativeLifespan">Preservative Lifespan</label>
              <input type="number" class="form-control" id='newpreservativeLifespan' name ='newpreservativeLifespan' min="1" required="required">
            </div>
            <div class="form-group">
              <label for="newpreservativeFresh">Fresh Level</label>
              <input type="number" class="form-control" id='newpreservativeFresh' name ='newpreservativeFresh' min="1" required="required">

            </div>
            <div class="form-group">
              <label for="newpreservativeMedium">Neutral Level</label>
              <input type="number" class="form-control" id='newpreservativeMedium' name ='newpreservativeMedium' min="1" required="required">
            </div>
            <div class="form-group">
              <label for="newpreservativeCritical">Critical Level</label>
              <input type="number" class="form-control" id='newpreservativeCritical' name ='newpreservativeCritical' min="1"required="required">
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
            <button type="text" class="btn btn-success" id="btnsavenewpreservative">
							<i class="fa fa-plus mr-1"></i>
							Add
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--Edit Preservative Modal-->
  <div class="modal fade" id="editpreservativeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editnewpreservativeTitle">
						<i class="fa fa-edit px-2 fa-sm"></i> 
						Edit Preservative
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editpreservative.php" name="form_editpreservative">
          <div class="modal-body">
            <div class="form-group">
              <label for="editpreservativeName">Preservative Name</label>
              <input type="hidden" name = "preservative_ID" id = "preservative_ID">
              <input type="text" class="form-control" id='editpreservativeName' name ='editpreservativeName' required>
            </div>
            <div class="form-group">
              <label for="editpreservativeLifespan">Preservative Lifespan</label>
              <input type="number" class="form-control" id='editpreservativeLifespan' name ='editpreservativeLifespan' min="1" max="99" required>
            </div>
            <div class="form-group">
              <label for="editpreservativeFresh">Fresh Level</label>
              <input type="number" class="form-control" id='editpreservativeFresh' name ='editpreservativeFresh' min="1" max="99" required>
            </div>
            <div class="form-group">
              <label for="editpreservativeMedium">Neutral Level</label>
              <input type="number" class="form-control" id='editpreservativeMedium' name ='editpreservativeMedium' min="1" max="99" required>
            </div>
            <div class="form-group">
              <label for="editpreservativeCritical">Critical Level</label>
              <input type="number" class="form-control" id='editpreservativeCritical' name ='editpreservativeCritical' min="1" max="99" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveeditpreservative">
							<i class="fa fa-save pr-1 fa-sm"></i> 
							Save
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--view details-->
	<div class="modal fade" id="viewpreservativeModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewnewbloodcomponentTitle">
						<i class="fa fa-toggle-off px-2 fa-sm"></i>
						Preservative
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="text-white" aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action ="deletecomponent.php" name="form_viewpreservative">
					<div class="modal-body">
						<div class="form-group">
							<label for="editpreservativeName">Preservative Name</label>
							<input type="hidden" name = "viewpreservative_ID" id = "viewpreservative_ID">
							<input type="text" class="form-control" id='viewpreservativeName' name ='viewpreservativeName' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeLifespan">Preservative Lifespan</label>
							<input type="number" class="form-control" id='viewpreservativeLifespan' name ='viewpreservativeLifespan' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeFresh">Fresh Level</label>
							<input type="number" class="form-control" id='viewpreservativeFresh' name ='viewpreservativeFresh' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeMedium">Neutral Level</label>
							<input type="number" class="form-control" id='viewpreservativeMedium' name ='viewpreservativeMedium' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeCritical">Critical Level</label>
							<input type="number" class="form-control" id='viewpreservativeCritical' name ='viewpreservativeCritical' readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-danger" id="btnsavedeletepreservative">
							<i class="fa fa-toggle-off pr-1 fa-sm"></i>
							Disable
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- enable Preservative -->
	<div class="modal fade" id="viewpreservativeModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
					<h5 class="modal-title text-white" id="viewnewbloodcomponentTitle">
						<i class="fa fa-toggle-on px-2 fa-sm"></i>
						Preservative
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="text-white" aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action ="enablecomponent.php" name="form_viewpreservative_enable">
					<div class="modal-body">
						<div class="form-group">
							<label for="editpreservativeName">Preservative Name</label>
							<input type="hidden" name = "viewpreservative_ID_enable" id = "viewpreservative_ID_enable">
							<input type="text" class="form-control" id='viewpreservativeName_enable' name ='viewpreservativeName_enable' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeLifespan_enable">Preservative Lifespan</label>
							<input type="number" class="form-control" id='viewpreservativeLifespan_enable' name ='viewpreservativeLifespan_enable' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeFresh_enable">Fresh Level</label>
							<input type="number" class="form-control" id='viewpreservativeFresh_enable' name ='viewpreservativeFresh_enable' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeMedium_enable">Neutral Level</label>
							<input type="number" class="form-control" id='viewpreservativeMedium_enable' name ='viewpreservativeMedium_enable' readonly>
						</div>
						<div class="form-group">
							<label for="viewpreservativeCritical_enable">Critical Level</label>
							<input type="number" class="form-control" id='viewpreservativeCritical_enable' name ='viewpreservativeCritical_enable' readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
						<button type="submit" class="btn btn-success" id="btnsaveenablepreservative">
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
    $('#preservative').addClass('active');
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

    //show active preservatives
    let activePreservatives = 'activePreservatives';
    $('#tblActivePreservatives').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 5
			}],
      'ajax': {
        url: '../controller/preservative/datatables.php',
        type: 'POST',
        data: { type: activePreservatives }
      },
      'language': {
        'emptyTable': 'No active preservatives to show'
      }
    });

    //show inactive preservatives
    let inactivePreservatives = 'inactivePreservatives';
    $('#tblInactivePreservatives').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 5
			}],
      'ajax': {
        url: '../controller/preservative/datatables.php',
        type: 'POST',
        data: { type: inactivePreservatives }
      },
      'language': {
        'emptyTable': 'No inactive preservatives to show'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $("#newpreservativeFresh").on('change',function(){
      // console.log("hi");
      var lifespan = parseInt($("#newpreservativeLifespan").val());
      var fresh = parseInt($("#newpreservativeFresh").val());
      var neutral = parseInt($("#newpreservativeMedium").val());
      var critical = parseInt($("#newpreservativeCritical").val());
      if (lifespan > fresh)	{}
			else	{
        alert("Lifespan should have the largest value.");
			}
    /*  if(neutral < fresh){
        alert("Neutral level must be greater than fresh level");
      }else if(critical < fresh){
        alert("Critical level must be greater than fresh level and neutral level");
      }*/
    });

    $("#newpreservativeMedium").on('change',function()	{
      // console.log("hi");
      var lifespan = parseInt($("#newpreservativeLifespan").val());
      var fresh = parseInt($("#newpreservativeFresh").val());
      var neutral = parseInt($("#newpreservativeMedium").val());
      var critical = parseInt($("#newpreservativeCritical").val());

      if (lifespan > neutral)	{
        if(neutral < fresh)	{
          alert("Neutral level must be greater than fresh level");
        }
      }
			else	{
        alert("Lifespan should have the biggest value");
      }
    });

    $("#newpreservativeCritical").on('change',function(){
      var lifespan = parseInt($("#newpreservativeLifespan").val());
      var fresh = parseInt($("#newpreservativeFresh").val());
      var neutral = parseInt($("#newpreservativeMedium").val());
      var critical = parseInt($("#newpreservativeCritical").val());

      if (lifespan > critical)	{
        if(critical < neutral || neutral < fresh)	{
          alert("Neutral level must be greater than fresh level , Critical level must be greater than neutral level");
				}
      }
			else	{
        alert("Lifespan should have the biggest value");
      }
    });

    $("#editpreservativeFresh").on('change',function()	{
      var lifespan = parseInt($("#editpreservativeLifespan").val());
      var fresh = parseInt($("#editpreservativeFresh").val());
      var neutral = parseInt($("#editpreservativeMedium").val());
      var critical = parseInt($("#editpreservativeCritical").val());

      if (lifespan > fresh)	{}
			else	{
        alert("Lifespan should have the biggest value");
      }
    /*  if(neutral < fresh){
        alert("Neutral level must be greater than fresh level");
      }else if(critical < fresh){
        alert("Critical level must be greater than fresh level and neutral level");
      }*/
    });

    $("#editpreservativeMedium").on('change',function(){
      var lifespan = parseInt($("#editpreservativeLifespan").val());
      var fresh = parseInt($("#editpreservativeFresh").val());
      var neutral = parseInt($("#editpreservativeMedium").val());
      var critical = parseInt($("#editpreservativeCritical").val());

      if (lifespan > neutral)	{
        if(neutral < fresh)	{
          alert("Neutral level must be greater than fresh level");
        }
      }
			else	{
        alert("Lifespan should have the biggest value");
      }
    });

    $("#editpreservativeCritical").on('change',function(){
      var lifespan = parseInt($("#editpreservativeLifespan").val());
      var fresh = parseInt($("#editpreservativeFresh").val());
      var neutral = parseInt($("#editpreservativeMedium").val());
      var critical = parseInt($("#editpreservativeCritical").val());

      if (lifespan > critical)	{
        if(critical < neutral || neutral < fresh)	{
          alert("Neutral level must be greater than fresh level , Critical level must be greater than neutral level");
        }
      }
			else	{
        alert("Lifespan should have the biggest value");
      }
    });

    $("form[name='form_addnewpreservative']").on('submit',function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var fresh = $("#newpreservativeFresh").val();
      var neutral = $("#newpreservativeMedium").val();
      var critical = $("#newpreservativeCritical").val();
      var formdata = $("form[name='form_addnewpreservative']").serialize();
      swal({
        title: "Notice.",
        text: "Are you sure you want to add this preservative?",
        icon: "warning",
        buttons: ['No', 'Add'],
				dangerMode: true
      })
      .then((willApprove) => {
        if (willApprove)	{
          $.ajax({
            type: "POST",
            url: '../controller/preservative/addNewPreservative.php',
            data: {formdata,formdata},
            success:function(data){
              console.log(data);
              if(data == 1){
                // alert("Blood Component Added");
                swal({
                  title: "Good!",
                  text: "The preservative has been added.",
                  icon: "success",
                  // buttons: {text:"Close"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    $('#addpreservativeModal').modal('hide');
                    $("#addpreservativeModal .modal-body input").val("");
                    window.location.href = "preservative.php";
                  }
                });
                // $('#addpreservativeModal').modal('hide');
                // $("#addpreservativeModal .modal-body input").val("");
                // window.location.href = "preservative-tab.php";
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2)	{
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "Oops.",
                  text: "The preservative is already existing.",
                  icon: "error",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
              else if (data == 3) {
                // swal("","Blood Component is not saved","info");
                swal({
                  title:"Oops.",
                  text:"The preservative is not saved.",
                  icon:"error",
                  // buttons:{text:"OKAY"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    window.location.href = "preservative.php";
                  }
                });
              }
              else if(data == 4){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "Oops.",
                  // text: "The days are not correct",
                  text: "The submitted levels are not acceptable. Please check.",
                  icon: "warning",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
              else if(data == 5){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "Oops.",
                  text: "The submitted levels are not acceptable. Please check.",
                  icon: "warning",
                  // buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
            }
          });
        }
        else {
          swal("","The action is cancelled.","");
        }
      });
    });

    $("#btnsavedeletepreservative").click(function(e)	{
      e.preventDefault();
      var id = $("#viewpreservative_ID").val();
      // var confirm_delete = confirm("Are you sure?");
      swal({
        title: "Notice.",
        text: "Are you sure you want to disable this preservative?",
        icon: "warning",
        buttons: ['No', 'Disable'],
				dangerMode: true
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/preservative/disablePreservative.php',
            data: {id:id},
            success:function(data){
              // alert("Blood Component has been disabled");
              if(data == "deleted"){
              swal({
                title: "Okay.",
                text: "The preservative has been disabled.",
                icon: "success",
                // buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "preservative.php";
                }
              });
            } else {
              swal({
                title: "Oops.",
                text: "The preservative is not disabled because " + data + " record/s uses this.",
                icon: "error",
                // buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "preservative.php";
                }
              });
            }
          }
        });
      }
      else {
        swal("","The action is cancelled.","");
      }
    });
  });

  $("#btnsaveenablepreservative").click(function(e){
    e.preventDefault();
    var id = $("#viewpreservative_ID_enable").val();
    // var confirm_enable = confirm("Are you sure?");
    swal({
      title: "Notice",
      text: "Are you sure you want to enable this preservative?",
      icon: "warning",
      buttons: ['No', 'Enable'],
			dangerMode: true
    })
    .then((willApprove) =>{
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: '../controller/preservative/enablePreservative.php',
          data: {id:id},
          success:function(data){
            // alert("Blood Component has been enabled");
            swal({
              title: "Okay.",
              text: "The preservative is now enabled.",
              icons: "success",
              // buttons:{text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "preservative.php";
              }
            });
          }
        });
      }
      else {
        swal("","The action is cancelled.","");
      }
    });
  });

  $("form[name='form_editpreservative']").on('submit',function(e){
    e.preventDefault();
    // var confirm_input = confirm("Are you sure?");

    var formdata = $("form[name='form_editpreservative']").serialize();
    swal({
      title: "Notice.",
      text: "Are you sure you want to update this preservative?",
      icon: "warning",
      buttons: ['No', 'Update'],
			dangerMode: true
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: '../controller/preservative/editPreservative.php',
          data: {formdata,formdata},
          success:function(data){
            console.log(data);
            if(data == 1){
              swal({
                title: "Okay.",
                text: "The preservative has been updated.",
                icon: "success",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                $('#editpreservativeModal').modal('hide');
                $("#editpreservativeModal .modal-body input").val("");
                window.location.href = "preservative.php";
              });
              // alert("Blood Component Succesfully Edited");
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              swal({
                title: "Oops.",
                text: "The preservative already exists. Please refer to the Inactive Preservatives panel.",
                icon: "error",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                //  window.location.href = "preservatives-tab.php";
                }
              });
              // alert("The Blood Component You Entered Already Exists");
            }
            else if (data == 3) {
              swal({
                title: "Oops.",
                text: "The preservative is not edited",
                icon: "error",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "preservative.php";
                }
              });
              // alert("Blood Component is not Edited");

            }
            else if(data == 4){
              // swal("","The Blood Component You Entered Already Exists","info");
              swal({
                title: "Oops.",
                text: "The submitted levels are not acceptable. Please check.",
                icon: "warning",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if(willApprove) {
                  //window.location.href = "preservatives-tab.php";
                }
              });
            }
            else if(data == 5){
              // swal("","The Blood Component You Entered Already Exists","info");
              swal({
                title: "Oops.",
                text: "The submitted levels are not acceptable. Please check.",
                icon: "warning",
                // buttons:{text:"Okay"},
              })
              .then((willApprove) => {
                if(willApprove) {
                  //window.location.href = "preservatives-tab.php";
                }
              });
            }
          }
        });
      }
      else {
        swal("","The action is cancelled.","info");
      }
    });
  });

  $('#editpreservativeModal').on('show.bs.modal', function(e) {

    var rowid = $(e.relatedTarget).data('id');
    var txt = $(e.relatedTarget).data('prename');
    var span = $(e.relatedTarget).data('span');
    var fresh = $(e.relatedTarget).data('fresh');
    var neutral = $(e.relatedTarget).data('neutral');
    var critical = $(e.relatedTarget).data('critical');
    //alert(txt);
    $("#preservative_ID").val(rowid);
    $("#editpreservativeName").val(txt);
    $("#editpreservativeLifespan").val(span);
    $("#editpreservativeFresh").val(fresh);
    $("#editpreservativeMedium").val(neutral);
    $("#editpreservativeCritical").val(critical);
  });

  $('#viewpreservativeModal').on('show.bs.modal', function(e) {

    var rowid = $(e.relatedTarget).data('id');
    var txt = $(e.relatedTarget).data('prename');
    var span = $(e.relatedTarget).data('span');
    var fresh = $(e.relatedTarget).data('fresh');
    var neutral = $(e.relatedTarget).data('neutral');
    var critical = $(e.relatedTarget).data('critical');
    //alert(txt);
    $("#viewpreservative_ID").val(rowid);
    $("#viewpreservativeName").val(txt);
    $("#viewpreservativeLifespan").val(span);
    $("#viewpreservativeFresh").val(fresh);
    $("#viewpreservativeMedium").val(neutral);
    $("#viewpreservativeCritical").val(critical);
  });

  $('#viewpreservativeModal_enable').on('show.bs.modal', function(e) {

    var rowid = $(e.relatedTarget).data('id');
    var txt = $(e.relatedTarget).data('prename');
    var span = $(e.relatedTarget).data('span');
    var fresh = $(e.relatedTarget).data('fresh');
    var neutral = $(e.relatedTarget).data('neutral');
    var critical = $(e.relatedTarget).data('critical');
    //alert(txt);
    $("#viewpreservative_ID_enable").val(rowid);
    $("#viewpreservativeName_enable").val(txt);
    $("#viewpreservativeLifespan_enable").val(span);
    $("#viewpreservativeFresh_enable").val(fresh);
    $("#viewpreservativeMedium_enable").val(neutral);
    $("#viewpreservativeCritical_enable").val(critical);
  });
  </script>
	</body>
</html>
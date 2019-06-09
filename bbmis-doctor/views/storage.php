<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Storage</title>
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
        <h3 class="p-2">Storage</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem">
                <h4 class="py-2">Active Storage</h4>
                <table id="tblActiveStorage" class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 25%">Storage Name</td>
                      <td style="width: 25%">Storage Type</td>
                      <td style="width: 15%">Capacity</td>
                      <td style="width: 35%">Action</td>
                    </tr>
                  </thead>
                </table>
                <button type="button" class="btn btn-outline-danger float-right my-2 mx-3" data-toggle="modal" data-target="#addBloodStorageModal">
									<i class="fa fa-plus mr-1"></i>
									Add Storage
								</button>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container" style="padding-bottom: 4rem">
                <h4 class="py-2">Disabled Storage</h4>
                <table id="tblInactiveStorage" class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 25%">Storage Name</td>
                      <td style="width: 25%">Storage Type</td>
                      <td style="width: 15%">Capacity</td>
                      <td style="width: 35%">Action</td>
                    </tr>
                  </thead>
                </table>
								<button type="button" class="btn btn-outline-danger float-right my-2 mx-3" data-toggle="modal" data-target="#addBloodStorageModal">
									<i class="fa fa-plus mr-1"></i>
									Add Storage
								</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modals -->
  <!--Add Storage Modal-->
  <div class="modal fade" id="addBloodStorageModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="addnewbloodstorageTitle">
						<i class="fa fa-plus mx-2"></i>
						Add Blood Storage
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewbloodstorage.php" name="form_addnewbloodstorage">
          <div class="modal-body">
            <div class="form-group">
              <label for="newBloodStorageName">Storage Name</label>
              <input type="text" class="form-control" id='newBloodStorageName' name ='newBloodStorageName' required>
            </div>
            <div class="form-group">
              <label>Storage Type</label>
              <select class="form-control" name="sel_storagetype">
                <option selected disabled>Select storage type</option>
              <?php
								$fetch_storagetype = mysqli_query($connections, "
									SELECT *
									FROM tblstoragetype
								");

								if(mysqli_num_rows($fetch_storagetype) > 0)	{
									while ($row = mysqli_fetch_assoc($fetch_storagetype)) {
										$storagetype = $row["strStorageType"];
										
										echo "<option value='".$storagetype."'>$storagetype</option>";
									}
								}
              ?>
							</select>
            </div>
            <div class="form-group">
              <label for="newBloodStorageCapacity">Storage Capacity</label>
              <input type="number" class="form-control" id='newBloodStorageCapacity' name ='newBloodStorageCapacity' required>
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
            <button type="submit" class="btn btn-success" id="btnsavenewbloodstorage">
							<i class="fa fa-plus mr-1"></i>
							Add
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Edit Storage Modal-->
  <div class="modal fade" id="editBloodStorageModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editnewbloodstorageTitle">
						<i class="fa fa-edit mx-2"></i>
						Edit Blood Storage
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="blood-related/editstorage.php" name="form_editbloodstorage">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodStorageName">Blood Storage Name</label>
              <input type="hidden" name = "bloodstorage_ID" id = "bloodstorage_ID">
              <input type="text" class="form-control" id='editBloodStorageName' name ='editBloodStorageName' required>
            </div>
            <div class="form-group">
              <label for="editBloodStorageCapacity">Blood Storage Capacity</label>
              <input type="number" class="form-control" id='editBloodStorageCapacity' name ='editBloodStorageCapacity' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveeditstorage">
							<i class="fa fa-save pr-1 fa-sm"></i> 
							Save
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--View Details-->
  <div class="modal fade" id="viewBloodStorageModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editnewbloodstorageTitle">
						<i class="fa fa-toggle-off mx-2"></i>
						Blood Storage
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="deletestorage.php" name="form_viewbloodstorage">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodStorageName">Blood Storage Name</label>
              <input type="hidden" name = "viewbloodstorage_ID" id = "viewbloodstorage_ID">
              <input type="text" class="form-control" id='viewBloodStorageName' name ='viewBloodStorageName' readonly>
            </div>
            <div class="form-group">
              <label for="editBloodStorageCapacity">Blood Storage Capacity</label>
              <input type="number" class="form-control" id='viewBloodStorageCapacity' name ='viewBloodStorageCapacity'readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-danger" id="btnsavedeletestorage">
							<i class="fa fa-toggle-off pr-1 fa-sm"></i>
							Disable
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end -->
  <div class="modal fade" id="viewBloodStorageModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="viewBloodStorageModal_enable">
						<i class="fa fa-toggle-on mx-2"></i>
						Blood Storage
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="enablestorage.php" name="form_viewbloodstorage_enable">
          <div class="modal-body">
            <div class="form-group">
              <label for="editBloodStorageName">Blood Storage Name</label>
              <input type="hidden" name = "viewbloodstorage_ID_enable" id = "viewbloodstorage_ID_enable">
              <input type="text" class="form-control" id='viewBloodStorageName_enable' name ='viewBloodStorageName_enable' readonly>
            </div>
            <div class="form-group">
              <label for="editBloodStorageCapacity">Blood Storage Capacity</label>
              <input type="number" class="form-control" id='viewBloodStorageCapacity_enable' name ='viewBloodStorageCapacity_enable'readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="button" name="delete" class="btn btn-outline-danger" id="btn_deletestorage">
							<i class="fa fa-trash pr-1 fa-sm"></i>
							Delete
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveenablestorage">
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
    $('#storage').addClass('active');
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

    //show active storage
    let activeStorage = 'activeStorage';
    $('#tblActiveStorage').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 3
			}],
      'ajax': {
        url: '../controller/storage/datatables.php',
        type: 'POST',
        data: { type: activeStorage }
      },
      'language': {
        'emptyTable': 'No active storage to show'
      }
    });

    //show inactive storage
    let inactiveStorage = 'inactiveStorage';
    $('#tblInactiveStorage').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 3
			}],
      'ajax': {
        url: '../controller/storage/datatables.php',
        type: 'POST',
        data: { type: inactiveStorage }
      },
      'language': {
        'emptyTable': 'No inactive storage to show'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $(document).on("submit", "form[name='form_addnewbloodstorage']", function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_addnewbloodstorage']").serialize();

      swal({
        title: "Are you sure?",
        text: "You are about to add a new storage",
        icon: "info",
        buttons: true
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: "../controller/storage/addNewStorage.php",
            data: {formdata, formdata},
            success: function(data){
              console.log(data);
              if (data == "1"){
                swal({
                  title: "",
                  text: "Storage added",
                  icon: "success",
                  buttons: {text: "Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    $("#addBloodStorageModal .modal-body input").val("");
                    $("#addBloodStorageModal").modal("hide");
                    window.location.href = "storage.php";
                  }
                });
              }
              else if (data == "2") {
                swal("","Storage already exists, Please check the disabled storages too.","warning");
              }
              else if (data == "3"){
                swal("","Please select storage type","error");
              }
              else if (data == "4"){
                swal("","Please set storage capacity", "error");
              }
              else if (data == "5"){
                swal("","something wrong","error");
              }
            }
          });
        }
        else {
          swal("","Cancelled");
        }
      });
    });

  $(document).on("show.bs.modal", "#editBloodStorageModal", function(e){
    var rowid = $(e.relatedTarget).data('id');
    //alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/storage/fetchStorageDetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#bloodstorage_ID').val(data.intStorageId);
        $('#editBloodStorageName').val(data.strStorageName);
        $('#editBloodStorageCapacity').val(data.intStorageCapacity);
        // console.log(data);
      }
    });
  });

  $(document).on("show.bs.modal", "#viewBloodStorageModal", function(e){
    var rowid = $(e.relatedTarget).data('id');
    //alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/storage/fetchStorageDetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#viewbloodstorage_ID').val(data.intStorageId);
        $('#viewBloodStorageName').val(data.strStorageName);
        $('#viewBloodStorageCapacity').val(data.intStorageCapacity);
        // console.log(data);
      }
    });
  });

  $(document).on("show.bs.modal", "#viewBloodStorageModal_enable", function(e){
    var rowid = $(e.relatedTarget).data('id');
    //alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/storage/fetchStorageDetails.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#viewbloodstorage_ID_enable').val(data.intStorageId);
        $('#viewBloodStorageName_enable').val(data.strStorageName);
        $('#viewBloodStorageCapacity_enable').val(data.intStorageCapacity);
        console.log(data);
      }
    });
  });

  $(document).on("click", "#btnsavedeletestorage", function(e){
    e.preventDefault();
    var id = $("#viewbloodstorage_ID").val();
    swal({
      title: "Are you sure?",
      text: "You are about to disable this storage",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: "../controller/storage/disableStorage.php",
          data: {id:id},
          success: function (data){
            if (data == '1'){
              swal("Can't disable storage","Storage has blood bags in it! Move it to another storage first", "warning");
            }
            else if (data == '2'){
              swal({
                title: "Success!",
                text: "Storage is now disabled",
                icon: "success",
                buttons: {text:"Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href= "storage.php";
                }
              });
            }
          }
        });
      }
      else {
        swal("","Cancelled");
      }
    });
  });

  $(document).on("click", "#btnsaveenablestorage", function(e){
    e.preventDefault();
    var id = $("#viewbloodstorage_ID_enable").val();
    var confirm_enable = confirm("Are you sure?");
    if(confirm_enable == true){
      $.ajax({
        type: "POST",
        url: '../controller/storage/enableStorage.php',
        data: {id:id},
        success:function(data){
          alert("Storage has been enabled");
          window.location.href = "storage.php";
        }
      });
    }
    else{
      alert("Confirmation Cancelled");
      return false;
    }
  });

  $(document).on("click", "#btn_deletestorage", function(e){
    e.preventDefault();

    var storage_id = $("#viewbloodstorage_ID_enable").val();
    swal({
      title: "Are you sure?",
      text: "You are about to delete this storage. You will not be able to enable this storage ever",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove){
        $.ajax({
          type: "POST",
          url: "../controller/storage/deleteStorage.php",
          data: "storage_id=" + storage_id,
          success: function(data){
            swal({
              title: "",
              text: "Storage is deleted",
              icon: "success",
              buttons: {text:"Okay"}
            })
            .then((willApprove)=>{
              if (willApprove) {
                window.location.href = "storage.php";
              }
            });
          }
        });
      }
      else {
        swal("","Cancelled");
      }
    });
  });

  $(document).on("submit", "form[name='form_editbloodstorage']", function(e){
    e.preventDefault();
    let formdata = $(this).serialize();

    swal({
      title: "Are you sure?",
      text: "You are about to edit this storage's details",
      icon: "warning",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: "../controller/storage/editStorage.php",
          data: {formdata : formdata},
          success: function (data) {
            if (data == "1"){
              swal({
                title: "",
                text: "Storage successfully edited",
                icon: "success",
                buttons: {text: "Okay"},
              })
              .then((willApprove) => {
                if (willApprove) {
                  window.location.href = "storage.php";
                  $('#editBloodStorageModal').modal('hide');
                  $("#ediBloodStorageModal .modal-body input").val("");
                }
              });
            }
            else if (data == "2"){
              swal("","The storage name you entered already exists!","error");
            }
            else if (data == "3"){
              swal("","Storage name is not edited", "error");
            }
            else if (data == "4"){
              swal("","Entered capacity is lower than total blood bags in the storage. Enter higher!","error");
            }
            else if (data == "5"){
              swal("", "Entered capacity is equal to the number of blood bags in the storage. Enter higher!", "error");
            }
          }
        });
      }
      else {
        swal("","Confirmation cancelled");
      }
    });
  });
  </script>
</body>
</html>
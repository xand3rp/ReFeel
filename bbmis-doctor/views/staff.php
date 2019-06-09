<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Staff</title>
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
        <h3 class="p-2">Staff</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem">
                <h4 class="py-2">Current Staff</h4>
                <table id="tblStaff" class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 50%">Name</td>
                      <td style="width: 15%">Type</td>
                      <td style="width: 15%">Status</td>
                      <td style="width: 20%">Action</td>
                    </tr>
                  </thead>
                </table>
                <button type="button" class="btn btn-outline-danger float-right mx-3 my-2" data-toggle="modal" data-target="#modalSignUp">
									<i class="fas fa-user-plus"></i>
									Add Staff
								</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modals -->
  <div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Employee Sign Up</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="../controller/staff/employeeSignUp.php" method="POST" id="" enctype="multipart/form-data">

            <p class="text-muted"><small><strong>PERSONAL INFORMATION</strong></small></p>
            <hr style="margin-top: -15px;" />

            <div class="row">
              <!-- Name -->
              <div class="form-group col-4">
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

            <div class="form-group">
              <label for="fileimg" class="col-form-label">Picture</label>
              <span style="color: red">*</span>
              <input type="file" class="form-control" name="fileimg" id="fileimg" required="required" />
               <img id="imageprev" style = "width:200px;height:200px" src="#" alt="your image" />
            </div>

            <div id = "uploaded_image"></div>

            <div class="form-group col-6">
              <label for="lblPos" class="col-form-label">Position</label>
              <span style="color: red;">*</span>
              <select class="form-control" name="optPos" required="required">
                <option value="Staff">Staff</option>
                <option value="Doctor">Doctor</option>
              </select>
            </div>

            <p class="text-muted"><small><strong>ACCOUNT CREDENTIALS</strong></small></p>
            <hr style="margin-top: -15px;" />

            <!-- Username -->
            <div class="form-group">
              <label for="lblUn" class="col-form-label">Username</label>
              <span style="color: red">*</span>
              <input type="text" class="form-control" name="txtUn" required="required" minlength="8">
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="lblPw" class="col-form-label">Password</label>
              <span style="color: red">*</span>
              <input type="password" class="form-control" name="txtPw" required="required" minlength="8">
            </div>

            <div class="modal-footer">
              <span style="color: red">Fields with asterisk(*) are required.</span>
              <button type="submit" class="btn btn-outline-danger">Sign Up</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editstaffinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editdonorinfo">Edit Staff Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-close="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form action="../controller/staff/employeeEdit.php" method="POST" id="" enctype="multipart/form-data" name ='editemployee'>

              <p class="text-muted"><small><strong>PERSONAL INFORMATION</strong></small></p>
              <hr style="margin-top: -15px;" />

              <div class="row">
                <!-- Name -->
                <input type = "hidden" name="hidden_id" id="hidden_id">
                <div class="form-group col-4">
                  <label for="lblFirstName" class="col-form-label">First Name</label>
                  <span style="color: red;">*</span>
                  <input type="text" class="form-control" id="edit_lblFirstName" name="txtFname" required="required" />
                </div>
                <div class="form-group col-4">
                  <label for="lblMiddleName" class="col-form-label">Middle Name (if any)</label>
                  <input type="text" class="form-control" id="edit_lblMiddleName" name="txtMname" />
                </div>
                <div class="form-group col-4">
                  <label for="lblLastName" class="col-form-label">Last Name</label>
                  <span style="color: red;">*</span>
                  <input type="text" class="form-control" id="edit_lblLastName" name="txtLname" required="required" />
                </div>
                <div class="form-group col-6">
                  <label for="view_username" class="col-form-label">Username</label>
                  <input type="text" class="form-control" id="view_username" name="view_username" readonly />
                </div>
                <div class="form-group col-6">
                  <label for="view_password" class="col-form-label">Password</label>
                  <input type="text" class="form-control" id="view_password" name="view_password" readonly/>
                </div>
                <div class="form-group col-6">
                  <label for="lblLastName" class="col-form-label">Image</label>
                  <span style="color: red;">*</span>
                  <input type="file" class="form-control" id="edit_image" name="edit_image"  />
                  <img id="imageprev2" style = "width:200px;height:200px" src="#" alt="your image" />
                </div>
              </div>

              <div class="form-group col-6">
                <label for="lblPos" class="col-form-label">Position</label>
                <span style="color: red;">*</span>
                <select class="form-control" name="optPos" id="edit_optPos" required="required">
                  <option value="Staff">Staff</option>
                  <option value="Doctor">Doctor</option>
                </select>
              </div>

              <div class="form-group col-6">
                <label for="lblPos" class="col-form-label">Status</label>
                <span style="color: red;">*</span>
                <select class="form-control" name="optstat" id="edit_optstat" required="required">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>

              <div class="modal-footer">
                <span style="color: red">Fields with asterisk(*) are required.</span>
                <button type="submit" class="btn btn-outline-danger">Save</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
  <?php 
  include "components/core-script.php";
  ?>
  <script src="../public/js/datatables.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#maintenance').addClass('active');
    $('#staff').addClass('active');
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

    //show staff
    $('#tblStaff').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        url: '../controller/staff/datatables.php',
        type: 'POST'
      },
      'language': {
        'emptyTable': 'No staff to show'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $('#editstaffinfo').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      var fname = $(e.relatedTarget).data('fname');
      var mname = $(e.relatedTarget).data('mname');
      var lname = $(e.relatedTarget).data('lname');
      var status = $(e.relatedTarget).data('status');
      var type = $(e.relatedTarget).data('type');
      var uname = $(e.relatedTarget).data('uname');
      var pass = $(e.relatedTarget).data('pass');
      //alert(rowid+fname+status);
      $("#hidden_id").val(rowid);
      $("#edit_lblFirstName").val(fname);
      $("#edit_lblMiddleName").val(mname);
      $("#edit_lblLastName").val(lname);
      $("#edit_optPos").val(type);
      $("#edit_optstat").val(status);
      $("#view_username").val(uname);
      $("#view_password").val(pass);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#imageprev').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#fileimg").change(function() {
      readURL(this);
    });

    function readURL2(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#imageprev2').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#edit_image").change(function() {
      readURL2(this);
    });
  </script>
</body>
</html>
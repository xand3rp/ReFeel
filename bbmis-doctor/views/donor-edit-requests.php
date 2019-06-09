<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Donor Edit Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
  <link rel="stylesheet" href="../public/css/bs-override.css">
</head>
<body>
  <?php include "components/loader.php"; ?>
  <div class="wrapper">
    <?php include "components/sidebar.php"; ?>
    <main class="mainpanel">
      <?php include "components/header.php"; ?>
      <div class="page-title">
        <h3 class="p-2">Donor Edit Requests</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container">
                <?php
                  $viewrequests = mysqli_query($connections,"
										SELECT *
                    FROM tblrequest
                    WHERE stfRequestStatus = 'Requested'
										AND stfUpdateStatus = 'Not Updated'
										AND stfRequestFeedback = 'Unnotified'
									");

                  if(mysqli_num_rows($viewrequests) > 0){
                ?>
                <table class='table table-bordered mt-2 text-center'>
                <thead>
                  <tr class="bg-danger text-white">
                    <td>Request ID</td>
                    <td>Client Name</td>
                    <td>Date Requested</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <?php
										while($row = mysqli_fetch_assoc($viewrequests))	{
											$reqId = $row["intClientReqId"];
											$clientId = $row["intClientId"];
											$changes = $row["txtChanges"];
											$date_requested = date_format(date_create($row["dtmDateRequested"]), 'F d, Y - h:i A');

											$latestrequestqry = mysqli_query($connections,"
												SELECT intClientReqId, txtchanges
												FROM tblrequest
												WHERE intClientId = '$clientId'
												ORDER BY intClientReqId DESC
												LIMIT 1,1
											");

											if(mysqli_num_rows($latestrequestqry) > 0)	{
												while($request = mysqli_fetch_assoc($latestrequestqry))	{
													$requestid = $request["intClientReqId"];
													$changes = $request["txtchanges"];
												}
											}
											else	{
												$changes = "Profile not yet edited.";
											}

											$getClientName = mysqli_query($connections,"
												SELECT CONCAT(strClientLastName, ', ', strClientFirstName, ' ', strClientMiddleName) AS Fullname
												FROM tblclient
												WHERE intClientId = '$clientId'
											");
											
											while($row2 = mysqli_fetch_assoc($getClientName)){
												$fullname = $row2["Fullname"];
											}
                  ?>
                  <tr>
                    <td class="align-middle"><?php echo $reqId; ?></td>
                    <td class="align-middle"><?php echo $fullname; ?></td>
                    <td class="align-middle"><?php echo $date_requested; ?></td>
                    <td>
											<button type='button' name = 'viewRequest' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#viewRequestModal' data-id='<?php echo $reqId ?>'data-changes='<?php echo $changes ?>'>
												<i class="fa fa-eye fa-sm mr-1"></i>
												View
											</button>
                    </td>
                  </tr>
                  <?php
										}
                ?>
                </table>
                <?php
									}
									else	{
                ?>
                <h4>No Requests to Show</h4>
                <?php
									}
								?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modals -->
  <!-- view request modal -->
  <div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
					<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="viewnewsurveycategoryTitle_enable">
						<i class="fa fa-user-edit px-2"></i>
						Edit Request
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="enable_category.php" name="form_viewsurveycategory_enable">
          <div class="modal-body">
            <div class="form-group">
              <label for="viewhiddenRequestId">Request ID</label>
              <input type="hidden" name = "viewhiddenRequestId" id = "viewhiddenRequestId">
              <input type="text" class="form-control" id='viewRequestId' name ='viewRequestId' readonly>
            </div>
            <div class="form-group">
              <label for="viewDonorName">Donor Name</label>
              <input type="text" class="form-control" id='viewDonorName' name ='viewDonorName' readonly>
            </div>
            <div class="form-group">
              <label for="viewDateRequested">Date Requested</label>
              <input type="text" class="form-control" id='viewDateRequested' name ='viewDateRequested' readonly>
            </div>
            <div class="form-group">
              <label for="viewPastEdit">Past Donor Profile Edit</label>
              <input type="text" class="form-control" id='viewPastEdit' name ='viewPastEdit' readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="acceptrequest">
							<i class="fa fa-check fa-sm mr-2"></i>
							Allow
						</button>
            <!--<button type="button" class="btn btn-danger" id="rejectrequest">Reject</button>-->
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include "components/core-script.php"; ?>
  <script src="../public/js/sweetalert.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#maintenance').addClass('active');
    $('#donor-edit-requests').addClass('active');
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

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $(document).on("show.bs.modal", "#viewRequestModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      var changes = $(e.relatedTarget).data('changes');
      console.log(changes + ' ' + rowid);
      $('#viewPastEdit').val(changes);
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/donor/fetchRequest.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewRequestId').val(data.intClientReqId);
          $('#viewDonorName').val(data.Fullname);
          $('#viewDateRequested').val(data.DateRequested);

        }
      });
    });

    $(document).on("click", "#acceptrequest", function(e){
      var reqId = $('#viewRequestId').val();
      // var confirm_input = confirm("Are you sure you?");
      // if(confirm_input == true){
        // $.ajax({
          // type: "POST",
          // url: '../controller/donor/acceptRequest.php',
          // data: 'reqId=' + reqId,
          // success: function(data){
            // alert("Edit Granted");
            // window.location.href = "donor-edit-requests.php";
          // }
        // });
      // }
      // else{
        // alert("Confirmation Cancelled");
        // return false;
      // }
			
			swal({
				title: "Notice.",
				text: "Are you sure you want to allow this user to update his/her information?",
				icon: "warning",
				buttons: ['No', 'Allow'],
				dangerMode: true
			})
			.then((willAllow) => {
				if(willAllow)	{
					$.ajax({
						type: "POST",
						url: '../controller/donor/acceptRequest.php',
						data: 'reqId=' + reqId,
						success: function(data){
							// alert("Edit Granted");
							swal("Okay!", "The request has been granted.", "success")
							.then((willOkay) => {
								window.location.href = "donor-edit-requests.php";
							})
						}
					});
				}
			})
    });
  </script>
</body>
</html>
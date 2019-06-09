<?php 
include "../controller/fetchEmpAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Discarded Blood Bags</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
  <style>
  .bb-col {
    border: 1px solid rgb(20,20,20);
    height: 30pt; 
  }
  </style>
</head>
<body>
  <?php 
  include "components/loader.php";
  ?>
  <div class="wrapper">
    <?php 
    include "components/sidebar.php";
    ?>
    <main class="mainpanel">
      <?php 
      include "components/header.php";
      ?>
      <div class="page-title">
        <!-- <div class="row"> -->
      <h3>Discarded Blood Bags</h3>
          <!-- <div class="col-md-4"> -->
            <!-- <div class="input-group float-right"> -->
              <!-- <input type="text" class="form-control" placeholder="Search serial number"> -->
              <!-- <div class="input-group-btn"> -->
                <!-- <button class="btn btn-default" id=""><i class="fas fa-search"></i></button> -->
              <!-- </div> -->
            <!-- </div> -->
          <!-- </div> -->
        <!-- </div> -->
      </div>
      <section class="content">
        <div class="content-container container-fluid">
          <div class="row pl-2 pr-2" id="bloodBags">
          </div>
        </div>
      </section>
    </main>
  </div>
  <div class="modal fade" id="bloodBagDetails" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-lg modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Blood Bag Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-6">
              <strong>Serial Number </strong>
              <input type="text" id="serialNum" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
              <strong>Blood Type</strong>
              <input type="text" id="bloodType" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
              <strong>Blood Volume (measured in cubic centimeter) </strong>
              <input type="text" id="bloodVolume" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <strong>Preservative Used </strong>
              <input type="text" id="pres" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <strong>Expired in</strong>
              <input type="text" id="expDate" class="form-control" readonly>
            </div>
            <div class="form-group col-md-12">
              <strong>Donor Name</strong>
              <input type="text" id="donorName" class="form-control" style="width: 50%" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php 
  include "components/core-script.php";
  ?>
  <script src="../public/js/notification.js"></script>
  <script>
  $('#transaction').addClass('active');
  $('#blood-inventory').addClass('active');
  $('.loader').hide();

  var arrDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
  var arrMonth = ['Jan', 'Feb', 'March', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  $.ajax({
    type: 'POST',
    url: '../controller/blood/fetchDiscardedBloodBags.php',
    dataType: 'json',
    success: function(resp) {
      if (resp != '1') {
        let values = resp.map( value => {
          return `
            <button class='col-md-2 btn bb-col d-flex justify-content-center align-items-center align-content-center' id='${value.strBloodBagSerialNo}' data-toggle='modal' data-target='#bloodBagDetails'>
              <p>${value.strBloodBagSerialNo}</p>
            </button>
          `;
        });
        $('#bloodBags').html(values);
      }
    }
  });

  $(document).on('show.bs.modal', '#bloodBagDetails', function(e) {
    serialNo = $(e.relatedTarget).attr("id");
    
    $.ajax({
      type: "POST",
      url: "../controller/blood/fetchBloodBagInfo.php",
      data: 'serialno=' + serialNo,
      dataType: "json",
      success: function(resp) {
        let tmpExpDate = new Date(resp.dateofexpiration);
        let day = tmpExpDate.getDay();
        let year = tmpExpDate.getFullYear();
        let date = tmpExpDate.getDate();
        let mon = tmpExpDate.getMonth();
        $('#serialNum').val(serialNo);
        $('#bloodType').val(resp.stfBloodType);
        $('#bloodVolume').val(resp.intBloodVolume + ' cc');
        $('#pres').val(resp.txtPreservative);
        $('#expDate').val(`${arrDays[day]}, ${arrMonth[mon]} ${date}, ${year}`);
        $('#donorName').val(resp.strClientFirstName + ' ' + resp.strClientMiddleName + ' ' + resp.strClientLastName);
      }
    });
  });
  </script>
</body>
</html>
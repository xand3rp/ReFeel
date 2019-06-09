<?php 
include "../controller/fetchEmpAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Blood Inventory</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
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
        <h3>Blood Inventory</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 3rem">
                <h4>Storage</h4>
                <div class="button-container">
                  <?php
                    $fetch_allstorage = mysqli_query($connections, " SELECT * FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId ");
                    $output =
                    "
                    <div class='row'>
                    ";
                    if (mysqli_num_rows($fetch_allstorage) > 0) {
                      while($row = mysqli_fetch_assoc($fetch_allstorage)){
                        $storage_id = $row["intStorageId"];
                        $storage_name = $row["strStorageName"];
                        $storage_type = $row["strStorageType"];
                        $output .=
                        "
                        <div class='col-md-4'>
                        <button type='button' onclick='window.location.href=\"selectedStorage.php?storage_id=$storage_id\"' class='btn btn-lg btn-block storage-buttons mt-2' id=$storage_id><i class='fas fa-box-open'></i> $storage_name<br><small>$storage_type</small></button>
                        </div>
                        ";
                      }
                      $output .= "</div>";
                      echo $output;
                    }
                    else {
                      echo "No active storage";
                    }
                  ?>
                </div>
                <button type="button" class="btn btn-outline-danger float-right" id="btn_addbloodbag" data-toggle="modal" data-target="#modal_addbloodbag"><i class="fas fa-plus"></i> Add Blood Bag</button>
              </div>
              <div class="content-container mt-2">
                <h4>Released Blood Bags</h4>
                <div class="container-fluid" id="releasedBloodBags">

                </div>
              </div>
              <div class="content-container mt-2">
                <h4>Rotten Blood Bag</h4>
                <div class="container-fluid" id="rottenBloodBags">

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
<!-- add blood bag modal -->
<div class="modal fade" id="modal_addbloodbag" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addbloodheader">Add Blood Bag</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form method="post" id="addbloodbag" name="addbloodbag">
            <div class="form-group">
              <label for="bloodserial">Blood Bag Serial</label>
              <input type="text" class="form-control" placeholder="Enter serial number" id="bloodserial" name="bloodserial" required>
            </div>
          <!--  <div class="form-group">
              <label for="bloodvolume">Volume</label>
              <select class="form-control" name="bloodvolume" id="bloodvolume" required="required">
                <option value="450cc">450 cubic centimeter</option>
                <option value="250cc">250 cubic centimeter</option>
              </select>
            </div>-->
            <div class="form-group">
              <label for="chosenStorage">Choose a Storage</label>
              <select class="form-control" name="chosenStorage" id="chosenStorage" required>
              <?php

              $fetch_storage = mysqli_query($connections, " SELECT intStorageId,intStorageCapacity,strStorageName FROM tblstorage WHERE intStorageTypeId = 1 AND stfStorageStatus = 'Active'");

              if(mysqli_num_rows($fetch_storage) > 0 ){
                while($row = mysqli_fetch_assoc($fetch_storage)){
                  $storageid = $row["intStorageId"];
                  $storagename = $row["strStorageName"];
                  $storagecapacity = $row["intStorageCapacity"];

                  $check_ifmayspacepa = mysqli_query($connections,"SELECT COUNT(intBloodBagId) AS bloodcount FROM tblbloodbag bb JOIN tblstorage s ON bb.intStorageId = s.intStorageId WHERE intBloodDispatchmentId = '1' AND stfIsBloodBagExpired = 'No' AND intStorageTypeId = 2 AND s.intStorageId = $storageid");

                  while ($row2 = mysqli_fetch_assoc($check_ifmayspacepa)) {
                    $quantity = $row2["bloodcount"];
                  }

                  if($quantity < $storagecapacity){
                  ?>
                  <option value="<?php echo $storageid ?>"><?php echo $storagename ?></option>
                  <?php
                }

                }
              }
              ?>
            </select>
            </div>

            <div class="form-group">
              <label for="chosenPreservative">Choose a Preservative</label>
              <select class="form-control" name="chosenPreservative" id="chosenPreservative" required>
              <?php

              $fetch_preservative = mysqli_query($connections, " SELECT intPreservativeId, txtPreservative, intPreservativeLifespan FROM tblpreservatives WHERE stfPreservativeStatus = 'Active'");

              if(mysqli_num_rows($fetch_preservative) > 0 ){
                while($pres = mysqli_fetch_assoc($fetch_preservative)){
                  $preservativeid = $pres["intPreservativeId"];
                  $preservative = $pres["txtPreservative"];
                  $preservativelifespan = $pres["intPreservativeLifespan"];

                  ?>

                  <option value="<?php echo $preservativeid ?>"><?php echo $preservative.' = '.$preservativelifespan.' days' ?></option>

                  <?php
                }
              }
              ?>
            </select>
            </div>

            <div class="form-group">
              <label for="bloodtype">Blood Type :</label>

              <label id='bloodtype'>
              </div>
              <div class="form-group">
                <label for="blooddonor">Donor</label>
                <input type="text" class="form-control" placeholder="Enter the first name of the donor" id="blooddonor" name="donorname" autocomplete="off" required>
                <div class="result"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" name="savebloodbag">
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php 
  include "components/core-script.php";
  ?>
  <script src="../public/js/sweetalert.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#transaction').addClass('active');
    $('#blood-inventory').addClass('active');
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

    fetchReleasedBloodBags();
    fetchRottenBloodBags();
    
    // fetch released bloodbags
    function fetchReleasedBloodBags(){
      $.ajax({
        url: "../controller/blood/fetchReleasedBloodBags.php",
        success: function(data){
          $('#releasedBloodBags').html(data);
        },
        complete: function(){
          setTimeout(fetchReleasedBloodBags,5000);
        }
      });
    }

    function fetchRottenBloodBags(){
      $.ajax({
        url: "../controller/blood/fetchRottenBloodBags.php",
        success: function(data){
          $('#rottenBloodBags').html(data);
        },
        complete: function(){
          setTimeout(fetchRottenBloodBags,5000);
        }
      });
    }

    $(document).on("submit", "form[name='addbloodbag']", function(e){
      e.preventDefault();
      var formdata = $(this).serialize();
      var confirm_input = confirm("Are you sure?");
      console.log(formdata);

      if(confirm_input == true)
      {
        $.ajax({
          url: "../controller/blood/insertBloodBag.php",
          method: "POST",
          data: {formdata,formdata},
          success: function(data){
            console.log(data);
            if (data == '1'){
              alert('Insert Succesful.');
              console.log(data);
              $(".modal-body input").val("");
              $(".modal-body select").val("");
              $('#addbloodmodal').modal("hide");
              $('#bloodtype').text("");
            }
            else if (data == '2'){
              alert('Donor has undefined bloodtype. Please update his/her record.');
            }
            else if (data == '3'){
              alert('Please check the donor serialno because there is already a bloodbag with the same serial.');
            }
            else if(data == '4'){
              alert('Please check the donor name, Because the donor already has a blood bag in the record.');
            }
            else if(data == '5'){
              alert('Donor not found. Please register the donor first.');
            }
            else if(data == '6'){
              alert('Donor has no current transaction');
            }
            else if(data == '7'){
              alert('Donor has no Blood Volume');
            }
            else if(data == '8'){
              alert('Cannot insert to storage. Storage Full.');
            }
            else if(data == '9'){
              alert('Please fill out all the fields.');
            }
            else if(data =='10') {
              alert('Storage full!');
            }
          }//success
        });
      }//end of if confirm_input
      else{
        alert("Confirmation Cancelled.");
        return false;
      }
    });

    $(document).on("keyup", "#blooddonor", function(e){
      /* Get input value on change */
      var inputVal = $(this).val();
      var resultDropdown = $(this).siblings(".result");

      console.log(inputVal);
      if(inputVal.length){
        $.get("../controller/blood/backendSearch.php", {term: inputVal}).done(function(data){
          // Display the returned data in browser
          resultDropdown.html(data);
        });
      } else{
        resultDropdown.empty();
      }
    });

    $(document).on("click", ".result p", function(){
      $(this).parents("#modal_addbloodbag").find('#blooddonor').val($(this).text());
      var donor = $(this).text();
      $(this).parent(".result").empty();

      $.ajax({
        url:"../controller/blood/fetchDonorBloodType.php",
        type:"POST",
        data:'donor=' + donor,
        dataType: "json",
        success: function(data){
          console.log(data);
          $('#bloodtype').text(data.stfBloodType);
          $('#bloodtype').append(" ");
          $('#bloodtype').append(data.stfBloodTypeRhesus);
          console.log(data.stfBloodType);
        }
      });
    });
  </script>
</body>
</html>
<?php
include("../connections.php");

$viewreleasedbloodbags = mysqli_query($connections, " SELECT strBloodBagSerialNo, TIMESTAMPDIFF(minute,dtmDispatchmentTimer,NOW()) as timer FROM tblbloodbag WHERE intBloodDispatchmentId = 2 AND stfIsBloodBagExpired = 'No' AND stfIsBloodBagDiscarded = 'No' ");


if (mysqli_num_rows($viewreleasedbloodbags) > 0 ){
  $output = "
  <table class='table table-bordered text-center'>
    <thead>
      <tr>
        <th>Blood Bag Serial Number</th>
        <th>Timer</th>
        <th>Action</th>
      </tr>
    </thead>
  ";
  while ($row = mysqli_fetch_assoc($viewreleasedbloodbags)){
    $serialno = $row["strBloodBagSerialNo"];
    $timer = $row["timer"];

    if ($timer < 20){
      $output .= "
      <tbody>
        <tr>
          <td>$serialno</td>
          <td>$timer minutes</td>
          <td><button type='button' class='btn btn_return' data-id=$serialno><i class='fas fa-arrow-left'></i> Return</button></td>
        </tr>
      </tbody>
      ";
      // echo "<script type='text/javascript'>swal('','Blood bag ' + $serialno + ' is alive and healthy', 'info')</script>";
      // if ($timer == 10 && $timer < 11){
      //   echo "<script type='text/javascript'>swal('','Blood bag '+ $serialno + ' is still outside, you sure its still out there?', 'info')</script>";
      // }
      // else if ($timer == 15 && $timer < 20){
      //   echo "<script type='text/javascript'>swal('', 'Blood bag ' + $serialno + ' only has few minutes left!', 'info')</script>";
      // }
    }
    else if ($timer >= 20){
      $output .= "
      <tbody>
        <tr>
          <td>$serialno</td>
          <td>'rotten blood bag yeet'</td>
          <td><button type='btn' class='btn mr-2 btn_discard' data-id=$serialno><i class='fas fa-archive'></i> Discard</button><button type='button' class='btn btn_return' data-id=$serialno disabled><i class='fas fa-arrow-left'></i> Return</button></td>
        </tr>
      </tbody>
      ";
      echo "<script type='text/javascript'>swal('','Blood bag' + $serialno + ' is expired!')</script>";
      mysqli_query($connections, " UPDATE tblbloodbag SET stfIsBloodBagExpired = 'Yes', stfTransfusionSuccess = 'Yes' WHERE strBloodBagSerialNo = '$serialno' ");
    }
  }
  $output .= "</table>";
  echo $output;
}
else if (mysqli_num_rows($viewreleasedbloodbags) == 0){
  echo "<div class='text-center'>
  <i class='fas fa-box fa-5x'></i>
  <h5 class='mt-2' style='color: rgb(110,110,110); font-weight: bold'>No released blood bags</h5>
  </div>";
}
 ?>
 <script type="text/javascript">
 $.getScript("js/sweetalert.min.js");
 //return to storage
 $(document).on("click",".btn_return", function(){
   var serialno = $(this).attr("data-id");
   console.log(serialno);

   swal({
     title: "Return blood bag",
     text: "This bag will be returned to its rightful storage",
     icon: "info",
     buttons: true,
   })
   .then((willApprove) => {
     if (willApprove) {
       $.ajax({
         method: "POST",
         url: "../controller/blood/returnBloodBag.php",
         data: "serialno=" + serialno,
         success: function (data) {
           swal("Success!","Blood bag successfully returned","success");
           swal({
             title: "",
             text: "Blood bag successfully returned to its rightful storage",
             icon: "success",
             buttons: {text:"Okay"},
           })
           .then((willApprove) => {
             if (willApprove) {
               location.reload();
             }
           });
         }
       });
     }
     else {
       swal("","No action done","info");
     }
   });
 });
 // discard blood bag

</script>

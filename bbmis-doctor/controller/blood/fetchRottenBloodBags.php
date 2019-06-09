<?php
include("../connections.php");

// fetch numbers that will be used to compare to dates
/*$fetch_bloodstatus = mysqli_query($connections, " SELECT * FROM tblpreservatives WHERE intPreservativeId = 1 ");
while($row = mysqli_fetch_assoc($fetch_bloodstatus)){
  $bloodbaglifespan = $row["intPreservativeLifespan"];
  $freshbloodbag = $row["intPreservativeFreshPercentage"];
  $mediumbloodbag = $row["intPreservativeNeutralPercentage"];
  $criticalbloodbag = $row["intPreservativeCriticalPercentage"];
}
settype($bloodbaglifespan, "int");
settype($freshbloodbag, "int");
settype($mediumbloodbag, "int");
settype($criticalbloodbag, "int");

$fresh_percentage = $freshbloodbag / 100;
$medium_percentage = $mediumbloodbag / 100;
$critical_percentage = $criticalbloodbag / 100;

$fresh_lifespan = $bloodbaglifespan * $fresh_percentage;
settype($fresh_lifespan, "int");
$medium_lifespan = $bloodbaglifespan * $medium_percentage;
settype($medium_lifespan, "int");
$critical_lifespan = $bloodbaglifespan * $critical_percentage;
settype($critical_lifespan, "int");*/

$fetch_expiredbloodbags = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb
  JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
  JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId
  JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
  JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
  JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE stfIsBloodBagExpired = 'Yes' AND stfIsBloodBagDiscarded = 'No' AND  DATEDIFF(NOW(), dtmDateStored) > tp.intPreservativeLifespan ");

if (mysqli_num_rows($fetch_expiredbloodbags) > 0 ){
  $output = "
  <table class='table table-striped table-bordered text-center'>
  <thead>
    <tr>
      <th>Serial Number</th>
      <th>Action</th>
    </tr>
  </thead>
  ";
  while($row = mysqli_fetch_assoc($fetch_expiredbloodbags)){
    $serialno = $row["strBloodBagSerialNo"];
    $fetch_expiredbb = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb
      JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
      JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId
      JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
      JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
      JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE stfIsBloodBagExpired = 'Yes' AND stfIsBloodBagDiscarded = 'No' OR  DATEDIFF(NOW(), dtmDateStored) > tp.intPreservativeLifespan AND strBloodBagSerialNo = '$serialno' ");

      if (mysqli_num_rows($fetch_expiredbb) > 0){
        $output .= "
        <tbody>
          <tr>
            <td>$serialno</td>
            <td><button type='button' class='btn btn_discard mr-2' data-id=$serialno><i class='fas fa-archive'></i> Discard</button></td>
          </tr>
        </tbody>
        ";
      }
  }
  $output .= "</table>";
  echo $output;
}
else if (mysqli_num_rows($fetch_expiredbloodbags) == 0){
  echo "
  <div class='text-center'>
  <i class='fas fa-box fa-5x'></i>
  <h5 class='mt-2' style='color: rgb(110,110,110); font-weight: bold'>No expired blood bags</h5>
  </div>";
}
 ?>
<script type="text/javascript">
$(document).on("click",".btn_discard",function(){
  var serialno = $(this).attr("data-id");
  swal({
    title: "Discard blood bag",
    text: "This bag will be discarded due to its long period outside the storage",
    icon: "info",
    buttons: true,
  })
  .then((willApprove) => {
    if (willApprove) {
      $.ajax({
        method: "POST",
        url: "../controller/blood/discardBloodBag.php",
        data: "serialno=" + serialno,
        success: function (data) {
          // swal("Success!","Blood bag is now discarded.","success");
          swal({
            title: '',
            text: 'Blood bag discarded successfully!',
            icon: 'success',
            buttons: {text: 'Okay'}
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
      swal("","No action done");
    }
  });
});
</script>

<?php
include("../connections.php");
parse_str($_POST["formdata"], $params);
$serialno = $params["hiddenserial"];
$reason = $params["rbtn_reason"];
$otherreason = $params["otherreason"];

if ($reason == 'on' && $otherreason == ''){
  echo "3";
}
else if($otherreason){
  mysqli_query($connections, " UPDATE tblbloodbag SET txtDispatchmentReason = '$otherreason' WHERE strBloodBagSerialNo = '$serialno' ");
  // echo $otherreason;
  echo "1"; //for lab or for patient
  $releasebloodbag = mysqli_query($connections, " UPDATE tblbloodbag SET intBloodDispatchmentId = 2 WHERE strBloodBagSerialNo = '$serialno' ");
  $startcountup = mysqli_query($connections, " UPDATE tblbloodbag SET dtmDispatchmentTimer = NOW() WHERE strBloodBagSerialNo = '$serialno' ");
}
else if ($reason){
  mysqli_query($connections, " UPDATE tblbloodbag SET txtDispatchmentReason = '$reason' WHERE strBloodBagSerialNo = '$serialno' ");
  // echo $reason;
  echo "2"; //for other reasons
  $releasebloodbag = mysqli_query($connections, " UPDATE tblbloodbag SET intBloodDispatchmentId = 2 WHERE strBloodBagSerialNo = '$serialno' ");
  $startcountup = mysqli_query($connections, " UPDATE tblbloodbag SET dtmDispatchmentTimer = NOW() WHERE strBloodBagSerialNo = '$serialno' ");
}
 ?>

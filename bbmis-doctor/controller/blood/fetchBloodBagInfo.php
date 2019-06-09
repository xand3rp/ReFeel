<?php
include("../connections.php");

if($_POST['serialno']){
  $serialno = $_POST['serialno'];

  // $fetch_statuscritical = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb JOIN tblpreservatives tbp ON tbb.intPreservativeId = tbp.intPreservativeId WHERE tbb.strBloodBagSerialNo = '$serialno' ");
  // $row_status = mysqli_fetch_assoc($fetch_statuscritical);
  // $bloodbaglifespan = $row_status["intPreservativeLifespan"];
  // settype($critical_endday, "int");
  $viewinfo = mysqli_query($connections, " SELECT tc.strClientFirstName, tc.strClientMiddleName, tc.strClientLastName, DATEDIFF(NOW(), tbb.dtmDateStored) AS 'daysinstorage', DATE_ADD(tbb.dtmDateStored, INTERVAL intPreservativeLifespan DAY) AS 'dateofexpiration', TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(dtmDateStored, INTERVAL intPreservativeLifespan DAY)) AS 'daysremaining', tbb.strBloodBagSerialNo, tbv.intBloodVolume, tbt.stfBloodType, tbt.stfBloodTypeRhesus, intPreservativeLifespan, txtPreservative
  FROM tblclient tc
  JOIN tblbloodbag tbb ON tc.intClientId = tbb.intClientId
  JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
  JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
  JOIN tblpreservatives tp on tbb.intPreservativeId = tp.intPreservativeId
  WHERE tbb.strBloodBagSerialNo = '$serialno' ");

  $row = mysqli_fetch_assoc($viewinfo);
  echo json_encode($row);
}

 ?>

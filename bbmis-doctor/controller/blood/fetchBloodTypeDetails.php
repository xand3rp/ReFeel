<?php
include("../connections.php");

if($_POST['rowid']){
  $btid = $_POST['rowid'];
  settype($btid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intBloodTypeId,stfBloodType,stfBloodTypeRhesus FROM tblbloodtype WHERE intBloodTypeId = $btid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

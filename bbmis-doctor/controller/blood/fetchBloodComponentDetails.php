<?php
include("../connections.php");

if($_POST['rowid']){
  $bloodcomponentid = $_POST['rowid'];
  settype($bloodcomponentid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intBloodComponentId,strBloodComponent,intDeferralDay,decMaleLeastVal,decMaleMaxVal,decFemaleLeastVal,decFemaleMaxVal FROM tblbloodcomponent WHERE intBloodComponentId = $bloodcomponentid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

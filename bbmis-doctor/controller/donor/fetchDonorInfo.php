<?php
include("../connections.php");

if($_POST['rowid']){
  $clientid = $_POST['rowid'];
  settype($clientid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, strClientContact, stfClientSex, stfClientCivilStatus, datClientBirthday, strClientOccupation, c.intBloodTypeId FROM tblclient c JOIN tblbloodtype bt ON c.intBloodTypeId = bt.intBloodTypeId WHERE intClientId = $clientid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

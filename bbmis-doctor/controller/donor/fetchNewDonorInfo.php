<?php
include("../connections.php");

if($_POST['clientid']){
  $clientid = $_POST['clientid'];
  settype($clientid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, strClientContact, stfClientSex, stfClientCivilStatus, datClientBirthday, strClientOccupation FROM tblclient WHERE intClientId = $clientid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

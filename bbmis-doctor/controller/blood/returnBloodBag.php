<?php
include("../connections.php");

if ($_POST['serialno']){
  $serialno = $_POST['serialno'];

  mysqli_query($connections, " UPDATE tblbloodbag SET intBloodDispatchmentId = 1 WHERE strBloodBagSerialNo = '$serialno' ");
  mysqli_query($connections, " UPDATE tblbloodbag SET txtDispatchmentReason = '' WHERE strBloodBagSerialNo = '$serialno' ");
}

 ?>

<?php

include("../connections.php");

if($_POST["serialno"]){
  $serialno = $_POST["serialno"];

  mysqli_query($connections, " UPDATE tblbloodbag SET stfIsBloodBagDiscarded = 'Yes' WHERE strBloodBagSerialNo = '$serialno' ");
}

 ?>

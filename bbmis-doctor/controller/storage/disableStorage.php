<?php
include("../connections.php");
$id = $_POST["id"];

$checkifstoragehasbloodbags = mysqli_query($connections, " SELECT * FROM tblbloodbag WHERE intStorageId = $id AND stfIsBloodBagExpired = 'No' ");

if (mysqli_num_rows($checkifstoragehasbloodbags) > 0 ){
  echo "1"; // if storage has bloodbags in it
}
elseif (mysqli_num_rows($checkifstoragehasbloodbags) == 0) {
  echo "2"; // if storage doesn't have any blood bags
  mysqli_query($connections,"UPDATE tblStorage SET stfStorageStatus = 'Inactive' WHERE intStorageId = $id");
}
?>

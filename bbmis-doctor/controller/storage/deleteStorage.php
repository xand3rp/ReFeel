<?php
include("../connections.php");

if($_POST["storage_id"]){
  $storage_id = $_POST["storage_id"];

  mysqli_query($connections, " DELETE FROM tblstorage WHERE intStorageId = $storage_id ");
}
 ?>

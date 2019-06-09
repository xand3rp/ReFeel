<?php
include("../connections.php");

if($_POST['rowid']){
  $bloodstorageid = $_POST['rowid'];
  settype($bloodstorageid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intStorageId,strStorageName,intStorageCapacity FROM tblstorage WHERE intStorageId = $bloodstorageid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

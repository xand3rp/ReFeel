<?php
include("../connections.php");
$id = $_POST["id"];

mysqli_query($connections,"UPDATE tblStorage SET stfStorageStatus = 'Active' WHERE intStorageId = $id");
?>

<?php
include("../connections.php");
$id = $_POST["id"];

mysqli_query($connections,"UPDATE tblpreservatives SET stfPreservativeStatus = 'Active' WHERE intPreservativeId = $id");
?>

<?php
include("../connections.php");
$id = $_POST["id"];

mysqli_query($connections,"UPDATE tblbloodcomponent SET stfBloodComponentStatus = 'Active' WHERE intBloodComponentId = $id");
?>

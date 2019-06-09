<?php
include("../connections.php");
$id = $_POST["id"];

mysqli_query($connections,"UPDATE tbldisease SET stfDiseaseStatus = 'Active' WHERE intDiseaseId = $id");
?>

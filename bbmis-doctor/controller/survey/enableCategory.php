<?php
include("../connections.php");
$id = $_POST["id"];

mysqli_query($connections,"UPDATE tblquestioncategory SET stfQuestionCategoryStatus = 'Active' WHERE intQuestionCategoryId = $id");
?>

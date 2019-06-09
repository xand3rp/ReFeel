<?php
	include("../connections.php");
	$id = $_POST["id"];

	mysqli_query($connections,"
		UPDATE tblbloodtype
		SET stfBloodTypeStatus = 'Active'
		WHERE intBloodTypeId = $id
	");
?>

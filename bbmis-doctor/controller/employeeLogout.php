<?php
	session_start();
	// session_unset($_SESSION["sessEmpId"]);
	unset($_SESSION["sessEmpId"]);
	// session_destroy();
	echo "Logging out, please wait.";
	header("Refresh: 1; url=../views/doctor-login.php");
?>
<?php
	session_start();
	unset($_SESSION["sessId"]);
	// session_destroy();
	echo "Logging out, please wait.";
	header("Refresh: 1; url=home.php");
?>

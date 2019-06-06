<?php
	include "connection.php";
	session_start();
	if(isset($_SESSION["sessId"]))	{
		$varDbId = $_SESSION["sessId"];
	}
	else	{
		echo "<script type='text/javascript'>window.location.href = 'err.php'</script>";
	}
?>
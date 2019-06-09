<?php
	include "connections.php";
	session_start();
	if(isset($_SESSION["sessEmpId"]))	{
		$varEmpId = $_SESSION["sessEmpId"];
	}
	else	{
		echo "<script type='text/javascript'>window.location.href = 'err.php'</script>";
	}
?>

<?php
	include "connection.php";
	session_start();
	if(isset($_SESSION["sessId"]))	{
		session_unset();
	}
?>
<?php
	include_once "connections.php";
	session_start();
	$varEmpId = $_SESSION["sessEmpId"];

	// echo $varDbId;

	$qryFetchEmpInfo = mysqli_query($connections, "
		SELECT strEmployeeFirstName, strEmployeeLastName, stfEmployeeType,strUserImageDir
		FROM tblemployee e JOIN tbluser u ON e.intUserId = u.intUserId
		WHERE intEmployeeId = $varEmpId
	");
	while($rowEmpInfo = mysqli_fetch_assoc($qryFetchEmpInfo))	{
		$varFname = $rowEmpInfo["strEmployeeFirstName"];
		$varLname = $rowEmpInfo["strEmployeeLastName"];
		$varRole = $rowEmpInfo["stfEmployeeType"];
		$varImg = $rowEmpInfo["strUserImageDir"];
	}
?>

<?php
	$qryJoinView = mysqli_query($conn, "
	SELECT c.strClientFirstName,  c.strClientMiddleName, c.strClientLastName, c.strClientContact, c.txtClientEmail, c.stfClientSex, c.stfClientCivilStatus, c.datClientBirthday, TIMESTAMPDIFF(YEAR, c.datClientBirthday, NOW()) AS 'Age', c.strClientOccupation, c.stfClientType, u.strUserName, u.strUserPassword, u.strUserImageDir
	FROM tblclient c
	JOIN tbluser u ON c.intUserId = u.intUserId
	WHERE c.intClientId = '$varDbId'");
	
	while($row = mysqli_fetch_assoc($qryJoinView))	{
		$varFname = $row["strClientFirstName"];
		$varMname = $row["strClientMiddleName"];
		$varLname = $row["strClientLastName"];
		$varContNo = $row["strClientContact"];
		$varEmail = $row["txtClientEmail"];
		$varSex = $row["stfClientSex"];
		$varCvlStat = $row["stfClientCivilStatus"];
		$varBday = $row["datClientBirthday"];
		$varAge = $row["Age"];
		$varOcc = $row["strClientOccupation"];
		$varRole = $row["stfClientType"];
		
		$varUn = $row["strUserName"];
		$varPw = $row["strUserPassword"];	
		$varImg = $row["strUserImageDir"];
	}
?>
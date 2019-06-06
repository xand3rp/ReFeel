<?php
	include "connection.php";
	parse_str($_POST["formdata2"], $params2);

	$varFname = filter_var(ucwords(strtolower(ltrim(rtrim($params2["txtFname"])))), FILTER_SANITIZE_STRING);
	$varMname = filter_var(ucwords(strtolower(ltrim(rtrim($params2["txtMname"])))), FILTER_SANITIZE_STRING);
	$varLname = filter_var(ucwords(strtolower(ltrim(rtrim($params2["txtLname"])))), FILTER_SANITIZE_STRING);
	$varContNo = filter_var(ltrim(rtrim($params2["txtContNo"])), FILTER_SANITIZE_STRING);
	$varEmail = filter_var($params2["txtEmail"], FILTER_SANITIZE_EMAIL);
	$varSex = filter_var($params2["optSex"], FILTER_SANITIZE_STRING);
	$varCvlStat = filter_var($params2["optCvlStat"], FILTER_SANITIZE_STRING);
	$varBm = filter_var($params2["txtBm"], FILTER_SANITIZE_STRING);
	$varBd = filter_var($params2["txtBd"], FILTER_SANITIZE_STRING);
	$varBy = filter_var($params2["txtBy"], FILTER_SANITIZE_STRING);
	$varOcc = filter_var(ucwords(strtolower(ltrim(rtrim($params2["txtOcc"])))), FILTER_SANITIZE_STRING);
	$varUn = filter_var(strtolower(ltrim(rtrim($params2["txtUn"]))), FILTER_SANITIZE_STRING);
	$varPw = filter_var($params2["txtPw"], FILTER_SANITIZE_STRING);


	if($varUn && $varPw)	{
		$qryCheckUser = mysqli_query($conn, "
			SELECT *
			FROM tbluser
			WHERE strUserName = '$varUn'
		");

		// Checks and returns rows of the username entered
		$qryCheckUserOcc = mysqli_num_rows($qryCheckUser);

		// If username has no matched in the records
		if($qryCheckUserOcc == 0)	{
			$qryAddUser = mysqli_query($conn, "
				INSERT INTO tbluser(strUserName, strUserPassword)
				VALUES('$varUn', '$varPw')
			");

			if($qryAddUser)	{
				//Fetch the recent UserId inserted.
				$qryCheckUserNew = mysqli_query($conn, "
					SELECT *
					FROM tbluser
					WHERE strUserName = '$varUn'
				");

				while($row = mysqli_fetch_assoc($qryCheckUserNew))	{
					$varDbId = $row["intUserId"];
				}
			}

			if($varFname && $varLname && $varContNo && $varSex && $varCvlStat && $varBm && $varBd && $varBy && $varOcc)	{
				$qryAddClient = mysqli_query($conn, "
				INSERT INTO tblclient(intUserId, strClientFirstName, strClientMiddleName, strClientLastName, strClientContact, stfClientSex, stfClientCivilStatus, datClientBirthday, strClientOccupation)
				VALUES('$varDbId', '$varFname', '$varMname', '$varLname', '$varContNo', '$varSex', '$varCvlStat', '$varBy/$varBm/$varBd', '$varOcc')");

				if($qryAddClient)	{
					// Success applicant signup.
					echo 1;
				}
			}
		}

		else	{
			// Account is already existing. Please signup again.
			echo 2;
		}
	}
?>

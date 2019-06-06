<?php
	include "connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];
	
	parse_str($_POST["formdata"], $params);
	$varBtnVal = $params["btnAct"];
	
	include "fetchClientAcc.php";
	
	//Personal Information
	if($varBtnVal == "Request")	{
		$qryInsertReq = mysqli_query($conn, "
		INSERT INTO tblrequest(intClientId, stfRequestStatus, dtmDateRequested)
		VALUES($varDbId, 'Requested', NOW())");
		echo '1';
	}
	
	else if($varBtnVal == "Update")	{
		$varNewFname = ucwords(strtolower(ltrim(rtrim($params["txtNewFname"]))));
		$varNewMname = ucwords(strtolower(ltrim(rtrim($params["txtNewMname"]))));
		$varNewLname = ucwords(strtolower(ltrim(rtrim($params["txtNewLname"]))));
		$varNewSex = $params["optNewSex"];
		$varNewCvlStat = $params["optNewCvlStat"];
		$varNewBm = $params["optNewBm"];
		$varNewBd = $params["optNewBd"];
		$varNewBy = $params["optNewBy"];
		$varNewOcc = ucwords(strtolower(ltrim(rtrim($params["txtNewOcc"]))));
		
		$qryUpdatePI = mysqli_query($conn, "
		UPDATE tblclient
		SET strClientFirstName = '$varNewFname',
		strClientMiddleName = '$varNewMname',
		strClientLastName = '$varNewLname',	
		stfClientSex = '$varNewSex',	
		stfClientCivilStatus = '$varNewCvlStat',
		datClientBirthday = '$varNewBy/$varNewBm/$varNewBd',
		strClientOccupation = '$varNewOcc'
		WHERE intClientId = '$varDbId'");
		
		$varChanges = '';
		
		if(!($varFname == $varNewFname))	{
			$varChanges .= 'First Name: ' . $varFname . '->' . $varNewFname . '/n';
		}
		
		if(!($varMname == $varNewMname))	{
			$varChanges .= 'Middle Name: ' . $varMname . '->' . $varNewMname . '/n';
		}
		
		if(!($varLname == $varNewLname))	{
			$varChanges .= 'Last Name: ' . $varLname . '->' . $varNewLname . '/n';
		}
		
		if(!($varSex == $varNewSex))	{
			$varChanges .= 'Sex: ' . $varSex . '->' . $varNewSex . '/n';
		}
		
		if(!($varCvlStat == $varNewCvlStat))	{
			$varChanges .= 'Civil Status: ' . $varCvlStat . '->' . $varNewCvlStat . '/n';
		}
		
		if(!($varBday == ('$varNewBy-$varNewBm-$varNewBd')))	{
			$varChanges .= 'Civil Status: ' . $varCvlStat . '->' . $varNewCvlStat . '/n';
		}
		
		if(!($varOcc == $varNewOcc))	{
			$varChanges .= 'Occupation: ' . $varOcc . '->' . $varNewOcc . '/n';
		}
		
		$qryLatestReqId = mysqli_query($conn, "
			SELECT intClientReqId
			FROM tblrequest
			WHERE intClientId = '$varDbId'
			ORDER BY intClientReqId DESC
			LIMIT 1
		");
		
		while($rowLatestReqId = mysqli_fetch_assoc($qryLatestReqId))	{
			$varLatestReqId = $rowLatestReqId["intClientReqId"];
		}
		
		$qryUpdated = mysqli_query($conn, "
			UPDATE tblrequest
			SET stfUpdateStatus = 'Updated', txtChanges = '$varChanges', dtmDateUpdated = NOW()
			WHERE intClientId = '$varDbId'
			AND intClientReqId = $varLatestReqId
		");
		
		echo '2';
	}
	
	//Contact Information
	else if($varBtnVal == "Contact")	{
		$varNewContNo = $params['txtNewContNo'];
		$varNewEmail = $params['txtNewEmail'];
		
		$qryUpdateContNo = mysqli_query($conn, "
			UPDATE tblclient
			SET strClientContact = '$varNewContNo',
			txtClientEmail = '$varNewEmail'
			WHERE intClientId = $varDbId
		");
		
		echo '3';
	}
	
	//Account Credentials
	else if($varBtnVal == "Account")	{
		//echo $params["btnAct"];
		$varNewUn = strtolower(ltrim(rtrim($params["txtNewUn"])));
		$varOldPw = $params["txtOldPw"];
		$varNewPw = $params["txtNewPw"];
		$varConfNewPw = $params["txtConfNewPw"];
		
		if($varPw == $varOldPw)	{
			if($varNewPw == $varConfNewPw)	{
				$qryUpdateAccCred = mysqli_query($conn, "
				UPDATE tbluser
				SET strUserName = '$varNewUn', strUserPassword = '$varNewPw'
				WHERE intUserId = (
					SELECT intUserId
					FROM tblclient
					WHERE intClientId = '$varDbId')");
				
				if($qryUpdateAccCred)	{
					//account credentials is updated!
					echo "1";
				}
			}
			
			else	{
				//new and confimation passwords does not match.
				echo "2";
			}
		}
		
		else	{
			//recent password is incorrect
			echo "3";
		}
	}
?>
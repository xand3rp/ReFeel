<?php
	include "connection.php";
	
	function btnReq()	{
		echo "
			<input type='hidden' name='btnAct' value='Request' />
			<input type='submit' value='Request for Update' id='btnReq' class='btn btn-outline-danger' />
		";
	}
	
	function btnWait()	{
		echo "
			<button class='btn btn-outline-danger' type='button' disabled='disabled'>Waiting for Response</button>
		";
	}
	
	function btnUpd()	{
		echo "
			<input type='hidden' name='btnAct' value='Update' />
			<input type='submit' value='Update' id='btnUpd' class='btn btn-outline-danger' />
		";
	}
	
	function btnCld($varCooldown)	{
		echo "
		<button class='btn btn-outline-danger' type='button' title='You can update again your personal information after $varCooldown day/s.' disabled='disabled'>
			Request for Update ($varCooldown)
		</button>
		";
	}
	
	//Latest request record of the client.
	$qryFetchReq = mysqli_query($conn, "
		SELECT stfRequestStatus, stfRequestFeedback, stfUpdateStatus, dtmDateRequested, TIMESTAMPDIFF(DAY, dtmDateRequested, NOW()) AS 'Requested Day Difference', dtmDateUpdated, TIMESTAMPDIFF(DAY, dtmDateUpdated, NOW()) AS 'Updated Day Difference'
		FROM tblrequest
		WHERE intClientId = '$varDbId'
		ORDER BY intClientReqId DESC
		LIMIT 1
	");
	
	while($rowQry = mysqli_fetch_assoc($qryFetchReq))	{
		$varRqs = $rowQry["stfRequestStatus"];
		$varRqf = $rowQry["stfRequestFeedback"];
		$varUpd = $rowQry["stfUpdateStatus"];
		$varDatReq = $rowQry["dtmDateRequested"];
		$varDateReqDiff = $rowQry["Requested Day Difference"];
		$varDatUpd = $rowQry["dtmDateUpdated"];
		$varDateUpdDiff = $rowQry["Updated Day Difference"];
	}
	
	if(!isset($varRqs))	{
		btnReq();
	}
	
	else	{
		if($varRqs == 'Requested')	{
			if($varRqf == 'Unnotified')	{
				btnWait();
			}
			
			else if($varRqf == 'Granted' && $varUpd == 'Not Updated')	{
				btnUpd();
			}
			
			else {
				//Variable for fetching the cooldown days of the request set by the employee.
				
				$varReqWait = 60; 
				
				if(isset($varDateUpdDiff))	{
					$varDateDiff = $varDateUpdDiff;
				}
				
				else	{
					$varDateDiff = $varDateReqDiff;
				}
				
				$varCooldown = $varReqWait - $varDateDiff;
				
				if($varCooldown <= 0)	{
					btnReq();
				}
				
				else	{
					btnCld($varCooldown);
				}
			}
		}		
	}
?>
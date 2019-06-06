<?php
	include "connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];
	
	class Progress {
		public $me;
		public $pe;
		public $is;
		public $ss;
	}
	
	$objDonProg = new Progress();
	
	$qryFetchRecDon = mysqli_query($conn, "
		SELECT intDonationId
		FROM tbldonation
		WHERE intClientId = $varDbId
		ORDER BY 1 DESC
		LIMIT 1
	");
	$rowFetchRecDon = mysqli_fetch_assoc($qryFetchRecDon);
	$varRecDonId = $rowFetchRecDon["intDonationId"];
	
	$qryCliSex = mysqli_query($conn, "
		SELECT stfClientSex
		FROM tblclient
		WHERE intClientId = $varDbId
	");
	$rowCliSex = mysqli_fetch_assoc($qryCliSex);
	$varCliSex = $rowCliSex["stfClientSex"];
	
	if(isset($varRecDonId))	{
		$qryFetchMeRemarks = mysqli_query($conn, "
			SELECT DISTINCT(stfAnswerRemarks)
			FROM tblmedicalexam
			WHERE intDonationId = $varRecDonId
		");
		
		$varMeRemarks = array();
		// $varCountMeRemarks = array();
		
		$varCount = 0;
		
		while($rowMeRemarks = mysqli_fetch_assoc($qryFetchMeRemarks))	{
			$varMeRemarks[$varCount] = $rowMeRemarks["stfAnswerRemarks"];
			// $varCountMeRemarks[$varCount] = $rowMeRemarks["Remarks Count"];
			$varCount++;
		}
		
		$varCountRows = mysqli_num_rows($qryFetchMeRemarks);
		
		if($varCountRows > 1)	{
			//If there is a 'Wrong' remarks in all valid remarks of the exam.
			if(in_array('Wrong', $varMeRemarks) && in_array('Correct', $varMeRemarks))	{
				$objDonProg -> me = 2;
			}
			else	{
				//Error if there are foreign remark except the valid remarks.
					if($varCliSex == 'Male')	{
						//Unchecked
						$objDonProg -> me = 3;
					}
					else if($varCliSex == 'Female')	{
						//Checking Error
						$objDonProg -> me = 4;
					}
			}
		}
		
		else if($varCountRows == 1)	{
			if(in_array('Correct', $varMeRemarks))	{
				$objDonProg -> me = 1;
			}
			else if(in_array('Wrong', $varMeRemarks))	{
				$objDonProg -> me = 2;
			}
			else if(in_array('Unchecked', $varMeRemarks))	{
				$objDonProg -> me = 5;
			}
			else if(in_array('Expired', $varMeRemarks))	{
				$objDonProg -> me = 6;
			}
		}
		
		$qryFetchPeRemarks = mysqli_query($conn, "
			SELECT DISTINCT(stfClientPhysicalExamRemarks)
			FROM tblphysicalexam
			WHERE intDonationId = $varRecDonId
		");
		$rowPeRemarks = mysqli_fetch_assoc($qryFetchPeRemarks);
		$varPeRemarks = $rowPeRemarks["stfClientPhysicalExamRemarks"];
		if(isset($varPeRemarks))	{
			if($varPeRemarks == 'Passed')	{
				$objDonProg -> pe = 1;
			}
			else if($varPeRemarks == 'Failed')	{
				$objDonProg -> pe = 2;
			}
		}
		else	{
			$objDonProg -> pe = 0;
		}
		
		$qryFetchIsRemarks = mysqli_query($conn, "
			SELECT DISTINCT(stfClientInitialScreeningRemarks)
			FROM tblinitialscreening
			WHERE intDonationId = $varRecDonId
		");
		$rowIsRemarks = mysqli_fetch_assoc($qryFetchIsRemarks);
		$varIsRemarks = $rowIsRemarks["stfClientInitialScreeningRemarks"];
		if(isset($varIsRemarks))	{
			if($varIsRemarks == 'Passed')	{
				$objDonProg -> is = 1;
			}
			else if($varIsRemarks == 'Failed')	{
				$objDonProg -> is = 2;
			}
		}
		else	{
			$objDonProg -> is = 0;
		}
		
		$qryFetchSsRemarks = mysqli_query($conn, "
			SELECT DISTINCT(stfDonorSerologicalScreeningRemarks)
			FROM tblserologicalscreening
			WHERE intDonationId = $varRecDonId
		");
		$rowSsRemarks = mysqli_fetch_assoc($qryFetchSsRemarks);
		$varSsRemarks = $rowSsRemarks["stfDonorSerologicalScreeningRemarks"];

		if(isset($varSsRemarks))	{
			if($varSsRemarks == 'Passed')	{
				$objDonProg -> ss = 1;
			}
			else if($varSsRemarks == 'Failed')	{
				$objDonProg -> ss = 2;
			}
		}
		else	{
			$objDonProg -> ss = 0;
		}
	}
	
	else	{
		$objDonProg -> me = 0;
	}
	
	echo json_encode($objDonProg);
?>
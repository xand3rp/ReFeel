<?php
	include ("../connections.php");
	parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
	$varDbId = $params["hidden_id"];

	$date = $params['date_med'];
	$datenow = date('Y-m-d H:i:s');
	$date_1 = new DateTime($date);
	$datenow_1 = new DateTime($datenow);

	$qryQueId = mysqli_query($connections, "SELECT intQuestionId,intQuestionCategoryId FROM tblquestion WHERE boolVersionInUse = '1'");

	$varQueCount = mysqli_num_rows($qryQueId);

	$qryCliSex = mysqli_query($connections, "SELECT stfClientSex FROM tblclient WHERE intClientId = $varDbId");
	while($rowCliSex = mysqli_fetch_assoc($qryCliSex))	{
		$varSex = $rowCliSex["stfClientSex"];
	}

if($date_1 <= $datenow_1){
	// mysqli_query($connections, "INSERT INTO tbldonation(intClientId,stfDonationRemarks,stfDonationStatus) VALUES('$varDbId','Incomplete','Unable')");
	mysqli_query($connections, "INSERT INTO tbldonation(intClientId) VALUES('$varDbId')");

	$donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$varDbId' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

 while($donation = mysqli_fetch_assoc($donationidqry)){
	 $donation_id = $donation["intDonationId"];
	 settype($donation_id,"int");
 }


	while($rowQueId = mysqli_fetch_assoc($qryQueId))	{
		$varQueId = $rowQueId["intQuestionId"];
		$category = $rowQueId["intQuestionCategoryId"];


		if(isset($params["txtYn$varQueId"]))	{
			$varAnsYn = $params["txtYn$varQueId"];
		}
		else	{
			$varAnsYn = null;
		}

		if(isset($params["txtBm$varQueId"]) && isset($params["txtBd$varQueId"]) && isset($params["txtBy$varQueId"]))	{
			$varAnsDat = $params["txtBy$varQueId"] . '-' . $params["txtBm$varQueId"] . '-' . $params["txtBd$varQueId"];
		}
		else	{
			$varAnsDat = null;
		}

		if(isset($params["intQua$varQueId"]))	{
			$varAnsQua = $params["intQua$varQueId"];
		}
		else	{
			$varAnsQua = 0;
		}

		if(isset($params["txtStr$varQueId"]))	{
			$varAnsStr = $params["txtStr$varQueId"];
		}
		else	{
			$varAnsStr = null;
		}

		if(isset($params["updatestatus$varQueId"])){
			$varstatus = $params["updatestatus$varQueId"];
		}
		else {
			$varstatus = 'Unchecked';
		}
	//	echo '<br />';

		if($varSex == 'Female'){
				$qryInsertAnswers = mysqli_query($connections, "INSERT INTO tblmedicalexam( intQuestionId, intDonationId, stfAnswerYn, datAnswerDate, intAnswerQuantity, strAnswerString,dtmExamTaken, dtmExamChecked, stfAnswerRemarks) VALUES('$varQueId', '$donation_id', '$varAnsYn', '$varAnsDat', $varAnsQua, '$varAnsStr','$date', '$date', '$varstatus')");

		if($varstatus == 'Wrong'){
					mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
				}
		}

		else if ($varSex == 'Male' AND $category == '3'){
			$qryInsertAnswers = mysqli_query($connections, "INSERT INTO tblmedicalexam( intQuestionId, intDonationId, stfAnswerYn, datAnswerDate, intAnswerQuantity, strAnswerString,dtmExamTaken, dtmExamChecked, stfAnswerRemarks) VALUES('$varQueId', '$donation_id', '$varAnsYn', '$varAnsDat', $varAnsQua, '$varAnsStr', '$date','$date', 'Correct')");

		}

		else if ($varSex == 'Male' AND $category != '3') {

			$qryInsertAnswers = mysqli_query($connections, "INSERT INTO tblmedicalexam( intQuestionId, intDonationId, stfAnswerYn, datAnswerDate, intAnswerQuantity, strAnswerString,dtmExamTaken, dtmExamChecked, stfAnswerRemarks) VALUES('$varQueId', '$donation_id', '$varAnsYn', '$varAnsDat', $varAnsQua, '$varAnsStr', '$date','$date', '$varstatus')");

		if($varstatus == 'Wrong'){
			mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
		}
		}

	}
}else{
	echo '2';
}
?>

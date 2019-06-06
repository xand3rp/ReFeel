<?php
	include "connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];
	
	parse_str($_POST["formdata"], $params);
	
	$qryQueId = mysqli_query($conn, "
		SELECT intQuestionId
		FROM tblquestion
		WHERE decQuestionVersion = (
			SELECT DISTINCT(q1.decQuestionVersion)
			FROM tblquestion q1
			WHERE boolVersionInUse = '1'
		)
	");
	
	$varQueCount = mysqli_num_rows($qryQueId);
	
	$qryCliSex = mysqli_query($conn, "
		SELECT stfClientSex
		FROM tblclient
		WHERE intClientId = $varDbId
	");
	$rowCliSex = mysqli_fetch_assoc($qryCliSex);
	$varCliSex = $rowCliSex["stfClientSex"];
	
	$qryInsertDon = mysqli_query($conn, "
		INSERT INTO tbldonation(intClientId)
		VALUES($varDbId)
	");
	
	$qryDistDon = mysqli_query($conn, "
		SELECT intDonationId
		FROM tbldonation
		WHERE intClientId = $varDbId
		ORDER BY intDonationId DESC
		LIMIT 1
	");
	$rowDistDon = mysqli_fetch_assoc($qryDistDon);
	$varDonId = $rowDistDon["intDonationId"];

	while($rowQueId = mysqli_fetch_assoc($qryQueId))	{
		$varQueId = $rowQueId["intQuestionId"];

		if(isset($params["txtYn$varQueId"]))	{
			$varAnsYn = $params["txtYn$varQueId"];
		}
		else	{
			$varAnsYn = null;
		}

		if(isset($params["optDm$varQueId"]) && isset($params["optDd$varQueId"]) && isset($params["optDy$varQueId"]))	{
			$varAnsDat = $params["optDy$varQueId"] . '-' . $params["optDm$varQueId"] . '-' . $params["optDd$varQueId"];
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
			$varAnsStr = filter_var($params["txtStr$varQueId"], FILTER_SANITIZE_STRING);
		}
		else	{
			$varAnsStr = null;
		}
		
		$qryInsertAnswers = mysqli_query($conn, "
			INSERT INTO tblmedicalexam(intDonationId, intQuestionId, stfAnswerYn, datAnswerDate, intAnswerQuantity, strAnswerString)
			VALUES($varDonId, $varQueId, '$varAnsYn', '$varAnsDat', $varAnsQua, '$varAnsStr')
		");
		
		if($varCliSex == 'Male')	{
			$qryMaleFemExcRem = mysqli_query($conn, "
				UPDATE tblmedicalexam
				SET stfAnswerRemarks = 'Correct', dtmExamChecked = NOW()
				WHERE intQuestionId IN (SELECT intQuestionId FROM tblquestion WHERE intQuestionCategoryId = 3 AND boolVersionInUse = '1');
			");
		}
	}
	
	echo 1;
?>
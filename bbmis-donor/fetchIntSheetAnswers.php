<?php
	include "connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];
	
	$qryFetchDonationId = mysqli_query($conn, "
		SELECT me1.intDonationId
		FROM tbldonation d
		JOIN tblmedicalexam me1 ON d.intDonationId = me1.intDonationId
		WHERE d.intClientId = $varDbId
		ORDER BY 1 DESC
		LIMIT 1
	");
	while($rowFetchDonationId = mysqli_fetch_assoc($qryFetchDonationId));
	$varDonationId = $rowFetchDonationId["intDonationId"];
	
	echo $varDonationId;
	
	$qryFetchSheetVer = mysqli_query($conn, "
		SELECT DISTINCT(q.decQuestionVersion)
		FROM tblquestion q
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = $varDonationId
	");
	
	while($rowQryVer = mysqli_fetch_assoc($qryFetchSheetVer))	{
		$varIntSheetVerDb = $rowQryVer["decQuestionVersion"];
	}
	
	$qryFetchItemAns = mysqli_query($conn, "
		SELECT q.intQuestionId, me.stfAnswerYn, me.strAnswerString, me.datAnswerDate, me.intAnswerQuantity
		FROM tblquestion q
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = $varDonationId
	");
	
	$arrIntSheet = array();
	
	$varCount = 0;
	
	class ItemAns	{
		public $id;
		public $yn;
		public $str;
		public $dm;
		public $dd;
		public $dy;
		public $qua;
	}
	
	while($rowItemAns = mysqli_fetch_assoc($qryFetchItemAns))	{
		$varQueId = $rowItemAns["intQuestionId"];
		$varAnsYn = $rowItemAns["stfAnswerYn"];
		$varAnsStr = $rowItemAns["strAnswerString"];

		if($rowItemAns["datAnswerDate"] == '0000-00-00' || $rowItemAns["datAnswerDate"] == null)	{
			$varAnsDm = $varAnsDd = '00';
			$varAnsDy = '0000';
		}
		else	{
			$varAnsDm = date_format(date_create($rowItemAns["datAnswerDate"]), 'n');
			$varAnsDd = date_format(date_create($rowItemAns["datAnswerDate"]), 'j');
			$varAnsDy = date_format(date_create($rowItemAns["datAnswerDate"]), 'Y');
		}
		
		$varAnsQua = $rowItemAns["intAnswerQuantity"];
		
		$objItemsAns = new ItemAns();
		
		$objItemsAns -> id = $varQueId;
		$objItemsAns -> yn = $varAnsYn;
		$objItemsAns -> str = $varAnsStr;
		$objItemsAns -> dm = $varAnsDm;
		$objItemsAns -> dd = $varAnsDd;
		$objItemsAns -> dy = $varAnsDy;
		$objItemsAns -> qua = $varAnsQua;
		
		array_push($arrIntSheet, $objItemsAns);
	}
	
	echo json_encode($arrIntSheet);
?>
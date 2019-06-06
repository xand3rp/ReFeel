<?php
	include "connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];
	
	$qryFetchSheetVer = mysqli_query($conn, "
		SELECT DISTINCT(q.decQuestionVersion)
		FROM tblquestion q
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = (
			SELECT me1.intDonationId
			FROM tbldonation d
			JOIN tblmedicalexam me1 ON d.intDonationId = me1.intDonationId
			WHERE d.intClientId = $varDbId
			LIMIT 1
		)
	");
	
	while($rowQryVer = mysqli_fetch_assoc($qryFetchSheetVer))	{
		$varIntSheetVerDb = $rowQryVer["decQuestionVersion"];
	}
	
	$qryFetchItemAns = mysqli_query($conn, "
		SELECT q.intQuestionId, me.stfAnswerYn, me.strAnswerString, me.datAnswerDate, me.intAnswerQuantity
		FROM tblquestion q
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = (
			SELECT me1.intDonationId
			FROM tbldonation d
			JOIN tblmedicalexam me1 ON d.intDonationId = me1.intDonationId
			WHERE d.intClientId = $varDbId
			LIMIT 1
		)
	");
	
	// $varParArrAns = array();
	// $arrIntSheet = array();
	
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
	
	// $arrPrntItemsAns = array();
	// $arrChldItemsAns = array();
	
	while($rowItemAns = mysqli_fetch_assoc($qryFetchItemAns))	{
		$varQueId = $rowItemAns["intQuestionId"];
		$varAnsYn = $rowItemAns["stfAnswerYn"];
		$varAnsStr = $rowItemAns["strAnswerString"];
		$varAnsDm = date_format(date_create($rowItemAns["datAnswerDate"]), 'n');
		$varAnsDd = date_format(date_create($rowItemAns["datAnswerDate"]), 'j');
		$varAnsDy = date_format(date_create($rowItemAns["datAnswerDate"]), 'Y');
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
		
		// $varArrAns = array('id' => $varQueId, 'yn' => $varAnsYn, 'str' => $varAnsStr, 'dat' => $varAnsDate, 'qua' => $varAnsQua);
		
		
		// $varCount++;
	}
	
	echo json_encode($arrIntSheet);
	
	
	// print_r($objItemsAns);
	
	// print_r($arrIntSheet);
	
	// $varQueCount = mysqli_num_rows($qryFetchItemAns);
	
	// echo $varQueCount;
?>
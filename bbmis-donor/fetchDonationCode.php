<?php
	$qryFetchDonationIdDate = mysqli_query($conn, "
		SELECT d.intDonationId, me.dtmExamTaken
		FROM tbldonation d
		JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
		WHERE d.intClientId = $varDbId
	");
	while($rowDonationIdDate = mysqli_fetch_assoc($qryFetchDonationIdDate))	{
		$varDonaId = $rowDonationIdDate["intDonationId"];
		$varExamTaken = $rowDonationIdDate["dtmExamTaken"];
	}
	
	if(isset($varDonaId))	{
		echo 'Donation Code: ' . $varDonaId . date_format(date_create($varExamTaken), 'Ymd');
	}
	else	{
		echo 'Donation Code: 000000000';
	}
?>
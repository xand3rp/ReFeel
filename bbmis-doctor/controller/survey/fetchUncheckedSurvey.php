<?php

	include "../connections.php";
	$res = array();
	$fetchUncheckedSurvey = mysqli_query($connections, "
		SELECT DISTINCT(d.intDonationId), c.intClientId, CONCAT(strClientLastName, ', ', strClientFirstName, ' ', strClientMiddleName) AS Applicant_DonorName
		FROM tbldonation d
		JOIN tblclient c ON d.intClientId = c.intClientId
		JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
		WHERE stfAnswerRemarks = 'Unchecked'
		AND stfDonationRemarks = 'Incomplete'
		AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
	");

	while($row = mysqli_fetch_assoc($fetchUncheckedSurvey)) {
		$res[] = $row;
	}

	echo json_encode($res);
<?php

	include "../connections.php";
	$res = array();
	$fetchUncheckedSurvey = mysqli_query($connections, "
		SELECT DISTINCT(d.intDonationId), c.intClientId, CONCAT(strClientLastName, ', ', strClientFirstName, ' ', strClientMiddleName) AS Applicant_DonorName, DATE_FORMAT(dtmExamTaken, '%M %d, %Y - %h:%i %p') AS 'Expectation_Date'
		FROM tbldonation d
		JOIN tblclient c ON d.intClientId = c.intClientId
		JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
		WHERE d.intDonationId NOT IN (
				SELECT intDonationId
				FROM tblmedicalexam
				WHERE stfAnswerRemarks = 'Wrong'
				OR stfAnswerRemarks ='Unchecked'
			)
			AND d.intDonationId NOT IN (
				SELECT intDonationId
				FROM tblphysicalexam
			)
		AND stfDonationRemarks = 'Incomplete'
		AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
		GROUP BY 1
	");

	while($row = mysqli_fetch_assoc($fetchUncheckedSurvey)) {
		$res[] = $row;
	}

	echo json_encode($res);
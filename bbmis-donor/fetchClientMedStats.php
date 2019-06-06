<?php
	//for Profile purpose
	$qryMedStatsView = mysqli_query($conn, "
		SELECT decClientWeight
		FROM tblphysicalexam
		WHERE intClientId = $varDbId
	");
	
	while($row = mysqli_fetch_assoc($qryMedStatsView))	{
		$varWeight = $row["decClientWeight"];
	}
?>
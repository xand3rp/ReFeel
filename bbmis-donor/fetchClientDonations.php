<?php
	$qryFetchDonations = mysqli_query($conn, "
		SELECT d.intDonationId, MAX(me.dtmExamTaken) AS 'Exam Taken', ss.dtmDateScreened AS 'Date Screened', bv.intBloodVolume AS 'Amount Bled', ss.strPhlebotomist AS 'Phlebotomist', d.stfDonationStatus, d.stfDonationRemarks
		FROM tbldonation d
		JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
		JOIN tblphysicalexam pe ON me.intDonationId = pe.intDonationId
		JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
		JOIN tblserologicalscreening ss ON ins.intDonationId = ss.intDonationId
		JOIN tblbloodvolume bv ON pe.intBloodVolumeId = bv.intBloodVolumeId
		WHERE d.intDonationId = (
			SELECT d1.intDonationId
			FROM tbldonation d1
			WHERE d1.intClientId = $varDbId
			LIMIT 1
		)
		GROUP BY d.intDonationId
		ORDER BY 1 DESC
	");
	
	$varDonations = mysqli_num_rows($qryFetchDonations);
	
	if(!isset($varDonations))	{
		$varDonations = 0;
	}
	
	// echo $varDonations;
	
	if($varDonations > 0)	{
		while($rowDonations = mysqli_fetch_assoc($qryFetchDonations))	{
			$varDonId = $rowDonations["intDonationId"];
			$varExamTaken = date_format(date_create($rowDonations["Exam Taken"]), "F d, Y");
			
			if(isset($varDateScreened))	{
				$varDateScreened = date_format(date_create($rowDonations["Date Screened"]), "F d, Y");
			}
			else	{
				$varDateScreened = 'Unscreened';
			}
			
			$varBloodVolume = $rowDonations["Amount Bled"];
			$varPhlebotomist = $rowDonations["Phlebotomist"];
			$varStatus = $rowDonations["stfDonationStatus"];
			$varRemarks = $rowDonations["stfDonationRemarks"];
		}
		
		echo "
			<table class='table table-hover text-center'>
				<tr class='bg-danger text-white'>
					<td style='width: 5%' >No.</td>
					<td style='width: 15%'>Exam Taken</td>
					<td style='width: 15%'>Date Screened</td>
					<td style='width: 12%'>Blood Volume</td>
					<td style='width: 23%'>Phlebotomist</td>
					<td style='width: 15%'>Status</td>
					<td style='width: 15%'>Remarks</td>
				</tr>
		";
		
		for($x=0; $x<$varDonations; $x++)	{
			echo "
				<tr id='rowDon1' class='table-bordered'>
					<td>$varDonId</td>
					<td>$varExamTaken</td>
					<td>$varDateScreened</td>
					<td>$varBloodVolume</td>
					<td>$varPhlebotomist</td>
					<td>$varStatus</td>
					<td>$varRemarks</td>
				</tr>
			";
		}
		
		echo "
			</table>
		";
	}
	
	else	{
		echo "
			<span>No donation records. <a href='clientIntSheet.php' class='text-danger'>Donate now!</a></span>
		";
	}
?>
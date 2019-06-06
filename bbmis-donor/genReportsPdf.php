<?php
	include "connection.php";
	// session_start();
	// $varEmpId = $_SESSION["empId"];
	$varEmpId = 1;
	
	require('assets/fpdf/fpdf.php');
	
	$pdf = new FPDF('P', 'in', 'Letter');
	$pdf -> SetMargins(0, 0.5, 0);
	$pdf -> SetFont('Times','',12);
	$pdf -> AddPage();
	
	$pdf -> Image('assets/images/logo-a1.png', 0.35, 0.35, 1.75);
	
	$pdf -> SetFont('Arial', 'B', 20);
	$pdf -> Text(2.25, 0.95, 'Reports');
	
	$pdf -> Line(0.5, 1.65, 8, 1.65);
	
	$qryFetchEmpInfo = mysqli_query($conn, "
		SELECT e.strEmployeeFirstName, e.strEmployeeMiddleName, e.strEmployeeLastName, NOW() AS 'Date Generated'
		FROM tblemployee e
		WHERE intEmployeeId = $varEmpId
	");
	
	while($rowEmpInfo = mysqli_fetch_assoc($qryFetchEmpInfo))	{
		$varFname = $rowEmpInfo["strEmployeeFirstName"];
		$varMname = $rowEmpInfo["strEmployeeMiddleName"];
		$varLname = $rowEmpInfo["strEmployeeLastName"];
		
		if($varMname == '')	{
			$varFullName1 = $varLname . ', ' . $varFname;
		}
		else	{
			$varFullName1 = $varLname . ', ' . $varFname . ' ' . $varMname;
		}
		
		$varDateNow  = $rowEmpInfo["Date Generated"];
		
		$pdf -> SetFont('Arial', '', 12.5);
		$pdf -> Text(0.75, 2, 'Name : ' .  strtoupper($varFullName1));
	}
	
	
	$pdf -> Text(0.75, 2.25, 'Date Generated : ' . date_format(date_create($varDateNow), 'F d, Y'));
	
	$pdf -> Line(0.5, 2.50, 8, 2.50);
	
	$pdf -> Ln(2.25);
	
	//Remaining Blood Bag per Blood Type
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Remaining Blood Bags', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Type', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$reports_remaining = mysqli_query($conn,  " 
		SELECT bt.stfBloodType, COUNT(intBloodBagId) AS 'count_remaining'
		FROM tblbloodtype bt
		JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
		WHERE stfIsBloodBagExpired ='No'
		AND intBloodDispatchmentId = '1'
		GROUP BY 1
	");
	while($rowBbRem = mysqli_fetch_assoc($reports_remaining))	{
		$varBloodTypeRem = $rowBbRem["stfBloodType"];
		$varRemCount = $rowBbRem["count_remaining"];
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBloodTypeRem, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varRemCount, 1, 1, 'C');
	}
	if(!isset($varBloodTypeRem))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No remaining blood bags.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Waster Blood Bag per Blood Type
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Wasted Blood Bags', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Type', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$reports_wastage = mysqli_query($conn, " SELECT stfBloodType, COUNT(intBloodBagId) AS 'count_wastage'
		FROM tblbloodtype bt
		JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
		WHERE stfIsBloodBagExpired ='Yes'
		AND stfTransfusionsuccess = 'No'
		GROUP BY bt.intBloodTypeId, YEAR(dtmDateStored)
	");
	while($rowBbWst = mysqli_fetch_assoc($reports_wastage))	{
		$varBloodTypeWst = $rowBbWst["stfBloodType"];
		$varWstCount = $rowBbWst["count_remaining"];
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBloodTypeWst, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varWstCount, 1, 1, 'C');
	}
	if(!isset($varBloodTypeWst))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No wasted blood bags.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Daily Blood Bag Count
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Daily Blood Bags', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Type', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$daily_count = mysqli_query($conn, "
		SELECT stfBloodType, COUNT(intBloodBagId) AS 'Daily Count'
		FROM tblbloodbag bb
		JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
		WHERE DATE_FORMAT(dtmDateStored, '%Y') = DATE_FORMAT(NOW(), '%Y')
		AND DATE_FORMAT(dtmDateStored, '%m') = DATE_FORMAT(NOW(), '%m')
		AND DATE_FORMAT(dtmDateStored, '%U') = DATE_FORMAT(NOW(), '%U')
		AND DATE_FORMAT(dtmDateStored, '%d') = DATE_FORMAT(NOW(), '%d')
		GROUP BY 1
	");
	while($rowBbDaily = mysqli_fetch_assoc($daily_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varBloodTypeDaily = $rowBbDaily["stfBloodType"];
		$varDailyCount = $rowBbDaily["Daily Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBloodTypeDaily, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varDailyCount, 1, 1, 'C');
	}
	if(!isset($varBloodTypeDaily))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No blood bags.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Weekly Blood Bag Count
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Weekly Blood Bags', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Type', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$weekly_count = mysqli_query($conn, "
		SELECT stfBloodType, COUNT(intBloodBagId) AS 'Weekly Count'
		FROM tblbloodbag bb
		JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
		WHERE DATE_FORMAT(dtmDateStored, '%Y') = DATE_FORMAT(NOW(), '%Y')
		AND DATE_FORMAT(dtmDateStored, '%m') = DATE_FORMAT(NOW(), '%m')
		AND DATE_FORMAT(dtmDateStored, '%U') = DATE_FORMAT(NOW(), '%U')
		GROUP BY 1
	");
	while($rowBbWeekly = mysqli_fetch_assoc($weekly_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varBloodTypeWeekly = $rowBbWeekly["stfBloodType"];
		$varWeeklyCount = $rowBbWeekly["Weekly Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBloodTypeWeekly, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varWeeklyCount, 1, 1, 'C');
	}
	if(!isset($varBloodTypeWeekly))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No blood bags.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
		
	//Monthly Blood Bag Count
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Monthly Blood Bags', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Type', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$monthly_count = mysqli_query($conn, "
		SELECT stfBloodType, COUNT(intBloodBagId) AS 'Monthly Count'
		FROM tblbloodbag bb
		JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
		WHERE DATE_FORMAT(dtmDateStored, '%Y') = DATE_FORMAT(NOW(), '%Y')
		AND DATE_FORMAT(dtmDateStored, '%m') = DATE_FORMAT(NOW(), '%m')
		GROUP BY 1
	");
	while($rowBbMonthly = mysqli_fetch_assoc($monthly_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varBloodTypeMonthly = $rowBbMonthly["stfBloodType"];
		$varMonthlyCount = $rowBbMonthly["Monthly Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBloodTypeMonthly, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varMonthlyCount, 1, 1, 'C');
	}
	if(!isset($varBloodTypeMonthly))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No blood bags.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
		
	//Yearly Blood Bag Count
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Yearly Blood Bags', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Type', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$yearly_count = mysqli_query($conn, "
		SELECT stfBloodType, COUNT(intBloodBagId) AS 'Yearly Count'
		FROM tblbloodbag bb
		JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
		WHERE DATE_FORMAT(dtmDateStored, '%Y') = DATE_FORMAT(NOW(), '%Y')
		GROUP BY 1
	");
	while($rowBbYearly = mysqli_fetch_assoc($yearly_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varBloodTypeYearly = $rowBbYearly["stfBloodType"];
		$varYearlyCount = $rowBbYearly["Yearly Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBloodTypeYearly, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varYearlyCount, 1, 1, 'C');
	}
	if(!isset($varBloodTypeYearly))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No blood bags.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Blood Component Failure Count
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Blood Component Failure Count', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Component', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$bcfail_count = mysqli_query($conn, "
		SELECT bc.strBloodComponent, COUNT(*) AS 'Count'
		FROM tblbloodcomponent bc
		JOIN tblinitialscreening ins ON bc.intBloodComponentId = ins.intBloodComponentId
		WHERE ins.strBloodComponentRemarks = 'Failed'
		GROUP BY 1
	");
	while($rowBcFail = mysqli_fetch_assoc($bcfail_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varBcFail = $rowBcFail["strBloodComponent"];
		$varBcFailCount = $rowBcFail["Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBcFail, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varBcFailCount, 1, 1, 'C');
	}
	if(!isset($varBcFail))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No failed blood components.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Client List - Blood Component Failure
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Client Failed Blood Component List', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Blood Component', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Client Name', 'TRB', 1, 'C');
	
	$bcfail_list = mysqli_query($conn, "
		SELECT strBloodComponent, CONCAT(c.strClientFirstName, ' ', c.strClientLastName) AS 'Client Full Name'
		FROM tblclient c
		JOIN tbldonation d ON c.intClientId = d.intClientId
		JOIN tblinitialscreening ins ON d.intDonationId = ins.intDonationId
		JOIN tblbloodcomponent bc ON ins.intBloodComponentId = bc.intBloodComponentId
		WHERE ins.strBloodComponentRemarks = 'Failed'
		AND DATE_FORMAT(dtmDateScreened, '%Y') = DATE_FORMAT(NOW(), '%Y')
		AND DATE_FORMAT(dtmDateScreened, '%m') = DATE_FORMAT(NOW(), '%m')
		GROUP BY 1
	");
	while($rowBcFailList = mysqli_fetch_assoc($bcfail_list))	{
		$pdf -> SetFont('Times', '', 12);
		$varBcFail2 = $rowBcFailList["strBloodComponent"];
		$varBcFailClient = $rowBcFailList["Client Full Name"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varBcFail2, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varBcFailClient, 1, 1, 'C');
	}
	if(!isset($varBcFail2))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No failed client in blood components.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Disease Failure Count
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Disease Failure Count', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Disease', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$difail_count = mysqli_query($conn, "
		SELECT d.strDisease, COUNT(*) AS 'Count'
		FROM tbldisease d
		JOIN tblserologicalscreening ss ON d.intDiseaseId = ss.intDiseaseId
		WHERE ss.decDiseaseRemarks = 'Failed'
		GROUP BY 1
	");
	while($rowDiFail = mysqli_fetch_assoc($difail_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varDiFail = $rowDiFail["strDisease"];
		$varDiFailCount = $rowDiFail["Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varDiFail, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varDiFailCount, 1, 1, 'C');
	}
	if(!isset($varDiFail))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No failed disease.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Client List - Disease Failure
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Client Failed Disease List', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Disease', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Client Name', 'TRB', 1, 'C');
	
	$difail_list = mysqli_query($conn, "
		SELECT di.strDisease, CONCAT(c.strClientFirstName, ' ', c.strClientLastName) AS 'Client Full Name'
		FROM tblclient c
		JOIN tbldonation do ON c.intClientId = do.intClientId
		JOIN tblserologicalscreening ss ON do.intDonationId = ss.intDonationId
		JOIN tbldisease di ON ss.intDiseaseId = di.intDiseaseId
		WHERE ss.decDiseaseRemarks = 'Failed'
		AND DATE_FORMAT(dtmDateScreened, '%Y') = DATE_FORMAT(NOW(), '%Y')
		AND DATE_FORMAT(dtmDateScreened, '%m') = DATE_FORMAT(NOW(), '%m')
		GROUP BY 1
	");
	while($rowDiFailList = mysqli_fetch_assoc($difail_list))	{
		$pdf -> SetFont('Times', '', 12);
		$varDiFail2 = $rowDiFailList["strBloodComponent"];
		$varDiFailClient = $rowDiFailList["Client Full Name"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varDiFail2, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varDiFailClient, 1, 1, 'C');
	}
	if(!isset($varDiFail2))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No failed client in diseases.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Client Count per Sex
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Client Count per Sex', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Sex', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$clientsex_count = mysqli_query($conn, "
		SELECT stfClientSex, COUNT(*) AS 'Client Count'
		FROM tblclient
		GROUP BY 1
	");
	while($rowCliSexCount = mysqli_fetch_assoc($clientsex_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varSex = $rowCliSexCount["stfClientSex"];
		$varSexCount = $rowCliSexCount["Client Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varSex, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varSexCount, 1, 1, 'C');
	}
	if(!isset($varSex))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No client counted.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	//Client Count per Age
	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> SetTextColor(255, 255, 255);
	$pdf -> SetFillColor(220, 53, 69);
	$pdf -> SetX(0.5);
	$pdf -> Cell(7.5, 0.3, 'Client Count per Sex', 1, 1, 'C', true);
	$pdf -> SetX(0.5);
	$pdf -> SetTextColor(0, 0, 0);
	$pdf -> Cell(3.75, 0.3, 'Age', 1, 0, 'C');
	$pdf -> Cell(3.75, 0.3, 'Count', 'TRB', 1, 'C');
	
	$clientage_count = mysqli_query($conn, "
		SELECT TIMESTAMPDIFF(YEAR, datClientBirthday, NOW()) AS 'Age', COUNT(*) AS 'Count'
		FROM tblclient
		GROUP BY 1
		ORDER BY 1 ASC
	");
	while($rowCliAgeCount = mysqli_fetch_assoc($clientage_count))	{
		$pdf -> SetFont('Times', '', 12);
		$varAge = $rowCliAgeCount["Age"];
		$varAgeCount = $rowCliAgeCount["Count"];
		$pdf -> SetX(0.5);
		$pdf -> Cell(3.75, 0.3, $varAge, 1, 0, 'C');
		$pdf -> Cell(3.75, 0.3, $varAgeCount, 1, 1, 'C');
	}
	if(!isset($varAge))	{
		$pdf -> SetFont('Times', '', 12);
		$pdf -> SetTextColor(0, 0, 0);
		$pdf -> SetX(0.5);
		$pdf -> Cell(7.5, 0.3, 'No client counted.', 1, 1, 'C');
	}
	$pdf -> Ln(0.25);
	
	$pdf -> Cell(8.5, 0.3, '---NOTHING FOLLOWS---', 0, 0, 'C');
	
	$pdf -> Output();
?>
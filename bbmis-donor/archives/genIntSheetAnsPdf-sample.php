<?php
	include "connection.php";
	session_start();
	$varDbId = $_SESSION["sessId"];

	$getClientQry = mysqli_query($conn,"SELECT * FROM tblclient WHERE intClientId = '$varDbId'");
	if(mysqli_num_rows($getClientQry)>0){
		while($row = mysqli_fetch_assoc($getClientQry)){
			$clientid = $row['intClientId'];
		}
	}

	require('assets/fpdf/fpdf.php');

	$pdf = new FPDF('P', 'in', 'Letter');
	$pdf -> SetMargins(0, 0.5, 0);
	$pdf -> SetFont('Times','',12);
	$pdf -> AddPage();

	$pdf -> Image('assets/images/logo-a1.png', 0.35, 0.35, 1.75);

	$pdf -> SetFont('Arial', 'B', 20);
	$pdf -> Text(2.25, 0.95, 'Medical Exam Interview Sheet');

	$qryFetchSheetVer = mysqli_query($conn, "
		SELECT DISTINCT(q.decQuestionVersion)
		FROM tblquestion q
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = (
			SELECT me1.intDonationId
			FROM tbldonation d
			JOIN tblmedicalexam me1 ON d.intDonationId = me1.intDonationId
			WHERE d.intClientId = '$clientid'
			LIMIT 1
		)
	");

	while($rowVer = mysqli_fetch_assoc($qryFetchSheetVer))	{
		$pdf -> SetFont('Times', '', 10);
		$pdf -> Text(2.25, 1.15, 'v[decQuestionVersion]');
	}

	$pdf -> Line(0.5, 1.65, 8, 1.65);

	$qryFetchClientInfo = mysqli_query($conn, "
		SELECT c.strClientFirstName, c.strClientMiddleName, c.strClientLastName, d.intDonationId, me.dtmExamTaken
		FROM tblclient c
		JOIN tbldonation d ON c.intClientId = d.intClientId
		JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
		WHERE c.intClientId = '$clientid'
		ORDER BY 5 DESC
		LIMIT 1
	");

	while($rowClientInfo = mysqli_fetch_assoc($qryFetchClientInfo))	{
		$varFname = $rowClientInfo["strClientFirstName"];
		$varMname = $rowClientInfo["strClientMiddleName"];
		$varLname = $rowClientInfo["strClientLastName"];

		if($varMname == '')	{
			$varFullName1 = $varLname . ', ' . $varFname;
			$varFullName2 = $varFname . ' ' . $varLname;
		}
		else	{
			$varFullName1 = $varLname . ', ' . $varFname . ' ' . $varMname;
			$varFullName2 = $varFname . ' ' . $varMname . ' ' . $varLname;
		}

		$pdf -> SetFont('Arial', '', 12.5);
		$pdf -> Text(0.75, 2, 'Name : [Last Name], [First Name]');
		$varDonationId = $rowClientInfo["intDonationId"];
		$varExamTaken = $rowClientInfo["dtmExamTaken"];
	}

	$varDonCode = '[intDonationId][yyyy][mm][dd]';

	$pdf -> Text(4.25, 2, 'Donation Code : ' . $varDonCode);

	$pdf -> Text(4.25, 2.25, 'Date Taken : [MMM] [dd], [yyyy]');

	$pdf -> Line(0.5, 2.50, 8, 2.50);

	$pdf -> Ln(2.25);

	$qryFetchQueCtg = mysqli_query($conn, "
		SELECT DISTINCT(qc.stfQuestionCategory)
		FROM tblquestioncategory qc
		JOIN tblquestion q ON qc.intQuestionCategoryId = q.intQuestionCategoryId
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = (
			SELECT intDonationId
			FROM tbldonation
			WHERE intClientId = '$clientid'
			ORDER BY 1 DESC
			LIMIT 1
		)
	");

	//Distincted Question Category used.
	$varCountQueCtg = mysqli_num_rows($qryFetchQueCtg);

	//Item counter.
	$varCountItems = 1;

	for($varOffset=0; $varOffset<$varCountQueCtg; $varOffset++)	{
		$qryFetchQueCtgOff = mysqli_query($conn, "
			SELECT DISTINCT(qc.stfQuestionCategory)
			FROM tblquestioncategory qc
			JOIN tblquestion q ON qc.intQuestionCategoryId = q.intQuestionCategoryId
			JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
			WHERE me.intDonationId = (
				SELECT intDonationId
				FROM tbldonation
				WHERE intClientId = '$clientid'
				ORDER BY 1 DESC
			)
			LIMIT 1 OFFSET $varOffset
		");

		//Question Category heading
		while($rowQueCtgOff = mysqli_fetch_assoc($qryFetchQueCtgOff))	{
			$varQueCtgOff = $rowQueCtgOff["stfQuestionCategory"];
			$pdf -> SetFont('Times', 'B', 12);
			$pdf -> SetTextColor(255, 255, 255);
			$pdf -> SetFillColor(220, 53, 69);
			$pdf -> SetX(0.5);
			$pdf -> Cell(7.5, 0.3, $varQueCtgOff, 1, 1, 'C', true);

			$pdf -> SetX(0.5);
			$pdf -> SetFont('Times', 'B', 12);
			$pdf -> SetTextColor(0, 0, 0);
			$pdf -> Cell(0.35, 0.3, 'No.', 'LB', 0, 'C');
			$pdf -> Cell(3.575, 0.3, 'Question', 'RBL', 0, 'C');
			$pdf -> Cell(3.575, 0.3, 'Answer/s', 'RB', 1, 'C');
		}

		$qryFetchItemAns = mysqli_query($conn, "
			SELECT q.txtQuestion, me.stfAnswerYn, me.strAnswerString, me.datAnswerDate, me.intAnswerQuantity
			FROM tblquestion q
			JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
			WHERE me.intDonationId = (
				SELECT me1.intDonationId
				FROM tbldonation d
				JOIN tblmedicalexam me1 ON d.intDonationId = me1.intDonationId
				WHERE d.intClientId = '$clientid'
				LIMIT 1
			)
			AND q.intQuestionCategoryId = (
				SELECT intQuestionCategoryId
				FROM tblquestioncategory
				WHERE stfQuestionCategory = '$varQueCtgOff'
			)
		");

		while($rowItemAns = mysqli_fetch_assoc($qryFetchItemAns))	{
			//Items and Answers - Cell
			// $pdf -> SetX(0.5);
			// $pdf -> SetFont('Arial', '', 11.5);
			// $pdf -> SetTextColor(0, 0, 0);
			// $pdf -> Cell(0.35, 0.3, $varCountItems, 1, 0, 'C');
			// $pdf -> Cell(3.575, 0.3, $rowItemAns["txtQuestion"], 1, 0, 'L');
			// $pdf -> Cell(3.575, 0.3, 'Answer', 1, 1, 'C');

			//Items and Answers - MultiCell
			// $pdf -> SetFont('Arial', '', 11.5);
			// $pdf -> SetTextColor(0, 0, 0);
			// $pdf -> SetX(0.5);
			// $pdf -> MultiCell(0.35, 0.3, $varCountItems, 1, 'C');
			// $pdf -> SetX(0.85);
			// $pdf -> MultiCell(3.575, 0.3, $rowItemAns["txtQuestion"], 1);
			// $pdf -> SetX(4.425);
			// $pdf -> MultiCell(3.575, 0.3, 'Answer', 1, 'C');

			//Hagdan
			// $pdf -> SetFont('Arial', '', 11.5);
			// $pdf -> SetTextColor(0, 0, 0);
			// $pdf -> SetX(0.5);
			// $pdf -> MultiCell(0.35, 0.3, $varCountItems, 1, 'C');
			// $pdf -> SetX(0.85);
			// $pdf -> MultiCell(3.575, 0.3, $rowItemAns["txtQuestion"], 1);
			// $pdf -> SetX(4.425);
			// $pdf -> MultiCell(3.575, 0.3, 'Answer', 1, 'C');

			// Attempt 3
			$varWdNo = 0.35;
			$varWdQA = 3.575;

			$pdf -> SetFont('Times', '', 11.5);
			$pdf -> SetTextColor(0, 0, 0);
			$pdf -> SetX(0.85);
			$pdf -> MultiCell($varWdQA, 0.25, $rowItemAns["txtQuestion"], 'LRB');
			$varGetY = $pdf -> GetY();
			$varGetX = $pdf -> GetX();
			$pdf -> SetXY(0.85 + $varGetX + $varWdQA, $varGetY - 0.25);

			$varAnsYn = $rowItemAns["stfAnswerYn"];
			if($varAnsYn == '')	{
				$varAnsYn = '';
			}
			else	{
				if($varAnsYn == 'Yes')	{
					$varAnsYn = 'Oo';
				}
				else if($varAnsYn == 'No')	{
					$varAnsYn = 'Hindi';
				}
			}

			$varAnsStr = $rowItemAns["strAnswerString"];
			if($varAnsStr == '')	{
				$varAnsStr = '';
			}

			$varAnsDat = $rowItemAns["datAnswerDate"];
			if($varAnsDat == '0000-00-00')	{
				$varAnsDat = '';
			}
			else	{
				$varAnsDat = date_format(date_create($rowItemAns["datAnswerDate"]), 'F d Y');
			}

			$varAnsQua = $rowItemAns["intAnswerQuantity"];
			if($varAnsQua == 0)	{
				$varAnsQua = '';
			}

			$pdf -> Cell($varWdQA, 0.25, $varAnsYn . ' ' . $varAnsStr . ' ' . $varAnsDat . ' ' . $varAnsQua, 'TRB');
			$pdf -> SetXY(0.5, $varGetY - 0.25);
			$pdf -> MultiCell($varWdNo, 0.25, $varCountItems, 'TLB');

			$varCountItems++;
		}

		$pdf -> Ln(0.25);
	}

	$pdf -> SetMargins(0.5, 0.5, 0.5);

	$pdf -> SetFont('Times', 'B', 12);
	$pdf -> Write(0.25, "
	DONOR'S CONSENT (PAHINTULOT)
	");

	$pdf -> Ln(0.05);

	$pdf -> SetFont('Times', '', 12);
	$pdf -> Write(0.25, "
	     Nagpapatunay na ako ang taong tinutukoy at ang lahat ng nakasulat dito ay nabasa ko at naiintindihan at ako ay kusang-loob na magbigay ng dugo. Alam ko ang mga panganib at kahihihatnan sa panahong pagkuha ng dugo sa akin at pagkatapos ng donasyon. Ito ay ipinaliwanag sa akin at naintindihan ko ng mabuti.

	     Pagkatapos masagutan ng buong katapatan ang mga tanong, ako ay kusa at buong-loob na magbibigay ng dugo sa Blood Bank ng Our Lady of Lourdes Hospital. Naiintindihan ko na ang aking dugo ay susuriin ng mabuti upang malaman ang blood type, hematocrit, hemoglobin, malaria, syphilis, Hepatitis B & C, at HIV.
	");

	$pdf -> Ln(1);
	$pdf -> SetFont('Times', '', 13);
	$pdf -> SetX(4.5);
	$pdf -> Cell(3, 0.3, '[First Name] [Last Name]', 'B', 1, 'C');
	$pdf -> SetFont('Times', '', 11.5);
	$pdf -> SetX(4.5);
	$pdf -> Cell(3, 0.3, 'Signature over Printed Name', 0, 0, 'C');

	// $pdf -> Output('D', 'ReFeel-MedEx-' . $varDonCode. '.pdf');
	$pdf -> Output();
?>

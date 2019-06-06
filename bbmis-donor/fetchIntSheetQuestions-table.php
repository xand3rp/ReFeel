<?php
	include("connection.php");
	
	//Fetch the answered survey version.
	$qryVersionUsed = mysqli_query($conn, "
		SELECT DISTINCT(q.decQuestionVersion)
		FROM tblquestion q
		JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
		WHERE me.intDonationId = (
			SELECT d.intDonationId
			FROM tbldonation d 
			WHERE d.intClientId = $varDbId
			AND d.stfDonationRemarks = 'Incomplete'
		)
	");
	$rowVersionUsed = mysqli_fetch_assoc($qryVersionUsed);
	$varVersionUsed = $rowVersionUsed["decQuestionVersion"];
	
	//Fetch the current in-use survey version.
	$qryVersionInUse = mysqli_query($conn, "
		SELECT DISTINCT(q.decQuestionVersion)
		FROM tblquestion q
		WHERE q.boolVersionInUse = '1'
	");
	$rowVersionInUse = mysqli_fetch_assoc($qryVersionInUse);
	$varVersionInUse = $rowVersionInUse["decQuestionVersion"];
	
	//Sets the version.
	if(isset($varVersionUsed))	{
		$varVersionToUse = $varVersionUsed;
	}
	else	{
		$varVersionToUse = $varVersionInUse;
	}
	
	$varQueCount = 1;

	$qryDistQueCtg = mysqli_query($conn, "
		SELECT DISTINCT(qc.stfQuestionCategory)
		FROM tblquestion q
		JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
		WHERE q.decQuestionVersion = $varVersionToUse
	");
	
	$varCountQueCtg = mysqli_num_rows($qryDistQueCtg);
	
	$qryCliSex = mysqli_query($conn, "SELECT stfClientSex FROM tblclient WHERE intClientId = $varDbId");
	$rowCliSex = mysqli_fetch_assoc($qryCliSex);
	$varSex = $rowCliSex["stfClientSex"];

	function typeYn($varQueId)	{
		echo "
				<div class='row'>
					<div class='btn-group-toggle text-center w-100' data-toggle='buttons'>
						<label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-4 mr-sm-2' value='Yes'>
							<input type='radio' name='txtYn$varQueId' value='Yes' autocomplete='off' required='required' />Oo
						</label>
						<label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-4' value='No'>
							<input type='radio' name='txtYn$varQueId' value='No' autocomplete='off' required='required' />Hindi
						</label>
					</div>
				</div>
		";
	}

	function typeDate($varQueId)	{
		echo "
				<div class='row mt-3'>
					<div class='form-group col-4'>
						<select class='form-control' name='optDm$varQueId' placeholder='Month'>
						<option value='00'>Month</option>';
						";

								for($m=1; $m<=12; $m++) {
									$month = date("F", mktime(0,0,0,$m, 1, date("Y")));
									echo "<option value='$m'>$month</option>'";
								}

		echo "
						</select>
					</div>
					<div class='form-group col-4'>
						<select class='form-control' name='optDd$varQueId'>
							<option value='00'>Day</option>
							";
						for($d=1; $d<=31; $d++)	{
							echo "
								<option value='$d'>$d</option>
							";
						}

		echo "
						</select>
					</div>
					<div class='form-group col-4'>
						<select class='form-control' name='optDy$varQueId'>
						<option value='0000'>Year</option>;
						";
								$curYear = date("Y");
								for($y=0; $y<=($curYear-($curYear-60)); $y++)	{
									$z = $curYear-$y;
									echo "<option value='$z'>$z</option>";
								}
		echo "
						</select>
					</div>
				</div>
		";
	}

	function typeQua($varQueId)	{
		echo "
				<div class='row'>
					<div class='form-group m-auto  mt-3>
						<input type='number' min='0' class='form-control' name='intQua$varQueId' value=0 />
					</div>
				</div>
		";
	}

	function typeStr($varQueId)	{
		echo "
				<div class='row'>
					<div class='form-group m-auto  mt-3'>
						<input type='text' class='form-control' name='txtStr$varQueId'/>
					</div>
				</div>
		";
	}
	
	for($x=0; $x<$varCountQueCtg; $x++)	{
		$qryQueCtg = mysqli_query($conn, "
			SELECT DISTINCT(qc.stfQuestionCategory)
			FROM tblquestion q
			JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
			WHERE decQuestionVersion = $varVersionToUse
			LIMIT 1 OFFSET $x
		");
		
		while($rowCtg = mysqli_fetch_assoc($qryQueCtg))	{
			$varQueCtg = $rowCtg["stfQuestionCategory"];

			if($varSex == 'Male')	{
				if($varQueCtg == 'Female-exclusive')	{
					//break;
					continue;
				}
			}

			echo "
				<table class='table table-bordered table-hover'>
					<tr>
						<td class='bg-danger text-white text-center' colspan='3'>
							$varQueCtg
						</td>
					</tr>
			";
			
			$qryQue = mysqli_query($conn, "
				SELECT q.intQuestionId, q.txtQuestion, q.stfQuestionType
				FROM tblquestion q
				JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
				WHERE qc.stfQuestionCategory = '$varQueCtg'
				AND decQuestionVersion = $varVersionToUse
			");

			while($rowQue = mysqli_fetch_assoc($qryQue))	{
				$varQueId = $rowQue["intQuestionId"];
				$varQue = $rowQue["txtQuestion"];
				$varQueType = $rowQue["stfQuestionType"];

				echo "
					<tr>
						<td class='align-middle text-center' style='width: 10%;'>
							$varQueCount.
						</td>
						<td class='align-middle' style='width: 40%;'>
							$varQue
						</td>
						<td class='align-middle' style='width: 50%;'>
				";

				$varQueCount++;

				if($varQueType == "Yn")	{typeYn($varQueId);}
				else if($varQueType == "YnDate")	{typeYn($varQueId); typeDate($varQueId); }
				else if($varQueType == "YnQua")	{typeYn($varQueId); typeQua($varQueId); }
				else if($varQueType == "YnStr")	{typeYn($varQueId); typeStr($varQueId); }
				else if($varQueType == "YnDateQua")	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); }
				else if($varQueType == "YnDateStr")	{typeYn($varQueId); typeDate($varQueId); typeStr($varQueId); }
				else if($varQueType == "YnQuaStr")	{typeYn($varQueId); typeQua($varQueId); typeStr($varQueId); }
				else if($varQueType == "YnDateQuaStr")	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
				else if($varQueType == "Date")	{typeDate($varQueId); }
				else if($varQueType == "DateQua")	{typeDate($varQueId); typeQua($varQueId); }
				else if($varQueType == "DateStr")	{typeDate($varQueId); typeStr($varQueId); }
				else if($varQueType == "DateQuaStr")	{typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
				else if($varQueType == "Qua")	{typeQua($varQueId); }
				else if($varQueType == "QuaStr")	{typeQua($varQueId); typeStr($varQueId); }
				else if($varQueType == "Str")	{typeStr($varQueId); }
				echo "
						</td>
					</tr>
				";
			}
			echo "
				</table>
			";
		}
	}
?>
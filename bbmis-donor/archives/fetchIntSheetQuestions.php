<?php
	include("connection.php");

	$varQueCount = 1;

	$qryDistQueCtg = mysqli_query($conn, "
	SELECT DISTINCT(qc.stfQuestionCategory)
	FROM tblquestion q
	JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
	");
	$qryCountQueCtg = mysqli_num_rows($qryDistQueCtg);

	$qryCliSex = mysqli_query($conn, "SELECT stfClientSex FROM tblclient WHERE intClientId = $varDbId");
	while($rowCliSex = mysqli_fetch_assoc($qryCliSex))	{
		$varSex = $rowCliSex["stfClientSex"];
	}

	function typeYn($varQueId)	{
		echo "
				<div class='btn-group-toggle text-center w-100' data-toggle='buttons'>
					<label class='btn btn-outline-danger form-control col-5 mt-sm-4 mr-sm-4'>
						<input type='radio' name='txtYn$varQueId' id='btnYn$varQueId' value='Yes' autocomplete='off' required='required'>Oo
					</label>
					<label class='btn btn-outline-danger form-control col-5 mt-sm-4'>
						<input type='radio' name='txtYn$varQueId' id='btnYn$varQueId' value='No' autocomplete='off' required='required'>Hindi
					</label>
				</div>
		";
	}

	function typeDate($varQueId)	{
		echo "
				<div class='row'>
					<div class='form-group m-auto col-4 mt-sm-4'>
						<select class='form-control' name='txtBm$varQueId' placeholder='Month'>
						<option value='00'>Month</option>';
						";

								for($m=1; $m<=12; $m++) {
									$month = date("F", mktime(0,0,0,$m, 1, date("Y")));
									echo "<option value='$m'>$month</option>'";
								}

		echo "
						</select>
					</div>
					<div class='form-group m-auto col-4 mt-sm-4'>
						<select class='form-control' name='txtBd$varQueId'>
							<option value='00'>Day</option>
							<option value=1>1</option>
							<option value=2>2</option>
							<option value=3>3</option>
							<option value=4>4</option>
							<option value=5>5</option>
							<option value=6>6</option>
							<option value=7>7</option>
							<option value=8>8</option>
							<option value=9>9</option>
							<option value=10>10</option>
							<option value=11>11</option>
							<option value=12>12</option>
							<option value=13>13</option>
							<option value=14>14</option>
							<option value=15>15</option>
							<option value=16>16</option>
							<option value=17>17</option>
							<option value=18>18</option>
							<option value=19>19</option>
							<option value=20>20</option>
							<option value=21>21</option>
							<option value=22>22</option>
							<option value=23>23</option>
							<option value=24>24</option>
							<option value=25>25</option>
							<option value=26>26</option>
							<option value=27>27</option>
							<option value=28>28</option>
							<option value=29>29</option>
							<option value=30>30</option>
							<option value=31>31</option>
						</select>
					</div>
					<div class='form-group col-4'>
						<select class='form-control m-auto mt-sm-4' name='txtBy$varQueId'>
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
				<div class='form-group m-auto col-8 mt-sm-4'>
					<input type='number' min='0' class='form-control' name='intQua$varQueId' value=0 />
				</div>
		";
	}

	function typeStr($varQueId)	{
		echo "
				<div class='row'>
					<div class='form-group m-auto col-8 mt-sm-2'>
						<input type='text' class='form-control' name='txtStr$varQueId'/>
					</div>
				</div>
		";
	}

	for($x=0; $x<$qryCountQueCtg; $x++)	{
		$qryQueCtg = mysqli_query($conn, "
		SELECT DISTINCT(qc.stfQuestionCategory)
		FROM tblquestion q
		JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
		WHERE decQuestionVersion = (
			SELECT DISTINCT(q1.decQuestionVersion)
			FROM tblquestion q1
			WHERE boolVersionInUse = '1')
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
				<div class='card-deck m-auto pt-4 text-center'>
					<div class='card'>
						<div class='card-header bg-danger text-white'>
							$varQueCtg
						</div>
			";
			
			$qryQue = mysqli_query($conn, "
				SELECT q.intQuestionId, q.txtQuestion, q.stfQuestionType
				FROM tblquestion q
				JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
				WHERE qc.stfQuestionCategory = '$varQueCtg'
				AND decQuestionVersion = (
					SELECT DISTINCT(q1.decQuestionVersion)
					FROM tblquestion q1
					WHERE boolVersionInUse = '1')
			");

			while($rowQue = mysqli_fetch_assoc($qryQue))	{
				$varQueId = $rowQue["intQuestionId"];
				$varQue = $rowQue["txtQuestion"];
				$varQueType = $rowQue["stfQuestionType"];

				echo "
							<div class='card-body'>
								<div class='card p-4 m-auto'>
									$varQueCount. $varQue
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
								</div>
							</div>
				";
			}
			echo "
						</div>
					</div>
			";
		}
	}
?>
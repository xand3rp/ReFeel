<?php
	include("../connections.php");
	$requestData = $_REQUEST;

	if ($requestData['type'] == 'activeSurveyCategory') {
		$columns = array(
			'stfQuestionCategory'
		);

		$query = "
			SELECT intQuestionCategoryId, stfQuestionCategory, boolIsEditable
			FROM tblquestioncategory
		";

	// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfQuestionCategoryStatus = 'Active'
				AND (stfQuestionCategory LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= ' ORDER BY stfQuestionCategory ASC ';
		}

		$query1 = '';
		if($_POST["length"] != -1)	{
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$filter_row = mysqli_query($connections, $query);
		$number_filter_row = mysqli_num_rows($filter_row);

		$result = mysqli_query($connections, $query . $query1);

		$data = array();

		while($row = mysqli_fetch_array($result)) {  // preparing an array
			$sub_array = array();

			// $sub_array[] = '<div class="update" data-id="'.$row["intBloodComponentId"].'" 	data-column="intBloodComponentId">' . $row["intBloodComponentId"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intQuestionCategoryId"].'"	data-column="stfQuestionCategory">' . $row["stfQuestionCategory"] . '</div>';

			$iseditable = $row['boolIsEditable'];

			if($iseditable == '0'){
				$sub_array[] =	'
					<button type="button" name="edit" class="btn btn-sm btn-outline-primary mr-2" id="'.$row["intQuestionCategoryId"].'" data-toggle="modal" data-target="#editSurveyCategoryModal" data-id="'.$row["intQuestionCategoryId"].'" disabled>
						<i class="fa fa-sm fa-edit mr-1"></i>
						Edit
					</button>
					<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intQuestionCategoryId"].'" data-toggle="modal"
					data-target="#viewSurveyCategoryModal" data-id="'.$row["intQuestionCategoryId"].'">
						<i class="fa fa-sm fa-eye mr-1"></i>
						View
					</button>
				';

				//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

				$data[] = $sub_array;
			}
			else if($iseditable == '1')	{
				$sub_array[] =	'
					<button type="button" name="edit" class="btn btn-sm btn-outline-primary mr-2" id="'.$row["intQuestionCategoryId"].'" data-toggle="modal" data-target="#editSurveyCategoryModal" data-id="'.$row["intQuestionCategoryId"].'">
						<i class="fa fa-sm fa-edit mr-1"></i>
						Edit
					</button>
					<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intQuestionCategoryId"].'" data-toggle="modal"
					data-target="#viewSurveyCategoryModal" data-id="'.$row["intQuestionCategoryId"].'">
						<i class="fa fa-sm fa-eye mr-1"></i>
						View
					</button>
				';
				$data[] = $sub_array;
			}
		}

		function get_all_data($connections)	{
			$query = "
				SELECT intQuestionCategoryId, stfQuestionCategory
				FROM tblquestioncategory
				WHERE stfQuestionCategoryStatus = 'Active'
			";
			$result = mysqli_query($connections, $query);
			return mysqli_num_rows($result);
		}

		$output = array(
			//"draw"    => intval($_POST["draw"]),
			"recordsTotal"  =>  get_all_data($connections),
			"recordsFiltered" => $number_filter_row,
			"data"    => $data
		);

		echo json_encode($output);  // send data as json format
	}
	
	else if ($requestData['type'] == 'inactiveSurveyCategory') {
		$columns = array(
			'stfQuestionCategory'
		);

		$query = "
			SELECT intQuestionCategoryId, stfQuestionCategory
			FROM tblquestioncategory
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfQuestionCategoryStatus = 'Inactive'
				AND (stfQuestionCategory LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= ' ORDER BY stfQuestionCategory ASC ';
		}

		$query1 = '';
		if($_POST["length"] != -1)	{
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$filter_row = mysqli_query($connections, $query);
		$number_filter_row = mysqli_num_rows($filter_row);

		$result = mysqli_query($connections, $query . $query1);

		$data = array();

		while($row = mysqli_fetch_array($result)) {  // preparing an array
			$sub_array = array();

			// $sub_array[] = '<div class="update" data-id="'.$row["intBloodComponentId"].'" 	data-column="intBloodComponentId">' . $row["intBloodComponentId"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intQuestionCategoryId"].'"	data-column="stfQuestionCategory">' . $row["stfQuestionCategory"] . '</div>';

			$sub_array[] = '
				<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intQuestionCategoryId"].'" data-toggle="modal" 	data-target="#viewSurveyCategoryModal_enable" data-id="'.$row["intQuestionCategoryId"].'">
					<i class="fa fa-sm fa-eye mr-1"></i>
					View
				</button>
			';

			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT intQuestionCategoryId, stfQuestionCategory
				FROM tblquestioncategory
				WHERE stfQuestionCategoryStatus = 'Inactive'
			";
			$result = mysqli_query($connections, $query);
			return mysqli_num_rows($result);
		}

		$output = array(
			//"draw"    => intval($_POST["draw"]),
			"recordsTotal"  =>  get_all_data($connections),
			"recordsFiltered" => $number_filter_row,
			"data"    => $data
		);

		echo json_encode($output);  // send data as json format
	}
?>
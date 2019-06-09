<?php
	include("../connections.php");
	$requestData = $_REQUEST;

	if($requestData['type'] == 'activePreservatives')	{
		$columns = array(
			'txtPreservative',
			'intPreservativeLifespan',
			'intPreservativeFreshPercentage',
			'intPreservativeNeutralPercentage',
			'intPreservativeCriticalPercentage'
		);

		$query = "
			SELECT intPreservativeId, txtPreservative, intPreservativeLifespan, intPreservativeFreshPercentage, intPreservativeNeutralPercentage, intPreservativeCriticalPercentage
			FROM tblpreservatives
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']))	{   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfPreservativeStatus = 'Active'
				AND (txtPreservative LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
		';
		}
		else	{
			$query .= ' ORDER BY txtPreservative ASC ';
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

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="txtPreservative">' . $row["txtPreservative"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeLifespan">' . $row["intPreservativeLifespan"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeFreshPercentage">' . $row["intPreservativeFreshPercentage"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeNeutralPercentage">' . $row["intPreservativeNeutralPercentage"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeCriticalPercentage">' . $row["intPreservativeCriticalPercentage"] . '</div>';

			$sub_array[] =	'
				<button type="button" name="edit" class="btn btn-outline-success btn-sm mr-1" id="'.$row["intPreservativeId"].'" data-toggle="modal" data-target="#editpreservativeModal" data-id="'.$row["intPreservativeId"].'"     data-prename = "'.$row["txtPreservative"].'" data-span = "'.$row["intPreservativeLifespan"].'" data-fresh ="'.$row["intPreservativeFreshPercentage"].'" data-neutral = "'.$row["intPreservativeNeutralPercentage"].'" data-critical ="'.$row["intPreservativeCriticalPercentage"].'">
					<i class="fa fa-edit fa-sm mr-1"></i>
					Edit
				</button>
				<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intPreservativeId"].'" data-toggle="modal"
				data-target="#viewpreservativeModal" data-id="'.$row["intPreservativeId"].'" data-prename = "'.$row["txtPreservative"].'" data-span = "'.$row["intPreservativeLifespan"].'" data-fresh ="'.$row["intPreservativeFreshPercentage"].'" data-neutral = "'.$row["intPreservativeNeutralPercentage"].'" data-critical ="'.$row["intPreservativeCriticalPercentage"].'">
					<i class="fa fa-eye fa-sm mr-1"></i>
					View
				</button>
			';

			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "SELECT intPreservativeId, txtPreservative, intPreservativeLifespan, intPreservativeFreshPercentage, intPreservativeNeutralPercentage, intPreservativeCriticalPercentage
			FROM tblpreservatives WHERE stfPreservativeStatus = 'Active' ";
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
	
	else if ($requestData['type'] == 'inactivePreservatives') {
		$columns = array(
			'txtPreservative',
			'intPreservativeLifespan',
			'intPreservativeFreshPercentage','intPreservativeNeutralPercentage',
			'intPreservativeCriticalPercentage'
		);

		$query = "
			SELECT intPreservativeId, txtPreservative, intPreservativeLifespan, intPreservativeFreshPercentage, intPreservativeNeutralPercentage, intPreservativeCriticalPercentage
			FROM tblpreservatives
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfPreservativeStatus = 'Inactive'
				AND (txtPreservative LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= ' ORDER BY txtPreservative ASC ';
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

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="txtPreservative">' . $row["txtPreservative"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeLifespan">' . $row["intPreservativeLifespan"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeFreshPercentage">' . $row["intPreservativeFreshPercentage"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeNeutralPercentage">' . $row["intPreservativeNeutralPercentage"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intPreservativeId"].'" 	data-column="intPreservativeCriticalPercentage">' . $row["intPreservativeCriticalPercentage"] . '</div>';

			$sub_array[] =	'
				<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intPreservativeId"].'" data-toggle="modal"
				data-target="#viewpreservativeModal_enable" data-id="'.$row["intPreservativeId"].'" data-prename = "'.$row["txtPreservative"].'" data-span = "'.$row["intPreservativeLifespan"].'" data-fresh ="'.$row["intPreservativeFreshPercentage"].'" data-neutral = "'.$row["intPreservativeNeutralPercentage"].'" data-critical ="'.$row["intPreservativeCriticalPercentage"].'">
					<i class="fa fa-eye fa-sm mr-1"></i>
					View
				</button>
			';

			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT intPreservativeId, txtPreservative, intPreservativeLifespan, intPreservativeFreshPercentage, intPreservativeNeutralPercentage, intPreservativeCriticalPercentage
				FROM tblpreservatives
				WHERE stfPreservativeStatus = 'Inactive'
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
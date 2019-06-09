<?php
	include("../connections.php");
	$requestData = $_REQUEST;

	if($requestData['type'] == 'activeBloodType') {
		$columns = array(
			'stfBloodType',
			'stfBloodTypeRhesus'
		);

		$query = "
			SELECT intBloodTypeId, stfBloodType, stfBloodTypeRhesus
			FROM tblbloodtype
		";

	// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfBloodTypeStatus = 'Active'
				AND intBloodTypeId <> 1
				AND (stfBloodType LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= 'ORDER BY stfBloodType ASC';
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

		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intBloodTypeId"].'" 	data-column="stfBloodType">' . $row["stfBloodType"] . '</div>';

		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intBloodTypeId"].'" 	data-column="stfBloodTypeRhesus">' . $row["stfBloodTypeRhesus"] . '</div>';

		$sub_array[] =	'
			<button type="button" name="edit" class="btn btn-outline-success btn-sm mr-1" id="'.$row["intBloodTypeId"].'" data-toggle="modal" data-target="#editBloodTypeModal" data-id="'.$row["intBloodTypeId"].'">
				<i class="fa fa-edit fa-sm mr-1"></i>
				Edit
			</button>
			<button type="button" name="view" class="btn btn-outline-secondary btn-sm" id="'.$row["intBloodTypeId"].'" data-toggle="modal" data-target="#viewBloodTypeModal" data-id="'.$row["intBloodTypeId"].'">
				<i class="fa fa-eye fa-sm mr-1"></i>
				View
			</button>
		';

		//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

		$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT intBloodTypeId, stfBloodType, stfBloodTypeRhesus
				FROM tblbloodtype
				WHERE stfBloodTypeStatus = 'Active'
				AND intBloodTypeId <> 1
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
	
	else if ($requestData['type'] == 'inactiveBloodType') {
		$columns = array(
			'stfBloodType',
			'stfBloodTypeRhesus'
		);

		$query = "
			SELECT intBloodTypeId, stfBloodType, stfBloodTypeRhesus
			FROM tblbloodtype
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfBloodTypeStatus = 'Inactive'
				AND intBloodTypeId <> 1
				AND (stfBloodType LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= ' ORDER BY stfBloodType ASC ';
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

		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intBloodTypeId"].'" 	data-column="stfBloodType">' . $row["stfBloodType"] . '</div>';
		
		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intBloodTypeId"].'" 	data-column="stfBloodTypeRhesus">' . $row["stfBloodTypeRhesus"] . '</div>';

		$sub_array[] =	'
			<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intBloodTypeId"].'" data-toggle="modal" data-target="#viewBloodTypeModal_enable" data-id="'.$row["intBloodTypeId"].'">
				<i class="fa fa-eye fa-sm mr-1"></i>
				View
			</button>
		';

		//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

		$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT intBloodTypeId, stfBloodType, stfBloodTypeRhesus
				FROM tblbloodtype
				WHERE stfBloodTypeStatus = 'Inactive'
				AND intBloodTypeId <> 1
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
	
	else if ($requestData['type'] == 'activeBloodComponent') {
		$columns = array(
			'strBloodComponent'
		);

		$query = "
			SELECT intBloodComponentId, strBloodComponent
			FROM tblbloodcomponent
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfBloodComponentStatus = 'Active'
				AND (strBloodComponent LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].'
			';
		}
		else	{
			$query .= ' ORDER BY strBloodComponent ASC ';
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

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intBloodComponentId"].'" 	data-column="strBloodComponent">' . $row["strBloodComponent"] . '</div>';

			$sub_array[] =	'
				<button type="button" name="edit" class="btn btn-outline-success btn-sm mr-1" id="'.$row["intBloodComponentId"].'" data-toggle="modal" data-target="#editBloodComponentModal" data-id="'.$row["intBloodComponentId"].'">
					<i class="fa fa-edit fa-sm mr-1"></i>
					Edit
				</button>
				<button type="button" name="view" class="btn btn-outline-secondary btn-sm mr-2" id="'.$row["intBloodComponentId"].'" data-toggle="modal"
				data-target="#viewBloodComponentModal" data-id="'.$row["intBloodComponentId"].'">
					<i class="fa fa-eye fa-sm mr-1"></i>
					View
				</button>
			';

			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
		$query = "
			SELECT intBloodComponentId, strBloodComponent
			FROM tblbloodcomponent
			WHERE stfBloodComponentStatus = 'Active'
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
	
	else if ($requestData['type'] == 'inactiveBloodComponent') {
		$columns = array(
			'strBloodComponent'
		);

		$query = "SELECT intBloodComponentId, strBloodComponent
		FROM tblbloodcomponent  ";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfBloodComponentStatus = 'Inactive' 
				AND (strBloodComponent LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= 'ORDER BY intBloodComponentId ASC ';
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

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intBloodComponentId"].'" 	data-column="strBloodComponent">' . $row["strBloodComponent"] . '</div>';

			$sub_array[] = '
				<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intBloodComponentId"].'" data-toggle="modal" data-target="#viewBloodComponentModal_enable" data-id="'.$row["intBloodComponentId"].'">
					<i class="fa fa-eye fa-sm mr-1"></i>
					View
				</button>
			';

			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT intBloodComponentId, strBloodComponent
				FROM tblbloodcomponent
				WHERE stfBloodComponentStatus = 'Inactive'
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
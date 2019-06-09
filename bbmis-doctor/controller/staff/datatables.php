<?php
	include("../connections.php");
	$requestData = $_REQUEST;
	$columns = array(
		'strEmployeeLastName',
		'stfEmployeeType',
		'stfEmployeeStatus'
	);

	$query = "
		SELECT intEmployeeId, strEmployeeFirstName, strEmployeeMiddleName, strEmployeeLastName, stfEmployeeStatus, stfEmployeeType, strUserName, strUserPassword
		FROM tblemployee e
		JOIN tbluser u ON e.intUserId = u.intUserId
	";

	// datatable column index  => database column name

	if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
	$query .= "
		WHERE (
			strEmployeeFirstName LIKE '%".$requestData['search']['value']."%'
			OR strEmployeeMiddleName LIKE '%".$requestData['search']['value']."%'
			OR strEmployeeLastName LIKE '%".$requestData['search']['value']."%'
		)
	";
	}

	if(isset($_POST["order"]))	{
		$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
		';
	}
	else	{
		$query .= ' ORDER BY strEmployeeFirstName ASC ';
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

	$sub_array[] = '<div class="update pt-1" data-id="'.$row["intEmployeeId"].'" 	data-column="strEmployeeLastName">' . $row["strEmployeeLastName"] . ', ' . $row["strEmployeeFirstName"] . ' ' . $row["strEmployeeMiddleName"] . '</div>';

	$sub_array[] = '<div class="update pt-1" data-id="'.$row["intEmployeeId"].'" 	data-column="stfEmployeeType">' . $row["stfEmployeeType"] . '</div>';

	$sub_array[] = '<div class="update pt-1" data-id="'.$row["intEmployeeId"].'" 	data-column="stfEmployeeStatus">' . $row["stfEmployeeStatus"] . '</div>';

	$sub_array[] = '
		<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editstaffinfo" data-id="'.$row["intEmployeeId"].'" data-fname = "'.$row["strEmployeeFirstName"].'"
		data-mname="'.$row["strEmployeeMiddleName"].'" data-lname="'.$row["strEmployeeLastName"].'" data-status="'.$row["stfEmployeeStatus"] .'"data-type="'.$row["stfEmployeeType"].'"data-uname="'.$row["strUserName"].'"data-pass="'.$row["strUserPassword"].'" style="padding: .2rem .75rem;">
			<i class="fa fa-sm fa-edit mr-1"></i>
			Edit
		</button>
	'; //<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

	$data[] = $sub_array;
	}

	function get_all_data($connections)	{
		$query = "
			SELECT strEmployeeFirstName, strEmployeeMiddleName, strEmployeeLastName
			FROM tblemployee e
			JOIN tbluser u ON e.intUserId = u.intUserId
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
?>
<?php
	include("../connections.php");
	$requestData = $_REQUEST;

	if ($requestData['type'] == 'activeStorage') {
		$columns = array(
		'strStorageName',
		'strStorageType',
		'intStorageCapacity'
		);

		$query = "
			SELECT ts.intStorageId, tst.strStorageType, ts.strStorageName, ts.intStorageCapacity
			FROM tblstorage ts
			JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfStorageStatus = 'Active'
				AND (strStorageName LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= ' ORDER BY strStorageName ASC ';
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

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intStorageId"].'" 	data-column="strStorageName">' . $row["strStorageName"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intStorageId"].'" 	data-column="strStorageType">' . $row["strStorageType"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intStorageId"].'" 	data-column="intStorageCapacity">' . $row["intStorageCapacity"] . '</div>';

			$sub_array[] = '
				<button type="button" name="edit" class="btn btn-sm btn-outline-primary mr-1" id="'.$row["intStorageId"].'" data-toggle="modal" data-target="#editBloodStorageModal" data-id="'.$row["intStorageId"].'">
					<i class="fa fa-sm fa-edit mr-1"></i>
					Edit
				</button>
				<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intStorageId"].'" data-toggle="modal"
				data-target="#viewBloodStorageModal" data-id="'.$row["intStorageId"].'">
					<i class="fa fa-sm fa-eye mr-1"></i> 
					View
				</button>
			';

			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT ts.intStorageId, tst.strStorageType, ts.strStorageName, ts.intStorageCapacity
				FROM tblstorage ts
				JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
				WHERE stfStorageStatus = 'Active'
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
	
	else if ($requestData['type'] == 'inactiveStorage') {
		$columns = array(
			'strStorageName',
			'strStorageType',
			'intStorageCapacity'
		);

		$query = "
			SELECT ts.intStorageId, tst.strStorageType, ts.strStorageName, ts.intStorageCapacity
			FROM tblstorage ts
			JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfStorageStatus = 'Inactive'
				AND (strStorageName LIKE '%".$requestData['search']['value']."%')
			";
		}

		if(isset($_POST["order"]))	{
			$query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= ' ORDER BY strStorageName ASC ';
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

		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intStorageId"].'" 	data-column="strStorageName">' . $row["strStorageName"] . '</div>';

		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intStorageId"].'" 	data-column="strStorageType">' . $row["strStorageType"] . '</div>';

		$sub_array[] = '<div class="update pt-1" data-id="'.$row["intStorageId"].'" 	data-column="intStorageCapacity">' . $row["intStorageCapacity"] . '</div>';

		$sub_array[] = '
			<button type="button" name="view" class="btn btn-sm btn-outline-secondary" id="'.$row["intStorageId"].'" data-toggle="modal"
			data-target="#viewBloodStorageModal_enable" data-id="'.$row["intStorageId"].'">
				<i class="fa fa-sm fa-eye mr-1 "></i>
				View
			</button>
		';

		//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

		$data[] = $sub_array;
		}


		function get_all_data($connections)
		{
		$query = " SELECT ts.intStorageId, tst.strStorageType, ts.strStorageName, ts.intStorageCapacity
		FROM tblstorage ts JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId WHERE stfStorageStatus = 'Inactive' ";
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
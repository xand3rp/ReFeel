<?php
	include("../connections.php");
	$requestData = $_REQUEST;

	if ($requestData['type'] == 'fetchDonor') {
		$columns = array(
			// 'strClientFirstName',
			// 'strClientMiddleName',
			// 'strClientLastName'
			'strClientLastName',
			'stfClientType',
			// 'strClientMiddleName'
		);
		
		$query = "
			SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, strClientOccupation, strClientContact, intBloodTypeId, stfClientCivilStatus, stfClientSex, stfClientType, TIMESTAMPDIFF(year,datClientBirthday,NOW()) AS age, strUserImageDir
			FROM tblclient
			JOIN tbluser ON tblclient.intUserId = tbluser.intUserId
		";
		
		// datatable column index  => database column name
		
		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfClientCandonate = 'Yes'
				AND	(
					strClientFirstName LIKE '%".$requestData['search']['value']."%'
					OR strClientMiddleName LIKE '%".$requestData['search']['value']."%'
					OR strClientLastName LIKE '%".$requestData['search']['value']."%'
				)
			";
		}
		
		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= "
				ORDER BY 4 ASC
			";
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
			$bloodid = $row["intBloodTypeId"];
			
			$fetch_bloodtype = mysqli_query($connections, "
				SELECT *
				FROM tblbloodtype
				WHERE intBloodTypeId = '$bloodid'
			");
			
			// if(mysqli_num_rows($fetch_bloodtype) > 0 )	{
			while($row2 = mysqli_fetch_assoc($fetch_bloodtype)){
				$blood_type = $row2["stfBloodType"];
				$rhesus = $row2["stfBloodTypeRhesus"];
				$bt = $blood_type." ".$rhesus;
			}
			// }
		
			$sub_array = array();
		
			// $sub_array[] = '<div class="update pt-1" data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientFirstName"] . '</div>';
		
			// $sub_array[] = '<div class="update pt-1" data-id="' . $row["intClientId"].'" data-column="strClientMiddleName">' . $row["strClientMiddleName"] . '</div>';
		
			// $sub_array[] = '<div class="update pt-1" data-id="' . $row["intClientId"].'" data-column="strClientLastName">' . $row["strClientLastName"] . '</div>';
			
			$sub_array[] = '<div class="update pt-1">' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientLastName"] . ', ' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientFirstName"] . ' '.'<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientMiddleName"] .'</div>';
		
			$sub_array[] = '<div class="update pt-1" data-id="' . $row["intClientId"].'" data-column="stfClientType">' . $row["stfClientType"] . '</div>';
		
			$sub_array[] = '
				<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'" data-fname = "'.$row["strClientFirstName"].'"
				data-mname="'.$row["strClientMiddleName"].'" data-lname="'.$row["strClientLastName"].'" data-occ="'.$row["strClientOccupation"].'" data-contact ="'.$row["strClientContact"].'" data-image ="'.$row["strUserImageDir"].'"
				data-sex="'.$row["stfClientSex"].'" data-btype = "'.$bloodid.'" data-status = "'.$row["stfClientCivilStatus"].'" data-age = "'.$row["age"].'" style="padding: .2rem .75rem;">
					<i class="fa fa-pen fa-sm mr-1"></i>
					Edit
				</button>
			'; //<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>
		
			$data[] = $sub_array;
		}
		
		function get_all_data($connections)	{
			$query = "
				SELECT strClientFirstName, strClientMiddleName, strClientLastName
				FROM tblclient
				WHERE stfClientCandonate = 'Yes'
			";
			$result = mysqli_query($connections, $query);
			return mysqli_num_rows($result);
		}
		
		$output = array	(
		 //"draw"    => intval($_POST["draw"]),
		 "recordsTotal"  =>  get_all_data($connections),
		 "recordsFiltered" => $number_filter_row,
		 "data"    => $data
		);
		
		echo json_encode($output);  // send data as json format
	}
	
	else if ($requestData['type'] == 'bannedDonor') {
		$columns = array(
			// 'strClientFirstName',
			// 'strClientMiddleName',
			'strClientLastName'
		);

		$query = "
			SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, strClientOccupation, strClientContact, intBloodTypeId, stfClientCivilStatus, stfClientSex
			FROM tblclient
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfClientCandonate = 'No'
				AND (
					strClientFirstName LIKE '%".$requestData['search']['value']."%'
					OR strClientMiddleName LIKE '%".$requestData['search']['value']."%'
					OR strClientLastName LIKE '%".$requestData['search']['value']."%'
				)
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= '
				ORDER BY strClientFirstName ASC
			';
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

			$bloodid = $row["intBloodTypeId"];

			$fetch_bloodtype = mysqli_query($connections, "
				SELECT *
				FROM tblbloodtype
				WHERE intBloodTypeId = '$bloodid'
			");
			//if(mysqli_num_rows($fetch_bloodtype) > 0 ){
			while($row2 = mysqli_fetch_assoc($fetch_bloodtype))	{
				$blood_type = $row2["stfBloodType"];
				$rhesus = $row2["stfBloodTypeRhesus"];
				$bt = $blood_type." ".$rhesus;
			}
			//}

			$sub_array = array();
			
			$sub_array[] = '<div class="update pt-1">' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientLastName"] . ', ' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientFirstName"] . ' '.'<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientMiddleName"] .'</div>';
			
			// $sub_array[] = '<div class="update pt-1" data-id="'.$row["intClientId"].'" 	data-column="strClientFirstName">' . $row["strClientFirstName"] . '</div>';

			// $sub_array[] = '<div class="update pt-1" data-id="'.$row["intClientId"].'" 	data-column="strClientMiddleName">' . $row["strClientMiddleName"] . '</div>';

			// $sub_array[] = '<div class="update pt-1" data-id="'.$row["intClientId"].'" 	data-column="strClientLastName">' . $row["strClientLastName"] . '</div>';

			// $sub_array[] =	'
				// <a style="border: 1px solid; color: white; background: #6C757D; border-radius: 4px; text-decoration: none; padding: .2rem .75rem" class=" ml-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="viewDonorRecordInfo.php?id='.$row["intClientId"].'">View</a>
			// ';
			
			$sub_array[] =	'
				<a class="btn btn-outline-secondary btn-sm" data-id="'.$row["intClientId"].'" href="viewDonorRecordInfo.php?id='.$row["intClientId"].'">
					<i class="fa fa-eye fa-sm mr-1"></i>
					View
				</a>
			';
			
			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;
		}

		function get_all_data($connections)	{
			$query = "
				SELECT strClientFirstName, strClientMiddleName, strClientLastName
				FROM tblclient
			";
			$result = mysqli_query($connections, $query);
			return mysqli_num_rows($result);
		}

		$output = array	(
		//"draw"    => intval($_POST["draw"]),
			"recordsTotal"  =>  get_all_data($connections),
			"recordsFiltered" => $number_filter_row,
			"data"    => $data
		);

		echo json_encode($output);  // send data as json format
	}
	
	else if ($requestData['type'] == 'bannedDonorRecord')	{
		$clientid = $_POST['clientid'];
		$requestData = $_REQUEST;
		$columns = array(
			'd.intDonationId',
			'm.dtmExamTaken',
			// 'd.stfDonationRemarks'
		);

		$query = "
			SELECT DISTINCT(d.intDonationId), DATE_FORMAT(m.dtmExamTaken, '%M %d, %Y - %h:%i %p') AS Donation_Date, d.stfDonationRemarks, d.intClientId
			FROM tbldonation d
			JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
		";

		// datatable column index  => database column name

		if(isset($_POST['search']['value']))	{   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE d.intClientId = '$clientid'
				AND	(d.intDonationId LIKE '%".$requestData['search']['value']."%')
				GROUP BY d.intDonationId  
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= '
				ORDER BY 1 ASC
			';
		}

		$query1 = '';
		if($_POST["length"] != -1)	{
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$filter_row = mysqli_query($connections, $query);
		$number_filter_row = mysqli_num_rows($filter_row);

		$result = mysqli_query($connections, $query . $query1);
		
		$data = array();
		
		$varSkip = '<i class="fa fa-angle-double-right text-secondary" title="Skipped"></i>';
		$varPass = '<i class="fa fa-check text-success" title="Passed"></i>';
		$varFail = '<i class="fa fa-times text-danger" title="Failed"></i>';
		$varCurr = '<i class="fa fa-circle text-primary" title="Current"></i>';
		$varNone = '<i class="fa fa-pause text-info" title="Waiting"></i>';
		
		$varME = $varNone;
		$varPE = $varNone;
		$varIS = $varNone;
		$varSS = $varNone;
		
		while($row = mysqli_fetch_array($result)) {  // preparing an array
			$did = $row['intDonationId'];
			$sub_array = array();
			
			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intDonationId"].'" 	data-column="intDonationId">' . $row["intDonationId"] . '</div>';

			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intDonationId"].'" 	data-column="dtmExamTaken">' . $row["Donation_Date"] . '</div>';
			///*
			$qryMeRemarks = mysqli_query($connections, "
				SELECT DISTINCT(me.stfAnswerRemarks)
				FROM tblclient c
				JOIN tbldonation d ON c.intClientId = d.intClientId
				JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
				WHERE me.intDonationId = $did
				GROUP BY me.stfAnswerRemarks
			");
				
			$varMeRemarks = array();
			
			while($rowMeRemarks = mysqli_fetch_assoc($qryMeRemarks))	{
				$varMeRemarks[] = $rowMeRemarks["stfAnswerRemarks"];
			}

			if(in_array('Wrong', $varMeRemarks))	{
				$varME = $varFail;
				$varPE = $varIS = $varSS = $varSkip;
			}
			else if(in_array('Expired', $varMeRemarks))	{
				$varME = $varPE = $varIS = $varSS = $varSkip;
			}			
			else if(in_array('Unchecked', $varMeRemarks))	{
				$varME = $varCurr;
			}
			else	{
				$varME = $varPass;

				$qryPeRemarks = mysqli_query($connections, "
					SELECT DISTINCT(pe.stfClientPhysicalExamRemarks) AS 'PE'
					FROM tbldonation d
					JOIN tblphysicalexam pe ON d.intDonationId = pe.intDonationId
					WHERE d.intDonationId = $did
				");
				
				$rowPeRemarks = mysqli_fetch_assoc($qryPeRemarks);
				$varPeRemarks = $rowPeRemarks["PE"];

				if(isset($varPeRemarks))	{
					if($varPeRemarks == 'Failed')	{
						$varPE = $varFail;
						$varIS = $varSkip;
						$varSS = $varSkip;
					}
					else	{
						$varPE = $varPass;
						
						$qryIsRemarks = mysqli_query($connections, "
							SELECT DISTINCT(ins.stfClientInitialScreeningRemarks) AS 'IS'
							FROM tbldonation d
							JOIN tblphysicalexam pe ON d.intDonationId = pe.intDonationId
							JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
							WHERE d.intDonationId = $did
						");
							
						$varIsRemarks = array();
						
						while($rowIsRemarks = mysqli_fetch_assoc($qryIsRemarks))	{
							$varIsRemarks[] = $rowIsRemarks["IS"];
						}
						
						if(!empty($varIsRemarks))	{
							if(in_array('Wrong', $varIsRemarks))	{
								$varIS = $varFail;
								$varSS = $varSkip;
							}
							else	{
								$varIS = $varPass;
								
								$qrySsRemarks = mysqli_query($connections, "
									SELECT DISTINCT(ss.stfDonorSerologicalScreeningRemarks) AS 'SS'
									FROM tbldonation d
									JOIN tblphysicalexam pe ON d.intDonationId = pe.intDonationId
									JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
									JOIN tblserologicalscreening ss ON ins.intDonationId = ss.intDonationId
									WHERE d.intDonationId = $did
								");
								
								$varSsRemarks = array();
								
								while($rowSsRemarks = mysqli_fetch_assoc($qrySsRemarks))	{
									$varSsRemarks[] = $rowSsRemarks["SS"];
								}
								
								if(!empty($varSsRemarks))	{
									if(in_array('Wrong', $varSsRemarks))	{
										$varSS = $varFail;
									}
									else	{
										$varSS = $varPass;
									}
								}
								else	{
									$varSS = $varCurr;
								}
							}
						}
						else	{
							$varIS = $varCurr;
						}
					}
				}
				else	{
					$varPE = $varCurr;
				}
			}
			//*/
			
			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intDonationId"].'">' . $varME . '</div>';
			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intDonationId"].'">' . $varPE . '</div>';
			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intDonationId"].'">' . $varIS . '</div>';
			$sub_array[] = '<div class="update pt-1" data-id="'.$row["intDonationId"].'">' . $varSS . '</div>';
			
			$sub_array[] =	'
				<a class="btn btn-outline-secondary btn-sm ml-2 btn_viewrec" data-id="'.$row["intDonationId"].'" href="viewDonorDonation.php?id='.$row["intDonationId"].'&stat='.$row["stfDonationRemarks"].'&clientId='.$row['intClientId'].'">
					<i class="fa fa-eye fa-sm mr-1"></i>
					View
				</a>
			'; 
			//<button type="button" name="delete" class="btn btn-danger fa fa-trash btn-sm btnDeleteCultureMedia" id="'.$row["intClientId"].'"></button>

			$data[] = $sub_array;		
		}

		function get_all_data($connections)	{
			$clientid = $_POST['clientid'];
			$query = "
				SELECT DISTINCT(d.intDonationId), m.dtmExamTaken, d.stfDonationRemarks
				FROM tbldonation d
				JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
				WHERE d.intClientId = '$clientid'
				GROUP BY d.intDonationId
			";
			$result = mysqli_query($connections, $query);
			return mysqli_num_rows($result);
		}

		$output = array(
			//"draw"    => intval($_POST["draw"]),
			"recordsTotal"  =>  get_all_data($connections),
			"recordsFiltered" => $number_filter_row,
			"data"    => $data,
			"query" => $query
		);
		
		echo json_encode($output);  // send data as json format
	}
	
	else if ($requestData['type'] == 'donorRecords') {
		$columns = array(
			// 'strClientFirstName',
			// 'strClientMiddleName',
			'strClientLastName'
		);

		$query = "
			SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName
			FROM tblclient
		";

		// $getlatestdonationIDquery = mysqli_query($connections,"
			// SELECT intDonationId
			// FROM tbldonation
			// WHERE intClientId = '$id'
			// ORDER BY intDonationId DESC
			// LIMIT 1 OFFSET 0
		// ");

		// datatable column index  => database column name

		if(isset($_POST['search']['value']))	{   // if there is a search parameter, $requestData['search']['value'] contains search parameter AND ItemOnHandStatus = 1
			$query .= "
				WHERE stfClientCanDonate = 'Yes'
				AND (
					strClientFirstName LIKE '%".$requestData['search']['value']."%'
					OR strClientMiddleName LIKE '%".$requestData['search']['value']."%'
					OR strClientLastName LIKE '%".$requestData['search']['value']."%'
				)
			";
		}

		if(isset($_POST["order"]))	{
			$query .= '
				ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. '
			';
		}
		else	{
			$query .= '
				ORDER BY strClientFirstName ASC
			';
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
			// $query_donors = "
				// SELECT intDonationId
				// FROM tbldonation
				// WHERE intClientId = '$id'
				// ORDER BY intDonationId DESC
				// LIMIT 1 OFFSET 0
			// ";
			$id = $row["intClientId"];
			$getlatestdonationIDquery = mysqli_query($connections,"
				SELECT intDonationId
				FROM tbldonation
				WHERE intClientId = '$id'
				ORDER BY intDonationId DESC
				LIMIT 1 OFFSET 0
			");

			if(mysqli_num_rows($getlatestdonationIDquery) > 0)	{
				while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
					$latestdonationID = $row2["intDonationId"];
				}

				$getdeferaldays = mysqli_query($connections,"
					SELECT MAX(`intDeferralDay`) AS Deferaldays
					FROM tblbloodcomponent tbc
					JOIN tblinitialscreening tis ON tbc.intBloodComponentId = tis.intBloodComponentId
					WHERE strBloodComponentRemarks = 'Failed'
					AND intDonationId = '$latestdonationID'
				");
				
				if(mysqli_num_rows($getdeferaldays) > 0)	{//if may fail na blood comp
					while ($row3 = mysqli_fetch_assoc($getdeferaldays)) {
						$deferaldays = $row3["Deferaldays"];
					}
				}
				else	{	//if walang nag fail
					$deferaldays = 0;
				}

				settype($deferaldays,"int");

				$check_ifhasrecordwithinninetydays = mysqli_query($connections, "
					SELECT c.intClientId
					FROM tblclient c
					JOIN tbldonation d ON c.intClientId = d.intClientId
					JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
					JOIN tblphysicalexam pe ON me.intDonationId = pe.intDonationId
					JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
					JOIN tblserologicalscreening ss ON ins.intDonationId = ss.intDonationId
					WHERE c.intClientId = '$id'
					AND d.stfDonationRemarks = 'Complete'
					AND d.intDonationId = (
						SELECT intDonationId
						FROM tbldonation
						WHERE intClientId = '$id'
						ORDER BY intDonationId DESC
						LIMIT 1 OFFSET 0
					)
					AND d.intDonationId IN (
						SELECT me.intDonationId
						FROM tblmedicalexam me
					)
					AND d.intDonationId IN (
						SELECT pe.intDonationId
						FROM tblphysicalexam pe
					)
					AND d.intDonationId IN (
						SELECT ins.intDonationId
						FROM tblinitialscreening ins
					)
					AND d.intDonationId IN (
						SELECT ss.intDonationId
						FROM tblserologicalscreening ss
					)
					AND me.dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
					AND pe.dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
					AND ins.dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
					AND ss.dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
				");

				$failed_survey = mysqli_query($connections,"
					SELECT *
					FROM tblmedicalexam
					WHERE intDonationId = '$latestdonationID'
					AND stfAnswerRemarks = 'Wrong'
					AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
				");

				$expired_survey = mysqli_query($connections,"
					SELECT *
					FROM `tblmedicalexam`
					WHERE intDonationId = '$latestdonationID'
					AND `stfAnswerRemarks` = 'Expired'
					AND `dtmExamTaken` BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
				");
				
				$unchecked_survey = mysqli_query($connections,"
					SELECT *
					FROM `tblmedicalexam`
					WHERE intDonationId = '$latestdonationID'
					AND `stfAnswerRemarks` = 'Unchecked'
					AND `dtmExamTaken` BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
				");

				$failed_BC = mysqli_query($connections,"
					SELECT *
					FROM `tblinitialscreening`
					WHERE dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL $deferaldays DAY) AND NOW()
					AND intDonationId = '$latestdonationID'
					AND strBloodComponentRemarks = 'Failed'
				");

				// $failed_hemo = mysqli_query($connections,"
					// SELECT *
					// FROM `tblinitialscreening`
					// WHERE intDonationId = '$latestdonationID'
					// AND intBloodComponentId = '3'
					// AND `stfClientInitialScreeningRemarks` = 'Failed'
					// AND dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
				// ");

				$check_ifseroremaining = mysqli_query($connections, "
					SELECT *
					FROM tbldonation
					WHERE stfDonationRemarks = 'Incomplete'
					AND intDonationId IN (
						SELECT intDonationId
						FROM tblphysicalexam
						WHERE intDonationId = '$latestdonationID'
					)
					AND intDonationId IN (
						SELECT intDonationId
						FROM tblinitialscreening
						WHERE intDonationId = '$latestdonationID'
					)
					AND intDonationId NOT IN (
						SELECT intDonationId
						FROM tblserologicalscreening
						WHERE intDonationId = '$latestdonationID'
					)
					AND intClientId = '$id'
				");

				$check_ifnoinit = mysqli_query($connections, "
					SELECT *
					FROM tbldonation
					WHERE stfDonationRemarks = 'Incomplete'
					AND intDonationId IN (
						SELECT intDonationId
						FROM tblphysicalexam
						WHERE intDonationId = '$latestdonationID'
					)
					AND intDonationId NOT IN (
						SELECT intDonationId
						FROM tblinitialscreening
						WHERE intDonationId = '$latestdonationID'
					)
					AND intClientId = '$id'
				");

				$check_ifnophys = mysqli_query($connections, "
					SELECT *
					FROM tbldonation
					WHERE stfDonationRemarks = 'Incomplete'
					AND intDonationId IN (
						SELECT intDonationId
						FROM tblmedicalexam
						WHERE intDonationId = '$latestdonationID'
					)
					AND intDonationId NOT IN (
						SELECT intDonationId
						FROM tblphysicalexam
						WHERE intDonationId = '$latestdonationID'
					)
					AND intClientId = '$id'
				");

				$checkifpwedenaulit = mysqli_query($connections, "
					SELECT *
					FROM tbldonation
					WHERE stfDonationRemarks = 'Complete'
					AND intDonationId = '$latestdonationID'
				");

				$sub_array = array();

				$sub_array[0] = '<div class="update pt-2">' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientLastName"] . ', ' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientFirstName"] . ' '.'<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientMiddleName"] .'</div>';

				if(mysqli_num_rows($check_ifhasrecordwithinninetydays) == 0)	{
					if(mysqli_num_rows($failed_BC) == 0 AND mysqli_num_rows($failed_survey) == 0 AND mysqli_num_rows($expired_survey) == 0)	{
						if(mysqli_num_rows($unchecked_survey) == 0)	{
							//  if(mysqli_num_rows($failed_hemo) == 0){
							if(mysqli_num_rows($check_ifnophys) > 0)	{
								$sub_array[1] =	'
									<div class="text-center">
										<button type="button" class="btn btn-primary btnAddphysical" data-id="'.$row["intClientId"].'">
											Add Physical Screening
										</button>
								';
							}
							else if(mysqli_num_rows($check_ifnoinit) > 0)	{
								$sub_array[1] =	'
									<div class="text-center">
										<button type="button" class="btn btn-primary btnAddinitial" data-id="'.$row["intClientId"].'">
										Add Initial Screening
										</button>
								';
							}
							else if(mysqli_num_rows($check_ifseroremaining) > 0 )	{
								$sub_array[1] =	'
									<div class="text-center">
										<button type="button" class="btn btn-primary btnAddserological" data-id="'.$row["intClientId"].'">
											Add Serological Screening
										</button>
								';
							}
							else if (mysqli_num_rows($checkifpwedenaulit) > 0)	{
								$sub_array[1] =	'
									<div class="text-center">
										<a href = "fetchIntSheetQuestions-table.php?client_id='.$row["intClientId"].'" style="text-decoration: none">
											<button type="button" class="btn btn-primary btnAddrecord" data-id="'.$row["intClientId"].'">
												Add record
											</button>
										</a>
								';
							}
						}
							else	{
								$sub_array[1] =	'
									<div class="text-center">
										<a href = "fetchIntSheetQuestions-table.php?client_id='.$latestdonationID.'" style="text-decoration: none">
											<button type="button" class="btn btn-primary btnchecksurvey"  name = "check_survey">
												Check Survey
											</button>
										</a>
								';
							}
					}
					else	{
						$sub_array[1] =	'
							<div class="text-center">
								<button type = "button" class ="btn btn-success" disabled>
									Record Complete
								</button>
						';
					}
				}
				else {
					$sub_array[1] =	'
						<div class="text-center">
							<button type = "button" class ="btn btn-success" disabled>
								Record Complete
							</button>
					';
				}
			}
			else	{
				$sub_array = array();

				$sub_array[0] = '<div class="update pt-2">' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientLastName"] . ', ' . '<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientFirstName"] . ' '.'<span data-id="' . $row["intClientId"].'" data-column="strClientFirstName">' . $row["strClientMiddleName"] .'</div>';

				$sub_array[1] =	'
					<div class="text-center">
						<a href = "fetchIntSheetQuestions-table.php?client_id='.$row["intClientId"].'">
							<button type="button" class="btn btn-primary btnAddrecord" data-id="'.$row["intClientId"].'">
								Add record
							</button>
						</a>
				';
			}	//end of else
			
			$sub_array[1] .= '
						<button type="button" class="btn mx-1 btn-outline-primary btn-sm p-2" data-toggle="modal" data-target="#editdonorinfo" data-id="'.$row["intClientId"].'" title="Edit">
							<i class="fa fa-user-edit fa-lg"></i>
						</button>
						<a class="btn btn-outline-secondary btn-sm mx-1 p-2 btn_viewrec" data-id="'.$row["intClientId"].'" href="viewDonorRecordInfo.php?id='.$row["intClientId"].'" title="View">
							<i class="fa fa-eye fa-lg"></i>
						</a>
					</div>
			';
		
			$data[] = $sub_array;
		}
	
		function get_all_data($connections)	{
			$query = "
				SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName
				FROM tblclient
				WHERE stfClientCanDonate = 'Yes'
			";
			$result = mysqli_query($connections, $query);
			return mysqli_num_rows($result);
		}

		$output = array(
		//"draw"    => intval($_POST["draw"]),
		"recordsTotal" =>  get_all_data($connections),
		"recordsFiltered" => $number_filter_row,
		"data" => $data
		);

		echo json_encode($output);  // send data as json format
	}
?>
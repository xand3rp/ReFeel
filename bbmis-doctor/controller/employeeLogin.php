<?php
	include ("connections.php");
	parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
	$varUn = $params["txtUn"];
	$varPw = $params["txtPw"];

	/* Validation */
	if($_SERVER["REQUEST_METHOD"] == "POST")	{
		if(empty($varUn) || empty($varPw))	{
			echo "<script type='text/javascript'>alert('Username and password required!')</script>";

		}
		else	{
			parse_str($_POST["formdata"], $params);
			$varUn = $params["txtUn"];
			$varPw = $params["txtPw"];
		}
	}

	/* Username and Password has value */
	if($varUn && $varPw)	{
		$qryCheckUser = mysqli_query($connections, "
		SELECT *
		FROM tbluser
		WHERE strUserName = '$varUn'");

		// Checks and returns rows of the username entered
		$qryCheckUserOcc = mysqli_num_rows($qryCheckUser);

		// If username has a record
		if($qryCheckUserOcc > 0)	{
			// If password matched to username's account
			while($row = mysqli_fetch_assoc($qryCheckUser))	{
				$varDbId = $row["intUserId"];
				$varDbPw = $row["strUserPassword"];


				if($varDbPw == $varPw)	{
					$qryJoinView1 = mysqli_query($connections, "SELECT e.intEmployeeId, e.stfEmployeeType ,u.strUserImageDir
					FROM tblemployee e
					JOIN tbluser u ON e.intUserId = u.intUserId
					WHERE u.intUserId = '$varDbId'
					AND e.intUserId = '$varDbId'
					AND stfEmployeeStatus = 'Active'");

					while($row = mysqli_fetch_assoc($qryJoinView1))	{
						$varEmpId = $row["intEmployeeId"];
						$varRole = $row["stfEmployeeType"];

					}

					if(isset($varRole))	{
						if($varRole == "Doctor" || $varRole == "Staff")	{
							session_start();
							$_SESSION["sessEmpId"] = $varEmpId;
							echo 1;
						}

						else	{
							echo 2;
						}
					}
					else	{
						echo 2;
					}
				}

				else	{
					echo 3;
				}
			}
		}
		else	{
			echo 4;
		}
	}
?>

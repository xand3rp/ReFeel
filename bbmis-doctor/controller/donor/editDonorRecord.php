<?php
	include("../connections.php");
	//parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
	$id = mysqli_real_escape_string($connections,$_POST['clientId']);
	settype($id,'int');
	$occupation = mysqli_real_escape_string($connections,$_POST['clientocc']);
	$contact = mysqli_real_escape_string($connections,$_POST['clientcontact']);
	$civilstat = mysqli_real_escape_string($connections,$_POST['clientcivstat']);
	$blood_type = mysqli_real_escape_string($connections, $_POST['clientbloodtype']);
	$clientfname = mysqli_real_escape_string($connections, $_POST['clientfname']);
	$clientminit = mysqli_real_escape_string($connections, $_POST['clientminit']);
	$clientlname = mysqli_real_escape_string($connections, $_POST['clientlname']);
	
	//$clientsex = mysqli_real_escape_string($connections, $_POST['clientsex']);

	$file = $_FILES['clientimage2'];
	$fileName = $_FILES['clientimage2']['name'];/*kukunin yung file name*/
	$fileTmpName = $_FILES['clientimage2']['tmp_name'];/*kukunin yung temporary destination na pinupuntahan ng file bago i upload*/
	$fileSize = $_FILES['clientimage2']['size'];/*kukunin file size*/
	$fileError = $_FILES['clientimage2']['error'];/*integer to pag 0 ibig sabihin succesful parang ganun*/
	$fileType = $_FILES['clientimage2']['type'];/*kukunin file type*/

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg','jpeg','png');
	
	if(in_array($fileActualExt, $allowed)) { /*ichicheck kung allowed ba yung file type */
		if($fileError === 0){
			if($fileSize < 1000000){
				$fileNameNew = uniqid('', true).".".$fileActualExt;/*gagawin niyang integer na unique*/

				$fileDestination = '../../public/img/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);/*yung unang paramter kung saan galing which is yung temporary location, yung second parameter kung saan ililipat*/
			}
			else	{
				echo "
					<script type='text/javascript'>
						// alert('Your file is too big!');
						swal('Oops!', 'Your file is too big! Please upload an image with size less than 1Mb.', 'error')
					</script>
				";
			}

		}
		else	{
			echo "
				<script type='text/javascript'>
					// alert('there was an error uploading the file!');
					swal('Oops!', 'There was an error uploading the file. Please try again.', 'error')
				</script>
			";
		}
	}
	else	{
		echo "
			<script type='text/javascript'>
				// alert('You cannot upload files of this type!');
				swal('Oops!', 'You cannot upload files of this type. Please upload files with .jpg, .jpeg, and .png files.', 'error')
			</script>
		";
	}

/////////////////////////////////////////////////////	

	if($occupation && $contact && $civilstat && $blood_type && $clientfname && $clientlname)	{
		mysqli_query($connections,"
			UPDATE tblclient
			SET strClientContact = '$contact', strClientOccupation = '$occupation', stfClientCivilStatus = '$civilstat', intBloodTypeId = '$blood_type', strClientFirstName ='$clientfname', strClientMiddleName ='$clientminit', strClientLastName='$clientlname'
			WHERE intClientId = $id
		");

		$useridqry = mysqli_query($connections,"
			SELECT *
			FROM tblclient c
			JOIN tbluser u ON c.intUserId = u.intUserId
			WHERE c.intClientId = '$id'
		");
		
		if(mysqli_num_rows($useridqry)>0)	{
			while ($row = mysqli_fetch_assoc($useridqry)) {
				// code...
				$userid = $row["intUserId"];
			}
		}

		mysqli_query($connections,"
			UPDATE tbluser
			SET strUserImageDir = '$fileNameNew'
			WHERE intUserId = '$userid'
		");
		
		echo  "
			<script type='text/javascript'>
				alert('You updated the user information successfully!');
				window.location.href = '../../views/donor.php';
			</script>
		";
		
		// echo "
			// <script type='text/javascript'>
				// swal({
					// title: 'Great!',
					// text: 'The user information has been successfully updated.',
					// icon: 'success'
				// }).then(() => {
					// $('#editdonorinfo').modal('hide');
					// window.location.href = '../../views/donor.php'
				// });
			// </script>
		// ";
	}
		
		//echo $id.$occupation.$contact.$civilstat.$blood_type;
	else	{
		echo  "
			<script type='text/javascript'>
				alert('Update failed.');
				window.location.href = '../../views/donor.php';
			</script>
		";
		
		// echo "
			// <script type='text/javascript'>
				// swal({
					// title: 'Oops.',
					// text: 'The user information has been unsuccessfully updated. Please try again.',
					// icon: 'error'
				// }).then(() => {
					// $('#editdonorinfo').modal('hide');
					// window.location.href = '../../views/donor.php'
				// });
			// </script>
		// ";
		
		// echo "
			// <script type='text/javascript'>
				// window.location.href = '../../views/donor.php'
			// </script>
		// ";
	}
?>
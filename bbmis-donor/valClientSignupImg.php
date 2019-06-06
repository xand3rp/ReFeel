<?php
	include "connection.php";
	
	echo $varDbId;
	
	$file = $_FILES['fileimg'];
	$fileName = $_FILES['fileimg']['name'];/*kukunin yung file name*/
	$fileTmpName = $_FILES['fileimg']['tmp_name'];/*kukunin yung temporary destination na pinupuntahan ng file bago i upload*/
	$fileSize = $_FILES['fileimg']['size'];/*kukunin file size*/
	$fileError = $_FILES['fileimg']['error'];/*integer to pag 0 ibig sabihin succesful parang ganun*/
	$fileType = $_FILES['fileimg']['type'];/*kukunin file type*/

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg','jpeg','png');
	if (in_array($fileActualExt, $allowed)) { /*ichicheck kung allowed ba yung file type */
		if($fileError === 0)	{
			if($fileSize < 1000000)	{
				$fileNameNew = uniqid('', true).".".$fileActualExt;/*gagawin niyang integer na unique*/

				$fileDestination = '../img/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);/*yung unang paramter kung saan galing which is yung temporary location, yung second parameter kung saan ililipat*/
				header("Location:home.php");
				
				$qryUploadImg = mysqli_query($conn, "
					UPDATE tbluser
					SET strUserImageDir = '$fileNameNew'
					WHERE intUserId = $varDbId
				");
				
				if($qryUploadImg)	{
					// Success
					// echo 1;
				}
				
				else	{
					// Failed
					// echo 2;
				}
			}
			else	{
				// File is too big.
				// echo 3;
				// echo "<script type='text/javascript'>alert('Your file is too big!');</script>";
			}

		}
		else	{
			// Error opening the file.
			// echo 4;
			// echo "<script type='text/javascript'>alert('there was an error uploading the file!');</script>";
		}
	}
	else	{
		// Cannot upload different type.
		// echo 5;
		// echo "<script type='text/javascript'>alert('You cannot upload files of this type!');</script>";
	}
?>
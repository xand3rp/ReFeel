<?php
	include("../connections.php");
	//parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
  $varId = mysqli_real_escape_string($connections,$_POST["hidden_id"]);
	$varFname = mysqli_real_escape_string($connections,$_POST["txtFname"]);
	$varMname = mysqli_real_escape_string($connections,$_POST["txtMname"]);
	$varLname = mysqli_real_escape_string($connections,$_POST["txtLname"]);
	$varPos = mysqli_real_escape_string($connections,$_POST["optPos"]);
  $varstat = mysqli_real_escape_string($connections,$_POST["optstat"]);

if(isset($_FILES['edit_image'])){
	$file = $_FILES ['edit_image'];
	$fileName = $_FILES['edit_image']['name'];/*kukunin yung file name*/
	$fileTmpName = $_FILES['edit_image']['tmp_name'];/*kukunin yung temporary destination na pinupuntahan ng file bago i upload*/
	$fileSize = $_FILES['edit_image']['size'];/*kukunin file size*/
	$fileError = $_FILES['edit_image']['error'];/*integer to pag 0 ibig sabihin succesful parang ganun*/
	$fileType = $_FILES['edit_image']['type'];/*kukunin file type*/

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg','jpeg','png');
	if (in_array($fileActualExt, $allowed)) { /*ichicheck kung allowed ba yung file type */
	  if($fileError === 0){
	    if($fileSize < 1000000){
	      $fileNameNew = uniqid('', true).".".$fileActualExt;/*gagawin niyang integer na unique*/

	      $fileDestination = '../img/'.$fileNameNew;
	      move_uploaded_file($fileTmpName, $fileDestination);/*yung unang paramter kung saan galing which is yung temporary location, yung second parameter kung saan ililipat*/


	    }
	    else	{
	      echo "<script type='text/javascript'>alert('Your file is too big!');</script>";
	    }

	  }
	  else	{
	    echo "<script type='text/javascript'>alert('there was an error uploading the file!');</script>";
	  }
	}
	else	{
	  echo "<script type='text/javascript'>alert('You cannot upload files of this type!');</script>";
	}
}


  if($varId && $varFname && $varLname && $varPos && $varstat){
    mysqli_query($connections,"UPDATE tblemployee
      SET strEmployeeFirstName = '$varFname',strEmployeeMiddleName = '$varMname',strEmployeeLastName = '$varLname',stfEmployeeType = '$varPos',stfEmployeeStatus = '$varstat'
      WHERE intEmployeeId = '$varId'");

			$useridqry = mysqli_query($connections,"SELECT * FROM tblemployee e JOIN tbluser u ON e.intUserId = u.intUserId WHERE e.intEmployeeId = '$varId'");
		  if(mysqli_num_rows($useridqry)>0){
		    while ($row = mysqli_fetch_assoc($useridqry)) {
		      // code...
		      $userid = $row["intUserId"];
		    }
		  }

		  mysqli_query($connections,"UPDATE tbluser SET strUserImageDir = '$fileNameNew' WHERE intUserId = '$userid'");
      echo "<script type='text/javascript'>alert('Edit Succesful');</script>";
      echo "<script type='text/javascript'>window.location.href = '../../views/staff.php';</script>";
      echo 1;
  }else{
    echo "<script type='text/javascript'>alert('Incomplete data');</script>";
    echo "<script type='text/javascript'>window.location.href = '../../views/staff.php';</script>";
    echo 2;
  }


?>

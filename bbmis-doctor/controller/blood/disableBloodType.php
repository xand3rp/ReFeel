<?php
include("../connections.php");
$id = $_POST["id"];

$countInUse = mysqli_query($connections, "SELECT COUNT(bt.intBloodTypeId) AS count
FROM tblbloodtype bt JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE bt.intBloodTypeId = '$id'");

if(mysqli_num_rows($countInUse) > 0){
  while($row = mysqli_fetch_assoc($countInUse)){
  $count = $row['count'];
  }
  settype($count,"int");

    if($count > 0){
      echo $count;//dont delete
    }else if ($count == 0){
      mysqli_query($connections,"UPDATE tblbloodtype SET stfBloodTypeStatus	 = 'Inactive' WHERE intBloodTypeId = $id");
      echo "deleted"; //delete
    }

}else{

}
?>

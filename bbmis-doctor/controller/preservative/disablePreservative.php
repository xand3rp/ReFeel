<?php
include("../connections.php");
$id = $_POST["id"];

$countInUse = mysqli_query($connections, "SELECT COUNT(b.intPreservativeId) AS count
FROM tblbloodbag b JOIN tblpreservatives p ON b.intPreservativeId = p.intPreservativeId
WHERE p.intPreservativeId = '$id'");

if(mysqli_num_rows($countInUse) > 0){
  while($row = mysqli_fetch_assoc($countInUse)){
  $count = $row['count'];
  }
  settype($count,"int");

    if($count > 0){
      echo $count;//dont delete
    }else if ($count == 0){
      mysqli_query($connections,"UPDATE tblpreservatives SET stfPreservativeStatus = 'Inactive' WHERE intPreservativeId = $id");
      echo "deleted"; //delete
    }

}else{

}
?>

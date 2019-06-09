<?php
include("../connections.php");
$id = $_POST["id"];

$countInUse = mysqli_query($connections, "SELECT COUNT(bc.intBloodComponentId) AS count
FROM tblbloodcomponent bc JOIN tblinitialscreening i ON bc.intBloodComponentId = i.intBloodComponentId
WHERE bc.intBloodComponentId = '$id'");

if(mysqli_num_rows($countInUse) > 0){
  while($row = mysqli_fetch_assoc($countInUse)){
  $count = $row['count'];
  }
  settype($count,"int");

    if($count > 0){
      echo $count;//dont delete
    }else if ($count == 0){
      mysqli_query($connections,"UPDATE tblbloodcomponent SET stfBloodComponentStatus = 'Inactive' WHERE intBloodComponentId = $id");
      echo "deleted"; //delete
    }

}else{

}
?>

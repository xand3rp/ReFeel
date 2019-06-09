<?php
include("../connections.php");
$id = $_POST["id"];

$countInUse = mysqli_query($connections, "SELECT COUNT(d.intDiseaseId) AS count
FROM tbldisease d JOIN tblserologicalscreening ss ON d.intDiseaseId = ss.intDiseaseId
WHERE d.intDiseaseId = '$id'");

if(mysqli_num_rows($countInUse) > 0){
  while($row = mysqli_fetch_assoc($countInUse)){
  $count = $row['count'];
  }
  settype($count,"int");

    if($count > 0){
      echo $count;//dont delete
    }else if ($count == 0){
      mysqli_query($connections,"UPDATE tbldisease SET stfDiseaseStatus = 'Inactive' WHERE intDiseaseId = $id");
      echo "deleted"; //delete
    }

}else{

}

?>

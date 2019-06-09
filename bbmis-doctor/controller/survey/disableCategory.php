<?php
include("../connections.php");
$id = $_POST["id"];

$countInUse = mysqli_query($connections, "SELECT COUNT(qc.intQuestionCategoryId) AS count
FROM tblquestioncategory qc JOIN tblquestion q ON qc.intQuestionCategoryId = q.intQuestionCategoryId
WHERE qc.intQuestionCategoryId = '$id'");

if(mysqli_num_rows($countInUse) > 0){
  while($row = mysqli_fetch_assoc($countInUse)){
  $count = $row['count'];
  }
  settype($count,"int");

    if($count > 0){
      echo $count;//dont delete
    }else if ($count == 0){
      mysqli_query($connections,"UPDATE tblquestioncategory SET stfQuestionCategoryStatus = 'Inactive' WHERE intQuestionCategoryId = $id");
      echo "deleted"; //delete
    }

}else{

}


?>

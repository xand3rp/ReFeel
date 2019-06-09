<?php
include("../connections.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$surveycategoryid = $params["surveycategory_ID"];
$surveycategoryname = $params["editSurveyCategoryName"];

if($surveycategoryid && $surveycategoryname){

    $viewsurveycategory = mysqli_query($connections,"SELECT *
                              FROM tblquestioncategory
                              WHERE stfQuestionCategory  LIKE '$surveycategoryname' ");

    if(mysqli_num_rows($viewsurveycategory) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"UPDATE tblquestioncategory
                                  SET stfQuestionCategory = '$surveycategoryname'
                                  WHERE intQuestionCategoryId = '$surveycategoryid'");
      echo "1";
    }
    elseif (mysqli_num_rows($viewsurveycategory) > 0) {//if ] nageexist yung blood component
      echo "2";
    }

}
else {
  echo "3";
}
?>

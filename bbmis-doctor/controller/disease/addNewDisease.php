<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$diseasename = $params["newDiseaseName"];
$sanitized_disease = sanitize($diseasename);

if($sanitized_disease){

    $viewdisease = mysqli_query($connections,"SELECT *
                              FROM tbldisease
                              WHERE strDisease  LIKE '%$sanitized_disease%' ");

    if(mysqli_num_rows($viewdisease) <= 0){//if di nageexist yung disease

      mysqli_query($connections,"INSERT INTO tbldisease(strDisease) VALUES ('$sanitized_disease')");
      echo "1";
    }
    elseif (mysqli_num_rows($viewdisease) > 0) {//if ] nageexist yung disease
      echo "2";
    }

}
else {
  echo "3";
}
?>

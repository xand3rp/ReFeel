<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$diseaseid = $params["disease_ID"];
$diseasename = $params["editDiseaseName"];
$sanitized_disease = sanitize($diseasename);

if($diseaseid && $sanitized_disease){

    $viewdisease = mysqli_query($connections,"SELECT *
                              FROM tbldisease
                              WHERE strDisease  LIKE '$sanitized_disease' ");

    if(mysqli_num_rows($viewdisease) <= 0){//if di nageexist yung disease

      mysqli_query($connections,"UPDATE tbldisease
                                  SET strDisease = '$sanitized_disease'
                                  WHERE intdiseaseId = '$diseaseid'");
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

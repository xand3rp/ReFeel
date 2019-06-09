<?php
include("../connections.php");

if($_POST['rowid']){
  $diseaseid = $_POST['rowid'];
  settype($diseaseid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intDiseaseId,strDisease FROM tbldisease WHERE intDiseaseId = $diseaseid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

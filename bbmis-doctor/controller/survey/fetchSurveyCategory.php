<?php
include("../connections.php");

if($_POST['rowid']){
  $surveycategoryid = $_POST['rowid'];
  settype($bloodcomponentid,'int');

  $viewrecord = mysqli_query($connections, "SELECT intQuestionCategoryId,stfQuestionCategory FROM tblquestioncategory WHERE intQuestionCategoryId = $surveycategoryid");

  $row = mysqli_fetch_assoc($viewrecord);

  echo json_encode($row);
}

?>

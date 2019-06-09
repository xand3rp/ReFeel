<?php
include("../connections.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$currdate = date('Y-m-d H:i:s');
$rowCount = $_POST["rowCount"];
settype($rowCount,'int');
$newrowCount = $rowCount - 1;
$latestVersion = mysqli_query($connections,"SELECT decQuestionVersion FROM tblquestion ORDER BY decQuestionVersion DESC LIMIT 1");

while($row = mysqli_fetch_assoc($latestVersion)){
  $version = $row["decQuestionVersion"];
  settype($version,'int');
}

$explodedVersion = explode('.',$version);
$beforeDecimal = array_shift($explodedVersion);


for($i=1; $i <= $newrowCount; $i++){
$question = htmlspecialchars($params["question"."$i"]);
$category = $params["category"."$i"];
$type = $params["type"."$i"];
$newversion = $beforeDecimal + 1.00 ;

 mysqli_query($connections,"INSERT INTO tblquestion(txtQuestion,decQuestionVersion,dtmQuestionAdded,intQuestionCategoryId,stfQuestionType)
                            VALUES ('$question','$newversion','$currdate','$category','$type')");

}
$latest_survey = mysqli_query($connections,"SELECT decQuestionVersion FROM tblquestion ORDER BY intQuestionId DESC LIMIT 1");

$row4 = mysqli_fetch_assoc($latest_survey);
echo json_encode($row4);
?>

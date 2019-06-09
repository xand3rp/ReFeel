<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
include("../connections.php");

// parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
parse_str(mysqli_real_escape_string($connections,$_POST["obj"]), $params);
// echo json_encode($params);
$version = $_POST["selected"];
$currdate = date('Y-m-d H:i:s');
$rowCount = $_POST["allrows"];
settype($version,"float");
settype($rowCount,"int");
$rowCount = $rowCount - 1;
$last_id_qry = mysqli_query($connections,"SELECT intQuestionId FROM tblquestion WHERE decQuestionVersion = $version ORDER BY intQuestionId ASC LIMIT 1 ");


$explodedVersion = explode('.', $version);
$beforeDecimal = array_shift($explodedVersion);
$afterDecimal = end($explodedVersion);
$beforeDecimal .=".";

$latestinthisversion_qry = mysqli_query($connections,"SELECT decQuestionVersion FROM tblquestion WHERE  decQuestionVersion LIKE '%$beforeDecimal%' ORDER BY intQuestionId DESC LIMIT 1 ");

while ($row = mysqli_fetch_assoc($last_id_qry)) {
  $last_id = $row["intQuestionId"];
}
settype($last_id,"int");

while ($row2 = mysqli_fetch_assoc($latestinthisversion_qry)) {
  $latestSurveyInThisWholeNo = $row2["decQuestionVersion"];
}
//---------------------------------------------------------------------------
// for($i=$last_id; $i <= $last_id+$rowCount; $i++){
// $question = $params["question"."$i"];
// $category = $params["category"."$i"];
// $type = $params["type"."$i"];
// $newversion = $latestSurveyInThisWholeNo + 0.01 ;
//
//   $getcategoryID = mysqli_query($connections,"SELECT intQuestionCategoryId FROM tblquestioncategory WHERE stfQuestionCategory LIKE '%$category%'");
//
//   while($row3 = mysqli_fetch_assoc($getcategoryID)){
//     $categoryID = $row3["intQuestionCategoryId"];
//   }
//   if($question && $category && $type){
//    mysqli_query($connections,"INSERT INTO tblquestion(txtQuestion,decQuestionVersion,dtmQuestionAdded,intQuestionCategoryId,stfQuestionType)
//                               VALUES ('$question','$newversion','$currdate','$categoryID','$type')");
//                               //echo $question." ".$category." ".$type." ".$i ;
//   }
//
// }
//---------------------------------------------------------------------------

foreach($_POST["obj"] as $value){
  $question =  mysqli_real_escape_string($connections,(htmlspecialchars($value['que'])));
  $category = mysqli_real_escape_string($connections,($value['cat']));
  $type = mysqli_real_escape_string($connections,($value['type']));
  $newversion = $latestSurveyInThisWholeNo + 0.01 ;

  $getcategoryID = mysqli_query($connections,"SELECT intQuestionCategoryId FROM tblquestioncategory WHERE stfQuestionCategory LIKE TRIM('%$category%')");

  while($row3 = mysqli_fetch_assoc($getcategoryID)){
    $categoryID = $row3["intQuestionCategoryId"];
  }
  if($question && $category && $type){
   mysqli_query($connections,"INSERT INTO tblquestion(txtQuestion,decQuestionVersion,dtmQuestionAdded,intQuestionCategoryId,stfQuestionType)
                              VALUES ('$question','$newversion','$currdate',TRIM('$categoryID'),TRIM('$type'))");
                              //echo $question." ".$category." ".$type." ".$i ;
  }
  // echo json_encode($category.$categoryID);
}

$latest_survey = mysqli_query($connections,"SELECT decQuestionVersion FROM tblquestion ORDER BY intQuestionId DESC LIMIT 1");
/*while ($row4 = mysqli_fetch_assoc($latest_survey)) {
  $latestsurveyversion = $row4["intQuestionVersion"];
}
echo $latestsurveyversion;*/
$row4 = mysqli_fetch_assoc($latest_survey);
echo json_encode($row4);
?>

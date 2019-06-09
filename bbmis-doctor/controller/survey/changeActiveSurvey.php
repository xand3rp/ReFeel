<?php
include("../connections.php");

$selecteedsurvey = $_POST["survey"];

$getcurrentsurvey = mysqli_query($connections,"SELECT decQuestionVersion
FROM tblquestion
WHERE boolVersionInUse = '1'");

while ($row = mysqli_fetch_assoc($getcurrentsurvey)) {
  $currentsurvey = $row["decQuestionVersion"];
}

mysqli_query($connections,"UPDATE tblquestion SET boolVersionInUse = '0' WHERE decQuestionVersion = '$currentsurvey'");
mysqli_query($connections,"UPDATE tblquestion SET boolVersionInUse = '1' WHERE decQuestionVersion = '$selecteedsurvey'");

echo $selecteedsurvey;
?>

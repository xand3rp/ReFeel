<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$bloodcomponentname = $params["newBloodComponentName"];
$sanitized_bloodcomponentname = sanitize($bloodcomponentname);
$deferral = $params["newBloodComponentDeferral"];
$maleleast = $params['newBloodComponentML'];
settype($maleleast,'float');
$malemax = $params['newBloodComponentMM'];
settype($malemax,'float');
$femaleleast = $params['newBloodComponentFL'];
settype($femaleleast,'float');
$femalemax = $params['newBloodComponentFM'];
settype($femalemax,'float');

if(!$deferral){
    $deferral = 0;
}
//settype($deferral,"int");
if($maleleast < $malemax AND $femaleleast < $femalemax){
if($sanitized_bloodcomponentname){

    $viewbloodcomponent = mysqli_query($connections,"SELECT *
                              FROM tblbloodcomponent
                              WHERE strBloodComponent  LIKE '%$sanitized_bloodcomponentname%' ");

    if(mysqli_num_rows($viewbloodcomponent) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"INSERT INTO tblbloodcomponent(strBloodComponent,intDeferralDay,decMaleLeastVal,decMaleMaxVal,decFemaleLeastVal,decFemaleMaxVal) VALUES ('$sanitized_bloodcomponentname','$deferral','$maleleast','$malemax','$femaleleast','$femalemax')");
      echo "1";
    }
    elseif (mysqli_num_rows($viewbloodcomponent) > 0) {//if ] nageexist yung blood component
      echo "2";
    }

}
else {
  echo "3";
}
}else{
  echo "4";
}
?>

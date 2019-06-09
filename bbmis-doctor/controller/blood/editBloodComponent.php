<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$bloodcomponentid = $params["bloodcomp_ID"];
$bloodcomponentname = $params["editBloodComponentName"];
$sanitized_bloodcomponentname = sanitize($bloodcomponentname);
$deferral = $params["editBloodComponentDeferral"];
$maleleast = $params['editBloodComponentML'];
settype($maleleast,'float');
$malemax = $params['editBloodComponentMM'];
settype($malemax,'float');
$femaleleast = $params['editBloodComponentFL'];
settype($femaleleast,'float');
$femalemax = $params['editBloodComponentFM'];
settype($femalemax,'float');
  if(!$deferral){
      $deferral = 0;
  }
if($maleleast < $malemax AND $femaleleast < $femalemax){
if($bloodcomponentid && $sanitized_bloodcomponentname){

    $viewbloodcomponent = mysqli_query($connections,"SELECT *
                              FROM tblbloodcomponent
                              WHERE strBloodComponent = '$sanitized_bloodcomponentname'
                              AND intDeferralDay = '$deferral'
                              AND decMaleLeastVal ='$maleleast'
                              AND decMaleMaxVal ='$malemax'
                              AND decFemaleLeastVal ='$femaleleast'
                              AND decFemaleMaxVal ='$femalemax'");

    if(mysqli_num_rows($viewbloodcomponent) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"UPDATE tblbloodcomponent
                                  SET strBloodComponent = '$sanitized_bloodcomponentname', intDeferralDay = '$deferral',decMaleLeastVal='$maleleast',decMaleMaxVal='$malemax',decFemaleLeastVal='$femaleleast',decFemaleMaxVal='$femalemax'
                                  WHERE intBloodComponentId = '$bloodcomponentid'");
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

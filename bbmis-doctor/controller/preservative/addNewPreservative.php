<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$preservativename = $params["newpreservativeName"];
$sanitized_preservativename = sanitize($preservativename);
$lifespan = $params["newpreservativeLifespan"];
$fresh = $params["newpreservativeFresh"];
$neutral = $params["newpreservativeMedium"];
$critical = $params["newpreservativeCritical"];
settype($fresh, "int");
settype($neutral, "int");
settype($critical, "int");

if($sanitized_preservativename && $lifespan && $fresh && $neutral && $critical ){
if($lifespan > $fresh && $lifespan > $neutral && $lifespan > $critical){
    if($fresh < $neutral && $neutral < $critical){
      $viewpreservative = mysqli_query($connections,"SELECT *
                                FROM tblpreservatives
                                WHERE txtPreservative LIKE '%$sanitized_preservativename%' ");

      if(mysqli_num_rows($viewpreservative) <= 0){//if di nageexist yung blood component

        mysqli_query($connections,"INSERT INTO tblpreservatives(txtPreservative,intPreservativeLifespan,intPreservativeFreshPercentage,intPreservativeNeutralPercentage,intPreservativeCriticalPercentage) VALUES ('$sanitized_preservativename','$lifespan','$fresh','$neutral','$critical')");
        echo "1";
      }
      elseif (mysqli_num_rows($viewpreservative) > 0) {//if ] nageexist yung blood component
        echo "2";
      }
  }else{
    //if di tama yung mga percentages
    echo "4";
  }
}else{
  //if may mas mataas sa Lifespan
  echo "5";
}

}
else {
  echo "3";
}
?>

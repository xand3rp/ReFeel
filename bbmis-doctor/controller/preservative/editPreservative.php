<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
$preservativename = $params["editpreservativeName"];
$sanitized_preservativename = sanitize($preservativename);
$lifespan = $params["editpreservativeLifespan"];
$fresh = $params["editpreservativeFresh"];
$neutral = $params["editpreservativeMedium"];
$critical = $params["editpreservativeCritical"];
$id = $params["preservative_ID"];
settype($fresh, "int");
settype($neutral, "int");
settype($critical, "int");

if($sanitized_preservativename && $lifespan && $fresh && $neutral && $critical ){
if($lifespan > $fresh && $lifespan > $neutral && $lifespan > $critical){
    if($fresh < $neutral && $neutral < $critical){
      $viewpreservative = mysqli_query($connections,"SELECT *
                                FROM tblpreservatives
                                WHERE txtPreservative LIKE '%$sanitized_preservativename%'
                                AND intPreservativeLifespan = '$lifespan'
                                AND intPreservativeFreshPercentage ='$fresh'
                                AND intPreservativeNeutralPercentage = '$neutral'
                                AND intPreservativeCriticalPercentage = '$critical' ");

      if(mysqli_num_rows($viewpreservative) <= 0){//if di nageexist yung blood component

        mysqli_query($connections,"UPDATE tblpreservatives
                                      SET txtPreservative = '$sanitized_preservativename',
                                      intPreservativeLifespan = '$lifespan',
                                      intPreservativeFreshPercentage ='$fresh',
                                      intPreservativeNeutralPercentage = '$neutral',
                                      intPreservativeCriticalPercentage = '$critical'
                                      WHERE intPreservativeId = '$id' ");
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

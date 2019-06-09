<?php
function sanitize($string){
  return filter_var($string,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
?>
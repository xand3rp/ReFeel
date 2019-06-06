<?php
	$str = "<h>Hello World!</1>";
	$newstr = filter_var($str, FILTER_SANITIZE_STRING);
	echo $newstr;
	
	$int = 100;

if (!filter_var($int, FILTER_VALIDATE_INT) === false) {
    echo("Integer is valid");
} else {
    echo("Integer is not valid");
}
?>
<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}
?>
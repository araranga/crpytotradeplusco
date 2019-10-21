<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
function mysql_query_cheat($query){
$con=mysqli_connect("localhost","root","","ending");

$data = mysqli_query($con,$query);

mysqli_close($con);

return $data;
}

function mysqli_fetch_array_cheat($result){
	return mysqli_fetch_array($result,MYSQLI_ASSOC);
}

#var_dump($_SESSION);
?>
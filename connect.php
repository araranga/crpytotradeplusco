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

	function saveLogs($account_id,$message,$username = NULL){


	
		if(!empty($username))
		{
			#$username = $username;
		}
		else
		{

				if(empty($_SESSION['username']))
				{
					$username = "BUG";
				} 
				else
				{
					$username = $_SESSION['username'];
				}	

		}

		mysql_query_cheat("INSERT INTO tbl_actionlog SET account_id='$account_id', logdata='$message', username = '$username'");
	}



#var_dump($_SESSION);
?>
<?phpsession_start();require_once("../connect.php");require_once("../function.php");$email  = $_POST['email'];$pass = $_POST['password'];$table = "tbl_accounts";$query = "SELECT * FROM $table WHERE email='$email' ";$q = mysql_query_cheat($query);$count = mysql_num_rows($q);if($count==1){	echo 1;	$row = mysqli_fetch_array_cheat($q);	$to = $row['email'];$subject = "Password Retrieval";$txt = "Here is your password:".$row['password'];$headers = "From: noreply@mccportal-ph.com" . "\r\n" ."CC: ardeenathanraranga@gmail.com";mail($to,$subject,$txt,$headers);	}if($count==0){	echo $count;	}?>
﻿<?phpinclude("connect.php");$startDate = date('Y-m-d');$query = "SELECT * FROM `tbl_buycode_history` WHERE `status` = '0' AND accounts_id!=0 AND maturity_date='$startDate'";$q = mysql_query_cheat($query);while($row = mysqli_fetch_array_cheat($q)){$quser = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='{$row['accounts_id']}'");$rowuser = mysqli_fetch_array_cheat($quser);			if($rowuser['refer']){			$q2 = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE username='{$rowuser['refer']}'");			$row2 = mysqli_fetch_array_cheat($q2);			$rebates = $row['maturity_amount'] * 0.05;			$refersummary = "5% From {$row['amount']} - {$rowuser['username']}";			mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos= balance_pesos + {$rebates} WHERE accounts_id='{$row2['accounts_id']}'");mysql_query_cheat("INSERT INTO tbl_bonus SET amount='{$rebates}',accounts_id='{$row2['accounts_id']}',bonus_type='{$rowuser['accounts_id']}',refer_summary='$refersummary'");			}	mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos =  balance_pesos + {$row['maturity_amount']} WHERE accounts_id = '{$row['accounts_id']}'");	mysql_query_cheat("UPDATE tbl_buycode_history SET status = 1 WHERE id = '{$row['id']}'");}?>
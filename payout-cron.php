﻿<?phpinclude("connect.php");$startDate = date('Y-m-d');$query = "SELECT * FROM `tbl_buycode_history` WHERE `status` = '0' AND accounts_id!=0 AND maturity_date='$startDate'";$q = mysql_query_cheat($query);while($row = mysqli_fetch_array_cheat($q)){$quser = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='{$row['accounts_id']}'");$rowuser = mysqli_fetch_array_cheat($quser);			if($rowuser['refer']){			$q2 = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE username='{$rowuser['refer']}'");			$row2 = mysqli_fetch_array_cheat($q2);			$rebates = $row['maturity_amount'] * 0.05;			$refersummary = "5% From {$row['amount']} - {$rowuser['username']}";			$msg = "5% Maturity Bonus --{$rebates}-- Referral bonus given to {$row2['username']}";			saveLogs($rowuser['accounts_id'],$msg,$rowuser['username']);			mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos= balance_pesos + {$rebates} WHERE accounts_id='{$row2['accounts_id']}'");mysql_query_cheat("INSERT INTO tbl_bonus SET amount='{$rebates}',accounts_id='{$row2['accounts_id']}',bonus_type='{$rowuser['accounts_id']}',refer_summary='$refersummary'");			}	$balance_pesos_payout = $row['maturity_amount'] * 0.70;	$balance_wallet_payout = $row['maturity_amount'] * 0.30;$msg = "Payout off code {$row['code_value']}-{$row['code_pin']} TOTALAMT:{$row['maturity_amount']} E-wallet:{$balance_wallet_payout} USD:{$balance_pesos_payout}";saveLogs($rowuser['accounts_id'],$msg,$rowuser['username']);	mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos =  balance_pesos + {$balance_pesos_payout} WHERE accounts_id = '{$row['accounts_id']}'");	mysql_query_cheat("UPDATE tbl_accounts SET balance_wallet =  balance_wallet + {$balance_wallet_payout} WHERE accounts_id = '{$row['accounts_id']}'");	mysql_query_cheat("UPDATE tbl_buycode_history SET status = 1 WHERE id = '{$row['id']}'");}echo $date = date("l jS \of F Y h:i:s A");mysql_query_cheat("UPDATE tbl_cmsmanager SET cmsmanager_content = '{$date}' WHERE id = '42'");?>
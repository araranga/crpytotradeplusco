﻿<?phpinclude("connect.php");for ($x = 1; $x <= 4; $x++) {$startDate = date('Y-m-d');$mainc  = "c".$x;$stat = "c".$x."status";$amt = "c".$x."amount";$query = "SELECT * FROM `tbl_buycode_history` WHERE $stat != '1' AND accounts_id!=0 AND $mainc='$startDate'";$q = mysql_query_cheat($query);echo $query."<br>";$bypass = mysql_query_cheat('SELECT * FROM tbl_payrate');$payrates = array();while($bypassrow = mysqli_fetch_array_cheat($bypass)){	$payrates[$bypassrow['paydate']] = $bypassrow['payrate'];}while($row = mysqli_fetch_array_cheat($q)){$quser = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='{$row['accounts_id']}'");$rowuser = mysqli_fetch_array_cheat($quser);$check_rate = mysql_query_cheat("SELECT * FROM tbl_rate WHERE rate_id='".$row['package_id']."'");$check_row  = mysqli_fetch_array_cheat($check_rate);if(!empty($payrates[$startDate])){	$check_row['cycle'.$x] = $payrates[$startDate];}if($x==3){	$row['maturity_amount'] = ($row['amount'] * ($check_row['cycle'.$x] / 100)) + $row['amount'];}else{	$row['maturity_amount'] = ($row['amount'] * ($check_row['cycle'.$x] / 100));	}			if($rowuser['refer']){			$q2 = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE username='{$rowuser['refer']}'");			$row2 = mysqli_fetch_array_cheat($q2);			$rebates = $row['maturity_amount'] * 0.05;			$refersummary = "5% From {$row['amount']} - {$rowuser['username']}";			$msg = "5% Maturity Bonus --{$rebates}-- Referral bonus given to {$row2['username']}";			saveLogs($rowuser['accounts_id'],$msg,$rowuser['username']);			mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos= balance_pesos + {$rebates} WHERE accounts_id='{$row2['accounts_id']}'");mysql_query_cheat("INSERT INTO tbl_bonus SET amount='{$rebates}',accounts_id='{$row2['accounts_id']}',bonus_type='{$rowuser['accounts_id']}',refer_summary='$refersummary'");			}	$balance_pesos_payout = $row['maturity_amount'] * 1;	$balance_wallet_payout = $row['maturity_amount'] * 0;$msg = "Payout off code {$row['code_value']}-{$row['code_pin']} TOTALAMT:{$row['maturity_amount']} PHP:{$balance_pesos_payout} CYCLE:$x";saveLogs($rowuser['accounts_id'],$msg,$rowuser['username']);	mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos =  balance_pesos + {$balance_pesos_payout} WHERE accounts_id = '{$row['accounts_id']}'");	mysql_query_cheat("UPDATE tbl_accounts SET balance_wallet =  balance_wallet + {$balance_wallet_payout} WHERE accounts_id = '{$row['accounts_id']}'");	$mat = $row['maturity_amount'];	mysql_query_cheat("UPDATE tbl_buycode_history SET $stat = '1', $amt = '$mat'   WHERE id = '{$row['id']}'");}}echo $date = date("l jS \of F Y h:i:s A");mysql_query_cheat("UPDATE tbl_cmsmanager SET cmsmanager_content = '{$date}' WHERE id = '42'");?>
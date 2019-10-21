<?php
require_once("./connect.php");
$accounts_id = $_SESSION['accounts_id'];
$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");
$row = mysqli_fetch_array_cheat($q);
function trans()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 12; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

	if($_POST['submit']!='')
	{
		$balance_id = "balance";

		if($_POST['claimtype']=='bank'){
			$balance_id = "balance_pesos";
		}

		if($_POST['password']!=$row['password'])
		{
			$error .= "<i class=\"fa fa-warning\"></i>Password do not match.<br>";
		}
		if($_POST['withdraw']==0 || $_POST['withdraw']<0)
		{
						$error .= "<i class=\"fa fa-warning\"></i>Please input valid and not empty amount to withdraw.<br>";
		}
		if($_POST['withdraw']>$row[$balance_id]) 
		{
			$error .= "<i class=\"fa fa-warning\"></i>Amount to withdraw(".$_POST['withdraw'].") is insufficient on current balance(".$row['balance']."). Please input valid amount.<br>";
		}
		
		if($error=='')
		{
		$sum  = $row[$balance_id] - $_POST['withdraw'];
		mysql_query_cheat("UPDATE tbl_accounts SET $balance_id='".$sum."' WHERE accounts_id='$accounts_id'");
		$success = 1;
		$trans = trans();
		
		$fields = $_POST['fields'];
		
		$summary = '';
		foreach($fields as $keya=>$vala){
			$title = ucwords(str_replace("_"," ",$keya));
			$summary .= "$title : $vala \n";
		}
		//$summary = nl2br($summary);
		mysql_query_cheat("INSERT INTO tbl_withdraw_new_history SET summary='$summary',transnum='$trans',claimtype='".$_POST['claimtype']."',accounts_id='$accounts_id',new_balance='".$sum."',amount='".$_POST['withdraw']."',current_balance='".$row['balance']."'");
		$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");
		$row = mysqli_fetch_array_cheat($q);		
		}
	}
//
?>
<h2>Withdrawal Request</h2>   

<p>BTC Balance: (<?php echo $row['balance'];?>)</p>
<?php
if($error!='')
{
?>
<div class="warning"><ul class="fa-ul"><li><?php echo $error;?></li></ul></div>
<?php
}
?>

<?php
if($success!='')
{
?>
<div class="noti"><ul class="fa-ul"><li><i class="fa fa-check fa-li"></i>Done requesting for withdrawal please see status <a href='?page=withdrawhistory'>here</a> </li></ul></div>
<?php
}
?>
<?php
$payment = array();
//cebuana
$fields = array();
$fields['fullname'] = "Fullname";
$fields['address'] = "Address";
$fields['mobile'] = "Mobile";
$payment['cebuana'] = $fields;
//cebuana
$fields = array();
$fields['fullname'] = "Fullname";
$fields['address'] = "Address";
$fields['mobile'] = "Mobile";
$payment['lbc'] = $fields;	
//BPI
$fields = array();
$fields['fullname'] = "Fullname";
$fields['account_name'] = "Bank Name";
$fields['account_number'] = "Account Number";
$payment['bank'] = $fields;
//BDO
$fields = array();
$fields['account_name'] = "Account Name";
$fields['account_number'] = "Account Number";
$payment['bank_bdo'] = $fields;


$fields = array();
$fields['account_number'] = "BTC Address";
$payment['btc'] = $fields;


?>

<?php
	foreach($payment as $paychildkey=>$paychild){
		echo "<table id='$paychildkey' style='display:none;'>";
		foreach($paychild as $pkey=>$pval){	
				?>
				 <tr class='antibug'>
					<td style="width:180px;" class="key" valign="top"><label for="accounts_name"><?php echo $pval; ?>:</label></td>
					<td>
					   <input style="width: 302px;" required="" type="text" name="fields[<?php echo $pkey; ?>]" id="withdraw" size="40" maxlength="255" value="">
					   <span class="validation-status"></span>												
					</td>
				 </tr>				
				<?php
		}
		echo "</table>";
	}
?>


<form method="POST" action="">
   <table width="100%">
      <tbody>

         <tr>
            <td style="width:180px;" class="key" valign="top"><label for="accounts_name">Widrawal Type</label></td>
            <td>
				<select id='claimtypeid' name='claimtype' onchange="widraw(this.value)" required>
						<!-- <option value='bank'>Bank Deposit</option> -->
						<option value='btc' selected='selected'>BTC</option>
				</select>											
            </td>
         </tr>
	</table>
		 <table id='optionspayment'>
		 </table>  
   <table id='defaultfield' width="100%" style='display:none;'>
      <tbody>					 
        <tr class='antibug'>
            <td style="width:180px;" class="key" valign="top"><label for="accounts_name">Amount to withraw:</label></td>
            <td>
               <input style="width: 302px;" required="" type="float" name="withdraw" id="withdraw" size="40" maxlength="255" value="">
               <span class="validation-status"></span>												
            </td>
         </tr>
		 
         <tr class="antibug">
            <td style="width:180px;" class="key" valign="top"><label for="accounts_name">Please enter password:</label></td>
            <td>
               <input style="width: 302px;" required="" type="password" name="password" id="password" size="40" maxlength="255" value="">
               <span class="validation-status"></span>												
            </td>
         </tr>
      </tbody>
   </table>
 
   <br>
   <center><input class="btn btn-primary btn-lg" type="submit" name="submit" value="Process"></center>
</form>
<script>
	jQuery('#claimtypeid').trigger('change');
function widraw(myval)
{
	if(myval){
		jQuery('#defaultfield').show();
	}else{
		jQuery('#defaultfield').hide();
	}

	jQuery('#optionspayment').html('');
	jQuery('#optionspayment').html(jQuery('#'+myval).html());

}
</script>
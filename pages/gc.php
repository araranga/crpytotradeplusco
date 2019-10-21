<?php
require_once("./connect.php");
$accounts_id = $_SESSION['accounts_id'];
$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");
$row = mysqli_fetch_array_cheat($q);

#var_dump($row);
function pin()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 7; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

	if($_POST['submit']!='')
	{
	$check_rate = mysql_query_cheat("SELECT * FROM tbl_rate WHERE rate_id='".$_POST['rate']."'");
	$check_row  = mysqli_fetch_array_cheat($check_rate);
	$check_row_main = $check_row;
	$check_row['rate_start'] = $_POST['amount'];
		if($_POST['password']!=$row['password'])
		{
						$error .= "<i class=\"fa fa-warning\"></i>Password incorrect!.<br>";
		}
		
		if($check_row['rate_start']>$row[$_POST['balancetype']])
		{
			$error .= "<i class=\"fa fa-warning\"></i>Insufficient Funds!.<br>";
		}


		if($check_row_main['rate_start']>$_POST['amount'])
		{
			$error .= "<i class=\"fa fa-warning\"></i>Mininum amount for this course is {$check_row_main['rate_start']}.<br>";
		}
		if($check_row_main['rate_end']<$_POST['amount'])
		{
			$error .= "<i class=\"fa fa-warning\"></i>Maximum amount for this course is {$check_row_main['rate_end']}.<br>";
		}



		if($_POST['amount']==0 || $_POST['amount']<0)
		{
						$error .= "<i class=\"fa fa-warning\"></i>Please input valid and not empty amount to fund.<br>";
		}

		if($error=='')
		{
		$current_balance  = $row['balance_pesos'] - $check_row['rate_start'];
		$rebates = $check_row['rate_start'] * 0.05;
		$code_pin = pin();
		$code_value = pin();
		$code_package = $_POST['rate'];
		$code_referrer = $accounts_id;
		mysql_query_cheat("INSERT INTO tbl_code SET code_value='$code_value',code_package='$code_package',code_pin='$code_pin',code_referrer='$code_referrer',activated='1'");

		mysql_query_cheat("UPDATE tbl_accounts SET {$_POST['balancetype']} = {$_POST['balancetype']} -  {$check_row['rate_start']} WHERE accounts_id='$accounts_id'");
		
		//rebates
		//history
		$package_id = $check_row['rate_id'];
		$package_summary = $check_row['rate_name']. " - ".$check_row['rate_start'];



		$startDate = date('Y-m-d');
		$wDays = $check_row_main['days'];
		$new_date = date('Y-m-d', strtotime("{$startDate} +{$wDays} weekdays"));

		$maturity_amount = (($check_row_main['maturity'] / 100) * $check_row['rate_start']) + $check_row['rate_start'];

$buycodeaccounts_id = 0;

if($row['refer'] && $_POST['datatype']=='yes'){
	$buycodeaccounts_id = $accounts_id;
	$refersummary = "5% From {$check_row['rate_start']} - {$row['username']}";

$q2 = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE username='{$row['refer']}'");
$row2 = mysqli_fetch_array_cheat($q2);
mysql_query_cheat("INSERT INTO tbl_bonus SET amount='$rebates',accounts_id='{$row2['accounts_id']}',bonus_type='{$row['accounts_id']}',refer_summary='$refersummary'");
mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos= balance_pesos + $rebates WHERE accounts_id='{$row2['accounts_id']}'");

}



mysql_query_cheat("INSERT INTO tbl_buycode_history SET package_id='$package_id',package_summary='$package_summary',accounts_id='$buycodeaccounts_id',position='$accounts_id',code_pin='$code_pin',code_value='$code_value',rebates='$rebates',maturity_date='$new_date',amount='{$check_row['rate_start']}',maturity_amount='$maturity_amount'");



		$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");
		$row = mysqli_fetch_array_cheat($q);	
		$success = "Here is the reference: $code_value-$code_pin";
		}
	}



$package_query = mysql_query_cheat("SELECT * FROM tbl_rate WHERE activated='1' AND rate_bet!=2");	
$arr = array();
$package_description = array();
while($row_package = mysqli_fetch_array_cheat($package_query))
{
	$arr[$row_package['rate_id']] = $row_package['rate_name']; 
}

$own = array();

$own['yes'] = "Use in my account funding.";
$own['no'] = "Provide codes and able to send to others.";


$own2 = array();

$own2['balance_pesos'] = "USD Balance.";
$own2['balance_wallet'] = "E-wallet";
	
$field[] = array("type"=>"select","value"=>"rate","label"=>"Choose Your Package","option"=>$arr);
$field[] = array("type"=>"select","value"=>"datatype","label"=>"Choose your purpose","option"=>$own);
$field[] = array("type"=>"select","value"=>"balancetype","label"=>"Which account to deduct","option"=>$own2);
$field[] = array("type"=>"text","value"=>"amount","label"=>"Enter Amount");
$field[] = array("type"=>"password","value"=>"password","label"=>"Enter Password");
//
?>
<h2>Buy Courses</h2>
<div class='coursebox' style='background-color:green;font-weight:700;'>
<p>Balance USD: <?php echo $row['balance_pesos'];?></p>
<p>Balance E-Wallet: <?php echo $row['balance_wallet'];?></p>
</div>
<style>
.coursebox{
	padding: 20px;
    background-color: #2196F3;
    color: white;
    margin-bottom: 15px;
}
</style>   
<div class='coursebox'>
	<?php 
	$package_query = mysql_query_cheat("SELECT * FROM tbl_rate WHERE activated='1' AND rate_bet!=2");	
	while($row_packagex = mysqli_fetch_array_cheat($package_query))
	{
		?>
	<span style='font-weight:700;'><?php echo $row_packagex['rate_name']; ?>
		- Minimum is $<?php echo $row_packagex['rate_start']; ?> and Maximum off $<?php echo $row_packagex['rate_end']; ?> with maturity rate of <?php echo $row_packagex['maturity']; ?>% after <?php echo $row_packagex['days']; ?> business days.
	</span><br/>
		<?php
	}
	?>
</div>
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
<div class="noti"><ul class="fa-ul"><li><i class="fa fa-check fa-li"></i>
<?php echo $success; ?>
</li></ul></div>
<?php
}
?>



<form method='POST' action=''>
<table width="100%">
						<?php
						$is_editable_field = 1;
						foreach($field as $inputs)
						{
												if($inputs['label']!='')
												{
												$label = $inputs['label'];
												}
												else
												{
												$label = ucwords($inputs['value']);
												}
						?>
									<!---weee--->
										<tr>
											<td style="width:180px;" class="key" valign="top" ><label for="accounts_name"><?php echo $label; ?><?php echo $req_fld?>:</label></td>
											<?php if ( $is_editable_field ) { ?>
											<td>
											<?php
											if ($inputs['type']=='select')
											{
												if($$inputs['value']!='' && $inputs['value']=='code_id')
												{ 
												//
												}
												else
												{
													
												
											
												?>
												<select name="<?php echo $inputs['value']; ?>" id="<?php echo $inputs['value']; ?>" required <?php echo $inputs['attr']; ?>>
												<?php
												foreach($inputs['option'] as $key=>$val)
												{
													?>
													<option <?php if($$inputs['value']==$val){echo"selected='selected'";} ?> value='<?php echo $key;?>'><?php echo $val;?></option>
													<?php
												}
												?>
												</select>
												<span class="validation-status"></span>
												<?php
												}
											}
											else
											{
												?>
												<input required <?php echo $inputs['attr']; ?> type="<?php echo $inputs['type']; ?>" name="<?php echo $inputs['value']; ?>" id="<?php echo $inputs['value']; ?>" size="40" maxlength="255" value="<?php echo $$inputs['value']; ?>" />
												<span class="validation-status"></span>												
												<?php
											}
											?>

											</td>
											<?php } else { ?>
											<td><?php echo $$inputs['value']; ?></td>
											<?php } ?>                                                                                                    
										</tr>
						<?php
						}
						?>
</table>
<br/>
<center><input class='btn btn-primary btn-lg' type='submit' name='submit' value='Process'></center>
</form>


<hr>
<?php
$qnotuse = mysql_query_cheat("SELECT * FROM tbl_buycode_history WHERE position='{$_SESSION['accounts_id']}' AND accounts_id = 0");
$counternotsure = mysqli_num_rows($qnotuse);

if(!empty($counternotsure)){
	?>
	<h3>Available Codes</h3>
	<?php


	?>
	<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
		   <th>Codes</th>
           <th>Amount</th>
           <th>Other Data</th>
        </tr>
    </thead>
    <tbody>
<?php
while($rowqnotuse = mysqli_fetch_array_cheat($qnotuse)){
	$check_rate = mysql_query_cheat("SELECT * FROM tbl_rate WHERE rate_id='".$rowqnotuse['package_id']."'");
	$check_row  = mysqli_fetch_array_cheat($check_rate);


	?>
        <tr>
		   <td><?php echo $rowqnotuse['code_value']; ?>-<?php echo $rowqnotuse['code_pin']; ?></td>
           <td><?php echo $rowqnotuse['amount']; ?></td>
           <td>
           	Package Name: <?php echo $check_row['rate_name']; ?><br>
           	Maturity Rate: <?php echo $check_row['maturity']; ?>%<br>
           	Maturity Days: <?php echo $check_row['days']; ?><br>
           	
           </td>
        </tr>
	<?php
}
?>

    </tbody>
</table>
	<?php
}
?>
﻿<?phprequire_once("./connect.php");$accounts_id = $_SESSION['accounts_id'];$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");$row = mysqli_fetch_array_cheat($q);	if($_POST['submit']!='')	{		if($_POST['amount']==0 || $_POST['amount']<0)		{			$error .= "<i class=\"fa fa-warning\"></i>Please input valid and not empty amount to convert.<br>";		}			if(countfield("username",$_POST['target'])==0)		{			$error .= "Referral username is not existing please enter valid one!.<br/>";		}		if($_POST['old_password']!=$_SESSION['password'])		{			$error .= "<i class=\"fa fa-warning\"></i>Please input the current password correctly.<br>";		}		if($row['balance_pesos']<$_POST['amount'])		{			$error .= "<i class=\"fa fa-warning\"></i>Insufficient Funds!.<br>";		}				if($error=='')		{			$amount = $_POST['amount'];mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos= balance_pesos - $amount WHERE accounts_id='{$_SESSION['accounts_id']}'");	mysql_query_cheat("UPDATE tbl_accounts SET balance_pesos= balance_pesos + $amount WHERE username='{$_POST['target']}'");					$success = "Sucessfully Transfered {$amount} to Username: {$_POST['target']}";$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");$row = mysqli_fetch_array_cheat($q);		}	}$field[] = array("type"=>"text","value"=>"target","label"=>"To Username");$field[] = array("type"=>"text","value"=>"amount","label"=>"Amount");$field[] = array("type"=>"password","value"=>"old_password","label"=>"Enter Password");if($error!=''){?><div class="warning"><ul class="fa-ul"><li><?php echo $error;?></li></ul></div><?php}?><?phpif($success!=''){?><div class="noti"><ul class="fa-ul"><li><i class="fa fa-check fa-li"></i><?php echo $success;?></li></ul></div><?php}?><form method='POST' action='' class="form-container fundtransfer">	<div class="npage-header">		<h2>Fund Transfer</h2>  	</div>	<div class="amount-box user-balance">		<ul class="amount-box-list">			<li>				<i class="icon-dollar"></i>				<span><em>Dollar</em> <?php echo "$".number_format($row['balance_pesos'],2);?></span>			</li>		</ul>	</div>	<div class="col-grp">		<?php			$is_editable_field = 1;			foreach ( $field as $inputs ) {							if ( $inputs['label'] != '' ) {					$label = $inputs['label'];				} else {					$label = ucwords($inputs['value']);				}		?>		<!---weee--->											<!-- <td style="width:180px;" class="key" valign="top" ><label for="accounts_name"><?php echo $label; ?><?php echo $req_fld?>:</label></td> -->					<?php 						if ( $is_editable_field ) {							echo '<div class="col col-12">';							if ( $inputs['type'] == 'select' ) {								if ( $$inputs['value'] != '' && $inputs['value'] == 'code_id' ) { 									$code = $$inputs['value'];									$codeqq = mysql_query_cheat("SELECT * FROM tbl_code as a JOIN tbl_rate as b JOIN tbl_accounts as c WHERE c.code_id=a.code_value AND a.code_value='$code' AND a.code_package=b.rate_id");									$coderow = mysqli_fetch_array_cheat($codeqq);									//asds									echo "Package Name"." : ".$coderow['rate_name'];									echo "<br>";									echo "Registration FEE"." : ".$coderow['rate_start'];									echo "<br>";									echo "Salary"." : ".$coderow['rate_end'];									echo "<br>";									echo "Code Value - Code Pin"." : ".$coderow['code_value']." - ".$coderow['code_pin'];									echo "<br><br>";									echo "Total Earnings"." : ".$coderow['total_earnings'];									echo "<br>";									echo "Current Balance"." : ".$coderow['balance']; 									//								} else {					?>									<select name="<?php echo $inputs['value']; ?>" id="<?php echo $inputs['value']; ?>" required <?php echo $inputs['attr']; ?>>										<?php											foreach ( $inputs['option'] as $val ) {										?>											<option <?php if($$inputs['value']==$val){echo"selected='selected'";} ?> value='<?php echo $val;?>'><?php echo $val;?></option>										<?php											}										?>									</select>									<span class="validation-status"></span>					<?php								}							} else {					?>								<input placeholder="<?php echo $label; ?>" required <?php echo $inputs['attr']; ?> type="<?php echo $inputs['type']; ?>" name="<?php echo $inputs['value']; ?>" id="<?php echo $inputs['value']; ?>" size="40" maxlength="255" value="<?php echo $$inputs['value']; ?>" />								<span class="validation-status"></span>																	<?php							}					?>					<?php							echo '</div>'; 						} else { 					?>							<div class="col col-12"><?php echo $$inputs['value']; ?></td>					<?php 						} 					?>                                                                                                    										</tr>			<?php			}			?>	</div>	<div class="action"><input class='nbtn nbtn-primary' type='submit' name='submit' value='Update'></div></form>
<?php
require_once("./connect.php");
$accounts_id = $_SESSION['accounts_id'];
$q = mysql_query_cheat("SELECT * FROM tbl_accounts WHERE accounts_id='$accounts_id'");
$row = mysqli_fetch_array_cheat($q);

$row1 = mysqli_fetch_array_cheat(mysql_query_cheat("SELECT SUM(amount) as sum FROM tbl_bonus WHERE accounts_id='$accounts_id' AND bonus_type='rb'"));
$row2 = mysqli_fetch_array_cheat(mysql_query_cheat("SELECT SUM(amount) as sum FROM tbl_bonus WHERE accounts_id='$accounts_id' AND bonus_type='rf'"));
$row3 = mysqli_fetch_array_cheat(mysql_query_cheat("SELECT SUM(amount) as sum FROM tbl_withdraw_new_history WHERE accounts_id='$accounts_id'"));


$row4 = mysqli_fetch_array_cheat(mysql_query_cheat("SELECT SUM(amount) as sum FROM tbl_bonus WHERE accounts_id='$accounts_id'"));


if($row[''])


?>
<h1>Your Timeline</h1>
<div class="row">

			<div class="col-lg-12 col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Your Referral Link
					</div>
					<div class="panel-body">
						<?php
							$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/index.php?page=register&refer=".$_SESSION['accounts_id']."-".md5($_SESSION['username']);
						?>	
						<p><?php echo $actual_link; ?></p>
					</div>
				</div>
			</div>	



			<div class="col-lg-12 col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Available Balance (BTC)
					</div>
					<div class="panel-body">
						<p>₿<?php echo number_format($row['balance'],7); ?></p>
					</div>
				</div>
			</div>	

			<div class="col-lg-12 col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Available Balance (Dollar)
					</div>
					<div class="panel-body">
						<p>$<?php echo number_format($row['balance_pesos'],2); ?></p>
					</div>
				</div>
			</div>	

			<div class="col-lg-12 col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Available Balance (E-Wallet)
					</div>
					<div class="panel-body">
						<p>$<?php echo number_format($row['balance_wallet'],2); ?></p>
					</div>
				</div>
			</div>	



			<div class="col-lg-12 col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Total Withdrawals
					</div>
					<div class="panel-body">
						<p>₿<?php echo number_format($row3['sum'],7); ?>
					</div>
				</div>
			</div>	

			<div class="col-lg-12 col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Total Direct Referrals
					</div>
					<div class="panel-body">
						<p>$<?php echo number_format($row4['sum'],2); ?></p>
					</div>
				</div>
			</div>	


						
</div>
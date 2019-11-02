<header id="dashboard-header">
	<a class="logo" href='index.php?page=home'>
		<img src='logo2.png' class='aimtoberich'>
	</a>
	<?php if ( $_SESSION['loggedin'] ) { ?>
	<div class="myaccount">
		<span class="nbtn nbtn-primary"><i class="icon-user"></i> My Account <i class="icon-chevron-small-down"></i></span>
		<ul>
			<li><a href="index.php?page=editprofile">Edit Profile</a></li>   
			<li><a href="index.php?page=changepass">Change Password</a></li>
			<li><a href="index.php?page=withdrawhistory">Withdrawal History</a></li>
			<li><a href="index.php?page=timeline">My Timeline</a></li>  
			<li><a href="index.php?page=security">Security</a></li>  
			<li><a href="index.php?page=rebate">Referrals</a></li>  
			<li><a href="index.php?page=codeactivate">Code Activate</a></li>  
		</ul>
	</div>
	<?php } ?>
	<nav>
		<div>
			<ul id="main-menu">
					
			<?php

				if ( $_SESSION['loggedin'] ) {
					$query 	= 'SELECT SUM(amount) as sums FROM tbl_buycode_history WHERE accounts_id = '.$_SESSION['accounts_id'];
					$q 		= mysql_query_cheat($query);
					$row 	= mysqli_fetch_array_cheat($q);
					$sums  	= $row['sums'];	

					if ( empty($sums) ) { $sums = 0; }	
					//SELECT rate_name,rate_id FROM `tbl_rate` WHERE rate_start <= 2499					
						$qrate= mysql_query_cheat("SELECT rate_name,rate_id FROM `tbl_rate` WHERE rate_start <= $sums");
			?>

				<li><a href="index.php?page=home" ><i class="icon-megaphone"></i>Announcement</a></li>	
				<li>
					<a href="#" ><i class="icon-book"></i>Trading Courses</a>
					<ul>
					<?php while ( $rowx = mysqli_fetch_array_cheat($qrate) ) { ?>
						<li><a href="index.php?page=tutorials&id=<?php echo $rowx['rate_id']; ?>"><?php echo $rowx['rate_name']; ?></a></li>
					<?php } ?>
					</ul>
				</li>					
				<li>
					<a href="#" ><i class="icon-cycle"></i>Convert</a>
					<ul>
						<li><a href="index.php?page=convert" >BTC to USD</a></li>
						<li><a href="index.php?page=convertpesos" >USD to BTC</a></li>
						<li><a href="index.php?page=convertwallet" >USD to E-wallet</a></li>
						<li><a href="index.php?page=fundtransfer" >Fund Transfer</a></li>
					</ul>
				</li>
				<li><a href="index.php?page=personalentity" ><i class="icon-price-tag"></i>My Products</a></li>
				<!--<li><a href="index.php?page=reentry" ><i class="fa fa-pencil-square-o"></i>Add Entry</a></li>-->
				<li><a href="index.php?page=gc" ><i class="icon-shopping-basket"></i>Purchase Products</a></li>					
				<li><a href="index.php?page=btcwallet" ><i class="icon-share-alternitive"></i>Deposit</a></li>	
				<li><a href="index.php?page=transaction" ><i class="icon-shield"></i>Verify My Deposit</a></li>	
				<li><a href="index.php?page=withdrawal" ><i class="icon-dollar"></i>Withdrawal</a></li>
				<li><a href="index.php?page=signout" ><i class="icon-log-out"></i>Logout</a></li>

			<?php
				} else {
			?>

				<li><a href="index.php?page=signin" ><i class="fa fa-sign-in"></i>Login</a></li>
				<li><a href="index.php?page=register" ><i class="fa fa-user"></i>Register</a></li>

			<?php
				}
			?>

			</ul>
		</div>

    </nav> 

</header>
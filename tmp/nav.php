        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
					
			
					<?php

					if($_SESSION['loggedin']){


					$query = 'SELECT SUM(amount) as sums FROM tbl_buycode_history WHERE accounts_id = '.$_SESSION['accounts_id'];

					$q = mysql_query_cheat($query);

					$row = mysqli_fetch_array_cheat($q);

					 $sums  = $row['sums'];		

					//SELECT rate_name,rate_id FROM `tbl_rate` WHERE rate_start <= 2499					
							

						$qrate= mysql_query_cheat("SELECT rate_name,rate_id FROM `tbl_rate` WHERE rate_start <= $sums");
					?>
                    <li>
                        <a href="index.php?page=home" ><i class="fa fa-desktop"></i>News & Announcement</a>
                    </li>	
                    <li>
                        <a href="#" ><i class="fa fa-book"></i>Tutorials</a>
                        <ul>
                        	<?php
                        		while($rowx = mysqli_fetch_array_cheat($qrate)){
                        			?>

										<li>
											<a href="index.php?page=tutorials&id=<?php echo $rowx['rate_id']; ?>"><i class="fa fa-pencil-square-o"></i><?php echo $rowx['rate_name']; ?></a>
										</li>

                        			<?php
                        		}
                        	?>

                        </ul>
                    </li>	

					<li>
						<a href="#" ><i class="fa fa-user"></i>My Account</a>
						<ul>
							<li>
								<a href="index.php?page=editprofile" ><i class="fa fa-pencil-square-o"></i>Edit Profile</a>
							</li>   
							<li>
								<a href="index.php?page=changepass" ><i class="fa fa-pencil-square-o"></i>Change Password</a>
							</li>
							<li>
								<a href="index.php?page=withdrawhistory" ><i class="fa fa-pencil-square-o"></i>Withdrawal History</a>
							</li>
							<li>
								<a href="index.php?page=timeline" ><i class="fa fa-trophy"></i>My Timeline</a>
							</li>  
							<li>
								<a href="index.php?page=security" ><i class="fa fa-lock"></i>Security</a>
							</li>  
							<li>
								<a href="index.php?page=rebate" ><i class="fa fa-columns"></i>Referrals</a>
							</li>  	


						</ul>
						
						
					</li>					
	
                    <li>
                        <a href="index.php?page=convert" ><i class="fa fa-bank"></i>Convert</a>
                    </li>


					<li>
						<a href="index.php?page=personalentity" ><i class="fa fa-database"></i>Funding Accounts</a>
					</li>
<!-- 					<li>
						<a href="index.php?page=reentry" ><i class="fa fa-pencil-square-o"></i>Add Entry</a>
					</li>   
				 -->
					<li>
						<a href="index.php?page=gc" ><i class="fa fa-qrcode"></i>Margin Funding</a>
					</li>					
					<li>
						<a href="#" ><i class="fa fa-send"></i>Deposit</a>
						<ul>
							<li>
								<a href="index.php?page=btcwallet" ><i class="fa fa-send"></i>BTC Wallet</a>
							</li>  
						</ul>
					</li>	
					<li>
						<a href="index.php?page=withdrawal" ><i class="fa fa-money"></i>Withdrawal</a>
					</li>
					<li>
						<a href="index.php?page=transaction" ><i class="fa fa-bank"></i>Transaction</a>
					</li>					
					<li>
						<a href="index.php?page=signout" ><i class="fa fa-sign-out"></i>Logout</a>
					</li>
					
					
						
					<?php
						}
						else
						{
							
					?>
					
					<li>
						<a href="index.php?page=signin" ><i class="fa fa-sign-in"></i>Login</a>
					</li>
					<li>
						<a href="index.php?page=register" ><i class="fa fa-user"></i>Register</a>
					</li>		
					<?php
						}
					?>

					
					
                </ul>
                            </div>

        </nav>  
<?phpsession_start();require_once("../connect.php");require_once("../function.php");$rate = $_REQUEST['packages'];//tbl_code//tbl_bet$query = "SELECT * FROM tbl_bet";$qbets = mysql_query_cheat($query);?><style>.mainectable > div > div {    border: 1px solid #ccc1c1 ;}.mainectable > div {	display: inline-table;	width: 25%;	}.mainectable > div > div { 	background: linear-gradient(-35deg,white 15px, #ccc1c1 15px,white 19px, white 3px);	}.mainectable {	width: 500px;    margin: 0 auto;}.pilina{	background: grey!important;}</style><h1 style='text-align:center;'>Select your number</h1><div class="mainectable">										<?php 											$countbet = 0;																						$start1 = array("1", "26", "51", "76");											while($qbetsrow=mysqli_fetch_array_cheat($qbets)){											$getbetter = mysql_query_cheat("SELECT b.username FROM tbl_code as a JOIN tbl_accounts as b WHERE code_package='".$rate."' AND a.code_owner=b.accounts_id AND a.code_bet='".$qbetsrow['bet_id']."'");											$rowgetbetter = mysqli_fetch_array_cheat($getbetter);													$countbet++;																					if (in_array($countbet, $start1)){																								echo "<div class='col' data-content='$countbet'>";											}																																?>											<div  class='pantay <?php if($rowgetbetter['username']){ echo "pilina"; } ?>' data-content='<?php echo $countbet; ?>'>  												<span><?php echo $qbetsrow['bet_value'][0];?>-<?php echo $qbetsrow['bet_value'][1];?></span>												<?php if(!$rowgetbetter['username']){ ?>																									<input type='radio' onclick="jQuery('#betset').val('<?php echo $qbetsrow['bet_id'];?>')" name='bet' value='<?php echo $qbetsrow['bet_id'];?>'/>												<?php } ?>											</div>										<?php											if($countbet==25){												echo "</div>";											}											if($countbet==50){												echo "</div>";											}																																if($countbet==75){												echo "</div>";											}											if($countbet==100){												echo "</div>";											}												}										?>		</div>
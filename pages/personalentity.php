<?php
require_once("./connect.php");
$accounts_id = $_SESSION['accounts_id'];
$accounts_id = $_SESSION['accounts_id'];
$query = "SELECT * FROM tbl_buycode_history as a 
JOIN tbl_accounts as b 
WHERE a.accounts_id=b.accounts_id  
AND a.accounts_id='$accounts_id'
";
$q = mysql_query_cheat($query);


function dateDiff($d1){
    $date1=strtotime($d1);
    $date2=strtotime(date("Y-m-d h:i:sa"));
    $seconds = $date1 - $date2;
    $weeks = floor($seconds/604800);
    $seconds -= $weeks * 604800;
    $days = floor($seconds/86400);
    $seconds -= $days * 86400;
    $hours = floor($seconds/3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds/60);
    $seconds -= $minutes * 60;
    $months=round(($date1-$date2) / 60 / 60 / 24 / 30);
    $years=round(($date1-$date2) /(60*60*24*365));
    $diffArr=array("Seconds"=>$seconds,
                  "minutes"=>$minutes,
                  "Hours"=>$hours,
                  "Days"=>$days,
                  "Weeks"=>$weeks,
                  "Months"=>$months,
                  "Years"=>$years
                 ) ;
   return $diffArr;
}


$monthly = "amount,maturity_date,maturity_amount";
?>
<style>
.timers{
  padding: 10px;
    background: green;
    color: white;
    font-weight: bolder;
    width: 154px;
}
</style>

<h2>My Products</h2>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
			     <th>My Product Database</th>
           <th>Other Status</th>
        </tr>
    </thead>
    <tbody>
		<?php
			while($row=mysqli_fetch_array_cheat($q)){		

        #var_dump($row);
				//var_dump(dateDiff($row['history']));
		?>
        <tr>
			<td><?php echo $row['package_summary']; ?></td>

      <td>
          <?php

          



              if($row['package_id']==6){
                  $textdata = $monthly;
              }else{
                 $textdata = $monthly;
              }


              $row['maturity_amount'] = "$".number_format($row['maturity_amount'],2);
              $row['amount'] = "$".number_format($row['amount'],2);


              foreach(explode(",",$textdata) as $text){

                  if(empty($row[$text])){
                    $row[$text] = "N/A";
                  }




                  echo str_replace("_"," ",ucwords($text))." :{$row[$text]}<br>";
              }



              $date = date("M j, Y H:i:s",strtotime($row['maturity_date']));

              if(empty($row['status'])){
          ?>
<script>
// Set the date we're counting down to
var countDownDate<?php echo $row['id']; ?> = new Date("<?php echo $date; ?>").getTime();

// Update the count down every 1 second
var x<?php echo $row['id']; ?> = setInterval(function() {

  // Get today's date and time
  var now<?php echo $row['id']; ?> = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance<?php echo $row['id']; ?> = countDownDate<?php echo $row['id']; ?> - now<?php echo $row['id']; ?>;
    
  // Time calculations for days, hours, minutes and seconds
  var days<?php echo $row['id']; ?> = Math.floor(distance<?php echo $row['id']; ?> / (1000 * 60 * 60 * 24));
  var hours<?php echo $row['id']; ?> = Math.floor((distance<?php echo $row['id']; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes<?php echo $row['id']; ?> = Math.floor((distance<?php echo $row['id']; ?> % (1000 * 60 * 60)) / (1000 * 60));
  var seconds<?php echo $row['id']; ?> = Math.floor((distance<?php echo $row['id']; ?> % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo<?php echo $row['id']; ?>").innerHTML = days<?php echo $row['id']; ?> + "d " + hours<?php echo $row['id']; ?> + "h "
  + minutes<?php echo $row['id']; ?> + "m " + seconds<?php echo $row['id']; ?> + "s ";
    
  // If the count down is over, write some text 
  if (distance<?php echo $row['id']; ?> < 0) {
    clearInterval(x<?php echo $row['id']; ?>);
    document.getElementById("demo<?php echo $row['id']; ?>").innerHTML = "Please wait for the system we are generating your payout.";
  }
}, 1000);
</script>
<hr>
Countdown to maturity:<p id="demo<?php echo $row['id']; ?>" class="timers">Loading...</p>

<?php

}
else{
  echo "Status: Completed";
}

?>
      </td>
        </tr>
		<?php
			}
		?>
    </tbody>
</table>
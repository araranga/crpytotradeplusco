﻿<?phpsession_start();require_once("./connect.php");$accounts_id = $_SESSION['accounts_id'];$q = mysql_query_cheat("SELECT * FROM tbl_bonus WHERE accounts_id='$accounts_id'");?><div class="npage-header">    <h2>Referral Logs</h2>    <p>Phasellus tincidunt est vel luctus elementum. Pellentesque pellentesque arcu nunc, eu porta mauris ultricies eu.</p></div><div class="ntable">    <table>        <thead>            <tr>                <th>Direct Referral</th>                <th>Amount</th>            </tr>        </thead>        <tbody>		<?php		while($row=mysqli_fetch_array_cheat($q)) {		?>            <tr>                <td><?php echo $row['refer_summary']; ?></td>                <td><?php echo "$".number_format($row['amount'],2); ?></td>            </tr>		<?php		}		?>        </tbody>    </table></div>   
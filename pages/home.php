<?php
require_once("./connect.php");
$query = "SELECT * FROM tbl_bannermanager";
$q = mysql_query_cheat($query);
?>
<!-- <style>
.mainectable > div > div {
    border: 1px solid #ccc1c1 ;
}
.mainectable > div {
	display: inline-table;
	width: 25%;
	
}
.mainectable > div > div { 
	background: linear-gradient(-35deg,white 15px, #ccc1c1 15px,white 19px, white 3px);
	
}
</style> -->
<div class="npage-header">
	<h2>Announcements</h2>
</div>
<?php
if ( $query ) :
	echo '<div class="announcements">';
	while($row=mysqli_fetch_array_cheat($q)) {
		$excerpt = $row['bannermanager_content'];
		//$excerpt = substr($excerpt, 0, 280);
?>
		<div class="announcement-item">
			<span class="ai-photo" style="background-image:url(adminpage/media/<?php echo $row['bannermanager_image_large']; ?>)"></span>
			<h3><?php echo $row['bannermanager_title']; ?></h3>
			<?php echo $excerpt; ?>
		</div>
<?php
	}
	echo '</div>';
endif;
?>


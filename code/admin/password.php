<?php 
include('config.php');
	//echo md5('123');
	
	$query = "select * from album where album.`type` = ''";

$result = mysqli_query($db,$query);

  $rows = array();
  while($r = mysqli_fetch_array($result)) {
    $rows['albums'][] = $r;
  }
echo json_encode($rows);
?>
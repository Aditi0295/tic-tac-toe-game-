<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	
	require_once('dbconfig.php');


	$database=new Database();
	$db=$database->getDbConnection();

	$sql="SELECT * FROM game_session";

	$result=mysqli_query($db,$sql);
	$item=array();

	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			array_push($item, $row);
		}
	}
	else{
		
	}
	
	//echo "event: abhishek\n";
	sleep(1);
	echo "data: ".json_encode($item)."\n\n";
	
	ob_end_flush();
	flush();
	
?>
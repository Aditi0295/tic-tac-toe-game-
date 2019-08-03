<?php

	require_once('dbconfig.php');
	
	class GameManager
	{
		private $db;
		
		function __construct()
		{
			$database=new Database();
			$this->db=$database->getDbConnection();
		}

		function checkExistance($gid){

			$query="SELECT * FROM game_session WHERE sid='$gid'";

			$result=mysqli_query($this->db,$query);

			if(mysqli_num_rows($result)>0){
				return true;
			}
			else{
				return false;
			}
		}

		function createGameSession($gid){

			$query="INSERT INTO game_session(sid,p1_turn,p2_turn,p1_engage,p2_engage) VALUES('$gid','yes','no','yes','no')";

			$result=mysqli_query($this->db,$query);

			if($result){
				return true;
			}
			else{
				return false;
			}
		}

		function getGameSessionDetail($gid){
			$query="SELECT * FROM game_session WHERE sid='$gid'";

			$result=mysqli_query($this->db,$query);

			if(mysqli_num_rows($result)>0){
				$data = mysqli_fetch_assoc($result);
				return $data;
			}
			else{
				return false;
			}
		}

		function hitBlock($sid,$block,$player){

			$query="UPDATE game_session SET $block='$player' WHERE sid='$sid'";

			$result=mysqli_query($this->db,$query);

			if($result){

				$next_turn="";

				if($player=='p1'){
					$next_turn='p2';
				}
				else{
					$next_turn='p1';
				}

				$query="UPDATE game_session SET $player"."_turn='no'".",$next_turn"."_turn='yes' WHERE sid='$sid'";

				$result=mysqli_query($this->db,$query);

				return json_encode(array("success"=>true));
			}
			else{
				return json_encode(array("success"=>false));	
			}
		}

		function engageSecondPlayer($sid){

			$query="UPDATE game_session SET p2_engage='yes' WHERE sid='$sid'";

			$result=mysqli_query($this->db,$query);

			if($result){
				return true;
			}
			else{
				return false;	
			}	
		}
	}


	if(isset($_POST['action'])){

		$gm=new GameManager();

		if($_POST['action']=='hit'){
			echo $gm->hitBlock($_POST['sid'],$_POST['block'],$_POST['player']);
		}
	}

?>
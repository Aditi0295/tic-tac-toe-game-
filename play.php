<?php
	require('server/GameManager.php');

	$gm=new GameManager();

	$resume=false;
	$first=false;

	if(isset($_GET['gid'])){
		if($gm->checkExistance($_GET['gid'])){
			$resume=true;
			
		}
		else{
			$gm->createGameSession($_GET['gid']);
			$first=true;
			$resume=false;	
		}
	}
	else{
		header('location:index.php');
	}

	$game_data=$gm->getGameSessionDetail($_GET['gid']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Play Game</title>
	<link rel="stylesheet" type="text/css" href="css/play.css">

	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
	<?php
		$turn="p1";
		if($first){
			$turn="p1";
		}
		else{
			$gm->engageSecondPlayer($_GET['gid']);

			if($game_data['p1_turn']=='yes'){
				$turn="p1";
			}
			else{
				$turn="p2";	
			}
		}

	?>
	<script type="text/javascript">
		var game={
			sid:"<?php echo $_GET['gid'] ?>",
			iam:"<?php if($first){echo 'p1';} else echo 'p2' ?>",
			turn:"<?php echo $turn ?>",
			myturn:false,
			p1_status:"<?php if($game_data['p1_engage']=='yes') echo 'Ready'; else echo 'Waiting'; ?>",
			p2_status:"<?php if($game_data['p2_engage']=='yes') echo 'Ready'; else echo 'Waiting'; ?>",
			gotMatch:false
		}

		if(game.iam==game.turn){
			game.myturn=true;
		}
		console.log(game);
	</script>
	<section>
		<div class="sub_cont game_hud">
			<div class="player_hud player_a_hud">
				<div>
					<span>P1</span>
					<span id="p1_status"><?php if($game_data['p1_engage']=='yes') echo 'Ready'; else echo 'Waiting'; ?></span>
				</div>
				<div>
					<span id="p1_turn">Turn</span>
				</div>
			</div>
			<div class="player_hud player_b_hud">
				<div>
					<span>P2</span>
					<span id="p2_status"><?php if($game_data['p2_engage']=='yes') echo 'Ready'; else echo 'Waiting'; ?></span>
				</div>
				<div>
					<span id="p2_turn">Turn</span>
				</div>
			</div>
		</div>
		<div class="sub_cont game_box">
			<table class="game_table">
				<tr>
					<td><button class="hit" data-block="r11"><?php if($game_data['r11']!=null){ if($game_data['r11']=='p1') echo '0'; else echo 'X';} ?></button></td>
					<td><button class="hit" data-block="r12"><?php if($game_data['r12']!=null){ if($game_data['r12']=='p1') echo '0'; else echo 'X';} ?></button></td>
					<td><button class="hit" data-block="r13"><?php if($game_data['r13']!=null){ if($game_data['r13']=='p1') echo '0'; else echo 'X';} ?></button></td>
				</tr>
				<tr>
					<td><button class="hit" data-block="r21"><?php if($game_data['r21']!=null){ if($game_data['r21']=='p1') echo '0'; else echo 'X';} ?></button></td>
					<td><button class="hit" data-block="r22"><?php if($game_data['r22']!=null){ if($game_data['r22']=='p1') echo '0'; else echo 'X';} ?></button></td>
					<td><button class="hit" data-block="r23"><?php if($game_data['r23']!=null){ if($game_data['r23']=='p1') echo '0'; else echo 'X';} ?></button></td>
				</tr>
				<tr>
					<td><button class="hit" data-block="r31"><?php if($game_data['r31']!=null){ if($game_data['r31']=='p1') echo '0'; else echo 'X';} ?></button></td>
					<td><button class="hit" data-block="r32"><?php if($game_data['r32']!=null){ if($game_data['r32']=='p1') echo '0'; else echo 'X';} ?></button></td>
					<td><button class="hit" data-block="r33"><?php if($game_data['r33']!=null){ if($game_data['r33']=='p1') echo '0'; else echo 'X';} ?></button></td>
				</tr>
			</table>
		</div>
		<div class="sub_cont share_box">
			<span>Share this link to Play with a Friend:</span>
			<div>
				<span><?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></span>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			var checkMatch=function(){

				if(game.gotMatch){
					return;
				}
				var hitlist=$('.hit');

				var matrix=[[hitlist[0].innerHTML,hitlist[1].innerHTML,hitlist[2].innerHTML],
							[hitlist[3].innerHTML,hitlist[4].innerHTML,hitlist[5].innerHTML],
							[hitlist[6].innerHTML,hitlist[7].innerHTML,hitlist[8].innerHTML]];

				var match='';

				for(var i=0;i<3;i++){
					if(matrix[i][0]=='0'&&matrix[i][1]=='0'&&matrix[i][2]=='0'){
						match='0';
						game.gotMatch=true;
					}
					if(matrix[i][0]=='X'&&matrix[i][1]=='X'&&matrix[i][2]=='X'){
						match='X';
						game.gotMatch=true;
					}
				}

				if(game.gotMatch){
					if(match=='0'){
						alert('Player 1 Won');
					}
					if(match=='X'){
						alert('Player 2 Won');	
					}
					return;
				}

				for(var i=0;i<3;i++){
					if(matrix[0][i]=='0'&&matrix[1][i]=='0'&&matrix[2][i]=='0'){
						match='0';
						game.gotMatch=true;
					}
					if(matrix[0][i]=='X'&&matrix[1][i]=='X'&&matrix[2][i]=='X'){
						match='X';
						game.gotMatch=true;
					}
				}

				if(game.gotMatch){
					if(match=='0'){
						alert('Player 1 Won');
					}
					if(match=='X'){
						alert('Player 2 Won');	
					}
					return;
				}

				if(matrix[0][0]=='0'&&matrix[1][1]=='0'&&matrix[2][2]=='0'){
					match='0';
					game.gotMatch=true;
				}
				if(matrix[0][2]=='X'&&matrix[1][1]=='X'&&matrix[2][0]=='X'){
					match='X';
					game.gotMatch=true;
				}

				if(game.gotMatch){
					if(match=='0'){
						alert('Player 1 Won');
					}
					if(match=='X'){
						alert('Player 2 Won');	
					}
					return;
				}

			}

			var playerReady=function(){

				if(game.p1_status=='Ready' && game.p2_status=='Ready'){
					return true;
				}

				return false;				
			}

			var updateGameHud=function(){

				$('#p1_turn').hide();
				$('#p2_turn').hide();

				$('#p1_status').text(game.p1_status);
				$('#p2_status').text(game.p2_status);

				if(game.iam==game.turn){
					game.myturn=true;

					if(game.iam=='p1'){
						$('#p1_turn').text('Your Turn');
						$('#p1_turn').show();
						$('#p2_turn').hide();
					}
					else{
						$('#p2_turn').text('Your Turn');
						$('#p2_turn').show();
						$('#p1_turn').hide();	
					}
				}
				else{
					if(game.iam=='p1'){
						$('#p2_turn').text('Turn');
						$('#p2_turn').show();
						$('#p1_turn').hide();
					}
					else{
						$('#p1_turn').text('Turn');
						$('#p1_turn').show();
						$('#p2_turn').hide();	
					}	
				}

				checkMatch();
			}

			$('.hit').on('click',function(){
				var hit=$(this);

				if(playerReady()){
					if(game.myturn){
						game.myturn=false;
						$(this).css({
							'background-image':"url('images/loader.gif')",
							'background-repeat': "no-repeat",
							'background-position': "50% 50%",
							'background-size': "40%"
						});
						$(this).manager({
							url:"server/GameManager.php",
							data: {
								sid:game.sid,
								action:'hit',
								block:this.dataset.block,
								player:game.iam
							},
							callbackfunc:function(data){
								console.log(data);

								data=JSON.parse(data);

								if(data.success){

									hit.css({
										'background-image':"url('')",
									});

									if(game.iam=='p1'){
										hit.text('0');
									}
									else{
										hit.text('X');
									}

									updateGameHud();
								}
								else{
									game.myturn=true;
								}
							}
						});
					}
					else{
						alert("Wait for your turn!!!");
					}
				}
				else{
					alert("Wait for both player to be ready!!!");
				}
			});

			var evtSource = new EventSource("server/HitSync.php");

	  		evtSource.onopen = function() {
			    console.log("Connection to server opened.");
			};

			evtSource.onmessage = function(e) {
			  	//console.log("message: " + e.data);

			  	var data=JSON.parse(e.data);

			  	var this_game=null;

			  	for(var object in data){
			  		if(data[object].sid==game.sid){
			  			this_game=data[object];
			  			break;
			  		}
			  	}

			  	var hitlist=$('.hit');

			  	for(var i=0;i<=8;i++){

			  		if(this_game[hitlist[i].dataset.block]!=null){
				  		if(this_game[hitlist[i].dataset.block]=='p1'){
				  			hitlist[i].innerHTML='0';
				  		}
				  		else{
				  			hitlist[i].innerHTML='X';
				  		}
			  		}
			  	}

			  	if(this_game['p1_turn']=='yes'){
			  		game.turn='p1';
			  	}
			  	else{
			  		game.turn='p2';	
			  	}

			  	if(this_game['p1_engage']=='yes'){
			  		game.p1_status='Ready';
			  	}
			  	else{
			  		game.p1_status='Waiting';
			  	}

			  	if(this_game['p2_engage']=='yes'){
			  		game.p2_status='Ready';	
			  	}
			  	else{
			  		game.p2_status='Waiting';		
			  	}

			  	updateGameHud();

			  	console.log(game);
			}

			evtSource.onerror = function(e) {
			  	//console.log("EventSource failed.");
			};

			updateGameHud();
		});
	</script>
</body>
</html>
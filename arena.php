<?php
	require_once 'core/init.php';

	$game = new Game();
	$game->getData(Session::get('active_game'));
	
	$user1 = new User($game->getAtt('user_1'));

	if ($game->getAtt('user_2') != 0) {
		$user2 = new User($game->getAtt('user_2'));
	} else {
		$user2 = NULL;
	}
	
	$game_status = $game->getAtt('game_status');

	$ship1 = $game->getShipCords(1);
	$ship2 = $game->getShipCords(2);
	//echo $game;


?>
<!DOCTYPE html>
<html>
<head>
	<title>dra4ka</title>
	<link rel="stylesheet" type="text/css" href="css/arena.css">
	<script type="text/javascript" src="js/arena.js"></script>
</head>
<body>
	<div class="header">
		<a href="exit_game.php">Leave game</a>
	</div>
	<div class="arena">
		<div class="player-1">
			<p>Player info: 
				<?php 
					if ($game->getAtt('winner') != 0) {
						if ($game->getAtt('winner') == $game->getAtt('user_1')) {
							echo 'You won';
						} else {
							echo 'You lose';
						}
					}
				?>
			</p>
			<table>
				<tr>
					<td>Name</td>
					<td><?php echo $user1->data()->login; ?></td>	
				</tr>
				<tr>
					<td>Health</td>
					<td><?php echo $game_status->user_1->health; ?></td>	
				</tr>
				<tr>
					<td>Speed</td>
					<td><?php echo $game_status->user_1->speed; ?></td>	
				</tr>
				<tr>
					<td>Power</td>
					<td><?php echo $game_status->user_1->power; ?></td>	
				</tr>
				<tr>
					<td>Direction</td>
					<td>
						<?php 
							$d = $game_status->user_1->direction;
							if ($d == 1) {
								$dm = "Up";
							} else if ($d == 2) {
								$dm = "Right";
							} else if ($d == 3) {
								$dm = "Down";
							} else {
								$dm = "Left";
							}
							echo $dm;
						?>		
					</td>	
				</tr>
				<tr>
					<td>Turn</td>
					<td>
						<?php 
							if ($game_status->turn == 1) {
								echo 'Your turn';
							} else {
								echo 'Oponent turn';
							}
						?>
					</td>	
				</tr>
				<tr>
					<td>Phase</td>
					<td>
						<?php 
							if ($game_status->turn == 1) {
								if ($game_status->phase == 1) {
									echo 'rorate-move-shoot';
								} else if ($game_status->phase == 2){
									echo 'move-shoot';
								} else {
									echo 'shoot';
								}
							}
						?>
					</td>	
				</tr>
			</table>

			<p>Controller</p>
			<table>
				<tr>
					<td>Rotate</td>
					<td><a href="controller.php?action=rotateLeft"><button>Left 90</button></a></td>	
				</tr>
				<tr>
					<td></td>
					<td><a href="controller.php?action=rotateRight"><button>Right 90</button></a></td>	
				</tr>
				<tr>
					<td>Move</td>
					<td>
						<form action='controller.php' method='get'>
							<input type="number" min="0" max="30" name="speed" value="30">
							<input type="hidden" name="action" value="move">
							<input type="submit" value="GO">
						</form>
					</td>	
				</tr>
				<tr>
					<td>Shoot</td>
					<td><a href="controller.php?action=shoot"><button>Shoot</button></a></td>	
				</tr>
			</table>			
		</div>
		<div class="map">
			<table>
			<?php
				for ($i = 1; $i <= 100; $i++) {
					echo "<tr>";
					for ($j = 1; $j <= 150; $j++) {
						$id = (($i - 1) * 150 + $j);
						if (in_array($id, $ship1)) {
							$color = 'red';
						} else if (in_array($id, $ship2)) {
							$color = 'blue';
						} else {
							$color = '';
						}
						echo "<td id='" . $id . "' class='" . $color ."'></td>";
					}
					echo "</tr>";
				}
			?>
			</table>
		</div>
		<div class="player-2">
			<p>Player info: 
				<?php 
					if ($game->getAtt('winner') != 0) {
						if ($game->getAtt('winner') == $game->getAtt('user_2')) {
							echo 'You won';
						} else {
							echo 'You lose';
						}
					}
				?>
			</p>
			<table>
				<tr>
					<td>Name</td>
					<td>
						<?php 
							if ($user2) {
								echo $user2->data()->login; 
							} else {
								echo 'Waiting for oponent';
							}
						?>
					</td>	
				</tr>
				<tr>
				<tr>
					<td>Health</td>
					<td><?php echo $game_status->user_2->health; ?></td>	
				</tr>
				<tr>
					<td>Speed</td>
					<td><?php echo $game_status->user_2->speed; ?></td>	
				</tr>
				<tr>
					<td>Power</td>
					<td><?php echo $game_status->user_2->power; ?></td>	
				</tr>
				<tr>
					<td>Direction</td>
					<td>
						<?php 
							$d = $game_status->user_2->direction;
							if ($d == 1) {
								$dm = "Up";
							} else if ($d == 2) {
								$dm = "Right";
							} else if ($d == 3) {
								$dm = "Down";
							} else {
								$dm = "Left";
							}
							echo $dm;
						?>		
					</td>	
				</tr>
				<tr>
					<td>Turn</td>
					<td>
						<?php 
							if ($game_status->turn == 2) {
								echo 'Your turn';
							} else {
								echo 'Oponent turn';
							}
						?>
					</td>	
				</tr>
				<tr>
					<td>Phase</td>
					<td>
						<?php 
							if ($game_status->turn == 2) {
								if ($game_status->phase == 1) {
									echo 'rorate-move-shoot';
								} else if ($game_status->phase == 2){
									echo 'move-shoot';
								} else {
									echo 'shoot';
								}
							}
						?>
					</td>	
				</tr>
			</table>

			<p>Controller</p>
			<table>
				<tr>
					<td>Rotate</td>
					<td><a href="controller.php?action=rotateLeft"><button>Left 90</button></a></td>	
				</tr>
				<tr>
					<td></td>
					<td><a href="controller.php?action=rotateRight"><button>Right 90</button></a></td>	
				</tr>
				<tr>
					<td>Move</td>
					<td>
						<form action='controller.php' method='get'>
							<input type="number" min="0" max="30" name="speed" value="30">
							<input type="hidden" name="action" value="move">
							<input type="submit" value="GO">
						</form>
					</td>	
				</tr>
				<tr>
					<td>Shoot</td>
					<td><a href="controller.php?action=shoot"><button>Shoot</button></a></td>	
				</tr>
			</table>			
		</div>
		</div>		
	</div>
</body>
</html>
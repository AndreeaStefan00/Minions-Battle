<?php include("player.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Minions Battle</title>
</head>
<body>

<?php 
$player1= new player("TIM",70,100,70,80,45,55,40,50,10,30);
$player2= new player("EvilMin",60,90,60,90,40,60,40,60,25,40);

$current_health_pl1=$player1->getHealth($player1);
$current_health_pl2=$player2->getHealth($player2);
$current_strength_pl1=$player1->getStrength($player1);
$current_strength_pl2=$player2->getStrength($player2);
$current_defense_pl1=$player1->getDefense($player1);
$current_defense_pl2=$player2->getDefense($player2);
$current_speed_pl1=$player1->getSpeed($player1);
$current_speed_pl2=$player2->getSpeed($player2);
$current_luck_pl1=$player1->getLuck($player1);
$current_luck_pl2=$player2->getLuck($player2);
$attacker;
$defender;
$damage;
?>
<form id="form_minions" name="form_minions" method="post" action="attack.php" >
	<table id="table_minions" style="width:800px;">
		<tr>
			<th width="45%" align="right"><?php echo $player1->name ?></th>
			<th width="10%" align="center"/>
			<th align="left"><?php echo $player2->name ?></th>
		</tr>
		<tr>
			<td width="45%" align="right">
				<img src="img/tim.jpg" alt="minion" style="width:40px;height:50px;">
			</td>
			<td width="10%" />
			<td>
				<img src="img/evilmin.jpg" alt="minion" style="width:40px;height:50px;">
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<input type="submit" name="play" value="PLAY" style="width:100px;height:30px;">
			</td>
		</tr>
		<?php 
		$previous="";
		if(isset($_GET['prevpage'])){
			$previous=$_GET['prevpage'];
		}
		if ($previous=='attack.php'){
		?>	
					
		<tr>
			<td colspan="3" align="center">
				<b>INITIAL VALUES</b>
			</td>
		</tr>
		<tr>
			<td width="45%" align="right"><?php echo $current_health_pl1; ?></td>
			<td width="10%" align="center">Health</td>
			<td><?php echo $current_health_pl2; ?></td>
		</tr>
		<tr>
			<td width="45%" align="right"><?php echo $current_strength_pl1; ?></td>
			<td width="10%" align="center">Strength</td>
			<td><?php echo $current_strength_pl2; ?></td>
		</tr>
		<tr>
			<td width="45%" align="right"><?php echo $current_defense_pl1; ?></td>
			<td width="10%" align="center">Defense</td>
			<td><?php echo $current_defense_pl2; ?></td>
		</tr>
		<tr>
			<td width="45%" align="right"><?php echo $current_speed_pl1; ?></td>
			<td width="10%" align="center">Speed</td>
			<td><?php echo $current_speed_pl2; ?></td>
		</tr>
		<tr>
			<td width="45%" align="right"><?php echo $current_luck_pl1; ?> %</td>
			<td width="10%" align="center">Luck</td>
			<td><?php echo $current_luck_pl2; ?> %</td>
		</tr>
		<?php }?>
	</table>
	<?php if ($previous=='attack.php'){	?>
	<table id="table_turns" border="1" style="width:800px;text-align:center;font-size:0.8em">
		<tr>
			<th width="10%">Turn No.</th>
			<th width="10%">Attacker</th>
			<th width="10%">Defender</th>
			<th width="20%">Banana strike used</th> 
			<th width="20%">Umbrella shield used</th>
			<th width="10%">Defender got lucky</th>
			<th width="10%">Damage</th> 
			<th width="10%">Defender's health left</th>
		</tr>
		
		<?php 
		$health_over=100;//initialized. User for defender's current health
		for ($counter = 1; $counter < 21 && $health_over> 0;$counter++ ){
			//establish attacker and defender
			if (!isset($attacker)){
				if ($current_speed_pl1>$current_speed_pl2){
					$attacker = $player1;
					$defender = $player2;
				}elseif ($current_speed_pl2>$current_speed_pl1){
					$attacker = $player2;
					$defender = $player1;
				}else{
					//same speed. verify luck
					if ($current_luck_pl1>=$current_luck_pl2){
						$attacker = $player1;
						$defender = $player2;
					}elseif ($current_luck_pl2>$current_luck_pl1){
						$attacker = $player2;
						$defender = $player1;
					}
				}
			}else{
				$buffer = $defender;
				$defender = $attacker;
				$attacker = $buffer;
			}
			
			$banana_strike_used=false;
			$umbrella_shield_used=false;
			$defender_got_lucky=false;
			$defender_turn_luck=0;
			$damage=0;
			
			//"banana strike" action
			$chance = rand(0, 100);
			if ($attacker->name =='TIM' && $chance<10){
				$banana_strike_used=true;
			}elseif ($attacker->name =='EvilMin' && $chance<20){
				$umbrella_shield_used=true;
			}
			
			//"got lucky" action: on each turn, they roll the dice again on luck. If greater than initial value then "he got lucky"
			if ($defender->name == 'TIM'){
				$defender_turn_luck = rand(0,30);
			}else{
				$defender_turn_luck = rand(0,40);
			}
			if ($defender_turn_luck>$defender->luck){
				$defender_got_lucky=true;
			}
			
			//damage control
			if (!$defender_got_lucky){
				$damage=$attacker->strength - $defender->defense;
				//if tim's the attacker and got to use banana strike subtract twice damage
				if ($banana_strike_used){
					$damage=$damage*2;
				}else{
					//tim's the defender. He might use umbrella shield
					if ($umbrella_shield_used){
						$damage=$damage/2;
					}
				}
			}
			$defender->health = $defender->health - $damage;
			
			$health_over=$defender->health;
		?>
		<tr>
			<td width="10%"><?php echo $counter ?>.</td>
			<td width="10%"><?php echo $attacker->name ?></td>
			<td width="10%"><?php echo $defender->name ?></td>
			<td width="20%"><?php if($attacker->name == 'TIM'){if ($banana_strike_used){echo "DA";}else{echo "NU";}} ?></td>
			<td width="20%"><?php if ($defender->name == 'TIM'){if ($umbrella_shield_used){echo "DA";}else{echo "NU";}} ?></td>
			<td width="10%"><?php if ($defender_got_lucky){echo "DA";}else{echo "NU";} ?></td>
			<td width="10%"><?php echo $damage ?></td>
			<td width="10%"><?php echo $defender->health ?></td>
		</tr>
		<?php } ?>
	</table>
	
	<p>
	<?php if( $counter<21){ ?>
		WINNER IS <?php if ($attacker == $player1 ){ ?>
			<img src="img/tim.jpg" alt="minion" style="width:40px;height:50px;">
		<?php }else{ ?>
			<img src="img/evilmin.jpg" alt="minion" style="width:40px;height:50px;">
		<?php } ?>
	</p>
	<?php }
	} ?>
</form>
</body>
</html>
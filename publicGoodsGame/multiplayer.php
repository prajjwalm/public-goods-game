<?php
	session_start();
	if (empty($_SESSION['grid'])) {
		session_destroy();
		header("Location: index.php");
	}
	
	
	$_SESSION['last_file'] = "multiplayer";
	if (isset($_SESSION['times'])){
		// echo "<script>alert('asdfas');</script>";
		
		unset($_SESSION['times']);
	}
	
	// https://stackoverflow.com/questions/20582962/whats-the-difference-between-isset-and-empty-in-php
?>
<!DOCTYPE html>

<!-- The 'peeps' used are taken from ncase.me/trust (https://github.com/ncase/trust/tree/gh-pages/assets) -->
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale=1">
		
		<meta name = "keywords" content = "Public Goods Game, Simulation, IIT, Kanpur">
		<meta name = "Description" content = "A simulation of the public goods game">
		<meta name = "theme-color" content = "#103d87">
		
		<title>PGG</title>
		
		<!-- js libraries -->
		<script src = "js/lib/jquery-3.2.1.min.js"></script>
		<script src="js/lib/pixi.min.js"></script>
		<script src="js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
		
		<!-- styles -->
		<link href="assets/icons/fa/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.css">
		
		<!-- my style >
		<link type="text/css" rel="stylesheet" href="css/style.css" /-->
		<link type="text/css" rel="stylesheet" href="css/build/game.css" />
		
		<!-- my code -->
		<script src = "js/base.js"></script>
		<script src = "js/slider_init.js"></script>
		<script src = "js/mp_renderer.js"></script>
		<script src = "js/mp_game.js"></script>
		<script src = "js/mp_players.js"></script>
		<script>		
		function KeyPress(e) {
			var evtobj = window.event? event : e
			if (evtobj.keyCode == 90 && evtobj.ctrlKey && evtobj.shiftKey) {
				$.ajax({
					type: "POST",
					url: "back/showsession.php",
					data: null,
					dataType: "text",
					success: function (data) {
						alert(JSON.stringify(data));
					},
					error: function (data) {
						alert("bad");
						alert(JSON.stringify(data));
					},
				});
			}
		}

		document.onkeydown = KeyPress;
		</script>
		
		<script src = "js/ping.js"></script>
	</head>

	<body>
	<div id = "main">
		<div id = "gamezone">
			<div id = "header" style = "z-index: 1;">
				Room  <span id = "grno"><?php echo $_SESSION['grid'] ?></span>: Round No.<span id = "rno"><?php echo $_SESSION['rno'] ?></span>
			</div>						
			<div id = "playground">
				<!-- canvas -->
				<div id = "premsg">
					<?php if ($_SESSION['host'] === true): ?>
					Once all the players have joined, adjust the Bot populations as reqd
					and press start to begin the game. Note: no player/bot can be added once the game starts.
					<?php else: ?>
					Waiting for the head to start the game.
					<?php endif ?>
				</div>
				<div id = "balance"></div>
				<div class = "dynamic"></div>
				<div id = "names" class = "dynamic"></div>
			</div>
			<div id = "game-interface" style = "display:none;">
				<!-- User Inputs -->
				<div style = "display:none;" id = "rp">
					Reward/Penalize: 
					<!-- span id = "pen-desc">to reward/penalize a player, click on the contribution values (in grey and above the cash) and enter the value (positive for rewards, negetive for penalites) </span-->
					<div id = "penalties"></div> <!-- Container for all the penalty inputs, keep empty -->
				</div>
				<div class="main-input" id = "contrib" autocomplete = "off" style = "display:none;">
					<div class="group">
						<input type="number" id="cinput" required="required" placeholder="&nbsp;" step = "0.001" min = "0"/>
						<!-- set max using current cash using js on each round -->
						<label for="cinput">Contribution</label>
						<div class="bar"></div>
					</div>
				</div>
				<button id = "ok">OK</button>
			</div>
		</div>
		<div id = "etc">
		
			<?php if ($_SESSION['host'] === true): ?>
			
				<div id = "meta" class = "opaque">
					<p>ADMIN space</p>
					<div id = "pop-manager">
						&nbsp;&nbsp;Bot Populations:
						<div id = "hatspace"></div>
						<div id = "botpops">
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<div id = "sliders">
								<div class = "pop-slider" style = "height: 120px;"></div>
								<div class = "pop-slider" style = "height: 120px;"></div>
								<div class = "pop-slider" style = "height: 120px;"></div>
								<div class = "pop-slider" style = "height: 120px;"></div>
								<div class = "pop-slider" style = "height: 120px;"></div>
							</div>
						</div>
					</div>
					<div id = "player-manager">
						Players Participating:
						<div id = "players">
							<div class = "admin player" style = "order: 1;"><span class = "name"><?php echo $_SESSION['name']?></span><i class="fas fa-crown"></i></div>
						</div>
					</div>
					<div id = "meta-controls">
						<button id = "start">Start</button>
						<!--button id = "abort">Abort</button-->
						<button id = "end" style = "display:none;">End</button>
					</div>
				</div>
			<?php else: ?>
				<div id = "meta" class = "opaque">
					<p>Meta Data</p>
					<div id = "pop-manager">
						&nbsp;&nbsp;Bot Populations:
						<div id = "hatspace"></div>
						<div id = "botpops-view">
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
							<input type="text" class="pop-count" readonly>
						</div>
					</div>
					<div id = "player-manager">
						Players Participating:
						<div id = "players">
						</div>
					</div>
				</div>
			<?php endif ?>
			
			<!-- div id = "leaderboard" class = "opaque"> leaderboard </div>
			<div id = "balance_graph" class = "opaque"> graph </div -->
		
		</div>
	</div>	

	<div id = "stdout" style = "Display:None;"></div>
	<div id = "msg-container">
		<div id = "warning" style = "Display:None;"><i class= "fas fa-exclamation-triangle"></i><span></span></div>
		<div id = "info" style = "Display:None;"><span></span></div>
	</div>

	</body>
</html>
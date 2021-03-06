<?php 
	session_start();
	if (empty($_SESSION['grid']) || empty($_SESSION['uid'])) {
		session_destroy();
	} else {
		// move to game room
		header("Location: multiplayer.php");
	}
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
		<script src = "../publicGoodsGame/js/lib/jquery-3.2.1.min.js"></script>
		<script src="../publicGoodsGame/js/lib/pixi.min.js"></script>
		<script src="../publicGoodsGame/js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
		
		<!-- styles -->
		<link href="../publicGoodsGame/assets/icons/fa/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../publicGoodsGame/js/lib/jquery-ui-1.12.1.custom/jquery-ui.min.css">
		
		<!-- my style -->
		<link type="text/css" rel="stylesheet" href="../publicGoodsGame/css/build/index.css" />
		<link type="text/css" rel="stylesheet" href="../publicGoodsGame/css/build/tooltip.css" />
		
		<!-- my code -->
		<script src = "js/index_ui.js"></script>
		<script src = "js/index_gen_room.js"></script>
	</head>

	<body>
		<div id = "input">
			<div class = "input-row header mode"> Play Mode:</div>
			<div class = "input-row opaque mode">
				<div id = "gametype">
					<label class="switch">
						<span class="word">Exploration</span>
						<input type="checkbox" id = "mode">
						<span class="slider round"></span>
					</label>
				</div>
                <div class = "tooltip-space"> <!-- index.scss 97 -->
                    <div class="tooltip" id ="start-info">?<div class="info">
                    </div></div>
                </div>
				<div id = "gameroom" class="main-input" autocomplete = "off" style = "display:none;">
					<div class="group">
						<input type="text" id="grinput" placeholder="&nbsp;" required maxlength="8" pattern="[a-z0-9]{8}"/>
						<label for="grinput">Game Room Id</label>
						<div class="bar"></div>
					</div>
				</div>			
				<div id = "name" class="main-input" autocomplete = "off" style = "display:none;">
					<div class="group">
						<input type="text" id="nameinput" placeholder="&nbsp;" required maxlength="32" pattern="^[a-zA-Z0-9-_\x20]{2,10}$"/>
						<label for="nameinput">Name</label>
						<div class="bar"></div>
					</div>
				</div>			
			</div>
			<div class = "input-row description mode">
				<span>Hovering on the information circles: <div class = "tooltip" style = "display:inline-block;animation:none; width: 12px; height: 12px; transform: translateY(3px);">
                </div> shows instructions on how to play the game. Now hover over the circle besides the 
                play mode selector to know how to enter a game. </span>
			</div>
			<div class = "input-row button"  style = "height: 32px;">
				<button id = "start" disabled>Start</button>
				<button id = "gen" style = "display:none;" disabled> Generate </button>
				<button id = "join" style = "display:none;" disabled>Join</button>
			</div>
		</div>
	</body>
</html>
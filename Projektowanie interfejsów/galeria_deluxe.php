<?php
	session_start();
	if (!isset($_SESSION['zalogowany'])) // Sprawdzenie, czy użytkownik jest zalogowany 
	{
		header('location: formularz.php');	// Przeniesienie do danego dokumentu
		exit();	// Zakończenie skryptu
	}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" /> <!-- Podpięcie .css do strony -->
	<title>Zarządzanie hotelem</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
			* {
			box-sizing: border-box;
			}

			body {
			margin: 0;
			font-family: Arial;
			}

			/* The grid: Four equal columns that floats next to each other */
			.column {
			float: left;
			width: 25%;
			padding: 10px;
			}

			/* Style the images inside the grid */
			.column img {
			opacity: 0.8; 
			cursor: pointer; 
			}

			.column img:hover {
			opacity: 1;
			}

			/* Clear floats after the columns */
			.row:after {
			content: "";
			display: table;
			clear: both;
			}

			/* The expanding image container */
			.container {
			position: relative;
			display: none;
			}

			/* Expanding image text */
			#imgtext {
			position: absolute;
			bottom: 15px;
			left: 15px;
			color: white;
			font-size: 20px;
			}

			/* Closable button inside the expanded image */
			.closebtn {
			position: absolute;
			top: 10px;
			right: 15px;
			color: white;
			font-size: 35px;
			cursor: pointer;
			}
			#expandedImg{
				position: relative;
				width:50%;
				margin-left: 25%;
				
			}
			.tytol_strony{
				background-color: rgb(231, 231, 231);
				border-radius: 20px;
				border: 2px double rgb(138, 138, 138);
				position: relative;
				width:300px;
				padding: 10px;
				left: 35%;
				top:40px;
				text-align: center;
			}
</style>
</head>

<body id="body">
	<div id="rodzic">
			<div id="gorna_belka"> 	

			<div class="gorna_belka2">
				<a href="panel.php"><img src = "logo/logoV3.png" width=200px></a>
			</div>

			<div class="gorna_belka3">
				<img src="ikony/User.png" class="IkonaPrzyciskGora">
			</div>

			<div class="gorna_belka4">
				<ul class="menu">
						<li>
								<?php 
									echo $_SESSION['imie_i_nazwisko'];
								?>
							<ul> <!-- <img width = "40px" src="ikony/wyloguj.png"> -->
								<li>
											<a href="logout.php" class="wylogujlink" >Wyloguj</a>   
								</li>
							</ul>
						</li>
				</ul>
			</div>
		</div>



		<div id="panel_boczny"  >

			<div class="kontener_panel_boczny">

				<div class="Panel_boczny_do_pozyckonowania">
					<div class="przyciskiBoczne" >
						<img src="ikony/bedFree.png" class="IkonaPrzycisk" >
						<a href="wolne_pokoje.php" class="TeksPaneBoczny"  >Wolne pokoje</a>
					</div>

					<div class="przyciskiBoczne">
						<img src="ikony/bed.png" class="IkonaPrzycisk" >
						<a  href="zajete_pokoje.php" class="TeksPaneBoczny" >Zajęte pokoje</a>
					</div>

					<div class="przyciskiBoczne">
						<?php
							$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
								if ($uprawnienia=="konserwator") {		
							} else {
								echo '
								<img src="ikony/plus.png" class="IkonaPrzycisk" >
								<a href="rezerwacje.php" class="TeksPaneBoczny" > Dodaj rezerwacje </a>
									';
							}
						?>
					</div>

					<div class="przyciskiBoczne">
						<?php
							$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
							if ($uprawnienia=="konserwator") {		
							} else {
							echo '
								<img src="ikony/book.png" class="IkonaPrzycisk" >
								<a href="rezerwacje_widok.php" class="TeksPaneBoczny" > Widok rezerwacji </a>
								';
							}
						?>
					</div>

					<div class="przyciskiBoczne">
					<?php
						$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
							if ($uprawnienia=="konserwator") {		
						} else {
							echo '
							<img src="ikony/money.png" class="IkonaPrzycisk" >
							<a href="cennik.php" class="TeksPaneBoczny" > Cennik </a>
								';
						}
					?>
					</div>

					<div class="przyciskiBoczne">
						<?php
							$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
							if ($uprawnienia=="administrator") {
									echo '
										<img src="ikony/Administracja.png" class="IkonaPrzycisk" >
										<a href="uzytkownicy.php" class="TeksPaneBoczny" > Administracja </a>
											' ;
							} else {
							}
						?>
					</div>

				</div>

			</div>
		</div>			


		<div id="panel_glowny">

			<div class="tytol_strony">
				Pokój deluxe
			</div>
			<br>
			<br>
				<!-- The four columns -->
				<div class="row">
				<div class="column">
					<img src="deluxe_galeria/1.jpg" style="width:100%" onclick="myFunction(this);">
				</div>
				<div class="column">
					<img src="deluxe_galeria/2.jpg" style="width:100%" onclick="myFunction(this);">
				</div>
				<div class="column">
					<img src="deluxe_galeria/3.jpg" style="width:100%" onclick="myFunction(this);">
				</div>
				<div class="column">
					<img src="deluxe_galeria/4.jpg" style="width:100%" onclick="myFunction(this);">
				</div>
				</div>

				<div class="container">
				<span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
				<img id="expandedImg">
				<div id="imgtext"></div>
				</div>

				<script>
				function myFunction(imgs) {
				var expandImg = document.getElementById("expandedImg");
				var imgText = document.getElementById("imgtext");
				expandImg.src = imgs.src;
				imgText.innerHTML = imgs.alt;
				expandImg.parentElement.style.display = "block";
				}
				</script>	








		</div>


		<div id="stopka">
		
		</div>
	</div>
	
</body>

</html>
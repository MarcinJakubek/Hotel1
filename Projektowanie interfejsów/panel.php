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



		
		<div id="panel_glowny" border=1>
		
		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
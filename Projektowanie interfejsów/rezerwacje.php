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
		<?php
				// Sprawdza czy użytkownik jest Konserwatorem. Jeśli jest to wywali do panelu.
				if ($uprawnienia=="konserwator") {
					header('location: panel.php');					
			} else {
			}
		?>



			<br>

			<form method="POST" action="dodanie_rezerwacji.php" autocomplete="off" enctype="multipart/form-data" class="" action="" >

			<div class="Dane_Klienta">

				<div class="Napis_Naglowek_Rezerwacje">
					<b> &nbsp Dane osobowe klienta </b>
				</div>

				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Płeć
				</div>

				<div class="Dane_wprowadzane_rezerwacje">
					<select  id="poletext" name="title" class="form-control" required >
													<option  value selected ></option>
													<option value="Męż">Mężczyzna</option>
													<option value="Kob">Kobieta</option>
					</select>
				</div>


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Imię
				</div>

				<div class="Dane_wprowadzane_rezerwacje">
					<input name="fname" id="poletext" required>
				</div>



				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Nazwisko
				</div>
				
				<div class="Dane_wprowadzane_rezerwacje">
					<input name="lname" id="poletext" required>
				</div>				


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Email
				</div>


				<div class="Dane_wprowadzane_rezerwacje">
					<input name="email" type="email" id="poletext" required> 
				</div>


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Numer telefonu
				</div>


				<div class="Dane_wprowadzane_rezerwacje">
					<input name="phone" type ="text" id="poletext" required>
				</div>


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Zdjęcie dowodu
				</div>


				<div class="Dane_wprowadzane_rezerwacje">
					<input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png" onchange="previewImage(event)" value=""> 
					<br><br>
					<img id="preview" src="#" alt="Podgląd obrazu" style="display: none; max-width: 200px; max-height: 200px;">
					<br>
				</div>
			
				<div class="czyszczenie_rezerwacje">

				</div>

			</div>

			<br>
			<br>

		<div class="Dane_rezerwacji">


				<div class="Napis_Naglowek_Rezerwacje">
					<b> &nbsp Dane rezerwacji</b>
				</div>


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Rodzaj pokoju
				</div>

				<div class="Dane_wprowadzane_rezerwacje">
					<select name="troom"  id="poletext" required>
														<option value selected ></option>
														<option value="Ekonomiczny">Ekonomiczny (Obniżony standard)</option>
														<option value="Standard">Standardowy</option>
														<option value="Superior">Superior (Podwyższony standard)</option>
														<option value="Deluxe">Deluxe (Podwyższony standard)</option>
														<option value="Premier">Premier (Podwyższony standard) </option>
														<option value="Executive">Executive (Stanowisko do pracy)</option>
														<option value="Guest Hause">Domek gościnny</option>
					</select> 
				</div>


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Ilość łóżek
				</div>

				<div class="Dane_wprowadzane_rezerwacje">
					<select name="bed" id="poletext" required>
													<option value selected ></option>
													<option value="Single">Single (Jednoosobowe Łóźko)</option>
													<option value="Twin">Twin (Dwa jednoosobowe łóźka)</option>
													<option value="Double">Double (Jedno dwuosobowe łóźko)</option>
													<option value="Triple">Triple (Trzy jednoosobowe łóźka)</option>
													<option value="Quad">Quad (Cztery jednoosobowe łóźka)</option>
					</select>
				</div>



				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Posiłek
				</div>
				
				<div class="Dane_wprowadzane_rezerwacje">
						<select name="posilek" id="poletext" required>
												<option value selected ></option>
                                                <option value="Brak">Brak</option>
                                                <option value="Sniadanie">Śniadanie</option>
												<option value="Obiadokolacja">Obiadokolacja</option>
												<option value="Pelne">Pełne wyżywienie</option>
						</select>
				</div>				


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Przyjazd
				</div>


				<div class="Dane_wprowadzane_rezerwacje">
					<input name="cin" type ="date" id="poletext">
				</div>


				<div class="Opis_Danych_wprowadzanie_rezerwacji">
					Odjazd
				</div>


				<div class="Dane_wprowadzane_rezerwacje">
					<input name="cout" type ="date" id="poletext">
				</div>
				<div class="czyszczenie_rezerwacje">

				</div>

		</div>

			<br>

		<div class="czyszczenie_rezerwacje" style="margin-left: 23px;">
			<br>
			<br>
			<input type="submit" name="submit" class="pozycjonowanie_Przycisku" value="Dodaj">
		</div>		
			</form>
	</div>

		<script>
				function previewImage(event) {
				var input = event.target;
				var preview = document.getElementById('preview');
				
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
					preview.src = e.target.result;
					preview.style.display = 'block';
					}

					reader.readAsDataURL(input.files[0]);
				}
				}
		</script>

		<div id="stopka">
		<!-- http://w3schools.sinsixx.com/php/php_mysql_where.asp.htm -->
		<!-- https://www.youtube.com/watch?v=YcLHapPnDQg -->
		</div>
	</div>
	
</body>

</html>
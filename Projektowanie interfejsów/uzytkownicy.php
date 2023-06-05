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
	<!-- <meta http-equiv="refresh" content="3"> -->
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
				// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
				if ($uprawnienia=="konserwator") {
					header('location: panel.php');					
			} else {
			}
			?>
			<?php
			
			require_once "connect.php";
			$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
			//Wypisanie Danych
					$sql = "SELECT   user, pass, uprawnienia, imie_i_nazwisko, kontakt FROM users";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<b> <br> &nbsp Aktywni użytkownicy </b> <br><br> <table  id="tabela">
							<tr id="tabela3"> 
																
									<th  > Login    </th>
									<th  > Uprawnienia </th>
									<th  > Imie i Nazwisko </th>
									<th  > kontakt  </th>
							</tr>';
						while($_SESSION = $result->fetch_assoc()) {
							echo   "<tr>
										
										<td>"  . $_SESSION['user']       . " </td>
										<td>"  . $_SESSION['uprawnienia']   . " </td> 
										<td>"  . $_SESSION['imie_i_nazwisko']      . " </td> 
										<td>"  . $_SESSION['kontakt']     . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak użytkowników</font>";
						} 
				
			?>
			<br><br><b> &nbsp Dodaj użytkownika </b><br><br>
		<form action="dodawanie_uzytkownikow.php" method="POST">
			<div class="Dane_Uzytkownika">


				<div class="Opis_Uzytkownicy">
					Login
				</div>

				<div class="Opis_Uzytkownicy">
					<input type="numbers" name="user" id="poletext" minlength="6" required>
				</div>


				<div class="Opis_Uzytkownicy2">
					Hasło
				</div>

				<div class="Opis_Uzytkownicy">
					<input type="password" name="pass" id="poletext" minlength="7" required>
				</div>

				<div class="Opis_Uzytkownicy2">
					Uprawnienia
				</div>
				
				<div class="Opis_Uzytkownicy">
					<select  id="poletext" name="title" class="form-control" required >
											<option  value selected ></option>
                                            <option value="administrator">Administrator</option>
                                            <option value="standardowy">Standardowy</option>
                                            <option value="konserwator">Konserwator</option>                              
					</select>
				</div>				

				<div class="Opis_Uzytkownicy2">
					Imie i Nazwisko
				</div>


				<div class="Opis_Uzytkownicy">
					<input type="text" name="imie_i_nazwisko" id="poletext" required>
				</div>


				<div class="Opis_Uzytkownicy2">
					kontakt
				</div>


				<div class="Opis_Uzytkownicy">
					<input type="text" name="kontakt" id="poletext" required>
				</div>

			
				<div class="Przycisk_Uzytkownicy">
					<input type="submit" name="przycisk" id="przycisk"  required value="Dodaj">
				</div>

			</div>
		</form>
			


			<br>
			<b>&nbsp  Zmień hasło:  </b>
			<form method="post" action="zmiana_hasla.php" >
				<div class="Wyszukaj_rezerwacje">	
								<div class="Widok_Rezerwacji_Wyszukaj">
									<input id="poletext" name="login" type="text" required  />
								</div>

								<div class="Widok_Rezerwacji_Wyszukaj">
									<input id="poletext" name="new_pass" type="password "minlength="7" required  />
								</div>

								<div class="Widok_Rezerwacji_Wyszukaj">
									<input class="przycisk" name="dousuniecia" type="submit" value="Akceptuj" />
								</div>


								<div class="Widok_Rezerwacji_opis">
									(Nazwa użytkownika)
								</div>

								<div class="Widok_Rezerwacji_Wyszukaj">
									(Nowe hasło)
								</div>
				</div>
			</form>
			
			

			<br><br>			
			<!-- Wskazanie konkrętnego użytkownika do usunięcia -->
			<b>&nbsp  Usuń użytkownika </b>
			<form method="post" action="usuniecie_konkretnego.php" >
				<div class="Wyszukaj_rezerwacje">	
									<div class="Widok_Rezerwacji_Wyszukaj">
										<input id="poletext" name="user" type="text" required  />
									</div>

									<div class="Widok_Rezerwacji_Wyszukaj">
										<input class="przycisk" name="dousuniecia" type="submit" value="Usuń" />
									</div>

									<div class="Widok_Rezerwacji_opis">
										(Login)
									</div>
				</div>
			</form>
		








			
			<?php /*
				// Wyczyszczenie całej tabeli
				$dbc = mysqli_connect('localhost', 'root', '', 'hotel') or die('Błąd połączenia z serwerem MYSQLI.'); 
				if(isset($_POST['submit_button']))
				{
					mysqli_query($dbc, 'TRUNCATE TABLE `users`');
					header("Location: " . $_SERVER['PHP_SELF']);
					exit();
				}
			*/?>
			<!--	 <br><br> <br><br> 
				<table id="formularze_uzytkownicy" cellpadding="8px">
					<tr>
						<td id="formularze_uzytkownicy" width="300px"> 
							<b> Usuń wszystkich użytkowników:</b> 
						</td>
						<td  id="formularze_uzytkownicy"><form method="post" action="" width="100px">
								<input id="przycisk" name="submit_button" type="submit" value="Usuń" id="formularze_uzytkownicy" />
							</form>	
						</td>
						<td width="800px">
						</td>
						
					</tr>
				</table> -->
				<br><br>
			
			
			
			
			
		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
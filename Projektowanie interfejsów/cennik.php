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
		<?php
			
			require_once "connect.php";
			$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
			//Wypisanie Danych
					$sql = "SELECT * FROM price_list WHERE idk='typ_pokoju'";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<b> <br> &nbsp Cennik: </b> <br> <table  id="tabela">
							<tr id="tabela3">   
									<th > Typ pokoju </th>
									<th width=8%> Cena (zł) </th>
									
							</tr>';
						while($row = $result->fetch_assoc()) {
							echo   "<tr>
										<td>"    . $row['service']   . " </td> 
										<td>"  				. $row['price']      . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak użytkowników</font>";
						} 
						?>








						<br> &nbsp <b> Zmień cene pokoju: </b><br>

			<form method="post" action="zmiana_ceny.php" >
				<div class="Wyszukaj_rezerwacje">	
							<div class="Widok_Rezerwacji_Wyszukaj">
								<select  id="poletext" name="type_service" class="form-control" required >
													<option  value selected ></option>
													<option value="Ekonomiczny">Ekonomiczny &nbsp &nbsp </option>
													<option value="Standard">Standard</option>
													<option value="Superior">Superior</option>
													<option value="Deluxe">Deluxe</option>
													<option value="Premier">Premier</option>
													<option value="Executive">Executive</option>
													
								</select>
							</div>

							<div class="Widok_Rezerwacji_Wyszukaj">
								<input id="poletext" name="new_price" type="text" required  />
							</div>

							<div class="Widok_Rezerwacji_Wyszukaj">
								<input id="przycisk" name="dousuniecia" type="submit" value="Wykonaj" />
							</div>


							<div class="Widok_Rezerwacji_opis">
								(Typ pokoju)
							</div>

							<div class="Widok_Rezerwacji_Wyszukaj">
								(Nowa cena)
							</div>
					</div>
			</form>





		<br>			
						<?php
					$sql = "SELECT * FROM price_list WHERE idk='posilek'";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<br> <table  id="tabela">
							<tr id="tabela3">   
									<th > Wyżywienie </th>
									<th width=8%> Cena (zł) </th>
									
							</tr>';
						while($row = $result->fetch_assoc()) {
							echo   "<tr>
										<td>"    . $row['service']   . " </td> 
										<td>"  				. $row['price']      . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak użytkowników</font>";
						} 
						?>





						<br> &nbsp <b> Zmień cene posiłku: </b><br>

			<form method="post" action="zmiana_ceny.php" >
				<div class="Wyszukaj_rezerwacje">	
							<div class="Widok_Rezerwacji_Wyszukaj">
								<select  id="poletext" name="type_service" class="form-control" required >
													<option  value selected ></option>
													<option value="Sniadanie">Śniadanie</option>
													<option value="Obiadokolacja">Obiadokolacja</option>
													<option value="Pelne">Pełne wyżywienie</option>
								</select>
							</div>

							<div class="Widok_Rezerwacji_Wyszukaj">
								<input id="poletext" name="new_price" type="text" required  />
							</div>

							<div class="Widok_Rezerwacji_Wyszukaj">
								<input id="przycisk" name="dousuniecia" type="submit" value="Wykonaj" />
							</div>


							<div class="Widok_Rezerwacji_opis">
								(Rodzaj posiłku)
							</div>

							<div class="Widok_Rezerwacji_Wyszukaj">
								(Nowa cena)
							</div>
					</div>
			</form>




		<br>

						<?php
			$sql = "SELECT * FROM price_list WHERE idk='lozko'";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<br> <table  id="tabela">
							<tr id="tabela3">   
									<th > Łóżka </th>
									<th width=8%> Cena (zł) </th>
									
							</tr>';
						while($row = $result->fetch_assoc()) {
							echo   "<tr>
										<td>"    . $row['service']   . " </td> 
										<td>"  				. $row['price']      . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak użytkowników</font>";
						} 
						
			$conn->close(); 
			
			?>





			<br> &nbsp <b> Zmień cene łóżka: </b><br>
			<form method="post" action="zmiana_ceny.php" >
			<div class="Wyszukaj_rezerwacje">	
						<div class="Widok_Rezerwacji_Wyszukaj">
							<select  id="poletext" name="type_service" class="form-control" required >
											<option  value selected ></option>
                                            <option value="Single">Single &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </option>
                                            <option value="Twin">Twin</option>
                                            <option value="Double">Double</option>
                                            <option value="Triple">Triple</option>
                                            <option value="Quad">Quad</option>
							</select>
						</div>

						<div class="Widok_Rezerwacji_Wyszukaj">
							<input id="poletext" name="new_price" type="text" required  />
						</div>

						<div class="Widok_Rezerwacji_Wyszukaj">
							<input id="przycisk" name="dousuniecia" type="submit" value="Wykonaj" />
						</div>


						<div class="Widok_Rezerwacji_opis">
							(Rodzaj łóżka)
						</div>

						<div class="Widok_Rezerwacji_Wyszukaj">
							(Nowa cena)
						</div>
				</div>
			</form>
		<br>
				
		






		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
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


		<div id="panel_glowny">
			<div class="SortowanieFormularz2">		
				<form method="post" action="sort.php" id="formularze_uzytkownicy" >
					
						<div class="SortowanieFormularz1">
							<b>Sortuj pokoje według: </b>
						</div>

						<div class="SortowanieFormularz">
							<select name="sort" id="poletext" required>
														<option value selected ></option>
														<option value="All">Wszystkie</option>
														<option value="Ekonomiczny">Ekonomiczny</option>													
														<option value="Standard">Standard</option>
														<option value="Superior">Superior</option>
														<option value="Deluxe">Deluxe</option>
														<option value="Premier">Premier</option>
														<option value="Executive">Executive</option>
							</select>
						</div>

						<div class="SortowanieFormularz">
							<input id="przycisk" name="button" type="submit" value="SORTUJ" />
						</div>
				</form>

				
			

					<br> <br>
					</div>
				<div class="SortowanieFormularz2">
					<form method="post" action="sort_bed.php" id="formularze_uzytkownicy" >
						<div class="SortowanieFormularz1">
							<b>Sortuj łóżka według: </b>
						</div>

						<div class="SortowanieFormularz">

							<select name="sort" id="poletext" required>
															<option value selected ></option>
															<option value="All">Wszystkie</option>
															<option value="Single">Single</option>													
															<option value="Twin">Twin</option>
															<option value="Double">Double</option>
															<option value="Triple">Triple</option>
															<option value="Quad">Quad</option>
							</select>

						</div>

						<div class="SortowanieFormularz">
							<input id="przycisk" name="button" type="submit" value="SORTUJ" />
						</div>
					
						</form>
				<br> <br>
				</div>
			<?php
					// Połączenie z bazą
					$link = mysqli_connect("localhost", "root", "", "hotel");
					if($link === false){
						die("ERROR: Nie połączono z bazą. " . mysqli_connect_error());
					}
					 
					// Attempt select query execution
					$sql = "SELECT room.id, room.Galeria, room.type, room.bedding, room.arrival, room. departure, price_list.price FROM room, price_list WHERE room.type = price_list.service AND place='Free'";
					if($result = mysqli_query($link, $sql)){
						if(mysqli_num_rows($result) > 0){
							echo '<table width=50% id=tabela >
								  <tr class="tabela3" >
									 <th>Numer</th>
									 <th>Galeria</th>
									 <th>Typ pokoju</th>
									 <th>Łóżko</th>
									 <th>Cena</th>
								 </tr>';
							while($row = mysqli_fetch_array($result)){
								    echo 
									'<tr> 
										  <td>' . $row['id'] .      '</td>';
								    echo '<td>' . $row['Galeria'] . '</td>';
									echo '<td>' . $row['type'] .    '</td>';
									echo '<td>' . $row['bedding'] . '</td>';
									echo '<td>' . $row['price'].    '</td>';
								   '</tr>';
							}
							echo "</table>";
							// Close result set
							mysqli_free_result($result);
						} else{
							echo "No records matching your query were found.";
						}
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
					 
					// Close connection
					mysqli_close($link);
					?>
			
					<br> <br>

		</div>


		<div id="stopka">

		</div>
	</div>
	
</body>

</html>
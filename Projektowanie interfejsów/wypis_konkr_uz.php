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
		<?php
				// Sprawdza czy użytkownik jest Konserwatorem. Jeśli jest to wywali do panelu.
				if ($uprawnienia=="konserwator") {
					header('location: panel.php');					
			} else {
			}
		?>

<form action="wypis_konkr_uz.php" method="POST">

<br>
<br>
&nbsp <b>Wyszukaj rezerwacje</b>
	<div class="Wyszukaj_rezerwacje">	
			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="text" id="poletext" name="firstname" required />
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="text" id="poletext" name="lastname"  required />
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="submit" class="przycisk" name="button" value="Pokaż"/>
			</div>

			<div class="Widok_Rezerwacji_opis">
				(Podaj imię)
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				(Podaj nazwisko)
			</div>
	</div>
</form>

<br>
<br>
&nbsp <b>Usuń rezerwacje</b>


<form action="usuniecie_rezerwacji.php" method="POST">
<div class="Wyszukaj_rezerwacje">	
			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="text" id="poletext" name="firstname" required />
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="text" id="poletext" name="lastname"  required />
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="text" id="poletext" name="email"  required />
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				<input type="submit" class="przycisk" name="button" value="Usuń"/>
			</div>

			<div class="Widok_Rezerwacji_opis">
				(Podaj imię)
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				(Podaj nazwisko)
			</div>

			<div class="Widok_Rezerwacji_Wyszukaj">
				(Podaj email)
			</div>
	</div>		
</form>

<br>
</br>



		<?php
				
			$firstname = $_POST['firstname'];	
			$lastname = $_POST['lastname'];	
			$link = mysqli_connect("localhost", "root", "", "hotel");
					if($link === false){
						die("ERROR: Nie połączono z bazą. " . mysqli_connect_error());
					}
					 
					// Attempt select query execution
					$sql = "SELECT roombook.id, roombook.Title, roombook.FName, roombook.LName, roombook.Email, roombook.nrid, roombook.TRoom, roombook.Phone, roombook.nodays, roombook.Bed, roombook.NRoom, roombook.Meal, roombook.cin, roombook.cout, roombook.stat, roombook.images, payment.fintot FROM roombook, payment WHERE roombook.nroom = payment.nroom and roombook.FName = '$firstname' and roombook.LName = '$lastname'";
					if($result = mysqli_query($link, $sql)){
						if(mysqli_num_rows($result) > 0){
							echo '<b> <br> &nbsp Rezerwacje: </b> <br> <table  class="tabela_rezerwacje_widok">
							<tr id="tabela3">   
									<th > Pokój </th>
									<th > Imie </th>
									<th > Nazwisko </th>
									<th > Kontakt  </th>
									<th > Telefon </th>
									<th > Zdjęcie dowodu  </th>
									<th > Typ pokoju  </th>
									<th > Łóżko  </th>
									<th > Posiłek  </th>
									<th > Przyjazd  </th>
									<th > Odjazd  </th>
									<th > Ilość dni  </th>
									<th > Pełna cena </th>
							</tr>';
							while($row = mysqli_fetch_array($result)){
								echo  "<tr>
										<td>"  . $row['NRoom']     . " </td> 
										<td>"  . $row['FName']   . " </td> 
										<td>"  . $row['LName']      . " </td> 
										<td>"  . $row['Email']     . " </td> 
										<td>"  . $row['Phone']     . " </td> 
										<td><a href='img/{$row["images"]}' width = 150  height=100 data-lightbox='images{$row["id"]}'><img src='img/{$row["images"]} 'width = 150 height=100 ></a></td>
										<td>"  . $row['TRoom']     . " </td> 
										<td>"  . $row['Bed']     . " </td> 
										<td>"  . $row['Meal']     . " </td> 
										<td>"  . $row['cin']     . " </td> 
										<td>"  . $row['cout']     . " </td> 
										<td>"  . $row['nodays']     . " </td> 
										<td>"  . $row['fintot']     . " <br> <a href='platnosc.php'> Szczegóły</a></td> 
								   </tr>";
						}
						    echo "</table>";
							// Close result set
							mysqli_free_result($result);
						} else{
							echo "Nie znaleziono rekordów.";
						}
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
					 
					// Close connection
					mysqli_close($link);
					?>
				<br> <br>
				<center>
					<form action="rezerwacje_widok.php" method="post">
						<input type="submit" id="przycisk" value="Pokaż wszystkie rezerwacje" />
					</form>
				</center>
			<br> <br>

		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
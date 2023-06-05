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
		</div>
		<div id="panel_boczny" >
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
		<br> <br> &nbsp <b> Znajdź klienta: </b>
			<form method="post" action="szukaj_platnosc.php" >
					<div class="Wyszukaj_rezerwacje">	
								<div class="Widok_Rezerwacji_Wyszukaj">
									<input id="poletext" name="fname" type="text" required  />
								</div>

								<div class="Widok_Rezerwacji_Wyszukaj">
									<input id="poletext" name="lname" type="text"  required  />
								</div>

								<div class="Widok_Rezerwacji_Wyszukaj">
									<input class="przycisk" name="button" type="submit" value="Szukaj" />
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



		<?php
				// Sprawdza czy użytkownik jest Konserwatorem. Jeśli jest to wywali do panelu.
				if ($uprawnienia=="konserwator") {
					header('location: panel.php');					
			} else {
			}
		?>
		<?php
			
			require_once "connect.php";
			$fname=$_POST['fname'];
			$lname=$_POST['lname'];
			$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
			//Wypisanie Danych
					$sql = "SELECT * FROM payment WHERE fname='$fname' AND lname='$lname'";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<b> <br> &nbsp Płatności: </b> <br> <table  class="tabela_rezerwacje_widok">
							<tr id="tabela3">   
								<th> Nr. pokoju  </th>
								<th> Imie </th>
								<th> Nazwisko </th>
								<th> Typ pokoju  </th>
								<th> Łóżko  </th>
								<th> Przyjazd  </th>
								<th> Odjazd  </th>
								<th> Ilość dni  </th>
								<th> Cena pokoju  </th>
								<th> Cena łóżka </th>
								<th> Wyżywienie</th>
								<th> Cena posiłku  </th>
								<th> Do zapłaty  </th>
							</tr>';
						while($row = $result->fetch_assoc()) {
							echo   "<tr>
										<td>"  . $row['nroom']     . " </td> 
										<td>"  . $row['fname']   . " </td> 
										<td>"  . $row['lname']      . " </td> 
										<td>"  . $row['troom']     . " </td> 
										<td>"  . $row['tbed']     . " </td> 
										<td>"  . $row['cin']     . " </td> 
										<td>"  . $row['cout']     . " </td> 
										<td>"  . $row['noofdays']     . " </td> 
										<td>"  . $row['ttot']     . " </td> 
										<td>"  . $row['mepr']     . " </td> 
										<td>"  . $row['meal']     . " </td> 
										<td>"  . $row['btot']     . " </td> 
										<td>"  . $row['fintot']     . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak wpisów</font>";
						} 
						?>
	
	
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
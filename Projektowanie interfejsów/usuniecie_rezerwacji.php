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
		<div id="gorna_belka" > 	
			<table>
				<tr>
					<td width="250px">
						<center><b> M&O </b></center>
					</td>
					<td width="1000px"></td>
					<td width="500px" align="right">
						<?php
							echo $_SESSION['imie_i_nazwisko'];		// Wypisanie nazwy użytkownika 
							 echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";  // Po prostu twarda spacja. 
							echo '<a href="logout.php" id="link" >Wyloguj się </a>'; // link do wylogowania
						?>
					</td>
				</tr>
			</table>
		</div>
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
		<?php
			$firstname = $_POST['firstname'];	
			$lastname = $_POST['lastname'];	
			$email = $_POST['email'];

			
			
			require_once "connect.php";
			$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						
			$newUser="SELECT * FROM roombook WHERE FName='$firstname' AND LName='$lastname'";
			$result = $conn->query($newUser);	
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$room = $row['TRoom'];
					$beeed = $row['Bed'];
					echo "$room";
					echo "$beeed";
				}
			} else {
				echo "0 results";
			}
	

			// Usunięcie użytkownika z tabeli
			$sql = "DELETE FROM roombook WHERE FName='$firstname' and LName='$lastname' and Email='$email'";
				$spr = "select * froom room";
				$psql = "UPDATE room SET place='Free', arrival='0', departure='0' WHERE type='$room' and bedding='$beeed'";

				if (mysqli_query($conn, $psql)) {
					echo "";
					} else {
					echo "Błąd podczas podmiany: " . mysqli_error($conn);
					}
						

			if (mysqli_query($conn, $sql)) {
				echo "Rezerwacja usunięta";
				header('location: rezerwacje_widok.php');
			} else {
				echo "Błąd podczas usuwania " . mysqli_error($conn);
			}		

		// Usunięcie płatności
			$sql = "DELETE FROM payment WHERE FName='$firstname' and LName='$lastname'";


			if (mysqli_query($conn, $sql)) {
				echo "Płatność usunięta";
				header('location: rezerwacje_widok.php');
			} else {
				echo "Błąd podczas usuwania " . mysqli_error($conn);
			}		
			
		
		?>
		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
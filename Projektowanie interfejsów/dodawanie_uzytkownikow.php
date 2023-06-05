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
		<div id="panel_boczny" >
	<center>
		<table id="tabela" width="100%" height="2"  cellpadding="15"></table>
		<table id="tabela" width="100%" height="75"  cellpadding="15">
			<tr>
				<td id="kolumna">
				<a href="wolne_pokoje.php" id="a" >Wolne pokoje</a>
				</td>
			</tr>
		</table>
		<table id="tabela" width="100%" height="75"  cellpadding="15">
			<tr>
				<td id="kolumna">
				<a href="zajete_pokoje.php" id="a" >Zajęte pokoje</a>
				</td>
			</tr>
			</table>
			<?php
			$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
				if ($uprawnienia=="konserwator") {		
			} else {
				echo '<table id="tabela" width="100%" height="75"  cellpadding="15">
						<tr>
							<td id="kolumna" > <a href="rezerwacje.php" id="a"> Rezerwacje </a> </td> 
						</tr> </table>' ;
			}
			?>
			<?php
			$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
				if ($uprawnienia=="konserwator") {		
			} else {
				echo '<table id="tabela" width="100%" height="75"  cellpadding="15">
						<tr>
							<td id="kolumna" > <a href="rezerwacje_widok.php" id="a"> Widok rezerwacji </a> </td> 
						</tr> </table>' ;
			}
			?>
			<?php
			$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
				if ($uprawnienia=="konserwator") {		
			} else {
				echo '<table id="tabela" width="100%" height="75"  cellpadding="15">
						<tr>
							<td id="kolumna" > <a href="rezerwacje_widok_oczekujacy.php" id="a"> Rezerwacje oczekujące </a> </td> 
						</tr> </table>' ;
			}
			?>

			<?php
			$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
				if ($uprawnienia=="konserwator") {
				
					
			} else {
				echo '<table id="tabela" width="100%" height="75"  cellpadding="15">
						<tr>
							<td id="kolumna" > <a href="platnosc.php" id="a"> Płatność </a> </td> 
						</tr> </table>' ;
			}
			?>
			
			<?php
			$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
				if ($uprawnienia=="konserwator") {		
			} else {
				echo '<table id="tabela" width="100%" height="75"  cellpadding="15">
						<tr>
							<td id="kolumna" > <a href="cennik.php" id="a"> Cennik </a> </td> 
						</tr> </table>' ;
			}
			?>
		
	<?php
		$uprawnienia = $_SESSION['uprawnienia'];	// Sprawdza czy użytkownik jest Administratorem. Jeśli jest to wyświetli dodatkowy panel.
		if ($uprawnienia=="administrator") {
				echo '<table id="tabela" width="100%" height="75"  cellpadding="15">
						<tr>
							<td id="kolumna" > <a href="uzytkownicy.php" id="a"> Użytkownicy </a> </td> 
						</tr> </table>' ;
					
		} else {
		}
	?>
	<table id="tabela" width="100%" height="2"  cellpadding="15"></table>
		</div>
		<div id="panel_glowny" border=1>
		<?php
				// Sprawdza czy użytkownik jest Konserwatorem. Jeśli jest to wywali do panelu.
				if ($uprawnienia=="konserwator") {
					header('location: panel.php');					
			} else {
			}
		?>
			<center>
			<?php
				$user=$_POST['user'];
				if ($user=="Administrator")
				{
					echo "<br> <b> <font color=red>Nie można utworzyć użytkownika z takim loginem </font><b> ";
				} else {
				require_once "connect.php";
				$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if 
						($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
				@$user=$_POST['user'];
				@$pass=$_POST['pass'];
				@$uprawnienia=$_POST['title'];
				@$imie_i_nazwisko=$_POST['imie_i_nazwisko'];
				@$kontakt=$_POST['kontakt'];
							//Wstawianie danych
				$sql = "INSERT INTO users (user, pass, uprawnienia, imie_i_nazwisko, kontakt) values ('$user', '$pass', '$uprawnienia', '$imie_i_nazwisko', '$kontakt')";
			echo "<br><b>Dane dodanego użytkownika:</b>";
				if ($conn->query($sql) === TRUE ) {
					echo 
					"<br><br> &nbsp &nbsp <font color=blue>login: </font>". $user. 
					"&nbsp &nbsp <font color=blue>Hasło:  </font>". "<b id=pass>$pass</b>". 
					"&nbsp &nbsp <font color=blue>Uprawnienia:     </font>". $uprawnienia. 
					"&nbsp &nbsp <font color=blue>Imie i Nazwisko:    </font>". $imie_i_nazwisko. 
					"&nbsp &nbsp <font color=blue>Kontakt:   </font>". $kontakt;
				} else{
					echo "Błąd wstawiania danych: " .$conn->error;
				}
				}

				header('location: uzytkownicy.php');
			?>
				<br><br>
				<form action="uzytkownicy.php" method="POST">
				<input type="submit" name="przycisk" value="Powrót" id="przycisk">
				</form>
			</center>
		
			
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
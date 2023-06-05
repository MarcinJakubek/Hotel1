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
				require_once "connect.php";
				$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if 
						($conn->connect_error) {
							die("Połączenie nieudane: " . $conn->connect_error);
						}
				@$name=$_POST['name'];
				@$surname=$_POST['surname'];
				@$nr_evidence=$_POST['nr_evidence'];
				@$phone=$_POST['phone'];
				@$email=$_POST['email'];
							//Wstawianie danych
				$sql = "INSERT INTO clients (name, surname, nr_evidence, phone, email) values ('$name', '$surname', '$nr_evidence', '$phone', '$email')";
			echo "<br><b>Dane osobowe dodanego klienta:</b>";
				if ($conn->query($sql) === TRUE ) {
					header('location: dodawanie_rezerwacji.php');
				} else{
					echo "Błąd wstawiania danych: " .$conn->error;
				}
			?>
				<br><br>
				<form action="rezerwacje.php" method="POST">
				<input type="submit" name="przycisk" value="Powrót" id="przycisk">
				</form>
			</center>
		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
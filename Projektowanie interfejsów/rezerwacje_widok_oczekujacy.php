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
	
			<?php
			
			require_once "connect.php";
			$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
			//Wypisanie Danych
					$sql = "SELECT * FROM roombook WHERE roombook.stat='NotConform'";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<b> <br> &nbsp Rezerwacje: </b> <br> <table  id="tabela"  cellpadding=3 border=0 width="100%">
							<tr id="tabela3">   
									<th > #    </th>
									<th > Imie </th>
									<th > Nazwisko </th>
									<th > Email  </th>
									<th > Numer dowodu  </th>
									<th > Numer telefonu  </th>
									<th > Typ pokoju  </th>
									<th > Łóżko  </th>
									<th > Posiłek  </th>
									<th > Przyjazd  </th>
									<th > Odjazd  </th>
									<th > Ilość dni  </th>
							</tr>';
						while($row = $result->fetch_assoc()) {
							echo   "<tr id=gwiersz>
										
										<td>"  . $row['id']       . " </td>
										<td id=dwiersz>"  . $row['FName']   . " </td> 
										<td>"  . $row['LName']      . " </td> 
										<td id=dwiersz>"  . $row['Email']     . " </td> 
										<td id=pass>"  . $row['nrid']     . " </td> 
										<td id=dwiersz>"  . $row['Phone']     . " </td> 
										<td>"  . $row['TRoom']     . " </td> 
										<td id=dwiersz>"  . $row['Bed']     . " </td> 
										<td>"  . $row['Meal']     . " </td> 
										<td id=dwiersz>"  . $row['cin']     . " </td> 
										<td>"  . $row['cout']     . " </td> 
										<td id=dwiersz>"  . $row['nodays']     . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak rezerwacji oczekujących</font>";
						} 
				
			
			$conn->close();
			?>
			<br> <br>
			&nbsp <b>Wyszukaj rezerwacje:</b>
			
			<form action="wypis_konkr_uz_oczekujocy.php" method="POST">
				<table cellpadding="3" id="formularze_uzytkownicy">
					
					<tr>
						<td> <input type="text" id="poletext" name="firstname" required /> </td> 
						<td> <input type="text" id="poletext" name="lastname"  required /></td> 
						<td><input type="submit" id="przycisk" name="button" value="Pokaż"/> </td>
						<td width="100%"> </td>
					</tr>
					<tr>
						<td><center><font size="3">(Podaj Imię)</font></center></td>
						<td><center><font size="3">(Podaj nazwisko)</font></center></td>
						<td> </td>
						<td> </td>
					</tr>
					
				</table>
			</form>
			<br> <br>
			&nbsp <b>Potwierdź rezerwacje:</b>
			
			<form action="potwierdzenie_rezerw.php" method="POST">
				<table cellpadding="3" id="formularze_uzytkownicy">
					
					<tr>
						<td> <input type="text" id="poletext" name="firstname" required /> </td> 
						<td> <input type="text" id="poletext" name="lastname"  required /></td> 
						<td> <input type="text" id="poletext" name="nrid"  required /></td> 
						<td><input type="submit" id="przycisk" name="button" value="Potwierdź"/> </td>
						<td width="100%"> </td>
					</tr>
					<tr>
						<td><center><font size="3">(Podaj Imię)</font></center></td>
						<td><center><font size="3">(Podaj nazwisko)</font></center></td>
						<td><center><font size="3">(Numer dowodu)</font></center></td>
						<td> </td>
						<td> </td>
					</tr>
					
				</table>
			</form>
			
			<br> <br>
			&nbsp <b>Usuń rezerwacje:</b>
			<form action="usuniecie_rezerwacji.php" method="POST">
				<table cellpadding="3" id="formularze_uzytkownicy">
					<tr>
						<td> <input type="text" id="poletext" name="firstname" required /> </td> 
						<td> <input type="text" id="poletext" name="lastname"  required /></td> 
						<td> <input type="text" id="poletext" name="email"  required /></td>
						<td> <input type="submit" id="przycisk" name="button" value="Usuń"  required /> </td>
					</tr>
					<tr>
						<td><center><font size="3">(Podaj Imię)</font></center></td>
						<td><center><font size="3">(Podaj nazwisko)</font></center></td>
						<td><center><font size="3">(Podaj email)</font></center> </td>
						<td width="100%"> </td>
					</tr>
				</table>
			</form>
			<br> <br>
			<?php /*
				// Wyczyszczenie całej tabeli
				$dbc = mysqli_connect('localhost', 'root', '', 'hotel') or die('Błąd połączenia z serwerem MYSQLI.'); 
				if(isset($_POST['submit_button']))
				{
					mysqli_query($dbc, 'TRUNCATE TABLE `roombook`');
					header('location: platnosc.php');
					exit();
				}
			*/?>
				<!-- <br><br> <br><br> 
				<table id="formularze_uzytkownicy" cellpadding="8px">
					<tr>
						<td id="formularze_uzytkownicy" width="300px"> 
							<b> Usuń wszystkie rezerwacje:</b> 
						</td>
						<td  id="formularze_uzytkownicy"><form method="post" action="" width="100px">
								<input id="przycisk" name="submit_button" type="submit" value="Usuń" id="formularze_uzytkownicy" />
							</form>	
						</td>
						<td width="800px">
						</td>
						
					</tr>
				</table> -->
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
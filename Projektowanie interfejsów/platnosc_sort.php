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
			$sort = $_POST['sort'];
			if($sort=="All"){
				header('location: platnosc.php');	// Przeniesienie do danego dokumentu
			} else {
				require_once "connect.php";
			$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
			//Wypisanie Danych
					$sql = "SELECT * FROM payment WHERE stat_paid='$sort'";
					$result = $conn->query($sql);
					
				if ($result->num_rows > 0) {
					echo '<b> <br> &nbsp Płatności: </b> <br> <table  id="tabela"  cellpadding=4 border=0 width="100%">
							<tr id="tabela3">   
									<th> Płeć   </th>
									<th> Imie </th>
									<th> Nazwisko </th>
									<th> Typ pokoju  </th>
									<th> Łużko  </th>
									<th> Ilość Łużek  </th>
									<th> Przyjazd  </th>
									<th> Odjazd  </th>
									<th> Ilość dni  </th>
									<th> Cena pokoju  </th>
									<th> Cena łóżka </th>
									<th> Posiłek  </th>
									<th> Cena posiłku  </th>
									<th> Do zapłaty  </th>
									<th> Status  </th>
									
									
							</tr>';
						while($row = $result->fetch_assoc()) {
							echo   "<tr id=gwiersz>
										<td>"  . $row['title']       . " </td>
										<td id=dwiersz>"  . $row['fname']   . " </td> 
										<td>"  . $row['lname']      . " </td> 
										<td id=dwiersz>"  . $row['troom']     . " </td> 
										<td>"  . $row['tbed']     . " </td> 
										<td id=dwiersz>"  . $row['nroom']     . " </td> 
										<td>"  . $row['cin']     . " </td> 
										<td id=dwiersz>"  . $row['cout']     . " </td> 
										<td>"  . $row['noofdays']     . " </td> 
										<td id=dwiersz>"  . $row['ttot']     . " </td> 
										<td>"  . $row['mepr']     . " </td> 
										<td id=dwiersz>"  . $row['meal']     . " </td> 
										<td>"  . $row['btot']     . " </td> 
										<td id=dwiersz>"  . $row['fintot']     . " </td> 
										<td>"  . $row['stat_paid']     . " </td> 
								   </tr>";
						}
						    echo "</table>";
						} else {
							echo "<br> &nbsp <font color=red>Brak wpisów</font>";
						} 
			}
			
				
			?>
			<br> <br> 
			<form method="post" action="" id="formularze_uzytkownicy" >
					<table cellpadding="8px"  >
						<tr>
							<td width="202px"><b>Sortuj płatności według: </b></td>
							<td><select name="sort" id="poletext" required>
													<option value selected ></option>
													<option value="All">Wszystkie</option>
													<option value="paid">Opłacone</option>													
													<option value="not paid">Nieopłacone</option>
					</select> </td>
							<td><input id="przycisk" name="button" type="submit" value="Sortuj" /> </td>
						</tr>
					</table>
				</form>
			<br> <br> &nbsp <b> Potwierdz opłate usług: </b>
			<form method="post" action="oplacenie.php" id="formularze_uzytkownicy" >
				<table cellpadding="8px" >
					<tr>
						<td > <input id="poletext" name="fname" type="text" required  /> </td>
						<td > <input id="poletext" name="lname" type="text"  required  /> </td>
						<td > <input id="poletext" name="price" type="text" required  /> </td>
						<td><input id="przycisk" name="button" type="submit" value="Wykonaj" /> </td>
					</tr>
						<td><center><font size="3">(Imie klienta)</font><center></td> 
						<td><center><font size="3">(Nazwisko klienta)</font><center></td>
						<td><center><font size="3">(Kwota do zapłacenia)</font><center></td>
				</table>
			</form>
		<br> <br> &nbsp <b> Znajdź klienta: </b>
			<form method="post" action="szukaj_platnosc.php" id="formularze_uzytkownicy" >
				<table cellpadding="8px" >
					<tr>
						<td > <input id="poletext" name="fname" type="text" required  /> </td>
						<td > <input id="poletext" name="lname" type="text"  required  /> </td>
						<td><input id="przycisk" name="button" type="submit" value="Szukaj" /> </td>
					</tr>
						<td><center><font size="3">(Imie klienta)</font><center></td> 
						<td><center><font size="3">(Nazwisko klienta)</font><center></td>
				</table>
			</form>
			<br> <br>
			<?php
				// Wyczyszczenie całej tabeli
				$dbc = mysqli_connect('localhost', 'root', '', 'hotel') or die('Błąd połączenia z serwerem MYSQLI.'); 
				if(isset($_POST['submit_button']))
				{
					mysqli_query($dbc, 'TRUNCATE TABLE `payment`');
					header('location: platnosc.php');
					exit();
				}
			?>
				 <br><br> <br><br> 
				<table id="formularze_uzytkownicy" cellpadding="8px">
					<tr>
						<td id="formularze_uzytkownicy" width="300px"> 
							<b> Usuń wszystkie płatności:</b> 
						</td>
						<td  id="formularze_uzytkownicy"><form method="post" action="" width="100px">
								<input id="przycisk" name="submit_button" type="submit" value="Usuń" id="formularze_uzytkownicy" />
							</form>	
						</td>
						<td width="800px">
						</td>
						
					</tr>
				</table>
		</div>
		<div id="stopka">
		</div>
	</div>
</body>

</html>
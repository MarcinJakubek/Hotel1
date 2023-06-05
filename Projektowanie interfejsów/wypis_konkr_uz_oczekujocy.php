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
				
			$firstname = $_POST['firstname'];	
			$lastname = $_POST['lastname'];	
			$link = mysqli_connect("localhost", "root", "", "hotel");
					if($link === false){
						die("ERROR: Nie połączono z bazą. " . mysqli_connect_error());
					}
					 
					// Attempt select query execution
					$sql = "SELECT * FROM roombook WHERE FName='$firstname' and LName='$lastname' AND stat='NotConform'";
					if($result = mysqli_query($link, $sql)){
						if(mysqli_num_rows($result) > 0){
							echo ' <br> &nbsp <b>Rezerwacje:</b><table id="tabela"  cellpadding=3 border=0 width="100%">
								  <tr id="tabela3">
									 <th > #    </th>
									<th > Imie </th>
									<th > Nazwisko </th>
									<th > Email  </th>
									<th > National  </th>
									<th > Numer dowodu  </th>
									<th > Numer telefonu  </th>
									<th > Typ pokoju  </th>
									<th > Łóżko  </th>
									<th > Posiłek  </th>
									<th > Przyjazd  </th>
									<th > Odjazd  </th>
									<th > Ilość dni  </th>
								 </tr>';
							while($row = mysqli_fetch_array($result)){
								echo "<tr id=gwiersz>
										
										<td>"  . $row['id']       . " </td>
										<td id=dwiersz>"  . $row['FName']   . " </td> 
										<td>"  . $row['LName']      . " </td> 
										<td id=dwiersz>"  . $row['Email']     . " </td> 
										<td>"  . $row['National']     . " </td> 
										<td id=dwiersz>"  . $row['nrid']     . " </td> 
										<td>"  . $row['Phone']     . " </td> 
										<td id=dwiersz>"  . $row['TRoom']     . " </td> 
										<td>"  . $row['Bed']     . " </td> 
										<td>"  . $row['Meal']     . " </td> 
										<td id=dwiersz>"  . $row['cin']     . " </td> 
										<td>"  . $row['cout']     . " </td> 
										<td>"  . $row['nodays']     . " </td> 
								   </tr>";
							}
							echo "</table>";
							// Close result set
							mysqli_free_result($result);
						} else{
							echo "<br><center><font color=red>Nie znaleziono klienta</font></center>";
						}
					} else{
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					}
					 
					// Close connection
					mysqli_close($link);
					?>
				<br> <br>
				<center>
					<form action="rezerwacje_widok_oczekujacy.php" method="post">
						<input type="submit" id="przycisk" value="Pokaż wszystkie rezerwacje oczekujące" />
					</form>
				</center>
				<br><br>
				&nbsp <b>Wyszukaj rezerwacje:</b>
				<form action="" method="POST">
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
		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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
			
			require_once "connect.php";
			$link = mysqli_connect("localhost", "root", "", "hotel");
			if($link === false){
				die("ERROR: Nie połączono z bazą. " . mysqli_connect_error());
			}
			//Wypisanie Danych
					
					$sql = "SELECT roombook.id, roombook.Title, roombook.FName, roombook.LName, roombook.Email, roombook.nrid, roombook.TRoom, roombook.Phone, roombook.nodays, roombook.Bed, roombook.NRoom, roombook.Meal, roombook.cin, roombook.cout, roombook.stat, roombook.images, payment.fintot FROM roombook, payment WHERE roombook.nroom = payment.nroom";
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
										<td>"  . $row['fintot']     . " <a href='platnosc.php'> Szczegóły</a></td> 
								   </tr>";
						}
						    echo "</table>";
							// Close result set
							mysqli_free_result($result);
						} else{
							echo "&nbsp &nbsp &nbsp &nbspBrak wpisanych rezerwacji";
						}
					} else{
						echo "ERROR: Błąd tabeli $sql. " . mysqli_error($link);
					}
				
					mysqli_close($link);
			?>
			<br> <br>

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
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>


</body>

</html>
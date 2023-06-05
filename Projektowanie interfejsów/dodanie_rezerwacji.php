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
			<?php	
						require_once "connect.php";
						$conn = new mysqli($host, $db_user, $db_password , $db_name);
						// Check connection
						if 
						($conn->connect_error) {
							die("Połączenie niudane: " . $conn->connect_error);
						}
							$troom=$_POST['troom'];
							$bed=$_POST['bed'];
							$meal=$_POST['posilek'];
							$cin=$_POST['cin'];
							$cout=$_POST['cout'];
							$title=$_POST['title'];
							$fname=$_POST['fname'];
							$lname=$_POST['lname'];
							$email=$_POST['email'];
							$phone=$_POST['phone'];
							$new = "Conform";


							if(isset($_POST["submit"])){
								if($_FILES["image"]["error"] == 4){
								  echo
								  "<script> alert('Image Does Not Exist'); </script>"
								  ;
								}
								else{
								  $fileName = $_FILES["image"]["name"];
								  $tmpName = $_FILES["image"]["tmp_name"];
							  
								  $validImageExtension = ['jpg', 'jpeg', 'png'];
								  $imageExtension = explode('.', $fileName);
								  $imageExtension = strtolower(end($imageExtension));
							  
									$newImageName = uniqid();
									$newImageName .= '.' . $imageExtension;
							  
									move_uploaded_file($tmpName, 'img/' . $newImageName);
								}
							  }
							

				
								$newUser="SELECT * FROM room WHERE type='$troom' and bedding='$bed' ";
									$result = $conn->query($newUser);	
									if ($result->num_rows > 0) {
												// output data of each row
										while($row = $result->fetch_assoc()) {
										$place = $row['place'];
									}
								
								} else {
									echo "Brak wyników w poleceniu służącym do pobrania zmiennej z tabeli";
								} 
								
								
								if ("$place"=="NotFree") {
									echo "<div class ='DodanieRezerwPokojZajety'><b>Ten pokój jest już zajęty</b></div>";
										$conn->close();
								} else { 
								require_once "connect.php";
							
							
										$conn = new mysqli($host, $db_user, $db_password , $db_name);
										// Check connection
										if ($conn->connect_error) {
											die("Connection failed: " . $conn->connect_error);
										}
												$newUser="SELECT * FROM room WHERE  type='$troom' AND bedding='$bed' ";
												$result = $conn->query($newUser);	
												if ($result->num_rows > 0) {
															// output data of each row
													while($row = $result->fetch_assoc()) {
													$nroom = $row['id'];
												
												}
											} else {
												echo "0 results";
											} 
								
								$sql = "INSERT INTO roombook (Title, FName, LName, Email, Phone, TRoom, Bed, NRoom, Meal, cin, cout, stat, nodays, images ) 
								VALUES ('$title','$fname','$lname','$email','$phone',
																	'$troom','$bed','$nroom','$meal',
																	'$cin','$cout','$new', datediff('$cout','$cin'),'$newImageName')"; 
									
								if ($conn->query($sql) === TRUE ) {
								} else{
									echo "Błąd wstawiania danych: " .$conn->error;
								}
								
											$servername = "localhost";
											$username = "root";
											$password = "";
											$dbname = "hotel";
											
											// Create connection
											$conn = mysqli_connect($servername, $username, $password, $dbname);
											// Check connection
											if (!$conn) {
												die("Połączenie nieudane: " . mysqli_connect_error());
											}
											
											$spr = "select * from room";
											$sql = "UPDATE room SET place='NotFree', arrival='$cin', departure='$cout' WHERE type='$troom' and bedding='$bed'";

											if (mysqli_query($conn, $sql)) {
												echo "";
											} else {
												echo "Błąd podczas podmiany: " . mysqli_error($conn);
											}
							
							

							
							
							require_once "connect.php";
							
							
							$conn = new mysqli($host, $db_user, $db_password , $db_name);
							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}
									$newUser="SELECT * FROM price_list WHERE  service='$troom' ";
									$result = $conn->query($newUser);	
									if ($result->num_rows > 0) {
												// output data of each row
										while($row = $result->fetch_assoc()) {
										$trooma = $row['service'];
										$pricea = $row['price'];
										/*echo "$trooma";
										echo "$pricea";*/
									
									}
								} else {
									echo "0 results";
								} 
								
									$newUser="SELECT * FROM price_list WHERE  service='$meal' ";
									$result = $conn->query($newUser);	
												// output data of each row
										while($row = $result->fetch_assoc()) {
										$bedq = $row['service'];
										$priceq = $row['price'];
										/*echo "$bedq";
										echo "$priceq"; */
										}
										
								
								
								
								
									$newUser="SELECT * FROM price_list WHERE  service='$bed' ";
									$result = $conn->query($newUser);	
									if ($result->num_rows > 0) {
												// output data of each row
										while($row = $result->fetch_assoc()) {
										$bedc = $row['service'];
										$pricec = $row['price'];
										/*echo "$bedc";
										echo "$pricec";*/
									}
								} else {
									echo "0 results";
								}
								
								$newUser="SELECT * FROM roombook WHERE  fname='$fname' and lname='$lname' ";
									$result = $conn->query($newUser);	
									if ($result->num_rows > 0) {
												// output data of each row
										while($row = $result->fetch_assoc()) {
										$days = $row['nodays'];
										/*echo "$days";*/
									}
								
								} else {
									echo "0 results";
								} 
								echo "<br>";
								$price_troom;
								$price_bed;
								$price_eat;
								$suma;
								$price_troom= "$pricea" * "$days";
								$price_bed= "$pricec" * "$days";
								$price_eat= "$priceq" * "$days";
								$suma= "$price_troom"+"$price_bed"+"$price_eat";
								
								$servername = "localhost";
								$username = "root";
								$password = "";
								$dbname = "hotel";

								require_once "connect.php";
								$conn = new mysqli($host, $db_user, $db_password , $db_name);
								// Check connection
								if 
								($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
								}
								
								$stat="not paid";
								$sql = "INSERT INTO payment (title, fname, lname, troom, tbed, nroom, cin, cout, ttot, fintot, mepr, meal, btot, noofdays, stat_paid) values 
								('$title', '$fname', '$lname', '$troom', '$bed', '$nroom','$cin','$cout','$price_troom','$suma','$price_bed','$meal','$price_eat','$days','$stat')";
			echo "<div class ='DodanieRezerwDivKontener'><b>Należność</b>";
				if ($conn->query($sql) === TRUE ) {
					echo 
					"<div class ='DodanieRezerwDiv'>&nbsp &nbsp Cena pokoju: <font color=#be3a34>$price_troom</font> (zł)". 
					"&nbsp &nbsp Cena posiłku: <font color=#be3a34>$price_eat</font> (zł)". 
					"&nbsp &nbsp Cena łóżka: <font color=#be3a34>$price_bed</font> (zł)". 
					"&nbsp &nbsp Należność: <font color=#be3a34>$suma</font> (zł)</div></div>";
				} else{
					echo "Błąd wstawiania danych: " .$conn->error;
				}								
							
						}
													
			?>


			<center>
			<br><br>
			<form action="rezerwacje.php"/>
				<input type="submit" id="przycisk" value="Powrót"/>
			</form>
			<br><br>
			</center>
		
		</div>
		<div id="stopka">
		</div>
	</div>
	
</body>

</html>
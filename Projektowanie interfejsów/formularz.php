<?php
	session_start();	// Rozpoczęcie sesji
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))	// Sprawdzenie, czy użytkownik jest już zalogowany
	{
		header('location:panel.php');	// Przeniesienie użytkownika do panel.php
		exit();	// Przerwanie wykonywania skrypku. (Jeśli warunek będzie spełniony dalszy skrypt nie będzie wykonywany)
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" /> <!-- Podpięcie .css do strony -->
	<title>Zarządzanie hotelem</title>
</head>


<body style="background-image: url('Logo/TloV2.png'); align=center;">

		<div id="tabaluga">

			<form action="zaloguj.php" method="post">
					
				&nbsp &nbsp <b>Login:</b><center><input type="text" name="login" id="poletext" required ></center>
					
					<br> 
					
				&nbsp &nbsp <b>Hasło:</b><center><input type="password" name="haslo" id="poletext" required ></center>
					
					<br> 
					<center>
						 <input type="submit" name="przycisk" value="Zaloguj się" id="przycisk">
					</center>
			</form>
			<br>
		<center>
			<?php
				if(isset($_SESSION['blad'])) // Sprawdzenie czy zmienna istnieje (isset)
				echo $_SESSION['blad'];	// Wypisanie komunikatu o błędzie (Źródło w pliku zaloguj.php w elsie linija 52.
			?>
		</center>

		</div>

</body>

</html>
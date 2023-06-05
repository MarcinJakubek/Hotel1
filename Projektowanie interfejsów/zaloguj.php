<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" /> <!-- Podpięcie .css do strony -->
	<title>Zarządzanie hotelem</title>
</head>


<body>
	
	<?php
	session_start(); // Rozpoczęcie sesi zmiennej. Zmienna musi znajdować się na początku dokumentu. Ciąg dalszy linia 38!!!
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
		{
			header('location: formularz.php');
			header('location: formularz.php');
			exit();
		}
	require_once "connect.php"; // Dołączenie innego dokumentu php do aktualnego dokumentu php. 
	// Polecenie "require" jest zamienne z "include". 
	// Różnią się tym, że require po napotkaniu błędu przerwie wykonywanie skryptu. 
	// "include" Po napotkaniu błędu i nie dołączeniu dodatkowego dokumentu wykona skrypt który jest dalej w kodzie. 
	// Dodatkowy operator "_once" wykrywa, czy jesteśmy już podpięci pod ten dokument. Jeśli jesteśmy to nie wykona niepotrzebie tego polecenia.
	
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); // Łączenie z bazą danych. ?Dane z bazy znajdują się w dokumencie który podpieliśmy?
						// Małpa służy do wyciszania błędów
						
		if ($polaczenie->connect_errno!=0) // Połączenie się nie udało. "0" oznacza wartość false. 
		{
			echo "Error:".$polaczenie->connect_errno;
		}
		else
		{
			$login=$_POST['login'];
			$haslo=$_POST['haslo'];		
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
			
			if ($rezultat = @$polaczenie->query(
			sprintf("SELECT * FROM users WHERE user='%s' AND pass='%s'",
			mysqli_real_escape_string($polaczenie,$login),
			mysqli_real_escape_string($polaczenie,$haslo))))
			{
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow>0)
				{
					$_SESSION['zalogowany'] = true;
					
					$wiersz = $rezultat->fetch_assoc();	// Tablica asocjacyjna
					$_SESSION['id'] = $wiersz['id']; // Tworzenie sesi dla zmiennej którą mogą używać inne dokumenty. Znajduje się na serwerze więc jest niewidoczna przez użytkowników. 11 linia rozpoczęcie.
					$_SESSION['uprawnienia'] = $wiersz['uprawnienia']; 
					$_SESSION['user'] = $wiersz['user']; 
					$_SESSION['imie_i_nazwisko'] = $wiersz['imie_i_nazwisko']; 
					$_SESSION['kontakt'] = $wiersz['kontakt']; 
					
					unset($_SESSION['blad']);	// Całkowite usunięcie niepotrzebnej zmiennej
					
					$rezultat->free_result();
					
					header('location: panel.php'); // Przeniesienie do pliku panel.php
					
				}else{
					$_SESSION['blad'] = '<span style = "color: red" > Nieprawidłowy login lub hasło </span>';
					header('location: formularz.php');
				}
			}
			
			$polaczenie->close(); //Zamknięcie połączenia
		}

	?>
</body>

</html>
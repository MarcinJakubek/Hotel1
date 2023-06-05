<?php
	session_start();	// Rozpoczęcie sesii
	session_unset();	// Zakończenie sessi, czyli wylogowanie
	header('location: formularz.php'); 	// Przeniesienie do strony index.php
?>


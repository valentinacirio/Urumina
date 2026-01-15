<?php
	$erroreDB = ""; //inizializzo variabile vuota che memorizzera eventuali errori
	try { //blocco try, se si avra un errore passa al catch
	  $connessione = new PDO("mysql:dbname=urumina; host=localhost; charset=utf8;", "root", "" ); //crea connessione al database sql usando PDO. Specifico nome del database, che il database è sullo stesso computer (con localhost) e la codifica UTF-8 per caratteri accentati
	} //root e il nome utente del dataase e password non c'e
	catch (PDOException $ex) { //se si verifica errore nel blocco try si passa qui, al catch
	  $erroreDB = $ex->getMessage(); //salva il messaggio di errore nella variabile errorDB
	}
?>


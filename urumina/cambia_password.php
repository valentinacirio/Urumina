<?php //file che cambia la password dopo aver inviato il form di cambio password
session_start();
include("connessione_db.php");

if(!isset($_SESSION['username'])){//se utente non loggato lo manda alla pagina di login
    header("location:urumina_login.php");
    exit; //exit blocca l'esecuzione del codice. Se invece e loggato il codice continua
}

//recupero i dati dal form
$username = $_POST['username'];
$nuovaPassword = $_POST['nuova_password'];
$nuovaPasswordHash = password_hash($nuovaPassword, PASSWORD_DEFAULT); //faccio hash della nuova password
//cerca l'username nel database
$sql = "SELECT username FROM utenti WHERE username = :username";
$stmt = $connessione->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR); //PDO::PARAM_STR specifica il tipo di dato (stringa) serve per evitare sql injection
$stmt->execute();
//recupero il risultato come array associativo
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//se non esiste nel database stampa messaggio di errore
if (!$row) {
    die('Questo non è il tuo username. <a href="pagina_cambio_password.php">Torna indietro</a>');
}
//invece se esiste, controlla che l'username della sessione coincida con quello inserito nel form (che sta anche nel database)
elseif($_SESSION['username'] == $row['username']) {
    //preparo la query di update
    $stmt = $connessione->prepare("UPDATE `utenti` SET `password` = :password WHERE username = :username");
    //associo i parametri 
    $stmt->bindParam(':password', $nuovaPasswordHash, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    //eseguo la query
    if ($stmt->execute()) {
    //se va a buon fine messaggio di successo altrimenti di problema
        echo "Password cambiata con successo. Torna alla homepage <a href='urumina_homepage.php'>Homepage</a>";
    } else {
        die("Problema di connessione con il server.");
    }
//se l'username del form non coincide con quello di sessione (cioe dell'utente loggato) stampa messaggio di errore
} else {
    echo "Questo non è il tuo username. <a href='pagina_cambio_password.php'>Torna indietro</a>";
}
?>

<html> 
<head>
   <TITLE>Cambio password</TITLE>
   <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8">
   <LINK REL="STYLESHEET" TYPE="TEXT/CSS" HREF="urumina_css.css">
</head>
<body>
    <TABLE class="header" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
        <TR>
            <TD VALIGN="MIDDLE">
                <P class="titolo_header">
                    <a href="urumina_homepage.php" style="text-decoration:none; color:inherit; cursor:pointer;">Urumina</a>
                </P>
                <P class="sottotitolo_header">Rendi la tua vita più splendente</P>
            </TD>
        </TR>
    </TABLE>
</body>
</html>
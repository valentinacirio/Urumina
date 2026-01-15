<?php //questo file manda la query per eliminare i dati dell'utente
session_start();
include("connessione_db.php");

if(!isset($_SESSION['username'])){//se utente non loggato lo manda alla pagina di login
    header("location:urumina_login.php");
    exit;
}

//prendo username dalla sessione e password dal form
$username = $_SESSION['username'];
$password = $_POST['password'];
//cerco l'utente nel database
$sql = "SELECT username, password FROM utenti WHERE username = :username"; //creo la query
$stmt = $connessione->prepare($sql); //preparo la query
$stmt->bindParam(':username', $username, PDO::PARAM_STR); //PDO::PARAM_STR specifica il tipo di dato (stringa) serve per evitare sql injection
$stmt->execute(); //eseguo la query

$row = $stmt->fetch(PDO::FETCH_ASSOC); //restituisce una riga dal database sotto forma di array associativo (con parametro e valore)
//se l'utente non esiste stampa "Utente non trovato"
if (!$row) {
    die("Utente non trovato. <a href='pagina_elimina_account.php'>Torna indietro</a>");
}
//se invce trova l'utente ma la password del database non corrisponde con quella inserita dall'utente stampa "Questa non e la tua password"
if (!password_verify($password, $row['password'])) { //password_verify per controllo password hashate altrimenti non trovera la psw nel database e non puo eliminare l'account, non la trovera perche la cerca in chiaro ma nel db e hashata
    die("Questa non è la tua password <a href='pagina_elimina_account.php'>Torna indietro</a>");
} 
//poi controlla se l'username di sessione combacia con quello trovato nel database (e inserito dall'utente)
elseif($_SESSION['username'] == $row['username']) {
    //preparo la query di delete
    $stmt = $connessione->prepare("DELETE FROM `utenti` WHERE username = :username"); //non serve password nella query perche basta eliminare l'account col suo nome utente dato nel codice di registrazione abbiamo impostato che e unico per persona. La psw l'abbiamo gia verificata con pasword_verify
    //associo il valore $username al suo parametro nella query (non lo faccio per password perche non l'ho messa nella query)
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    //eseguo la query
    if ($stmt->execute()) {
        echo "Account eliminato con successo. Torna alla <a href='home.php'>Home</a>";
    } else {
        die("Problema di connessione con il server.");
    }
}
?>

<html> 
<head>
   <TITLE>Elimina account</TITLE>
   <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8">
   <LINK REL="STYLESHEET" TYPE="TEXT/CSS" HREF="urumina_css.css">
</head>
<body>
    <TABLE class="header" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
        <TR>
            <TD VALIGN="MIDDLE">
                <P class="titolo_header">Urumina</P>
            </TD>
        </TR>
    </TABLE>
</body>
</html>
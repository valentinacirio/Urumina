<?php //questo file manda la query al database per inserire i dati del nuovo utente che ha compilato il form di registrazione (urumina_registration)
session_start();
require_once "connessione_db.php"; 
//se uni dei campi del form e vuoto rimanda a urumina_registration, la pagina del form di registrazione
if (!isset($_POST["username"]) || empty($_POST["username"]) ||
    !isset($_POST["email"]) || empty($_POST["email"]) ||
    !isset($_POST["password"]) || empty($_POST["password"]) ||
    !isset($_POST["conferma_password"]) || empty($_POST["conferma_password"])) {
      header("Location: urumina_registration.php");
      exit;
    }
//prendo i dati del form
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$conferma_password = $_POST["conferma_password"];
//controllo ce password e conferma_password siano uguali
if ($password !== $conferma_password) {
    echo "Le due password non corrispondono.<br>";
    echo "<a href='urumina_registration.php'>Ritorna alla pagina di registrazione</a>";
    exit;
}
//faccio hash della password ora
$password_hash = password_hash($password, PASSWORD_DEFAULT);
//procedo controllando se ce gia un utente con stesso username nel database:
$query = "SELECT * FROM utenti WHERE username = :username"; //creo la query
$stmt = $connessione->prepare($query); //preparo la query. $connessione è il nome della connessione che abbiam creato nel file connessione_db.php
$stmt->bindParam(":username", $username); //collega il parametro :username alla variabile $username
$stmt->execute(); //esegue la query
if ($stmt->rowCount() > 0) { //se il numero di righe trovate e > 0 cioe ha trovato un risultato con quel username
    echo "Esiste già un utente con questo username.<br>"; 
    echo "<a href='urumina_registration.php'>Torna alla pagina della registrazione</a>";
    exit;
}
//inserisco nuvo utente nel database
$query = "INSERT INTO utenti (username, email, password) VALUES (:username, :email, :password)";
$stmt = $connessione->prepare($query);//preparo la query
//non serve bindParam di password perche passo i valori direttamente dentro execute (si puo fare in entrambi i modi)
$eseguito = $stmt->execute([":username" => $username,":email" => $email,":password" => $password_hash,]); //esegue la query passando i valori ai parametri nel database

if ($eseguito) { //if $eseguito = true cioe andato a buon fine ci manda alla pagina di login
  header("Location: urumina_login.php");
  exit;
}else{
  echo "Errore nella registrazione.";
}
?>

<!DOCTYPE html>
<head>
    <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8">
    <link rel="stylesheet" type="text/css" href="urumina_css.css"/>
    <title>Form Registrazione</title>
</head>
<body>
</body>
</html>
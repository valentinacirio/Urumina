<?php
session_start(); //session_strat va invocato all'inizio prima di invocare html  
include("connessione_db.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") { //controlla che il form sia stato inviato con metodo post
    if (!isset($_POST["username"]) || empty($_POST["username"]) ||
        !isset($_POST["password"]) || empty($_POST["password"])){
            header("Location: urumina_login.php"); //se username o pswrd sono vuoti rimanda alla pagina login
            exit;
        }else{ //se invece sono stati compilati entrambi
            $username = $_POST["username"]; //salva i dati del form in delle variabili
            $password = $_POST["password"];
        $sql = "SELECT username, email, password FROM utenti WHERE username = :username"; //creo la query per cercarli nel database
        $stmt = $connessione->prepare($sql); //preparo la query. $connessione è il nome della connessione che abbiam creato nel file connessione_db.php
        $stmt->bindParam(':username', $username, PDO::PARAM_STR); //associa i parametri della query alle variabili ($username e $password)
        //$stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute(); //eseguo la query
        if ($stmt->rowCount() > 0) { //se c'e gia un utente con quei dati nel database
            $row = $stmt->fetch(PDO::FETCH_ASSOC); //prende i dati di quell'utente
            
            //ora verifico la password
            if (password_verify($password, $row['password'])) { //se corretta cioe $password inserita dall'utente = a quella trovata nel database nel risultato $row di quell'utente $row['password']...
                
            $_SESSION['username'] = $row['username']; //salva i dati nella sessione
            $_SESSION['email'] = $row['email'];
        }else{
            echo "<a href='urumina_login.php'>Credenziali errate! Torna alla pagina di login</a>";
            exit;
        }
    }
    if (!isset($_SESSION["username"])) { //se non c'e gia una sessione attiva
    header("Location: urumina_login.php");//ti indirizza alla pagina di login
    exit;
    }
}
}
?>

<HTML>
<HEAD>
   <TITLE>Urumina homepage</TITLE>
   <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8">
   <LINK REL="STYLESHEET" TYPE="TEXT/CSS" HREF="urumina_css.css">
</HEAD>
<BODY>
    <TABLE class="header" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
        <TR>
            <TD VALIGN="MIDDLE">
                <P class="titolo_header">Urumina</P>
                <P class="sottotitolo_header">Rendi la tua vita più splendente</P>
            </TD>
        </TR>
    </TABLE>

<div style="display: flex;
    flex-wrap: wrap;
    justify-content: center;
    width: 100%;">
    <div class="frame"><a href= 'pagina_cambio_password.php'>Cambia password</a></div>
    <div class="frame"><a href= 'http://localhost/urumina/app_client_Bootstrap/index.php'> Le mie recensioni </a></div><!--il percorso del file come quello che scriverei nella url sul web quindi con http e localhost-->
    <div class="frame"><a href= 'http://localhost/urumina/recensioni_di_tutti/app_client_Bootstrap/recensioni_di_tutti.php'> Recensioni di tutti </a></div>
    <div class="frame"><a href= 'logout.php'> Logout </a></div>
    <div class="frame"><a href= 'pagina_elimina_account.php'> Elimina account </a></div>
</div>

<P class="titoli_pagina"><strong>Buongiorno <?= $_SESSION["username"] ?>! Scopri tutti i nostri prodotti formulati con ingredienti idratanti per mentenere la pelle fresca e radiosa</strong></P>

  <div class="frame">
   <img src="immagini\prismpowder.webp" alt="Urumina glow powder" width="180" height="180" >
   <br>
   <a href="glow_prism_powder.php">Urumina Glow Prism Powder</a>
  </div>
  <div class="frame">
   <img src="immagini\body.webp" alt="Urumina yellow cream" width="130" height="180">
  <br>
   <a href="yellowcream.php">Urumina Pure Glow UV Milk Yellow</a>
  </div>
  <div class="frame">
   <img src="immagini\lavender.webp" alt="Urumina lavender cream" width="130" height="180">
   <br>
   <a href="lavendercream.php">Urumina Pure Glow UV Milk Levender</a>
  </div>
    <div class="frame">
   <img src="immagini\mist.webp" alt="Urumina mist blue" width="130" height="180">
   <br>
   <a href="mistblue.php">Urumina Pure Glow Mist Blue</a>
  </div>
    <div class="frame">
   <img src="immagini\mistlilac.webp" alt="Urumina mist lilac" width="130" height="180">
   <br>
   <a href="mistlilac.php">Urumina Pure Glow Mist Lilac</a>
  </div>

</body>
</html>




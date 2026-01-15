<?php
session_start();
include("connessione_db.php");
if(!isset($_SESSION['username'])){//utente non loggato
header("location:urumina_login.php");
exit;
}
?>
<!DOCTYPE html>
<head>
   <TITLE>Elimina account</TITLE>
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
                <P class="sottotitolo_header">Conferma la tua password per eliminare il tuo account</P>
            </TD>
        </TR>
    </TABLE>

    <form class="form" action="delete_account.php" method="post">
        <P class="sottotitolo_header">
            Password:<br>
            <input type="text" NAME="password" required>
        </P>
        <input type="submit" value="Conferma" >
    </form>

    Torna <a href="urumina_homepage.php">indietro</a>
    
</body>
</html>
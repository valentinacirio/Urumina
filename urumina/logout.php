<?php
session_start();
?>

<HTML>
<HEAD>
   <TITLE>Urumina logout</TITLE>
   <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8">
   <LINK REL="STYLESHEET" TYPE="TEXT/CSS" HREF="urumina_css.css">
</HEAD>
<BODY>
    <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
        <TR>
            <TD VALIGN="MIDDLE">
                <P class="titolo_header">
                    <a href="home.php" style="text-decoration:none; color:inherit; cursor:pointer">Urumina</a>
                </P>
            </TD>
        </TR>
    </TABLE>

<?php
if (isset($_SESSION["username"])) { //controllo se la variabile di sessione username è impostata
	$user = $_SESSION["username"]; //salvo username in una variabile prima di distruggere la sessione
	session_unset(); //quando facciamo logout prima con unset togliamo la sessione dalla memoria	
    session_destroy(); //poi chiudiamo la memoria distruggendo i cookie
?>		
<P class="sottotitolo_header">Ciao <?= $user ?>...sessione chiusa, arrivederci!</P>
<P class="sottotitolo_header">Vuoi accedere nuovamente?<a href="urumina_login.php">Accedi</a></P>
<?php
}else{ //se la variabile di sessione user NON è impostata
?>
<p class="sottotitolo_header">Sessione non valida</p>
<p class="sottotitolo_header">Vuoi accedere? <a href="urumina_login.php">Accedi</a></p>
<?php
}
?>

</BODY>
</HTML>

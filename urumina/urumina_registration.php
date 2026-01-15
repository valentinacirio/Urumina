<?php
session_start();
?>

<!DOCTYPE html>
<HTML>
<HEAD>
   <TITLE>Urumina Create account</TITLE>
   <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8">
   <LINK REL="STYLESHEET" TYPE="TEXT/CSS" HREF="urumina_css.css">
</HEAD>
<BODY>

<TABLE class="header" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
<TR>
<TD VALIGN="MIDDLE">
 <P class="titolo_header">
 <a href="home.php" style="text-decoration:none; color:inherit; cursor:pointer;">Urumina</a>
 </P>
  <P class="sottotitolo_header">
  Crea un account
 </P>
</TD>
</TR>
</TABLE>

<FORM class="form" method="POST" action="conferma_registrazione.php"> <!--Uso POST per non esporre username e password nell'URL-->
   <P class="sottotitolo_header">
      Username:<br>
      <input type="text" NAME="username" required>
   </P>
   <P class="sottotitolo_header">
      Email:<br>
      <input type="text" NAME="email" required>
   </P>
   <P class="sottotitolo_header">
      Password:<br>
      <input type="password" NAME="password" required>
   </P>
   <p class="sottotitolo_header">
      Conferma Password:<br>
      <input type="password" name="conferma_password" required>
   </p>
   <br>
   <input type="submit" value="Invia">
</FORM>

Hai già un account? <a href="urumina_login.php">Accedi</a>
</BODY>
</HTML>
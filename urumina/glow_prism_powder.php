<?php
session_start(); //session_strat va invocato all'inizio prima di invocare html
$profilo="home.php"; //se non ci sono sessioni attive o se utente non autenticato, la pagina di destinazione sara home.php
if(isset($_SESSION['username'])){//se invece c'e la sessione username, ci fa entrare in urumina_homepage.php
  $profilo="urumina_homepage.php"; 
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
        <P class="sottotitolo_header"> 
          <a href="<?php echo $profilo; ?>" style="text-decoration:none; color:inherit; cursor:pointer;">Urumina</a>
        </P>
      </TD>
    </TR>
  </TABLE>
  
  <div style="display: flex; justify-content: center">
    <div class="frame_scheda_prodotto">
      <img src="immagini/prismpowder1.webp" alt="Urumina glow powder" width="380" height="380" >
    </div>
    <div class="frame_scheda_prodotto">
      <p class="sottotitolo_header"><strong>Glow Prism Powder</strong></p>
      <br>
      Dettagli prodotto:
      <p id="cmd1"><a href="#" id="addInfo">Scopri i dettagli</a></p>
      <p id="ris"></p>
      <br>
      Ingredienti principali:
      <p id="cmd2"><a href="#" id="addIngredienti">Scopri gli ingredienti</a></p>
      <p id="ingredienti"></p>
    </div>
  </div>
  
  <script>//parte di javascript
  document.getElementById('addInfo').addEventListener("click", (e) => {//prende l'elemento con id addInfo col metodo getElementbyId e col metodo addEventListener all'evento del click esegue la funzione e descritta tra {}
  e.preventDefault(); //funzione e contiene preventDefault che previene comportamenti di default come ricaricamento pagina o seguire il link (dice non seguire il ink, scrivo io cosa succede al clikc anche se in questo caso il link è finto)
  document.getElementById('cmd1').classList.add('noShow');//prende l'elemento con id cmd1 e gli aggiunge la classe css chiamata noShow (che fa scomparire il link)
  
  const dettagli = "The luxurious blend of eight beauty essence ingredients gives skin a translucent, fresh, glowing complexion.";
  const lista = document.getElementById('ris');
  lista.innerHTML = dettagli; 
  });

  document.getElementById('addIngredienti').addEventListener("click", (e) => {//prende l'elemento con id addInfo col metodo getElementbyId e col metodo addEventListener all'evento del click esegue la funzione e descritta tra {}
  e.preventDefault(); //funzione e contiene preventDefault che previene comportamenti di default come ricaricamento pagina o seguire il link (dice non seguire il ink, scrivo io cosa succede al clikc anche se in questo caso il link è finto)
  document.getElementById('cmd2').classList.add('noShow');//prende l'elemento con id cmd1 e gli aggiunge la classe css chiamata noShow (che fa scomparire il link)

  const ingredienti = "Talc, synthetic fluorphlogopite, silica, diethylhexyl succinate, nylon-12, argania spinosa kernel oil, canina rose fruit oil, ascorbyl dipalmitate, centella asiatica leaf extract, ascorbyl tetraisopalmitate, tocopherol, niacinamide, retinyl palmitate, jojoba seed oil, hydrolyzed collagen, hydrolyzed hyaluronic acid, butylene glycol, bht, aminopropyltriethoxysilane, amodimethicone, corn oil, dimethiconol, dimethicone, hydrogen dimethicone, water, yellow 4, red 226";
  const lista = document.getElementById('ingredienti');
  lista.innerHTML = ingredienti; 
  });
   
</script> 
</BODY>
</HTML>
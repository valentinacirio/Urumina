<?php
session_start(); 
$profilo="home.php";
if(isset($_SESSION['username'])){ //se la sessione e attiva
  $profilo="/urumina/urumina_homepage.php"; //l variabile profilo ci porta a urumina_homepage, In questo caso metto anche urumina/ cioe specifico il percorso perche urumina_homepage non si trova nella stessa cartella di questo file
}
?>
<!doctype html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recensioni</title>
	
	<!--css di bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<!--bootstrap JavaScript-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
	integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script><!--L'attributo 
	integrity è una strategia di sicurezza che contiene un hash che corrisponde al link del css hashato. Controlla che il link css e 
	il codice hash in integrity siano uguali. per controllare ad esempio che un hacker non abbia messo un link css diverso maligno-->
    <!--icone Bootstrap-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<!--css fatto da me-->
	<link href="css/style.css" rel="stylesheet" />
	<!--includo sempre app.js che contiene le funzionalita del prodotto -->
	<script src="/urumina/app_client_Bootstrap/app.js"></script>
</head>

<body>
	<TABLE class="header" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
		<TR>
			<TD VALIGN="MIDDLE">
				<P class="sottotitolo_header">
					<a href="<?php echo $profilo; ?>" style="text-decoration:none; color:inherit; cursor:pointer;">Urumina</a>
				</P>
			</TD>
		</TR>
	</TABLE>
	<div id="app" class="container-fluid">
		<div class="page-header">
			<h1 id="page-title">Recensioni</h1>
		</div>
		<!--contenuto della pagina che si riempie dinamicamnete tramite javascript-->
		<div id="page-content"></div>
	</div>

	<script src="read-reviews.js"></script>    <!--carico qui tutti gli altri javascript solo dopo div class=page-haeder e page-content-->
	<script src="read-one-review.js"></script>
	<script src="create-review.js"></script>
	<script src="search-review.js"></script>

	<script>    
		showReviews(); //mostra le recensioni, senza questa funzione non si vedrebbe nulla

	</script>

</body>
</html>
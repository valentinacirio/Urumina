<?php
session_start();
require 'cors.php';

//specifico il formato della risposta (json)
header("Content-Type: application/json; charset=UTF-8");
 
//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

//creo una connessione al database management system
$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Review
$review = new Review($db);

//leggo le keywords (parametro s) nella richiesta (GET) 
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";//se $_GET['id'] è settata, la leggo, altrimenti a $keywords assegno la stringa vuota

//invoco il metodo search() che restituisce la lista dei prodotti che soddisfano la query
$stmt = $review->search($keywords); //$stmt è un recordset (insieme di righe del database)
//creo array che lista le recensioni
$reviews_list = array();
$reviews_list["reviews"] = array();
foreach ($stmt as $row) {
    $single_review = array(	//costruisco un array associativo ($single_review) che rappresenta ogni singolo recensione
        "id" => $row['id'],
        "title" => $row['titolo'],
        "text" => $row['testo'],
        "reviewed_product" => $row['prodotto_recensito'],
        "product_name" => $row['nome_prodotto']
    );
	//e lo aggiungo al fondo della lista di recensioni
    array_push($reviews_list["reviews"], $single_review); //la funzione array_push inserisce al fondo di un array
}
//trasformo la coppia reviews_list in un oggetto JSON vero e proprio e lo invio in HTTP response
echo json_encode($reviews_list);
?>
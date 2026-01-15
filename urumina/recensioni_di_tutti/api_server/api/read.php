<?php
session_start(); //session_start perche continua qui la sessione, voglio  memorizzare le mail degli utenti per mostrare ad ogni utente solo le sue recensioni
require 'cors.php';

//specifico il formato del contenuto (JSON)
header("Content-Type: application/json; charset=UTF-8");

//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';
 
//creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
$email = $_SESSION['email']; //email utente loggato

//creo un'istanza di Recensione
$review = new Review($db);

//invoco il metodo read() che restituisce l'elenco dei prodotti
$stmt = $review->read($email);

//if($stmt->rowCount()>0) {
if ($stmt) { //se ci sono delle recensioni...
    //creo una coppia "recensioni: [lista-di-recensioni]"
    $reviews_list = array();
    $reviews_list["reviews"] = array();

    foreach ($stmt as $row) { 
		//costruisco un array associativo ($single_review) che rappresenta ogni singola recensione...
        $single_review = array(
            "id" => $row['id'],
            "title" => $row['titolo'],
            "text" => $row['testo'],
            "reviewed_product" => $row['prodotto_recensito'],
            "product_name" => $row['nome_prodotto']
        );
		//...e lo aggiungo al fondo di lista-di-recensioni
        array_push($reviews_list["reviews"], $single_review); //funzione array_push inserisce l'array $single_review al fondo dell'array $reviews_list["reviws"] 
    }

    http_response_code(200); //imposto il response code 200 = tutto ok

	//trasformo in un oggetto JSON vero e proprio e lo invio in HTTP response
    echo json_encode($reviews_list);
}
else { //se invece non ci sono  prodotti...
    http_response_code(404); //imposto il response code 404 = Not found
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "No reviews found"));
}
?>
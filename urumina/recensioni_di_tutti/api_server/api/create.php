<?php
session_start();
require 'cors.php';

//specifico il formato della risposta (JSON)
header("Content-Type: application/json; charset=UTF-8");
 
//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

//creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Recensione
$review = new Review($db);

//leggo i dati nel body della request (metodo POST)
$data = json_decode(file_get_contents("php://input"));
 
//controllo che i dati ci siano...
if( !empty($data->title) &&
    !empty($data->text) &&
    !empty($data->reviewed_product)
) {
 
    //inserisco i valori nelle variabili d'istanza dell'oggetto $review
    $review->setTitle($data->title);
    $review->setText($data->text);
    $review->setReviewed_product($data->reviewed_product);
 
	//invoco il metodo create() che crea una nuova recensione (metodo in Review.php)
    if($review->create()){ //se va a buon fine...
        http_response_code(201); //response code 201 = created
        //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
        echo json_encode(array("message" => "Review was created"));
    }
    else{ //se la creazione fallisce...
        http_response_code(503); //response code 503 = service unavailable
        //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
        echo json_encode(array("message" => "Unable to create review"));
    }
}
else { //invece se i dati sono incompleti
    http_response_code(400); //response code 400 = bad request
	//e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "Unable to create review. Data is incomplete:"
		. " titolo=" . (empty($data->title) ? "null" : $data->title) . " testo=" . (empty($data->text) ? "null" : $data->text) . " prodotto_recensito=" . (empty($data->reviewed_product) ? "null" : $data->reviewed_product)));
}
?>
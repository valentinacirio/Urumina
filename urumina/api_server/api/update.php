<?php
require 'cors.php';

//definisco il formato della risposta (json)
header("Content-Type: application/json; charset=UTF-8");
 
//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Prodotto
$review = new Review($db);

//leggo i dati nel body della request (metodo POST/PUT/PATCH)
$data = json_decode(file_get_contents("php://input"));//json_decode trasforma JSON in PHP cosi da accedere ai campi con $data->id, $data->title, ecc.

//inserisco i valori nelle variabili di istanza dell'oggetto $review (compreso l'id che indica quale aggiornare)
$review->setId($data->id);
$review->setTitle($data->title);
$review->setText($data->text);
$review->setReviewed_product($data->reviewed_product);

//invoco il metodo update() che aggiorna i dati del prodotto
if($review->update()) { //se va a buon fine
    http_response_code(200); //response code 200 = tutto ok
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "Review was updated"));
    }
else { //se l'aggiornamento fallisce
    http_response_code(503); //response code 503 = service unavailable
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "Unable to update review"));
}
?>
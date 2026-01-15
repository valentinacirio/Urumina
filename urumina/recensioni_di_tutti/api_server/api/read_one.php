<?php
require 'cors.php';

//dichiaro il metodo consentito per la request
header("Access-Control-Allow-Methods: GET");
 
//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Review
$review = new Review($db);

//leggo l'id nella richiesta (GET) e lo inserisco nella variabile di istanza id dell'oggetto $review
//se $_GET['id'] è settata, la leggo, altrimenti invoco la funzione die() che uccide lo script
$id_toRead = isset($_GET['id']) ? $_GET['id'] : die();
$review->setId($id_toRead);
 
// invoco il metodo readOne() che restituisce le info del prodotto su cui viene invocato (l'id è gia nella variabile id di $review!)
$review->readOne();
 
if($review->title!=null) { //se il prodotto esiste (il titolo non è nullo)...
    //costruisco un array associativo ($single_review) che rappresenta la recensione...
    $single_review = array(
        "id" => $review->getId(),
        "title" => $review->getTitle(),
        "text" => $review->getText(),
        "reviewed_product" => $review->getReviewed_product(),
        "product_name" => $review->getProduct_name()
    );
    http_response_code(200); //response code 200 = tutto ok
    echo json_encode($single_review); // ... e lo restituisco nella response, dopo averlo trasformato in oggetto JSON
}
else { 
    http_response_code(404);
    echo json_encode(array("message" => "Review does not exist"));
}
?>
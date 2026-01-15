<?php
require 'cors.php';

//dichiaro il metodo consentito per la request
header("Access-Control-Allow-Methods: GET");
 
//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

//creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Review
$review = new Review($db);

//leggo l'id nella richiesta (GET) e lo inserisco nella variabile di istanza id dell'oggetto $review 
$id_toRead = isset($_GET['id']) ? $_GET['id'] : die(); //(forma compatta di if)

$review->setId($id_toRead);//salva l'id nell'oggeto review
 
//invoco il metodo readOne() che restituisce le info della recensione su cui viene invocato (l'id ora è gia nella variabile id di $review)
//la funzione readOne() non restituisce un risultato, modifica l'oggetto su cui viene invocata (cioe la recensione) a cui chiedo i dati 
$review->readOne();
 
if($review->title!=null) { //se la recensione esiste (il titolo non e nullo)
    //costruisco un array associativo ($single_review) che rappresenta la recensione
    $single_review = array(
        "id" => $review->getId(),
        "title" => $review->getTitle(),
        "text" => $review->getText(),
        "reviewed_product" => $review->getReviewed_product(),
        "product_name" => $review->getProduct_name()
    );
    http_response_code(200); //response code 200 = tutto ok
    echo json_encode($single_review); //e single_review lo restituisco nella response, dopo averlo trasformato in oggetto JSON
}
else { //se invece il nome del prodotto non esiste
    http_response_code(404); //response code 404 = Not found
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "Review does not exist"));
}
?>
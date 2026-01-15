<?php
require 'cors.php';

//specifico il formato della risposta (JSON)
header("Content-Type: application/json; charset=UTF-8");
 
//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

//creo una connessione al DBMS database manager system
$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Recensione
$review = new Review($db);

//dato che alla chiamata dell'endpoint abbiamo passato l'id nell'URL, leggo l'id nella richiesta GET
//poi inserisco l'id nella variabile di istanza id dell'oggetto $review 
$id_toDel = isset($_GET['id']) ? $_GET['id'] : die(); //forma compatta di if: se $_GET['id'] è settata, la leggo, altrimenti invoco la funzione die() che "uccide" lo script

$review->setId($id_toDel);

//invoco il metodo delete()
if ($review->delete()) { //se va a buon fine
    http_response_code(200); //response code 200 = tutto ok
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "Review was deleted"));
    }
else { //se il metodo fallisce
    http_response_code(503); //response code 503 = service unavailable
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "Unable to delete review"));
}
?>
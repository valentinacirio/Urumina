<?php
require 'cors.php';

header("Content-Type: application/json; charset=UTF-8");
 
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Review.php';

$database = new Database();
$db = $database->getConnection();
 
$review = new Review($db);

// leggo le keywords (parametro s) nella richiesta (GET) 
//se $_GET['id'] è settata, la leggo, altrimenti a $keywords assegno la stringa vuota
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";
 
//invoco il metodo search() che restituisce la lista delle recensioni che soddisfano la query
$stmt = $review->search($keywords); 

$reviews_list = array();
$reviews_list["reviews"] = array();
foreach ($stmt as $row) {
    $single_review = array(
        "id" => $row['id'],
        "title" => $row['titolo'],
        "text" => $row['testo'],
        "reviewed_product" => $row['prodotto_recensito'],
        "product_name" => $row['nome_prodotto']
    );
    array_push($reviews_list["reviews"], $single_review); 
}
echo json_encode($reviews_list);
?>
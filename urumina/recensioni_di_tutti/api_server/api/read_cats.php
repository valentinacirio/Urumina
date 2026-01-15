<?php
require 'cors.php';

//includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Product.php';
 
//creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
//creo un'istanza di Prodotto 
$product = new Product($db);
 
//invoco il metodo read() che restituisce l'elenco dei prodotti (metodo in Product.php)
$stmt = $product->read();

if($stmt) { //se ci sono dei prodotti...
    //creo una coppia prodotti: [lista-di-prodotti]
    $products_list = array();
    $products_list["products"] = array();

    foreach ($stmt as $row) {  
		//costruisco un array associativo ($product_item) che rappresenta ogni singolo prodotto...
        $product_item = array(
            "product_name" => $row['nome_prodotto']
        );
		//...e lo aggiungo al fondo di lista-di-prodotto
        array_push($products_list["products"], $product_item);
    }
 
    http_response_code(200); //response code 200 = tutto ok

	//trasformo la coppia prodotti: [lista-di-prodotti] in un oggetto JSON vero e proprio e lo invio in HTTP response
    echo json_encode($products_list);
}
else { //se non trova nessun prodotto
    http_response_code(404); //404 = Not found
    echo json_encode(array("message" => "No products found"));
}
?>
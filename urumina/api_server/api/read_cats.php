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
$stmt = $product->read(); //$stmt è un recordset (cioe un set che contiene piu record) che contiene tutti i risultati della query

if($stmt) { //= a if($stmt->rowCount()>0) cioe se ci sono dei prodotti
    //creo una coppia chiave-valore cioe products_list:[products] //[products] è la lista di prodotti contenuta in $products_list
    $products_list = array();
    $products_list["products"] = array();

    foreach ($stmt as $row) { 
		//costruisco un array associativo ($product_item) che rappresenta ogni singolo prodotto
        $product_item = array(
            "product_name" => $row['nome_prodotto']
        );
		// ...e lo aggiungo al fondo della lista di prodotti in $product_list
        array_push($products_list["products"], $product_item); //funzione array_push inserisce al fondo di un array
    }
 
    http_response_code(200); //imposto response code 200 = tutto ok

	//trasformo products_list in un oggetto JSON vero e proprio e lo invio in HTTP response
    echo json_encode($products_list);
}
else { //se non ci sono prodotti
    http_response_code(404); //response code 404 = Not found
    //e creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    echo json_encode(array("message" => "No products found"));
}
?>
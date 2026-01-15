<?php
class Product { 
	
	//connessione (inizializzata nel costruttore)
    private $conn;
 
    //proprietà dei prodotti, in questo caso ne abbiamo solo una
    public $product_name; //se riesco metto proprieta in inglese per distinguerle

    //il construttore inizializza la variabile per la connessione al DB
    public function __construct($db){
        $this->conn = $db;
    }

    public function getProduct_name(){
        return $this->product_name;
    }
    public function setProduct_name($product_name_par){
        $this->product_name = $product_name_par;
    }

	//servizio di lettura di tutti i prodotti
	function read() {
		//estraggo tutti i prodotti 
		$query = "SELECT * FROM prodotti ORDER BY nome_prodotto;";
		//preparo la query
		$stmt = $this->conn->prepare($query); 
		//eseguo la query
		$stmt->execute(); //$stmt conterra il risultato dell'esecuzione della query (in questo caso un recordset)

		return $stmt; 
	}	
}
?>
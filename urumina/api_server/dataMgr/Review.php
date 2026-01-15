<?php 
class Review { 
	
	//connessione (inizializzata nel costruttore)
    private $conn;
 
    //proprietà delle recensioni , le scrivo in inglese se posso per distinguerle
    public $id;
    public $title; 
    public $text;
    public $reviewed_product; //questa e la proprieta su cui si fa il join con product_name
    public $product_name; //proprieta di prodotti
	public $user_email;
	public $email; //questa e proprieta della tabella utenti
 
    //il construttore inizializza la variabile per la connessione al DB
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id_par) {
        $this->id = $id_par;
    }
    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title_par) {
        $this->title = $title_par;
    }
    public function getText() {
        return $this->text;
    }
    public function setText($text_par) {
        $this->text = $text_par;
    }
    public function getReviewed_product(){
        return $this->reviewed_product;
    }
    public function setReviewed_product($reviewed_product_par) {
        $this->reviewed_product = $reviewed_product_par;
    }
    public function getProduct_name(){
        return $this->product_name;
    }
    public function setProduct_name($product_name_par) {
        $this->product_name = $product_name_par;
    }
	public function getUser_email(){
        return $this->user_email;
    }
    public function setUser_email($user_email_par) {
        $this->user_email = $user_email_par;
    }
	public function getEmail(){
        return $this->email;
    }
    public function setEmail($email_par) {
        $this->email = $email_par;
    }

	//servizio di lettura di tutte le recensioni
	function read() {
		if (!isset($_SESSION['email'])) {
			return false;
		}
		$email = $_SESSION['email'];
		//estraggo tutte le recnsioni
		$query = "SELECT * FROM recensioni JOIN prodotti ON recensioni.prodotto_recensito = prodotti.nome_prodotto
		WHERE recensioni.email_utente = ? ORDER BY prodotti.nome_prodotto";
		//preparo la query
		$stmt = $this->conn->prepare($query); 
		//specifico i parametri
		$stmt->bindParam(1, $email); //1 dice che il primo segnaposto (?) nella query viene sostituito con $email
		//eseguo la query
		$stmt->execute(); //$stmt conterrà il risultato dell'esecuzione della query (un recordset)

		return $stmt; 
	}

	//servizio di lettura dei dati di una recensione, dato il suo id
	function readOne() {
		//estraggo la recensione con l'id indicato
		$query = "SELECT * FROM recensioni JOIN prodotti ON recensioni.prodotto_recensito = prodotti.nome_prodotto WHERE recensioni.id = ?";
		//preparo la query
		$stmt = $this->conn->prepare($query);
		//invio il valore per il parametro
		$stmt->bindParam(1, $this->id); 
		//eseguo la query
		$stmt->execute(); //$stmt conterrà il risultato dell'esecuzione della query (in questo caso un recordset con un solo elemento)

		//leggo la prima (e unica) riga del risultato della query
		$row = $stmt->fetch(PDO::FETCH_ASSOC); //la funzione fetch (libreria PDO) con parametro PDO::FETCH_ASSOC invocata su un PDOStatement, restituisce un record ($row), in particolare un array le cui chiavi sono i nomi delle colonne della tabella 
 
		if ($row) {
			//inserisco i valori nelle variabili d'istanza 
			$this->id = $row['id'];
			$this->title = $row['titolo'];
			$this->text = $row['testo'];
			$this->reviewed_product = $row['prodotto_recensito'];
			$this->product_name = $row['nome_prodotto']; //questo e della tabella prodotto
		}
		else {
			//se non trovo il prodotto, imposto i valori delle variabili d'istanza a null
			$this->id = null;
			$this->title = null;
			$this->text = null;
			$this->reviewed_product = null;
			$this->product_name = null;
		}
		//la funzione readOne non restituisce un risultato, bensì modifica l'oggetto su cui viene invocata (cioe la recensione)
	}

	//servizio di inserimento di unanuova recensione
	function create() {
		if (!isset($_SESSION['email'])) {
			return false; // utente non loggato
			}
			$this->user_email = $_SESSION['email']; // prendo l'email dalla sessione
		//inserisco la nuova recensione
		$query = "INSERT INTO recensioni SET titolo=:title, testo=:text, prodotto_recensito=:reviewed_product, email_utente=:email_utente";
		//preparo la query
		$stmt = $this->conn->prepare($query);

		//invio i valori per i parametri (i valori del nuovo prodotto sono nelle variabili d'istanza!!)
		$stmt->bindParam(":title", $this->title);
		$stmt->bindParam(":text", $this->text);
		$stmt->bindParam(":reviewed_product", $this->reviewed_product);
		$stmt->bindParam(":email_utente", $this->user_email);
		//eseguo la query
		$stmt->execute(); //$stmt conterrà il risultato dell'esecuzione della query

		return $stmt;		
	}

	//servizio di aggiornamento dei dati di una recensione
	function update() {
		//aggiorno i dati della recensione con l'id indicato
		$query = "UPDATE recensioni SET
					titolo = :n, 
					testo = :d,
					prodotto_recensito = :c_id
					WHERE
					id = :i";
		//preparo la query
		$stmt = $this->conn->prepare($query);
		//invio i valori per i parametri (NB i nuovi valori del prodotto sono nelle variabili d'istanza!!)
		$stmt->bindParam(':n', $this->title);
		$stmt->bindParam(':d', $this->text);
		$stmt->bindParam(':c_id', $this->reviewed_product);
		$stmt->bindParam(':i', $this->id);
		//eseguo la query
		$stmt->execute(); //$stmt conterrà il risultato dell'esecuzione della query

		return $stmt;
	}

	//servizio di cancellazione di una recensione
	function delete() {
		//cancello recensione con l'id indicato
		$query = "DELETE FROM recensioni WHERE id = ?";
		//preparo la query
		$stmt = $this->conn->prepare($query);
		//invio il valore per il parametro
		$stmt->bindParam(1, $this->id);
		//eseguo la query
		$stmt->execute(); //$stmt conterrà il risultato dell'esecuzione della query

		return $stmt;
	}

	//servizio di ricerca recensioni per keyword
	function search($keywords) {
		if (!isset($_SESSION['email'])) {
			return false; // utente non loggato
			}
			$email = $_SESSION['email'];
			//i % per trovare elementi che contengono keywords
			$keywords = "%{$keywords}%";
			//query con filtro per email_utente
			$query = " SELECT * FROM recensioni JOIN prodotti ON recensioni.prodotto_recensito = prodotti.nome_prodotto
                       WHERE recensioni.email_utente = :email AND (recensioni.titolo LIKE :keywords OR recensioni.testo LIKE :keywords 
                       OR prodotti.nome_prodotto LIKE :keywords)
                       ORDER BY recensioni.titolo";
			$stmt = $this->conn->prepare($query);
			//bind dei parametri
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':keywords', $keywords);
			
			$stmt->execute();
			return $stmt;
		}
}
?>
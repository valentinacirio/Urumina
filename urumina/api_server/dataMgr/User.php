<?php 
class User { 

	//connessione (inizializzata nel costruttore)
    private $conn;
 
    //proprietà degli utenti , le scrivo in inglese se posso per distinguerle
    public $email; //email e la ciave primaria dell'utente
    public $username;
    public $password;
 
    //il construttore inizializza la variabile per la connessione al DB
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setId($email_par) {
        $this->email = $email_par;
    }
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($username_par) {
        $this->username = $username_par;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password_par) {
        $this->password = $password_par;
    }
}
?>
//questo file implementa le funzioni per mostrare la lista di recensioni
document.addEventListener("click", e => {//al click di un elemento con classe read-reviews-button (cioe il bottone "Torna a tutte le recensioni") attiva la funzione showProducts
	//e.target.closest(".read-products-button") risale l'albero del DOM cercando se c'è un elemento che contiene e.target e che abbia classe read-reviews-button; se non lo trova restituisce null
	const btn = e.target.closest(".read-reviews-button"); 
  	if (btn) { //se btn esiste...
    	e.preventDefault();
    	showReviews(); //...fa partire la funzione showProducts
  	}
});

//funzine per collegarsi al server e scaricare il json con tutte le recensioni e poi formatta il json html in una tabella
function showReviews() {
	//invoca una send request all'api read.php, e prende i data (in json) delle recensioni
	sendRequest("read.php", data => { //data=coppia reviews: lista-precensioni (array di oggetti JSON)
		let read_reviews_html = container(search_reviews_form(), create_review_button());
		read_reviews_html += reviews_table(data.reviews); //a read_reviews_html accodo la funzione reviews_table la quale crea un tabella usando come parametro data.reviews
		
		document.getElementById("page-content").innerHTML = read_reviews_html;

		changePageTitle("Recensioni");
	});
}

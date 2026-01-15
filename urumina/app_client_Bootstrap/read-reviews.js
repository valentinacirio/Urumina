//questo file implementa la funzione per mostrare la lista di recensione quando apriamo index.php sul web
document.addEventListener("click", e => {//al click di un elemento con classe read-reviews-button (es il bottone "Torna a tutte le recensioni") attiva la funzione showReviews
	//e è l'evento
	//e.target è l'elemento cliccato (per es. potrebbe essere l'icona all'interno del bottone)
	//e.target.closest(".read-reviews-button") risale l'albero del DOM cercando se c'è un elemento che contiene e.target e che abbia classe read-reviews-button; se non lo trova restituisce null
	const btn = e.target.closest(".read-reviews-button"); 
  	if (btn) { //se btn esiste...
    	e.preventDefault();
    	showReviews(); //...fa partire la funzione showReviews
  	}
});

//funzine per collegarsi al server e scaricare il json con tutte le recensioni e poi formatta il json html in una tabella
function showReviews() {
	//funzione showReviews invoca una send request all'api read.php, e prende i data (in json) delle recensioni
	sendRequest("read.php", data => { //data=coppia reviews: lista-precensioni (array di oggetti JSON)
		//creo l'html per fare la lista delle recensioni
		let read_reviews_html = container(search_reviews_form(), create_review_button());//funzione container in app.js e come parametri (left e right in app.js) metto altre due funzioni sempre di app.js
		//search_reviews_form è la funzione che crea la barra di ricerca per cercare recensioni
		//create_review_button è la funzione che crea il bottone per inserire una nuova recensione
		read_reviews_html += reviews_table(data.reviews); //a read_reviews_html accodo la funzione reviews_table la quale crea un tabella usando come parametro data.reviews
		
		//a 'page-content' (di index.html) innietto l'html 
		document.getElementById("page-content").innerHTML = read_reviews_html; //l'html contiene tutto cio che abbiamo messo in read_reviews_html

		//infine cambio il nome della pagina web 
		changePageTitle("Recensioni");
	});
}

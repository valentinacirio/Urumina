//(1)crea il form, (2) dice cosa accade quando utente fa submit del form
//(1)mostra fomr html quando utente clicca su "Inserisci nuova recensione". Sembra porti a una pagina nuova ma no, e la stessa pagina che cambia e cambia titolo grazie alla funzione changePageTitle
document.addEventListener("click", e => {//usiamo document.addEventListener senza getElementById perche nel bottone ce anche un icona che se l'utente cliccherebbe non partirebbe l'evento. getElementById funzionerebbe solo al clik della parte del bottone con la scritta e non sull'icona
	const btn = e.target.closest(".create-review-button");//il tasto "Inserisci nuova recensione" creato con la funzione create_review_button in app.js
	if (btn) {//se trova il bottone
		e.preventDefault();

		sendRequest("read_cats.php", data => {
			let select_html = `<select name='reviewed_product' required>`; 
			data.products.forEach( val => {
				select_html += `<option value='${val.product_name}'>${val.product_name}</option>`;//option crea un menu a tendina con i valori val.valori
			});
			select_html+=`</select>`;

		//mostra l'html del form per inserire una nuova recensione		
		let create_review_html = container(undefined, back_to_reviews_button());
		create_review_html+=`	
			<form id='create-review-form' action='#' method='post' border='0'>
				<table class='table table-responsive table-bordered'>
					<tr>
					<td>Titolo</td>
					<td><input type='text' name='title' class='form-control' required /></td>
					</tr>
					<tr>
					<td>Prodotto</td>
					<td> `+select_html+` </td> <!--richiamo la variabile select_html in cui ho messo il menu a tendina in riga 11-->
					</tr>
					<tr>
					<td>Testo</td>
					<td><textarea name='text' class='form-control' required></textarea></td>
					</tr>
					<tr>
					<td></td>
					<td>
					<button type='submit' class='btn btn-success' aria-label='Crea recensione'>
					<i class="bi bi-check-circle"></i> Crea recensione
					</button>
					</td>
					</tr>
				</table>
			</form>`;

		//innietto l'html creato ora in 'page-content' (che si trova in index.html)
		document.getElementById("page-content").innerHTML = create_review_html;
 
		//cambio titolo della pagina
		changePageTitle("Crea recensione");
		});
	}
});

//(2)quando utente invia il form cliccando il tasto "Crea recensione" invia i dati della nuova recensione al servizio create 
document.addEventListener("submit", e => {
	const form = e.target.closest("#create-review-form");
	if (form) { //se lo trova il form
		e.preventDefault();

		//prende i dati del form (new FormData(form)) e li metto in un oggetto javascript (Object.fromEntries) e li converto in json tramite JSON.stringify (che converte da javascript)
		const form_data = JSON.stringify( Object.fromEntries( new FormData( form ) ) ); // form = the submitted form
		//quindi form_data contiene i dati del form in formato json
		//uso un console.log per vedere se capta i dati in form_data all'inivio del form(in caso voglio fare debugging)(F12, Console, invia form)
		console.log("FORM DATA: " + form_data);
		//funzione sendRequest invia richiesta alla rest api create.php, dico quale funzione da invocare dopo che invio il form(showREviews cioe l'elenco di tutti i fumetti), dico il metodo (POST) e i dati da inviare
		sendRequest("create.php", showReviews, "POST", form_data);
	}
});


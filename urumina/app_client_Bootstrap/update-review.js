//(*1*) mostra il form html precompilato coi dati attuali della recensione al click sul bottone "Modifica"
document.addEventListener("click", e => {//al click nella pagina
	const btn = e.target.closest(".update-review-button");
	if (btn) {//se è così
		e.preventDefault();

        //prende dal database l'id associato al bottone (questo id si riferisce alla recensione a cui fa riferimento il bottone)
		const id = btn.dataset.id; //prende l'id della recensione corrispondente al bottone

		let products;
		fetch(BASEURL + "read_cats.php").then( (response) => {
			if (!response.ok) { throw new Error(`HTTP error: ${response.status}`); }
				return response.json();
			})
			.then( data => {  console.log("Dati recensioni (reviews):", data.products);//console log
				products = data.products; //i data in json vengono messi dentro una variabile products
				return fetch(BASEURL + "read_one.php?id="+id); //poi un'altra fetch questa volta che prende i dati della singola recinsione grazie a read_one.php?id=+id
			})
			.then( response => {
				if (!response.ok) { 
					throw new Error(`HTTP error: ${response.status}`); 
				}
				return response.json();
			})
			.then( data => { 
				let select_html=`<select name='reviewed_product' id='cat'>`; //creo il menu a tendina coi prodotti e lo metto in una variabile select_html
				products.forEach( val => {
					select_html+=`<option value='`+val.product_name+`'`+(val.product_name==data.reviewed_product ? ` selected` : ``)+`>`+val.product_name+`</option>`; 
				});
				select_html+=`</select>`;

				let update_review_html = container(undefined, back_to_reviews_button());
				update_review_html += `
					<!-- build 'update review' html form -->
					<form id='update-review-form' action='#' method='post' border='0'>
						<table class='table table-hover table-responsive table-bordered'>
							<tr>
								<td>Titolo</td>
								<td><input value=\"` + data.title + `\" type='text' name='title' class='form-control' required /></td>
							<tr>
								<td>Testo</td>
								<td><textarea name='text' class='form-control' required>` + data.text + `</textarea></td>
							</tr>
							<tr>
								<td>Prodotto</td>
								<td>` + select_html + `</td>
							</tr>
							<tr>
								<!--'product id' nascosto ma c'e, per identificare quale recensione-->
								<td><input value=\"` + id + `\" name='id' type='hidden' /></td>
								<td>
									<button type='submit' class='btn btn-success' aria-label='Conferma modifica'>
										<i class="bi bi-check-circle"></i> Aggiorna recensione
									</button>
								</td>
							</tr>
						</table>
					</form>`;				

				document.getElementById("page-content").innerHTML = update_review_html;
	
				changePageTitle("Aggiorna recensione");
			}); 
	} 
});
	
//(*2*)quando l'utente invia il form, invia i dati aggiornati della recensione al servizio update
document.addEventListener("submit", e => {
	const form = e.target.closest("#update-review-form");
	if (form) {

		e.preventDefault();

		//prende i dati del form (new FormData(form)) e li metto in un oggetto javascript (Object.fromEntries) e li converto in json tramite JSON.stringify (che convertrte da javascript)
		const form_data = JSON.stringify( Object.fromEntries( new FormData( form ) ) );
        //quindi form_data contiene i dati del form in formato json
		// for debugging...
		console.log("FORM DATA: "+form_data);
        //funzione sendRequest invia richiesta alla rest api update, dico quale funzione da invocare dopo che invio il form(showReviews cioe l'elenco di tutte le recensioni), dico il metodo (PUT) e i dati da inviare
		sendRequest("update.php", showReviews, "PUT", form_data); 
	}
});
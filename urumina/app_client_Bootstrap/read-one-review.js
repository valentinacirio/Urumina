//quando utente clicca su bottone con classe read-one-review-button cioe tasto "Leggi"
document.addEventListener("click", e => {
	const btn = e.target.closest(".read-one-review-button"); //cerca nel dom l'elemento con questa classe
  	if (btn) { //se lo trova
		e.preventDefault();

		const id = btn.dataset.id; //prende l'id della recensione dal database. Proprieta dataset.x permette di accedere a tutti gli attributi data-x
        //invoco una send request all'api read.one.php che prende i data in json della recensione con quel id
		sendRequest("read_one.php?id="+id, data => { //quando ottengo data (i dati json)...

			//creo l'html con le info della singola recensione
			let read_one_review_html = container(undefined, back_to_reviews_button()); //solo il parametro di destra mettiamo in questo caso
			read_one_review_html += `
			<!--qui a read_one_review_html accodiamo i dati del fumetto-->
			<table class='table table-bordered'>
				<tr>
					<td class='w-25 fw-bold'>Titolo</td>
					<td class='w-75'>` + data.title + `</td>
				</tr>
				<tr>
					<td class='fw-bold'>Prodotto recensito</td>
					<td>` + data.reviewed_product + ` euro</td>
				</tr>
				<tr>
					<td class='fw-bold'>Testo</td>
					<td>` + data.text + `</td>
				</tr>
			</table>`;
			
			//in 'page-content' (di index.html) innietto l'html 
			document.getElementById("page-content").innerHTML = read_one_review_html;

			//cambio il titolo della pagina e della scheda web
			changePageTitle("Recensione");
		});
	}
});
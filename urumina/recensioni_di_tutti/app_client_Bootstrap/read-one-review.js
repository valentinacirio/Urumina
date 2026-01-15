//quando utente clicca su bottone con calsse read-one-review-button cioe tasto "Leggi"
document.addEventListener("click", e => {
	const btn = e.target.closest(".read-one-review-button"); //cerca nel dom l'elemento con questa classe
  	if (btn) { //se lo trova
		e.preventDefault();

		//prende l'id del prodotto dal database
		const id = btn.dataset.id;
        //invoco una send request all'api read.one.php che prende i data in json della recensione con quel id
		sendRequest("read_one.php?id="+id, data => {
			//creo l'html con le info della recensione
			let read_one_review_html = container(undefined, back_to_reviews_button()); //solo il parametro di destra mettiamo in questo caso
			read_one_review_html += `
			<!--qui a read_one_review_html accodiamo i dati dell recensione-->
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
			
			document.getElementById("page-content").innerHTML = read_one_review_html;

			changePageTitle("Recensione");
		});
	}
});
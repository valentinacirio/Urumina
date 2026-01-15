//questo file gestisce la barra di ricerca, la quale e classificata come un form
document.addEventListener("submit", e => { //al submit del form parte la funzione
	const form = e.target.closest("#search-review-form");//con e.target.closest risale nel dom (che ha struttura ad albero) cercando il primo elemento che trova con id #search_rreview_form
	if (form) {
		e.preventDefault(); //disattiva la action del form

        //guardo cosa c'e nella text box (che si chiama keywords)
		const keywords = form.querySelector("input[name='keywords']").value; //cioe prendo il tag input che ha name=keywords
//ora nell'uri cerca keywords cioe cio che ho scritto nella searchbar, la ricerca possibile grazie all'api search.php che invia la richiesta
		sendRequest("search.php?s="+encodeURIComponent(keywords), data => { //quando ottengo data cioe i dati in json delle recensioni trovate
			//creo l'html per mostrare le recensioni trovate
			let search_reviews_html = container(search_reviews_form(), back_to_reviews_button()); //funzione container di app.js che crea la parte in alto con la funzione che crea la barra di ricerca e la funzione che crea il tasto per tornare indietro
			search_reviews_html += reviews_table(data.reviews); //ci accodo la funzione che crea la tabella con i data in json delle recensioni trovate
			
			//in page-content innietto search_products_html in formato html, non piu json
			document.getElementById("page-content").innerHTML = search_reviews_html;

			//infine cambio il nome della pagina
			changePageTitle("Cerca recensioni: " + keywords);
		});
	}
});

// (*1*)mostra finestra pop-up di conferma quando utente clicca sul tasto Cancella
document.addEventListener("click", e => {
	const btn = e.target.closest(".delete-review-button");
  	if (btn) {
		e.preventDefault();

		//prende l'id della recensione
		const review_id = btn.dataset.id; 

		const confirmed = confirm("Sei sicuro di volere eliminare questa recensione?");
		if (confirmed) {
			//(*2*)se l'utente conferma, invia richiesta di delete al servizio delete
			sendRequest(`delete.php?id=${review_id}`, showReviews, "DELETE"); //il file api delete.php a cui accodo l'id della recensione, poi scrivo la callback (showReviews) e il metodo
		}
	}
});
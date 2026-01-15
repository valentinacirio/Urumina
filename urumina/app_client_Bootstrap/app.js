//questo file. app.js, contiene le funzioni principali
const BASEURL = "../api_server/api/";

//funzione che cambia il titolo della pagina web
function changePageTitle(page_title){ //come parametro il nome che voglio dare alla pagina
    document.getElementById('page-title').textContent = page_title; //page title
    document.title = page_title; //window title
}
//funzione per inviare richieste http (al server)
function sendRequest(api, callback, method="GET", body) { //api es. read.php, callback è la funzione che varra chiamata dopo che arrivano i dati al server, scelgo get come metodo di default, body è il corpo della richiesta (i dati che richiediamo al server)
    const fetchPromise = fetch(BASEURL + api, { //fetch restituisce una promessa che salvo in fetchPromise
        method, //shorthand property name: dato che la variabile ha lo stesso nome della proprieta si puo scrivere una parola sola, equivale a "method: method" (riga 10)
        headers: body ? { 'Content-Type': 'application/json' } : undefined, //se body esiste specifico ce dev'essere in json, se non esiste lo metto undefined. headers specifica il tipo di dati di body
        body //shorthand property name anche qui. body specifica quali sono i dati, in questo caso chiamati sempre body (riga 10)
    });
    fetchPromise //ora faccio fetchPromise
    .then( (response) => { //e quando il server risponde viene eseguito il .then
            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`);
            }
            return response.json(); //converto la risposta in json.
        }) //response.json è un'altra promessa e quando finisce (di convertire in json) viene eseguito un altro .then 
    .then ( data => callback(data) )//quando ottiene i data, esegue la callback specificata nei parametri //data equivale al contenuto di response.json cioe data sono i dati json
    .catch ((error) => {
        msg = error.message || 'Errore sconosciuto'; //se esiste un error.message usa quello senno usa 'Errore sconosciuto'
        console.error(`Errore: ${msg}`);
    })
}

//funzioni comuni contenenti bootstrap (in arancione) per generare la User Interface
//funzione che crea la barra di ricerca
function search_reviews_form() { 
    const searchForm = `
        <form id='search-review-form' action='#' method='post' class='me-2'> 
            <div class='input-group w-55'>
                <input type='text' name='keywords' class='form-control review-search-keywords' placeholder='Cerca recensioni...' />
                <button type='submit' class='btn btn-secondary' aria-label='Cerca recensione'>
                    <i class='bi bi-search'></i> <!--bi-search il nome dell'icona della lente-->
                </button>
            </div>
        </form>`;
    return searchForm;
}

//funzione che crea l'html del bottone per aggiungere una recensione
function create_review_button() {
    const createButton = `
			<button id='create-review' type='button' class='btn btn-success btn-sm create-review-button' aria-label='Aggiungi recensione'>
                <i class='bi bi-plus-circle'></i>
				Inserisci nuova recensione
			</button>`;
    return createButton;
}

//funzione che crea il bottone per tornare indietro
function back_to_reviews_button() { 
    const backButton = `
        <button id='read-reviews' type='button' class='btn btn-secondary btn-sm mb-3 read-reviews-button' aria-label='Torna a tutte le recensioni'>
            <i class='bi bi-arrow-left-circle'></i> Torna a tutte le recensioni <!--bi-arrow-left-circle icona freccia in un cerchio-->
        </button>`;
    return backButton;
}

//crea la parte in alto allineando il contenuto a sinistra e a destra. La uso per es in read-products.js e contiene la barra di ricerca e il tasto aggiungi recensione
function container(left, right) { //richiede 2 parametri, left e right
    let container_html = '';

    if (left && right) { //se utente ha specificato due parametri, crea un contenitore div per metterli entrambi sulla stessa riga alle estremita
        container_html = `<div class="d-flex justify-content-between align-items-center mb-3">${left}${right}</div>`;
    }
    else if (right) { //se invece utente ha messo solo right lo mette a destra
        container_html = `<div class="d-flex justify-content-end align-items-center mb-3">${right}</div>`;
    }
    else if (left) { //se solo left lo mette a sinistra
        container_html = `<div class="mb-3">${left}</div>`;
    }
    return container_html;
}

//funzione che crea una tabella contenente il parametro scritto tra(). La uso in read-reviews.js con come parametro i dati delle recensoni
function reviews_table(reviews) {
    let table = `
        <table class='table table-bordered table-hover'>
            <thead>
            <tr>
                <th class='rounded-cell'>Titolo</th>
                <th class='rounded-cell'>Prodotto recensito</th>
                <th class='rounded-cell'>Testo</th>
                <th class='rounded-cell'>Azioni</th>
            </tr>
            </thead><tbody>`;

    //loop through list of data
    reviews.forEach( val => { //per ogni recensione (val) esegue funzione freccia
        //crea una table row per ogni record
        table+=`<tr>
            <td>` + val.title + `</td>
            <td>` + val.reviewed_product + `</td>
            <td>` + val.text + `</td>    
            <!-- 'ora metto gli action' buttons -->
            <td class='text-center'>
                <div class='btn-group btn-group-sm'>
                <button class='btn btn-primary me-2 read-one-review-button' data-id='` + val.id + `' aria-label='Leggi recensione'>
                    <i class='bi bi-eye'></i>
                    <small>Leggi</small>
                </button>
                <button class='btn btn-warning me-2 update-review-button' data-id='` + val.id + `' aria-label='Modifica recensione'>
                    <i class='bi bi-pencil'></i>
                    <small>Modifica</small>
                </button>
                <button class='btn btn-danger delete-review-button' data-id='` + val.id + `' aria-label='Elimina recensione'>
                    <i class='bi bi-trash'></i>
                    <small>Cancella</small>
                </button>
                </div>
            </td>
        </tr>`;
    });
    //end table 
    table+=`</tbody></table>`;
    
    return table;
}

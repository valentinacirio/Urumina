<?php
/** Il protocollo CORS indica al browser con quali pagine web puo essere condivisa un risposta (in base all'origine delle pagine web)
 *  In questo file permette richieste GET, POST, o OPTIONS provenienti da qualsiasi origine specificata nell'header Origin (informazione che dice da dove arriva la richiesta)
 *  Informazioni sul protocollo CORS -> https://fetch.spec.whatwg.org/#http-cors-protocol
 */
// function cors() {
    
    //consente qualsiasi origine
    if (isset($_SERVER['HTTP_ORIGIN'])) { //se il browser ha inviato l'header origin, allora...
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}"); //permette l'accesso dal dominio che ha fatto la richiesta
        header('Access-Control-Allow-Credentials: true'); //consente l'uso di cookie e sessioni
        header('Access-Control-Max-Age: 86400'); //cache che dura 24 ore
    }
    //Il browser invia delle richieste OPTIONS per chiedere se puo fare le richieste vere e proprie (POST, PUT, ecc) e quali sono permesse
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) //se il browser chiede quali metodi sono permessi...
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); //specifico che permetto metodi GET, POST e OPTIONS (options chiede al server quali operazioni sono permesse su una risorsa, prima di eseguire la richiesta vera e propria)
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) //se il browser chiede quali header usera...
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}"); //...specifico quali headr sono permessi
        exit(0);
    }
// }
?>

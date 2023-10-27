document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../API_events.php')
        .then(response => response.json())
        .then(data => {
            displayEventi(data.eventi);
            displayEventiArchivio(data.archivio_eventi);
        })
        .catch(error => {
            console.error('Errore durante il recupero dei dati:', error);
        });
}

function displayEventi(eventi) {
    const eventiContainer = document.getElementById('contEventi');
    eventiContainer.innerHTML = `
        <h1 class="Heading-1 centerTitle">Prossimamente:</h1>
    `;
    eventi.forEach(evento => {
        const eventoDiv = document.createElement('div');
        eventoDiv.setAttribute('class', 'home-full-width-banner section container');
        const nomeMaiusc = evento.nome_evento.toUpperCase();
        eventoDiv.innerHTML = `
            <div class="home-left1" id="third">
                <div class="home-content">
                    <span class="home-text29">${nomeMaiusc}</span>
                    <span class="home-text30">${evento.descrizione}</span>
                </div>
                <div class="home-btn button border">
                    <span class="home-text31">Mostra dettagli</span>
                </div>
            </div>
            <img src="data:image/jpg;base64,${evento.immagine}" class="home-image6">
        `;
        eventiContainer.appendChild(eventoDiv);
    });
}

function displayEventiArchivio(archivio_eventi) {
    const eventiContainer = document.getElementById('contArchivioEventi');
    eventiContainer.innerHTML = `
        <div id="contTitolo">
            <h1 class="Heading-1 centerTitle">Vecchi spettacoli:</h1>
        </div>
    `;
    archivio_eventi.forEach(evento => {
        const eventoDiv = document.createElement('div');
        eventoDiv.setAttribute('class', 'home-full-width-banner section container');
        const nomeMaiusc = evento.nome_evento.toUpperCase();
        
        eventoDiv.innerHTML = `
        <div class="home-left1" id="third">
            <div class="home-content">
                <span class="home-text29">${nomeMaiusc}</span>
                <span class="home-text30">${evento.descrizione}</span>
            </div>
            <div class="home-btn button border">
                <span class="home-text31">Mostra dettagli</span>
            </div>
        </div>
        <img src="data:image/jpg;base64,${evento.immagine}" class="home-image6">
        `;

        eventiContainer.appendChild(eventoDiv);
    });
}
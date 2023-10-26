document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../API_events.php')
        .then(response => response.json())
        .then(data => {
            displayEventi(data.eventi);
            displayMusicisti(data.musicisti);
        })
        .catch(error => {
            console.error('Errore durante il recupero dei dati:', error);
        });
}

function displayEventi(eventi) {
    const eventiContainer = document.getElementById('contEventi');
    eventiContainer.innerHTML = '';
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

function displayMusicisti(musicisti) {
    const musicistiContainer = document.getElementById('musicisti-container');
    musicistiContainer.innerHTML = '';

    musicisti.forEach(musicista => {
        const musicistaDiv = document.createElement('div');
        musicistaDiv.innerHTML = `
            <h2>${musicista.nome_musicista}</h2>
            <img src = "data:image/jpg;base64,${musicista.immagine}" width = "100px">
            <p>${musicista.bio_musicista}</p>
        `;
        musicistiContainer.appendChild(musicistaDiv);
    });
}
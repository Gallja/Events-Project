document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../API_events.php')
        .then(response => response.json())
        .then(data => {
            displayEventi(data.eventi);
            displayComici(data.comici);
            displayMusicisti(data.musicisti);
        })
        .catch(error => {
            console.error('Errore durante il recupero dei dati:', error);
        });
}

function displayEventi(eventi) {
    const eventiContainer = document.getElementById('eventi-container');
    eventiContainer.innerHTML = '';

    eventi.forEach(evento => {
        const eventoDiv = document.createElement('div');
        eventoDiv.innerHTML = `
            <h2>${evento.nome_evento}</h2>
            <p>Data: ${evento.data_evento}</p>
            <p>Luogo: ${evento.luogo}</p>
            <p>${evento.descrizione}</p>
        `;
        eventiContainer.appendChild(eventoDiv);
    });
}

function displayComici(comici) {
    const comiciContainer = document.getElementById('comici-container');
    comiciContainer.innerHTML = '';

    comici.forEach(comico => {
        const comicoDiv = document.createElement('div');
        comicoDiv.innerHTML = `
            <h2>${comico.nome_comico} ${comico.cognome_comico}</h2>
            <p>${comico.bio}</p>
        `;
        comiciContainer.appendChild(comicoDiv);
    });
}

function displayMusicisti(musicisti) {
    const musicistiContainer = document.getElementById('musicisti-container');
    musicistiContainer.innerHTML = '';

    musicisti.forEach(musicista => {
        const musicistaDiv = document.createElement('div');
        musicistaDiv.innerHTML = `
            <h2>${musicista.nome_musicista}</h2>
            <p>${musicista.bio_musicista}</p>
        `;
        musicistiContainer.appendChild(musicistaDiv);
    });
}

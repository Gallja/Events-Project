document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../backend/API_events.php')
        .then(response => response.json())
        .then(data => {
            displayMusicisti(data.musicisti);
        })
        .catch(error => {
            console.error('Errore durante il recupero dei dati:', error);
        });
}

function displayMusicisti(musicisti) {
    const musContainer = document.getElementById('contMus');
    musContainer.innerHTML = '';
    musicisti.forEach(mus => {
        const musDiv = document.createElement('div');
        musDiv.setAttribute('class', 'home-full-width-banner section container');
        const nomeMaiusc = mus.nome_musicista.toUpperCase();
        musDiv.innerHTML = `
            <div class="home-left1" id="third">
                <div class="home-content">
                    <span class="home-text29">${nomeMaiusc}</span>
                    <span class="home-text30" dimRidottaSpan>${mus.bio_musicista}</span>
                </div>
            </div>
            <img src="data:image/jpg;base64,${mus.immagine}" class="home-image6 dimRidotta">
        `;
        musContainer.appendChild(musDiv);
    });
}
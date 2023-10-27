document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../API_events.php')
        .then(response => response.json())
        .then(data => {
            displayComici(data.comici);
        })
        .catch(error => {
            console.error('Errore durante il recupero dei dati:', error);
        });
}

function displayComici(comici) {
    const comiciContainer = document.getElementById('contComici');
    comiciContainer.innerHTML = '';
    comici.forEach(comico => {
        const comicoDiv = document.createElement('div');
        comicoDiv.setAttribute('class', 'home-full-width-banner section container');
        const nomeMaiusc = comico.nome_comico.toUpperCase();
        const cognomeMaiusc = comico.cognome_comico.toUpperCase();
        comicoDiv.innerHTML = `
            <div class="home-left1" id="third">
                <div class="home-content">
                    <span class="home-text29">${nomeMaiusc} ${cognomeMaiusc}</span>
                    <span class="home-text30 dimRidottaSpan">${comico.bio}</span>
                </div>
            </div>
            <img src="data:image/jpg;base64,${comico.immagine}" class="home-image6 dimRidotta">
        `;
        comiciContainer.appendChild(comicoDiv);
    });
}
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
    const comiciContainer = document.getElementById('carouselExampleIndicators');
    comiciContainer.innerHTML = ''; // Rimuovi tutto il contenuto precedente

    const indicatori = document.createElement('ol');
    indicatori.setAttribute('class', 'carousel-indicators');

    comici.forEach((comico, index) => {
        const indicator = document.createElement('li');
        indicator.setAttribute('data-target', '#carouselExampleIndicators');
        indicator.setAttribute('data-slide-to', index);

        if (index === 0) {
            indicator.classList.add('active'); // Imposta il primo indicatore come attivo
        }

        indicatori.appendChild(indicator);

        const comicoDiv = document.createElement('div');
        comicoDiv.setAttribute('class', 'carousel-item');

        if (index === 0) {
            comicoDiv.classList.add('active'); // Imposta il primo elemento come attivo
        }

        comicoDiv.innerHTML = `
            <img class="d-block w-100" src="data:image/jpeg;base64,${comico.immagine}" alt="${comico.nome_comico} ${comico.cognome_comico}">
            <div class="carousel-caption">
                <h5>${comico.nome_comico} ${comico.cognome_comico}</h5>
                <p>${comico.bio}</p>
            </div>
        `;

        comiciContainer.appendChild(comicoDiv);
    });

    comiciContainer.appendChild(indicatori);

    comiciContainer.innerHTML += `
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        `;
}

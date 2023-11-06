document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../backend/API_events.php')
        .then(response => response.json())
        .then(data => {
            displayEventi(data.eventi);
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
                <div class="home-btn button border" onclick="mostraDett(${evento.codice})">
                    <span class="home-text31">Mostra dettagli</span>
                </div>
            </div>
            <img src="data:image/jpg;base64,${evento.immagine}" class="home-image6">
        `;
        eventiContainer.appendChild(eventoDiv);
    });
}

function mostraDett(eventoId) {
    fetch(`../backend/API_events.php?evento_id=${eventoId}`)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            displayDett(data.eventi_comici, data.eventi_musicisti);
        })
        .catch(error => {
            console.error("Errore durante il recupero dei dettagli dello spettacolo:", error);
        });
}

function displayDett(eventi_comici, eventi_musicisti) {
    const dettagliContainer = document.getElementById('dettagli-container');
    const dettagliSpettacolo = document.getElementById('dettagli-spettacolo');
    const artistiAffiliati = document.getElementById('artisti-affiliati');

    dettagliSpettacolo.innerHTML = '';
    artistiAffiliati.innerHTML = '';

    if (eventi_comici.length > 0) {
        const ulSpett = document.createElement('ul');
        ulSpett.setAttribute('class', 'ul-spettacolo');

        const ulComico = document.createElement('ul');
        ulComico.setAttribute('class', 'ul-comico');

        var conta = 0;

        eventi_comici.forEach(evento => {
            if (conta == 0) {
                dettagliSpettacolo.innerHTML = '<h3 class="title-h">DETTAGLI SPETTACOLO:</h3>';
                const liEventoTitolo = document.createElement('li');
                const liEventoData = document.createElement('li');
                const liEventoOra = document.createElement('li');
                const liEventoLuogo = document.createElement('li');

                liEventoTitolo.textContent = `Nome evento: ${evento.nome_evento}`
                ulSpett.appendChild(liEventoTitolo);

                const data = new Date(evento.data_evento);
                const dataFormatt = `${data.getDate()}/${data.getMonth() + 1}/${data.getFullYear()}`;
                liEventoData.textContent = `Data: ${dataFormatt}`
                ulSpett.appendChild(liEventoData);

                const orario = evento.ora_evento;
                const orarioFormatt = orario.slice(0, 5);
                liEventoOra.textContent = `Ora: ${orarioFormatt}`
                ulSpett.appendChild(liEventoOra);

                liEventoLuogo.textContent = `Luogo: ${evento.luogo}`
                ulSpett.appendChild(liEventoLuogo);

                if (evento.link_biglietto != null) {
                    const liEventoLink = document.createElement('li');
                    const linkEvento = document.createElement('a');

                    liEventoLink.textContent = `Link biglietto: `;
                    linkEvento.setAttribute('href', evento.link_biglietto);
                    linkEvento.setAttribute('class', 'linkBE');
                    linkEvento.textContent = 'CLICCA QUI';

                    liEventoLink.appendChild(linkEvento);
                    ulSpett.appendChild(liEventoLink);
                }

                dettagliSpettacolo.appendChild(ulSpett);
            }
            
            artistiAffiliati.innerHTML = '<h3 class="title-h">COMICI:</h3>';
            const li = document.createElement('li');
            li.textContent = `${evento.nome_comico} ${evento.cognome_comico}`;
            ulComico.appendChild(li);

            conta ++;
        });

        artistiAffiliati.appendChild(ulComico);
    }

    if (eventi_musicisti.length > 0) {

        const ulSpett = document.createElement('ul');
        ulSpett.setAttribute('class', 'ul-spettacolo');

        const ulMusicisti = document.createElement('ul');
        ulMusicisti.setAttribute('class', 'ul-musicista');

        if (eventi_comici.length > 0) {
            const h3 = document.createElement('h3');
            h3.setAttribute('class', 'title-h');
            h3.innerHTML = 'MUSICISTI:';
            artistiAffiliati.appendChild(h3);

            eventi_musicisti.forEach(evento => {
                const li = document.createElement('li');
                li.textContent = `${evento.nome_musicista}`;
                ulMusicisti.appendChild(li);
            });

            artistiAffiliati.appendChild(ulMusicisti);
        } else {
            conta = 0;

            eventi_musicisti.forEach(evento => {
                if (conta == 0) {
                    dettagliSpettacolo.innerHTML = '<h3 class="title-h">DETTAGLI SPETTACOLO:</h3>';
                    const liEventoTitolo = document.createElement('li');
                    const liEventoData = document.createElement('li');
                    const liEventoOra = document.createElement('li');
                    const liEventoLuogo = document.createElement('li');

                    liEventoTitolo.textContent = `Nome evento: ${evento.nome_evento}`
                    ulSpett.appendChild(liEventoTitolo);

                    const data = new Date(evento.data_evento);
                    const dataFormatt = `${data.getDate()}-${data.getMonth() + 1}-${data.getFullYear()}`;
                    liEventoData.textContent = `Data: ${dataFormatt}`
                    ulSpett.appendChild(liEventoData);

                    const orario = evento.ora_evento;
                    const orarioFormatt = orario.slice(0, 5);
                    liEventoOra.textContent = `Ora: ${orarioFormatt}`
                    ulSpett.appendChild(liEventoOra);

                    liEventoLuogo.textContent = `Luogo: ${evento.luogo}`
                    ulSpett.appendChild(liEventoLuogo);

                    if (evento.link_biglietto != null) {
                        const liEventoLink = document.createElement('li');
                        const linkEvento = document.createElement('a');

                        liEventoLink.textContent = `Link biglietto: `;
                        linkEvento.setAttribute('href', evento.link_biglietto);
                        linkEvento.textContent = 'CLICCA QUI';

                        liEventoLink.appendChild(linkEvento);
                        ulSpett.appendChild(liEventoLink);
                    }

                    dettagliSpettacolo.appendChild(ulSpett);
                }

                const h3 = document.createElement('h3');
                h3.setAttribute('class', 'title-h');
                h3.innerHTML = 'MUSICISTI:';
                artistiAffiliati.appendChild(h3);

                const li = document.createElement('li');
                li.textContent = `Musicista: ${evento.nome_musicista}`;

                ulMusicisti.appendChild(li);

                conta ++;
            });
            
            artistiAffiliati.appendChild(ulMusicisti);
        }
    }

    dettagliContainer.style.display = 'block';
}
document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function fetchData() {
    fetch('../API_events.php')
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
    fetch(`../API_events.php?evento_id=${eventoId}`)
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
                const liEvento = document.createElement('li');

                liEvento.textContent = `Nome evento: ${evento.nome_evento}, Data: ${evento.data_evento}, Ora: ${evento.ora_evento}, Luogo: ${evento.luogo}`
                ulSpett.appendChild(liEvento);
                dettagliSpettacolo.appendChild(ulSpett);
            }
            
            const li = document.createElement('li');
            li.textContent = `Comico: ${evento.nome_comico} ${evento.cognome_comico}`;
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
            eventi_musicisti.forEach(evento => {
                const li = document.createElement('li');
                li.textContent = `Nome musicista: ${evento.nome_musicista}`;
                ulMusicisti.appendChild(li);
            });
        } else {
            conta = 0;

            eventi_musicisti.forEach(evento => {
                if (conta == 0) {
                    const liEvento = document.createElement('li');
                    liEvento.textContent = `Nome evento: ${evento.nome_evento}, Data: ${evento.data_evento}, Ora: ${evento.ora_evento}, Luogo: ${evento.luogo}`
                    ulSpett.appendChild(liEvento);
                    dettagliContainer.appendChild(ulSpett);
                }

                const li = document.createElement('li');
                li.textContent = `Nome evento: ${evento.nome_evento}, Data: ${evento.data_evento}, Ora: ${evento.ora_evento}, Luogo: ${evento.Luogo}, Musicista: ${evento.nome_musicista}`;

                ulMusicisti.appendChild(li);

                conta ++;
            });
            
            artistiAffiliati.appendChild(ulMusicisti);
        }
    }

    dettagliContainer.style.display = 'block';
}
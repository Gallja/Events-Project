function mostra_mod(contenuto, codice) {
    var form_completo = "myForm_" + contenuto + "_" + codice;
    // console.log(form_completo);
    var form = document.getElementById(form_completo);
    
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}

function mostraP() {
    const pwInput = document.getElementById('pw');

    if (pwInput.type === 'password') {
        pwInput.type = 'text';
    } else {
        pwInput.type = 'password';
    }
}

function mostraPassChange(str) {
    const pwInput = document.getElementById(str);

    if (pwInput.type === 'password') {
        pwInput.type = 'text';
    } else {
        pwInput.type = 'password';
    }
}

function ricerca() {
    var input_ricerca = document.getElementById('input_ricerca');
    var testo = input_ricerca.value.toLowerCase();
    var elementi_da_cercare = document.querySelectorAll('p, h1, h2, h3, h4, h5, h6, li, a, span, th, tr, td');

    if (testo.includes(" ")) {
        arrayStr = testo.split(" ");
        testo = arrayStr[0];
    }

    elementi_da_cercare.forEach(function (elemento) {
        var testo_elemento = elemento.textContent.toLowerCase();
        // console.log(elemento);
        if (testo_elemento.includes(testo)) {
            var elDistanceToTop = window.pageYOffset + elemento.getBoundingClientRect().top;
            elemento.classList.add('highlighted');
            window.scrollTo({
                top: elDistanceToTop,
                behavior: 'smooth'
            });

            setTimeout(function() {
                elemento.classList.remove('highlighted');
            }, 1500);
        }
    });
}

function mostraFoto(id) {
    firstStr = "pannelloFoto";
    idString = id.toString();
    idDiv = firstStr.concat(idString);
    var pannelloFoto = document.getElementById(idDiv);

    var pannelliAperti = document.querySelectorAll('[data-pannello="true"]');

    for (var i = 0; i < pannelliAperti.length; i++) {
        pannelliAperti[i].style.display = "none";
        pannelliAperti[i].setAttribute('data-pannello', 'false');
    }

    pannelloFoto.style.display = "block";
    pannelloFoto.setAttribute('data-pannello', 'true');
}

function chiudiFoto(id) {
    firstStr = "pannelloFoto";
    idString = id.toString();
    idDiv = firstStr.concat(idString);
    var pannelloFoto = document.getElementById(idDiv);

    pannelloFoto.style.display = "none";
    pannelloFoto.setAttribute('data-pannello', 'false');
}

function mostraDesc(id) {
    firstStr = "pannelloDesc";
    idString = id.toString();
    idDiv = firstStr.concat(idString);
    var pannelloDesc = document.getElementById(idDiv);

    var pannelliAperti = document.querySelectorAll('[data-pannello="true"]');

    for (var i = 0; i < pannelliAperti.length; i++) {
        pannelliAperti[i].style.display = "none";
        pannelliAperti[i].setAttribute('data-pannello', 'false');
    }

    pannelloDesc.style.display = "block";
    pannelloDesc.setAttribute('data-pannello', 'true');
}

function chiudiDesc(id) {
    firstStr = "pannelloDesc";
    idString = id.toString();
    idDiv = firstStr.concat(idString);
    var pannelloDesc = document.getElementById(idDiv);
    pannelloDesc.style.display = "none";
    pannelloDesc.setAttribute('data-pannello', 'false');
}

function clonaArtista(id) {
    const selectContainer = document.getElementById(id);    const selectClone = selectContainer.cloneNode(true);
    const submitButton = document.querySelector('input[type="submit"]');
    const br = document.createElement('br');

    selectContainer.parentNode.insertBefore(selectClone, submitButton);
    selectContainer.parentNode.insertBefore(br, submitButton);
}
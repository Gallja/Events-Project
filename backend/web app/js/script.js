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

function ricerca() {
    console.log("debug");
    var input_ricerca = document.getElementById('input_ricerca');
    var input_bottone = document.getElementById('input_bottone');

    input_bottone.addEventListener('click', function() {
        var testo = input_ricerca.value.toLowerCase();
        var elementi_da_cercare = document.querySelectorAll('p, h1, h2, h3, h4, h5, h6, li, a, span');

        elementi_da_cercare.forEach(function (elemento) {
            var testo_elemento = elemento.textContent.toLowerCase();
            if (testo_elemento.includes(testo)) {
                elemento.style.display = 'block';
            } else {
                elemento.style.display = 'none';
            }
        });
    });
}
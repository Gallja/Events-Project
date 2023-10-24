document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("searchInput").addEventListener("keydown", function(event) {
      if (event.keyCode === 13) {
        ricercaDinamica();
      }
    });
  
    function ricercaDinamica() {
        const searchTerm = document.getElementById("searchInput").value.toLowerCase();
        const elementsToSearch = ["h1", "p", "div", "span"];

        elementsToSearch.forEach(tagName => {
            const elements = document.querySelectorAll(tagName);
            elements.forEach(element => {
                const text = element.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    element.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            });
        });
    }

    const showDivButtons = document.getElementsByClassName('showDivButton');
    const centeredDiv = document.getElementById('centeredDiv');
    const closeDivButton = document.getElementById('closeDivButton');

    for (let i = 0; i < showDivButtons.length; i++) {
        showDivButtons[i].addEventListener('click', function() {
            centeredDiv.classList.remove('hidden');
        });
    }

    closeDivButton.addEventListener('click', function() {
        centeredDiv.classList.add('hidden');
    });

    const showDivButtons2 = document.getElementsByClassName('showDivButton2');
    const centeredDiv2 = document.getElementById('centeredDiv2');
    const closeDivButton2 = document.getElementById('closeDivButton2');

    for (let i = 0; i < showDivButtons2.length; i++) {
        showDivButtons2[i].addEventListener('click', function() {
            centeredDiv2.classList.remove('hidden');
        });
    }

    closeDivButton2.addEventListener('click', function() {
        centeredDiv2.classList.add('hidden');
    });
});
  
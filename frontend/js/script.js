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
            centeredDiv.style.display = 'flex';
        });
    }

    closeDivButton.addEventListener('click', function() {
        centeredDiv.classList.add('hidden');
        centeredDiv.style.display = 'none';
    });
});
  
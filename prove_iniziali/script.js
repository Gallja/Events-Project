document.getElementById('openMailPanel').addEventListener('click', function() {
    document.getElementById('mailPanel').classList.remove('hidden');
});

document.getElementById('mailForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const content = document.getElementById('content').value;
    sendMail(email, content);
    document.getElementById('mailForm').reset();
});

function sendMail(email, content) {
    // Qui puoi implementare la logica per l'invio della mail utilizzando un servizio backend o una libreria
    const mailTo = 'gallia4729@gmail.com';
    console.log('Mail inviata a: ' + mailTo);
    console.log('Contenuto della mail: ' + content);
}

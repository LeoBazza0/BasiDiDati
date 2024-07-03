document.addEventListener('DOMContentLoaded', () => {
    const entitySelect = document.getElementById('entity');
    const formFields = document.getElementById('formFields');

    entitySelect.addEventListener('change', updateFormFields);

    function updateFormFields() {
        const entity = entitySelect.value;
        formFields.innerHTML = ''; // Clear existing fields

        let fieldsHtml = '';
        switch (entity) {
            case 'ospedale':
                fieldsHtml = `
                    <label for="codice">Codice:</label>
                    <input type="text" id="codice" name="codice" required>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="indirizzo">Indirizzo:</label>
                    <input type="text" id="indirizzo" name="indirizzo" required>
                `;
                break;
            case 'personale':
                fieldsHtml = `
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="cognome">Cognome:</label>
                    <input type="text" id="cognome" name="cognome" required>
                    <label for="ruolo">Ruolo:</label>
                    <input type="text" id="ruolo" name="ruolo" required>
                    <label for="reparto">Reparto:</label>
                    <input type="text" id="reparto" name="reparto" required>
                `;
                break;
            case 'esame':
                fieldsHtml = `
                    <label for="codice">Codice:</label>
                    <input type="text" id="codice" name="codice" required>
                    <label for="descrizione">Descrizione:</label>
                    <input type="text" id="descrizione" name="descrizione" required>
                    <label for="costo">Costo:</label>
                    <input type="number" id="costo" name="costo" required>
                `;
                break;
            case 'paziente':
                fieldsHtml = `
                    <label for="tessera">Tessera Sanitaria:</label>
                    <input type="text" id="tessera" name="tessera" required>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="cognome">Cognome:</label>
                    <input type="text" id="cognome" name="cognome" required>
                    <label for="dataNascita">Data di Nascita:</label>
                    <input type="date" id="dataNascita" name="dataNascita" required>
                `;
                break;
        }
        formFields.innerHTML = fieldsHtml;
    }

    // Handle form submission
    const addForm = document.getElementById('addForm');
    addForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addForm);
        fetch('add.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Dati aggiunti con successo!');
                    addForm.reset();
                } else {
                    alert('Errore nell\'aggiunta dei dati.');
                }
            })
            .catch(error => console.error('Errore:', error));
    });
});

const toasts = document.querySelectorAll('.toast');
console.log(toasts);
const toastsBootstrap = [];
toasts.forEach(toast => {
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
    toastBootstrap.show();
    toastsBootstrap.push(toastBootstrap);
});


document.addEventListener("DOMContentLoaded", function () {
  document.getElementById('taskForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    // Récupération manuelle des données du formulaire
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const priority = document.getElementById('priority').value;

    // Construction du JSON
    const data = JSON.stringify({
      title: title,
      description: description,
      priority: priority
    });

    try {
      // Envoi de la requête POST
      const response = await fetch('/task/new', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: data,
      });

      if (response.ok) {
        alert('Task added successfully!');
        e.target.reset(); // Réinitialisation du formulaire
        document.querySelector('[data-modal-toggle="defaultModal"]').click(); // Fermeture du modal
      } else {
        const errors = await response.json();
        alert('Error: ' + JSON.stringify(errors));
      }
    } catch (error) {
      console.error('Erreur lors de l\'envoi :', error);
      alert('An error occurred while adding the task.');
    }
  });
});

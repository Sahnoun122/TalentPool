<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Annonces</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4D44B5',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-primary mb-2">Gestion des Annonces</h1>
            <p class="text-gray-600">Plateforme de gestion des offres d'emploi</p>
        </header>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="relative w-full md:w-1/2">
                <input type="text" id="searchInput" placeholder="Rechercher des annonces..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <button id="createBtn" class="w-full md:w-auto bg-primary hover:bg-primary/90 text-white font-medium py-2 px-6 rounded-lg transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Créer une annonce
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div id="annoncesContainer" class="divide-y divide-gray-200">
                <div class="p-8 text-center text-gray-500">
                    Chargement des annonces...
                </div>
            </div>
        </div>

        <div id="annonceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modalTitle" class="text-xl font-bold text-primary">Nouvelle Annonce</h3>
                        <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="annonceForm" class="space-y-4">
                        <input type="hidden" id="annonceId">
                        
                        <div>
                            <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                            <input type="text" id="titre" name="titre" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea id="description" name="description" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="localisation" class="block text-sm font-medium text-gray-700 mb-1">Localisation *</label>
                                <input type="text" id="localisation" name="localisation" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="salaire" class="block text-sm font-medium text-gray-700 mb-1">Salaire *</label>
                                <input type="number" id="salaire" name="salaire" step="0.01" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" id="cancelBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Annuler
                            </button>
                            <button type="submit" id="saveBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary hover:bg-primary/90">
                                Enregistrer
                            </button>
                            <button type="button" id="deleteBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 hidden">
                                Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Éléments du DOM
const annoncesContainer = document.getElementById('annoncesContainer');
const searchInput = document.getElementById('searchInput');
const createBtn = document.getElementById('createBtn');
const annonceModal = document.getElementById('annonceModal');
const closeModal = document.getElementById('closeModal');
const cancelBtn = document.getElementById('cancelBtn');
const annonceForm = document.getElementById('annonceForm');
const deleteBtn = document.getElementById('deleteBtn');

let currentAnnonces = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchAnnonces();
    
    searchInput.addEventListener('input', debounce(searchAnnonces, 300));
    createBtn.addEventListener('click', showCreateForm);
    closeModal.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);
    annonceForm.addEventListener('submit', handleFormSubmit);
    deleteBtn.addEventListener('click', handleDelete);
});

async function fetchAnnonces() {
    try {
        const response = await fetch('/api/annonces');
        if (!response.ok) throw new Error('Erreur réseau');
        
        currentAnnonces = await response.json();
        displayAnnonces(currentAnnonces);
    } catch (error) {
        console.error('Erreur:', error);
        annoncesContainer.innerHTML = `
            <div class="p-8 text-center text-red-500">
                Erreur lors du chargement des annonces: ${error.message}
            </div>
        `;
    }
}

async function createAnnonce(data) {
    const response = await fetch('/api/annonces', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return await response.json();
}

async function updateAnnonce(id, data) {
    const response = await fetch(`/api/annonces/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return await response.json();
}

async function deleteAnnonce(id) {
    const response = await fetch(`/api/annonces/${id}`, {
        method: 'DELETE'
    });
    return response.ok;
}


function AfficherAnnonces(annonces) {
    if (annonces.length === 0) {
        annoncesContainer.innerHTML = `
            <div class="p-8 text-center text-gray-500">
                Aucune annonce trouvée
            </div>
        `;
        return;
    }

    annoncesContainer.innerHTML = annonces.map(annonce => `
        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">${annonce.titre}</h3>
                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>${annonce.localisation}</span>
                        <span>•</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>${annonce.salaire} €</span>
                    </div>
                    <p class="text-gray-500 mt-2 line-clamp-2">${annonce.description}</p>
                </div>
                <button onclick="showEditForm(${annonce.id})" class="px-4 py-2 bg-primary/10 text-primary rounded-md hover:bg-primary/20 transition-colors duration-200">
                    Voir Détails
                </button>
            </div>
        </div>
    `).join('');
}

function voireCreeForm() {
    document.getElementById('modalTitle').textContent = 'Créer une annonce';
    document.getElementById('annonceId').value = '';
    document.getElementById('deleteBtn').classList.add('hidden');
    annonceForm.reset();
    annonceModal.classList.remove('hidden');
}

function voireModifierForm(id) {
    const annonce = currentAnnonces.find(a => a.id === id);
    if (!annonce) return;

    document.getElementById('modalTitle').textContent = 'Modifier une annonce';
    document.getElementById('annonceId').value = annonce.id;
    document.getElementById('titre').value = annonce.titre;
    document.getElementById('description').value = annonce.description;
    document.getElementById('localisation').value = annonce.localisation;
    document.getElementById('salaire').value = annonce.salaire;
    document.getElementById('deleteBtn').classList.remove('hidden');
    annonceModal.classList.remove('hidden');
}

function diparaitreModal() {
    annonceModal.classList.add('hidden');
}

async function gereFormSubmit(e) {
    e.preventDefault();
    
    const formData = {
        titre: document.getElementById('titre').value,
        description: document.getElementById('description').value,
        localisation: document.getElementById('localisation').value,
        salaire: parseFloat(document.getElementById('salaire').value),
        recruteur_id: 1 // À remplacer par l'ID du recruteur connecté
    };

    const annonceId = document.getElementById('annonceId').value;
    
    try {
        let result;
        if (annonceId) {
            result = await updateAnnonce(annonceId, formData);
        } else {
            result = await createAnnonce(formData);
        }
        
        hideModal();
        fetchAnnonces();
    } catch (error) {
        console.error('Erreur:', error);
        alert(`Une erreur est survenue: ${error.message}`);
    }
}

async function gereDelete() {
    const annonceId = document.getElementById('annonceId').value;
    if (!annonceId || !confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')) return;
    
    try {
        const success = await deleteAnnonce(annonceId);
        if (success) {
            hideModal();
            fetchAnnonces();
        } else {
            throw new Error('Échec de la suppression');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert(`Une erreur est survenue: ${error.message}`);
    }
}

function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

function recherecheAnnonces() {
    const searchTerm = searchInput.value.toLowerCase();
    if (!searchTerm) {
        displayAnnonces(currentAnnonces);
        return;
    }
    
    const filtered = currentAnnonces.filter(annonce => 
        annonce.titre.toLowerCase().includes(searchTerm) || 
        annonce.description.toLowerCase().includes(searchTerm) ||
        annonce.localisation.toLowerCase().includes(searchTerm)
    );
    
    displayAnnonces(filtered);
}

window.showEditForm = showEditForm;

    </script>
</body>
</html>
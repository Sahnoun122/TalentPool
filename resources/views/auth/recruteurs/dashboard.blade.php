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

    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Candidatures</title>
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
            <h1 class="text-3xl font-bold text-primary mb-2">Gestion des Candidatures</h1>
            <p class="text-gray-600">Plateforme de suivi des candidatures</p>
        </header>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="relative w-full md:w-1/2">
                <input type="text" id="searchCandidatureInput" placeholder="Rechercher des candidatures..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="flex gap-2">
                <select id="annonceFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Toutes les annonces</option>
                    <!-- Options seront ajoutées dynamiquement -->
                </select>
                <select id="statutFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="acceptee">Acceptée</option>
                    <option value="refusee">Refusée</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div id="candidaturesContainer" class="divide-y divide-gray-200">
                <div class="p-8 text-center text-gray-500">
                    Chargement des candidatures...
                </div>
            </div>
        </div>

        <!-- Modal pour postuler -->
        <div id="postulerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="postulerModalTitle" class="text-xl font-bold text-primary">Postuler à une annonce</h3>
                        <button id="closePostulerModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="postulerForm" class="space-y-4">
                        <input type="hidden" id="annonceIdPostuler">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CV *</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" id="cvFile" accept=".pdf,.doc,.docx" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lettre de motivation *</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" id="lettreMotivationFile" accept=".pdf,.doc,.docx" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" id="cancelPostulerBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Annuler
                            </button>
                            <button type="submit" id="submitPostulerBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary hover:bg-primary/90">
                                Envoyer la candidature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal pour modifier le statut -->
        <div id="statutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="statutModalTitle" class="text-xl font-bold text-primary">Modifier le statut</h3>
                        <button id="closeStatutModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="statutForm" class="space-y-4">
                        <input type="hidden" id="candidatureIdStatut">
                        
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Nouveau statut *</label>
                            <select id="statut" name="statut" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="en_attente">En attente</option>
                                <option value="acceptee">Acceptée</option>
                                <option value="refusee">Refusée</option>
                            </select>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" id="cancelStatutBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Annuler
                            </button>
                            <button type="submit" id="submitStatutBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-primary hover:bg-primary/90">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div id="notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden transition-opacity duration-300">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span id="notificationMessage">Opération réussie</span>
            </div>
        </div>
    </div>

    <script>
        const candidaturesContainer = document.getElementById('candidaturesContainer');
        const searchCandidatureInput = document.getElementById('searchCandidatureInput');
        const annonceFilter = document.getElementById('annonceFilter');
        const statutFilter = document.getElementById('statutFilter');
        
        // Modals
        const postulerModal = document.getElementById('postulerModal');
        const closePostulerModal = document.getElementById('closePostulerModal');
        const cancelPostulerBtn = document.getElementById('cancelPostulerBtn');
        const postulerForm = document.getElementById('postulerForm');
        
        const statutModal = document.getElementById('statutModal');
        const closeStatutModal = document.getElementById('closeStatutModal');
        const cancelStatutBtn = document.getElementById('cancelStatutBtn');
        const statutForm = document.getElementById('statutForm');
        
        const notification = document.getElementById('notification');
        
        let currentCandidatures = [];
        let currentAnnonces = [];

        document.addEventListener('DOMContentLoaded', () => {
            fetchCandidatures();
            fetchAnnoncesForFilter();
            
            searchCandidatureInput.addEventListener('input', debounce(searchCandidatures, 300));
            annonceFilter.addEventListener('change', filterCandidatures);
            statutFilter.addEventListener('change', filterCandidatures);
            
            closePostulerModal.addEventListener('click', hidePostulerModal);
            cancelPostulerBtn.addEventListener('click', hidePostulerModal);
            postulerForm.addEventListener('submit', handlePostulerSubmit);
            
            closeStatutModal.addEventListener('click', hideStatutModal);
            cancelStatutBtn.addEventListener('click', hideStatutModal);
            statutForm.addEventListener('submit', handleStatutSubmit);
        });

        async function fetchCandidatures() {
            try {
                const response = await fetch('/api/candidatures');
                if (!response.ok) throw new Error('Erreur réseau');
                
                currentCandidatures = await response.json();
                displayCandidatures(currentCandidatures);
            } catch (error) {
                console.error('Erreur:', error);
                candidaturesContainer.innerHTML = `
                    <div class="p-8 text-center text-red-500">
                        Erreur lors du chargement des candidatures: ${error.message}
                    </div>
                `;
            }
        }

        async function fetchAnnoncesForFilter() {
            try {
                const response = await fetch('/api/annonces');
                if (!response.ok) throw new Error('Erreur réseau');
                
                currentAnnonces = await response.json();
                populateAnnonceFilter();
            } catch (error) {
                console.error('Erreur:', error);
            }
        }

        function populateAnnonceFilter() {
            annonceFilter.innerHTML = '<option value="">Toutes les annonces</option>';
            currentAnnonces.forEach(annonce => {
                const option = document.createElement('option');
                option.value = annonce.id;
                option.textContent = annonce.titre;
                annonceFilter.appendChild(option);
            });
        }

        function displayCandidatures(candidatures) {
            if (candidatures.length === 0) {
                candidaturesContainer.innerHTML = `
                    <div class="p-8 text-center text-gray-500">
                        Aucune candidature trouvée
                    </div>
                `;
                return;
            }

            candidaturesContainer.innerHTML = candidatures.map(candidature => `
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">${candidature.annonce.titre}</h3>
                                    <p class="text-sm text-gray-600">Candidat: ${candidature.candidat.nom} ${candidature.candidat.prenom}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium ${getStatutClass(candidature.statut)}">
                                    ${formatStatut(candidature.statut)}
                                </span>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-4">
                                <a href="${candidature.cv_path}" target="_blank" class="flex items-center text-sm text-primary hover:text-primary/80">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Voir CV
                                </a>
                                <a href="${candidature.lettre_motivation_path}" target="_blank" class="flex items-center text-sm text-primary hover:text-primary/80">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Voir lettre de motivation
                                </a>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            ${candidature.statut === 'en_attente' ? `
                            <button onclick="showStatutModal(${candidature.id})" class="px-4 py-2 bg-primary/10 text-primary rounded-md hover:bg-primary/20 transition-colors duration-200">
                                Modifier statut
                            </button>
                            ` : ''}
                            <button onclick="deleteCandidature(${candidature.id})" class="px-4 py-2 bg-red-100 text-red-600 rounded-md hover:bg-red-200 transition-colors duration-200">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getStatutClass(statut) {
            switch(statut) {
                case 'acceptee': return 'bg-green-100 text-green-800';
                case 'refusee': return 'bg-red-100 text-red-800';
                default: return 'bg-yellow-100 text-yellow-800';
            }
        }

        function formatStatut(statut) {
            switch(statut) {
                case 'acceptee': return 'Acceptée';
                case 'refusee': return 'Refusée';
                default: return 'En attente';
            }
        }

        function showPostulerModal(annonceId) {
            document.getElementById('annonceIdPostuler').value = annonceId;
            document.getElementById('postulerModalTitle').textContent = `Postuler à l'annonce`;
            postulerModal.classList.remove('hidden');
        }

        function hidePostulerModal() {
            postulerModal.classList.add('hidden');
        }

        function showStatutModal(candidatureId) {
            const candidature = currentCandidatures.find(c => c.id === candidatureId);
            if (!candidature) return;

            document.getElementById('candidatureIdStatut').value = candidatureId;
            document.getElementById('statut').value = candidature.statut;
            document.getElementById('statutModalTitle').textContent = `Modifier statut pour ${candidature.candidat.nom}`;
            statutModal.classList.remove('hidden');
        }

        function hideStatutModal() {
            statutModal.classList.add('hidden');
        }

        async function handlePostulerSubmit(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('annonce_id', document.getElementById('annonceIdPostuler').value);
            formData.append('candidat_id', 1); // À remplacer par l'ID du candidat connecté
            formData.append('cv', document.getElementById('cvFile').files[0]);
            formData.append('lettre_motivation', document.getElementById('lettreMotivationFile').files[0]);

            try {
                const response = await fetch('/api/candidatures', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Erreur lors de la soumission');

                const result = await response.json();
                hidePostulerModal();
                fetchCandidatures();
                showNotification('Candidature envoyée avec succès');
            } catch (error) {
                console.error('Erreur:', error);
                showNotification(`Erreur: ${error.message}`, 'error');
            }
        }

        async function handleStatutSubmit(e) {
            e.preventDefault();
            
            const candidatureId = document.getElementById('candidatureIdStatut').value;
            const statut = document.getElementById('statut').value;

            try {
                const response = await fetch(`/api/candidatures/${candidatureId}/statut`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ statut })
                });

                if (!response.ok) throw new Error('Erreur lors de la mise à jour');

                const result = await response.json();
                hideStatutModal();
                fetchCandidatures();
                showNotification('Statut mis à jour avec succès');
            } catch (error) {
                console.error('Erreur:', error);
                showNotification(`Erreur: ${error.message}`, 'error');
            }
        }

        async function deleteCandidature(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')) return;
            
            try {
                const response = await fetch(`/api/candidatures/${id}`, {
                    method: 'DELETE'
                });

                if (!response.ok) throw new Error('Erreur lors de la suppression');

                fetchCandidatures();
                showNotification('Candidature supprimée avec succès');
            } catch (error) {
                console.error('Erreur:', error);
                showNotification(`Erreur: ${error.message}`, 'error');
            }
        }

        function searchCandidatures() {
            const searchTerm = searchCandidatureInput.value.toLowerCase();
            if (!searchTerm) {
                filterCandidatures();
                return;
            }
            
            const filtered = currentCandidatures.filter(candidature => 
                candidature.annonce.titre.toLowerCase().includes(searchTerm) || 
                candidature.candidat.nom.toLowerCase().includes(searchTerm) ||
                candidature.candidat.prenom.toLowerCase().includes(searchTerm)
            );
            
            displayCandidatures(filtered);
        }

        function filterCandidatures() {
            const annonceId = annonceFilter.value;
            const statut = statutFilter.value;
            
            let filtered = currentCandidatures;
            
            if (annonceId) {
                filtered = filtered.filter(c => c.annonce_id == annonceId);
            }
            
            if (statut) {
                filtered = filtered.filter(c => c.statut === statut);
            }
            
            displayCandidatures(filtered);
        }

        function showNotification(message, type = 'success') {
            notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg flex items-center transition-opacity duration-300 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
            document.getElementById('notificationMessage').textContent = message;
            notification.classList.remove('hidden');
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
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

        window.showPostulerModal = showPostulerModal;
        window.showStatutModal = showStatutModal;
        window.deleteCandidature = deleteCandidature;
    </script>
</body>
</html>
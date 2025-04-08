<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Annonce</title>
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
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-primary mb-2">Détails de l'Annonce</h1>
                <p class="text-gray-600">Informations complètes sur l'offre d'emploi</p>
            </div>
            <a href="gestion-annonces.html" class="flex items-center gap-2 text-primary hover:text-primary/80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour
            </a>
        </header>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div id="annonceDetails" class="p-8">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
                    <p class="mt-4 text-gray-500">Chargement des détails...</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <button id="editBtn" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200">
                Modifier l'annonce
            </button>
            <button id="deleteBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                Supprimer l'annonce
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const annonceId = urlParams.get('id');
            
            if (!annonceId) {
                window.location.href = '/recruteurs/dashboard';
                return;
            }

            await loadAnnonceDetails(annonceId);

            document.getElementById('editBtn').addEventListener('click', () => {
                window.location.href = `/recruteur/dashboard?edit=${annonceId}`;
            });

            document.getElementById('deleteBtn').addEventListener('click', () => {
                deleteAnnonce(annonceId);
            });
        });

        async function loadAnnonceDetails(id) {
            try {
                const response = await fetch(`/api/annonces/${id}`);
                if (!response.ok) throw new Error('Annonce non trouvée');
                
                const annonce = await response.json();
                displayAnnonceDetails(annonce);
            } catch (error) {
                console.error('Erreur:', error);
                document.getElementById('annonceDetails').innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        Erreur lors du chargement des détails: ${error.message}
                    </div>
                `;
            }
        }

        function displayAnnonceDetails(annonce) {
            document.getElementById('annonceDetails').innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">${annonce.titre}</h2>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>${annonce.localisation}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>${annonce.salaire} €</span>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Description du poste</h3>
                            <div class="prose max-w-none text-gray-600">
                                ${annonce.description.replace(/\n/g, '<br>')}
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-1">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations complémentaires</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Date de publication</h4>
                                    <p class="text-gray-800">${new Date(annonce.created_at).toLocaleDateString('fr-FR')}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Type de contrat</h4>
                                    <p class="text-gray-800">CDI</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Expérience requise</h4>
                                    <p class="text-gray-800">2+ ans</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Recruteur</h4>
                                    <p class="text-gray-800">${annonce.recruteur_nom || 'Entreprise XYZ'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        async function deleteAnnonce(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.')) {
                return;
            }

            try {
                const response = await fetch(`/api/annonces/${id}`, {
                    method: 'DELETE'
                });

                if (response.ok) {
                    alert('Annonce supprimée avec succès');
                    window.location.href = 'gestion-annonces.html';
                } else {
                    throw new Error('Échec de la suppression');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert(`Une erreur est survenue: ${error.message}`);
            }
        }
    </script>
</body>
</html>
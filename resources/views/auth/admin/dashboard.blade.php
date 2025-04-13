<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <h1 class="text-3xl font-bold text-primary mb-2">Statistiques et Rapports</h1>
            <p class="text-gray-600">Tableau de bord des activités sur la plateforme</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Carte Nombre d'annonces -->
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-primary">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nombre d'annonces</p>
                        <h2 id="annoncesCount" class="text-2xl font-bold mt-1">Chargement...</h2>
                    </div>
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Carte Nombre de candidatures -->
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nombre de candidatures</p>
                        <h2 id="candidaturesCount" class="text-2xl font-bold mt-1">Chargement...</h2>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Carte Candidatures par statut -->
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Candidatures en attente</p>
                        <h2 id="enAttenteCount" class="text-2xl font-bold mt-1">Chargement...</h2>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Graphique répartition candidatures -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Répartition des candidatures par statut</h2>
                <canvas id="statutChart" height="300"></canvas>
            </div>

            <!-- Graphique candidatures par annonce -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Top 5 des annonces avec le plus de candidatures</h2>
                <canvas id="topAnnoncesChart" height="300"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Dernières candidatures</h2>
            <div id="latestCandidatures" class="divide-y divide-gray-200">
                <div class="p-4 text-center text-gray-500">
                    Chargement des dernières candidatures...
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Récupérer les données statistiques
                const response = await fetch('/api/statistiques/admin');
                if (!response.ok) throw new Error('Erreur réseau');
                
                const data = await response.json();
                
                // Mettre à jour les cartes
                document.getElementById('annoncesCount').textContent = data.nombre_annonces;
                document.getElementById('candidaturesCount').textContent = data.nombre_candidatures;
                
                // Trouver le nombre de candidatures en attente
                const enAttente = data.repartition_candidatures.find(item => item.statut === 'en_attente');
                document.getElementById('enAttenteCount').textContent = enAttente ? enAttente.count : '0';
                
                // Préparer les données pour les graphiques
                prepareStatutChart(data.repartition_candidatures);
                
                // Récupérer les données pour le top des annonces
                const annoncesResponse = await fetch('/api/annonces');
                if (!annoncesResponse.ok) throw new Error('Erreur réseau');
                
                const annonces = await annoncesResponse.json();
                prepareTopAnnoncesChart(annonces);
                
                // Récupérer les dernières candidatures
                const candidaturesResponse = await fetch('/api/candidatures');
                if (!candidaturesResponse.ok) throw new Error('Erreur réseau');
                
                const candidatures = await candidaturesResponse.json();
                displayLatestCandidatures(candidatures.slice(0, 5));
                
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors du chargement des statistiques');
            }
        });

        function prepareStatutChart(data) {
            const ctx = document.getElementById('statutChart').getContext('2d');
            
            // Formater les données pour Chart.js
            const labels = data.map(item => {
                switch(item.statut) {
                    case 'en_attente': return 'En attente';
                    case 'acceptee': return 'Acceptées';
                    case 'refusee': return 'Refusées';
                    default: return item.statut;
                }
            });
            
            const counts = data.map(item => item.count);
            const backgroundColors = [
                'rgba(255, 206, 86, 0.7)',  // Jaune pour en attente
                'rgba(75, 192, 192, 0.7)',  // Vert pour acceptées
                'rgba(255, 99, 132, 0.7)'   // Rouge pour refusées
            ];
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: counts,
                        backgroundColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }

        function prepareTopAnnoncesChart(annonces) {
            // Trier les annonces par nombre de candidatures (descendant)
            annonces.sort((a, b) => (b.candidatures_count || 0) - (a.candidatures_count || 0));
            
            const topAnnonces = annonces.slice(0, 5);
            const ctx = document.getElementById('topAnnoncesChart').getContext('2d');
            
            const labels = topAnnonces.map(annonce => annonce.titre);
            const data = topAnnonces.map(annonce => annonce.candidatures_count || 0);
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nombre de candidatures',
                        data: data,
                        backgroundColor: 'rgba(77, 68, 181, 0.7)',
                        borderColor: 'rgba(77, 68, 181, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        function displayLatestCandidatures(candidatures) {
            const container = document.getElementById('latestCandidatures');
            
            if (candidatures.length === 0) {
                container.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        Aucune candidature récente
                    </div>
                `;
                return;
            }
            
            container.innerHTML = candidatures.map(candidature => `
                <div class="py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-800">${candidature.annonce.titre}</h3>
                            <p class="text-sm text-gray-600">${candidature.candidat.nom} ${candidature.candidat.prenom}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${getStatutClass(candidature.statut)}">
                            ${formatStatut(candidature.statut)}
                        </span>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        Postulé le ${new Date(candidature.created_at).toLocaleDateString()}
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
    </script>
</body>
</html>
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

   
</body>
</html>
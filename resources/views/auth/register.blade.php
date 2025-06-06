<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#4D44B5]">Inscription</h1>
            <p class="text-gray-600 mt-2">Créez votre compte</p>
        </div>

        <form method="POST" action="/api/register" id="registerForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="nom" name="nom" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
                </div>
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select id="role" name="role" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
                    <option value="">Sélectionnez votre rôle</option>
                    <option value="candidat">Candidat</option>
                    <option value="recruteur">Recruteur</option>
                </select>
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1] transition duration-200">
                    S'inscrire
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Déjà un compte ? 
                <a href="login.html" class="text-[#4D44B5] hover:underline">Se connecter</a>
            </p>
        </div>

        <div id="message" class="mt-4 text-center text-sm"></div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const userData = {
                nom: document.getElementById('nom').value,
                prenom: document.getElementById('prenom').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                role: document.getElementById('role').value
            };

            const messageDiv = document.getElementById('message');

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });

                const data = await response.json();

                if (response.ok) {
                    messageDiv.textContent = 'Inscription réussie ! Vous allez être redirigé...';
                    messageDiv.className = 'mt-4 text-center text-sm text-green-600';
                    
                    setTimeout(() => {
                        window.location.href = '/connecter';
                    }, 2000);
                } else {
                    const errorMsg = data.message || data.error || 'Erreur lors de l\'inscription';
                    messageDiv.textContent = errorMsg;
                    messageDiv.className = 'mt-4 text-center text-sm text-red-600';
                }
            } catch (error) {
                messageDiv.textContent = 'Erreur de connexion au serveur';
                messageDiv.className = 'mt-4 text-center text-sm text-red-600';
                console.error('Erreur:', error);
            }
        });
    </script>
</body>
</html>
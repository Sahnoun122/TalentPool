<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#4D44B5]">Réinitialisation</h1>
            <p class="text-gray-600 mt-2">Entrez votre email et nouveau mot de passe</p>
        </div>

        <form method="POST" action="/api/reset-password" id="resetForm" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D44B5]">
            </div>

            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1] transition duration-200">
                    Réinitialiser
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="login.html" class="text-sm text-[#4D44B5] hover:underline">Retour à la connexion</a>
        </div>

        <div id="message" class="mt-4 text-center text-sm"></div>
    </div>
    <script>
        document.getElementById('resetForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const resetData = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            const messageDiv = document.getElementById('message');

            try {
                const response = await fetch('/api/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(resetData)
                });

                const data = await response.json();

                if (response.ok) {
                    messageDiv.textContent = 'Mot de passe réinitialisé avec succès ! Redirection...';
                    messageDiv.className = 'mt-4 text-center text-sm text-green-600';
                    
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                } else {
                    const errorMsg = data.message || data.error || 'Erreur lors de la réinitialisation';
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
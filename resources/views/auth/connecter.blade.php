<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#4D44B5]">Connexion</h1>
            <p class="text-gray-600 mt-2">Accédez à votre compte</p>
        </div>

        <form method="POST" action="/api/login" id="loginForm" class="space-y-6">
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
                <button type="submit"
                    class="w-full py-2 px-4 bg-[#4D44B5] text-white rounded-md hover:bg-[#3a32a1] transition duration-200">
                    Se connecter
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="reset-password.html" class="text-sm text-[#4D44B5] hover:underline">Mot de passe oublié ?</a>
            <p class="mt-2 text-sm text-gray-600">Pas encore de compte ? 
                <a href="register.html" class="text-[#4D44B5] hover:underline">S'inscrire</a>
            </p>
        </div>

        <div id="message" class="mt-4 text-center text-sm"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('message');
    
            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        email: email,
                        password: password 
                    })
                });
    
                const data = await response.json();
    
                if (response.ok) {
                    localStorage.setItem('authToken', data.token);
                    localStorage.setItem('userRole', data.user.role);
                    
                    messageDiv.textContent = 'Connexion réussie ! Redirection...';
                    messageDiv.className = 'mt-4 text-center text-sm text-green-600';
                    
                    setTimeout(() => {
                        const role = data.user.role; 
                        switch(role) {
                            case 'admin':
                                window.location.href = 'admin-dashboard.html';
                                break;
                            case 'recruteur':
                                window.location.href = 'recruiter-dashboard.html';
                                break;
                            case 'candidat':
                                window.location.href = 'candidate-dashboard.html';
                                break;
                            default:
                                window.location.href = 'dashboard.html';
                        }
                    }, 1500);
                } else {
                    messageDiv.textContent = data.message || 'Email ou mot de passe incorrect';
                    messageDiv.className = 'mt-4 text-center text-sm text-red-600';
                }
            } catch (error) {
                messageDiv.textContent = 'Erreur de connexion au serveur';
                messageDiv.className = 'mt-4 text-center text-sm text-red-600';
                console.error('Erreur:', error);
            }
        });
    
        if (localStorage.getItem('authToken')) {
            const role = localStorage.getItem('userRole');
            switch(role) {
                case 'admin':
                    window.location.href = '/admin/dashboard';
                    break;
                case 'recruteur':
                    window.location.href = '/recruteurs/dashboard';
                    break;
                case 'candidat':
                    window.location.href = '/candidatures/dashboard';
                    break;
                default:
                    window.location.href = '/';
            }
        }
    </script>
 
    
</body>
</html>
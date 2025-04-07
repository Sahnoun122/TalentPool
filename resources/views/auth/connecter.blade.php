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

        <form id="loginForm" class="space-y-6">
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

    
</body>
</html>
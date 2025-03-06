<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-facebook {
            display: flex;
            align-items: center;
            background-color: #1877F2;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            width: 250px;
            justify-content: center;
        }

        .btn-facebook img {
            width: 20px;
            height: 20px;
            margin-right: 3px;
        }

        .btn-facebook:hover {
            background-color: #1558b3;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-100 to-purple-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
                <h2 class="text-center text-3xl font-bold text-pink-600 mb-8">Créez votre compte</h2>

                <form class="space-y-6" action="{{ route('registreForm')}}" method="Post">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-purple-700" for="nom">
                            Nom complet
                        </label>
                        <input type="text" id="name" name="name"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-pink-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        @error('name')
                        <p class="text-red-500">{{$message}}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-purple-700" for="email">
                            Adresse email
                        </label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-pink-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        @error('email')
                        <p class="text-red-500">{{$message}}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-purple-700" for="password">
                            Mot de passe
                        </label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-pink-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        @error('password')
                        <p class="text-red-500">{{$message}}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-purple-700" for="confirm-password">
                            Confirmez le mot de passe
                        </label>
                        <input type="password" id="confirm-password"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-pink-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="terms"
                            class="h-4 w-4 text-pink-600 border-pink-300 rounded focus:ring-pink-500">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            J'accepte les conditions d'utilisation
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        S'inscrire
                    </button>

                    <div class="flex flex-col items-center space-y-4">
                        <div class=" w-64">
                            <a title="Login with Google" href="{{ route('redirect.google') }}">
                                <img class="w-full" src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Google Sign-In Button">
                            </a>
                        </div>
                        <div class="w-64">
                            <a title="Login with Facebook" href="{{ route('redirect.facebook') }}" class="btn-facebook flex items-center justify-center border border-gray-300 rounded-lg p-2 w-full bg-blue-600 text-white">
                                <img class="h-6 w-6 mr-2" src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Logo">
                                Sign in with Facebook
                            </a>
                        </div>
                    </div>


                </form>

                <p class="mt-6 text-center text-sm text-gray-600">
                    Déjà inscrit(e) ?
                    <a href="#" class="font-medium text-pink-600 hover:text-pink-500">
                        Connectez-vous
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
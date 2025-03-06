<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions d'amis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-pink-100 to-purple-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">MonSite</div>
                <div class="flex items-center space-x-4">
                    <a href="/index" class="text-purple-700 hover:text-pink-500">Accueil</a>
                <a href="/dashboard" class="text-purple-700 hover:text-pink-500">Profil</a>
                <a href="/Suggestions" class="text-purple-700 hover:text-pink-500">Suggestions</a>
                <a href="/amis" class="text-purple-700 hover:text-pink-500 border-b-2 border-pink-500">Mes Amis</a>
                <a href="/invitations" class="text-purple-700 hover:text-pink-500">Invitations</a>
                <a href="/chatify" class="text-purple-700 hover:text-pink-500">chat</a>
                <a href="/logout" class="text-purple-700 hover:text-pink-500">Déconnexion</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-pink-600 mb-8">Suggestions d'amis</h1>
        <div class="max-w-md mx-auto mb-8">
    <form action="/Suggestions" method="get">
        <div class="relative flex items-center">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <!-- Icône de recherche simplifiée -->
                <svg class="h-5 w-5 text-pink-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input 
                type="text" 
                name="search" 
                id="search" 
                placeholder="Rechercher un ami..." 
                value="{{ request('search') }}"
                class="pl-10 block w-full py-3 px-4 bg-white border border-pink-300 rounded-l-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
            >
            <button 
                type="submit" 
                class="px-4 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-medium rounded-r-lg hover:from-pink-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-pink-500"
            >
                Rechercher
            </button>
        </div>
    </form>
</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Profil 1 -->
      
            @foreach( $users as $user)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-full bg-gradient-to-r from-pink-400 to-purple-400 flex items-center justify-center">
                            <span class="text-xl font-bold text-white">
                                @if($user->profile_image)
                                <img src="{{ asset('storage/'.$user->profile_image)}}" alt="" srcset="">
                                @else
                                <img src="{{ asset('storage/profile_image/anonyme.jpeg')}}" alt="" srcset="">
                                @endif
                            </span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-purple-800">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600">3 amis en commun</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-gray-700">{{ $user->bio }}</p>
                    </div>
                    
                    <div class="mt-5 flex space-x-2">
                        @if(!Auth::user()->hasSentFriendRequest($user->id))
                        <form action="{{route('addFreind')}}" method="POST">
                            @csrf
                            <input type="hidden" name="userEnvoye_id" value="{{auth()->id()}}">
                            <input type="hidden" name="userRecu_id" value="{{ $user->id }}">
                            <button class="flex-1 py-2 px-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm font-medium rounded hover:from-pink-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Ajouter
                            </button>
                        </form>
                        @else
                   <button class="btn btn-secondary" disabled>Invitation envoyée</button>
                        @endif

                        <a href="{{ route('consulteProfile',$user->id)}}" class="py-2 px-3 border border-gray-300 text-gray-700 text-sm font-medium rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            voir profile
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            
            
        </div>
    </div>
</body>
</html>
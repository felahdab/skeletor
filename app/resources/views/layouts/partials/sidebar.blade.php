@auth
    <a class="btn btn-outline-primary w-100" href="{{ route('home.index') }}">Accueil</a>
    <h5 class="w-100 text-center">{{ auth()->user()->display_name }}</h5>
        @if (count(auth()->user()->roles) > 1 )
            <a class="btn btn-outline-primary w-100"  href="{{ route('currentrole.show') }}">Changer de role</a>
        @endif
        <a class="btn btn-outline-primary w-100"  href="{{ route('logout.perform') }}">Se déconnecter</a>

    <button class='btn btn-warning w-100' onclick='affichage("bugreport");'>Signaler un problème</button>

    @can('users.index')
        <h5 class="w-100 text-center">Personnel</h5>
        @can('mindefconnect.index')<a class="btn btn-outline-primary w-100"  href="{{ route('mindefconnect.index') }}">Mindef Connect</a>@endcan
        <a class="btn btn-outline-primary w-100"  href="{{ route('users.index') }}">Utilisateurs</a>
        @can('roles.index')<a class="btn btn-outline-primary w-100" href="{{ route('roles.index')}}">Roles</a>@endcan
        @can('permissions.index')<a class="btn btn-outline-primary w-100" href="{{ route('permissions.index')}}">Permissions</a>@endcan
    @endcan
    @can('fonctions.index')
        <h5 class="w-100 text-center">Fonctions</h5>
        <a class="btn btn-outline-primary w-100" href="{{ route('fonctions.index')}}">Fonctions</a>
        <a class="btn btn-outline-primary w-100" href="{{ route('compagnonages.index')}}">Compagnonnages</a>
        <a class="btn btn-outline-primary w-100" href="{{ route('taches.index')}}">Tâches</a>
        <a class="btn btn-outline-primary w-100" href="{{ route('objectifs.index')}}">Objectifs</a>
    @endcan
    @can('stages.index')
        <h5 class="w-100 text-center">Stages</h5>
        <a class="btn btn-outline-primary w-100" href="{{ route('stages.index')}}">Stages</a>
    @endcan
    @can('transformation.index')
        <h5 class="w-100 text-center">Transformation</h5>
        <a class="btn btn-outline-primary w-100" href="{{route('transformation.index')}}">Suivi par marin</a>
        @can('transformation.indexparfonction')<a class="btn btn-outline-primary w-100" href="{{route('transformation.indexparfonction')}}">Suivi par fonction</a>@endcan
        @can('transformation.indexparstage')<a class="btn btn-outline-primary w-100" href="{{route('stages.show', ['stage' => 1])}}">Suivi par stage</a>@endcan
    @endcan
    @if(auth()->user()->en_transformation)
        <h5 class="w-100 text-center">Ma transformation</h5>
        <a class="btn btn-outline-primary w-100" href="{{route('transformation.monlivret')}}">Mon livret</a>
        <a class="btn btn-outline-primary w-100" href="{{route('transformation.maprogression')}}">Ma progression</a>
        <a class="btn btn-outline-primary w-100" href="{{route('transformation.mafichebilan')}}">Ma fiche bilan</a>
    @endif

    @if (auth()->user()->can('statistiques.index') or auth()->user()->can('statistiques.pourtuteurs') or auth()->user()->can('statistiques.pour2ps') or auth()->user()->can('statistiques.pourem'))
        <h5 class="w-100 text-center">Statistiques</h5>
        @can('statistiques.index')<a class="btn btn-outline-primary w-100" href="{{route('statistiques.index')}}">Statistiques</a>@endcan
        @can('statistiques.pourtuteurs')<a class="btn btn-outline-primary w-100" href="{{route('statistiques.pourtuteurs')}}">Bilan pour tuteurs</a>@endcan
        @can('statistiques.pour2ps')<a class="btn btn-outline-primary w-100" href="{{route('statistiques.pour2ps')}}">Bilan pour 2PS</a>@endcan
        @can('statistiques.pourem')<a class="btn btn-outline-primary w-100" href="{{route('statistiques.pourem')}}">Bilan pour EM</a>@endcan
    @endif
        
@endauth

@guest
    <a class="btn btn-outline-primary w-100" href="{{ route('keycloak.login.redirect') }}">Login</a>
@endguest

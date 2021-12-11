<x-app-layout>

    @section('title', 'Vehicules')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Vehicules ({{$vehicules->total()}})</span>
        </div>

        <div class="search-bar">
            <form method="GET">
                <x-jet-label class="labels wight-500 color-blue" for="search" value="{{ __('Search') }}" />
                <x-jet-input placeholder="Search for a user" type="text" value="{{request('search')}}" name="search" />
                <x-jet-button type="submit" class="buttonTxt">Search</x-jet-button>
            </form>
            <form method="GET" class="ml-3">
                <x-jet-label class="labels wight-500 color-blue" for="sort" value="{{ __('Sort') }}" />
                <select class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="sort">
                    <option value="created_at-desc" @if (request('sort') == 'created_at-desc') selected @endif >Newest</option>
                    <option value="created_at-asc" @if (request('sort') == 'created_at-asc') selected @endif >Oldest</option>
                    <option value="matricule-asc" @if (request('sort') == 'matricule-asc') selected @endif>Matricule &#8593; </option>
                    <option value="matricule-desc" @if (request('sort') == 'matricule-desc') selected @endif>Matricule &#8595; </option>
                    <option value="type-asc" @if (request('sort') == 'type-asc') selected @endif>Type &#8593; </option>
                    <option value="type-desc" @if (request('sort') == 'type-desc') selected @endif>Type &#8595; </option>
                    <option value="user_id-asc" @if (request('sort') == 'user_id-asc') selected @endif>User &#8593; </option>
                    <option value="user_id-desc" @if (request('sort') == 'user_id-desc') selected @endif>User &#8595; </option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
        </div>

        <div class="table-list">
            <table class="content">
                <thead>
                    <td>ID</td>
                    <td>Matricule</td>
                    <td>Type</td>
                    <td>User ID</td>
                    <td>User CIN</td>
                    <td>Marque</td>
                    <td>Gamme</td>
                    <td>Ville</td>
                    <td>Secteur</td>
                    <td>Actions</td>
                </thead>
                @if($vehicules->isNotEmpty())
                    @foreach ($vehicules as $vehicule)
                    <tr>
                        <td>{{$vehicule->id}}</td>
                        <td>{{$vehicule->matricule}}</td>
                        <td>{{$vehicule->type}}</td>
                        <td>{{$vehicule->agence->user_id}}</td>
                        <td>{{$vehicule->agence->user->cin}}</td>
                        <td>{{$vehicule->marque->marque}}</td>
                        <td>{{$vehicule->marque->gamme}}</td>
                        <td>{{$vehicule->agence->city->city}}</td>
                        <td>{{$vehicule->agence->city->secteur}}</td>
                        <td class="x-actions">
                            
                            <a href="{{route('admin.vehicules.edit', ['id' => $vehicule->id])}}"><x-heroicon-s-pencil class="icon color-info" /></a>
                            <form method="POST" class="mx-2" action="{{route('admin.vehicules.delete')}}" onsubmit="return confirm('Are you sure you want to delete this vehicule?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$vehicule->id}}">
                                <button><x-heroicon-s-trash class="icon color-danger" /></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else 
                    <tr>
                        <td colspan="10" class="text-center">
                            <h2>No vehicules found</h2>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="mt-5">
            {{$vehicules->links()}}
        </div>
    </div>

</x-app-layout>


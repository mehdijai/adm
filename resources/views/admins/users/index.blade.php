<x-app-layout>

    @section('title', 'Users')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Users ({{$users->total()}})</span>
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
                    <option value="created_at-asc" @if (request('sort') == 'created_at-asc') selected @endif >Oldest</option>
                    <option value="created_at-desc" @if (request('sort') == 'created_at-desc') selected @endif >Newest</option>
                    <option value="name-asc" @if (request('sort') == 'name-asc') selected @endif>Name &#8593; </option>
                    <option value="name-desc" @if (request('sort') == 'name-desc') selected @endif>Name &#8595; </option>
                    <option value="email-asc" @if (request('sort') == 'email-asc') selected @endif>Email &#8593; </option>
                    <option value="email-desc" @if (request('sort') == 'email-desc') selected @endif>Email &#8595; </option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
        </div>
        
        @error('search')
            {{$message}}
        @enderror

        <div class="table-list">
            <table class="content">
                <thead>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>CIN</td>
                    <td>Tel</td>
                    <td>Agence</td>
                    <td>Ville</td>
                    <td>N° Vehicules</td>
                    <td>Actions</td>
                </thead>
                @if($users->isNotEmpty())
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->cin}}</td>
                        <td>{{$user->agence->tel}}</td>
                        <td>{{$user->agence->name}}</td>
                        <td>{{$user->agence->city->city}} - {{$user->agence->city->secteur}}</td>
                        <td>{{count($user->agence->vehicules)}}</td>
    
                        <td class="x-actions">
                            <a href="{{route('admin.vehicules.create', ['id' => $user->id])}}"><x-heroicon-s-plus class="icon color-success" /></a>
                            <form method="POST" action="{{route('admin.users.delete')}}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$user->id}}" >
                                <button><x-heroicon-s-trash class="icon color-danger" /></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else 
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>No user found</h2>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="mt-5">
            {{$users->links()}}
        </div>
    </div>

</x-app-layout>


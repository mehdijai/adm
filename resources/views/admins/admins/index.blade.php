<x-app-layout>

    @section('title', 'Admins')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Admins ({{$admins->total()}})</span>
            <a href="{{route('admin.admins.create')}}">Add Admin <x-heroicon-s-plus class="icon" /> </a>
        </div>

        <div class="search-bar">
            <form method="GET">
                <x-jet-label class="labels wight-500 color-blue" for="search" value="{{ __('Search') }}" />
                <x-jet-input placeholder="Search for an admin" type="text" value="{{request('search')}}" name="search" />
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
                    <option value="cin-asc" @if (request('sort') == 'email-asc') selected @endif>CIN &#8593; </option>
                    <option value="cin-desc" @if (request('sort') == 'email-desc') selected @endif>CIN &#8595; </option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
        </div>

        <div class="table-list">
            <table class="content">
                <thead>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>CIN</td>
                    <td>Actions</td>
                </thead>
                
                @if($admins->isNotEmpty())
                    @foreach ($admins as $admin)
                    <tr>
                        <td>{{$admin->id}}</td>
                        <td>{{$admin->name}}</td>
                        <td>{{$admin->email}}</td>
                        <td>{{$admin->cin}}</td>
                        <td class="x-actions">
                            <form method="POST" action="{{route('admin.admins.delete')}}" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$admin->id}}">
                                <button><x-heroicon-s-trash class="icon color-danger" /></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else 
                <tr>
                    <td colspan="8" class="text-center">
                        <h2>No admin found</h2>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="mt-5">
            {{$admins->links()}}
        </div>
    </div>

</x-app-layout>


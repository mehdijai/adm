<x-app-layout>

    @section('title', 'Marques')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Marques ({{$marques->total()}})</span>
        </div>

        <div class="search-bar">
            <form method="GET">
                <x-jet-label class="labels wight-500 color-blue" for="search" value="{{ __('Search') }}" />
                <x-jet-input placeholder="Search for a user" type="text" value="{{request('search')}}" name="search" />
                <x-jet-button type="submit" class="buttonTxt">Search</x-jet-button>
            </form>
            <form method="GET" class="ml-3">
                <x-jet-label class="labels wight-500 color-blue" for="sort" value="{{ __('Sort') }}" />
                <select class="w-full focus:ring focus:ring-red-200 focus:ring-opamarque-50 rounded-sm bgc-white-full inputTxt" name="sort">
                    <option value="created_at-desc" @if (request('sort') == 'created_at-desc') selected @endif >Newest</option>
                    <option value="created_at-asc" @if (request('sort') == 'created_at-asc') selected @endif >Oldest</option>
                    <option value="marque-asc" @if (request('sort') == 'marque-asc') selected @endif>Marque &#8593; </option>
                    <option value="marque-desc" @if (request('sort') == 'marque-desc') selected @endif>Marque &#8595; </option>
                    <option value="gamme-asc" @if (request('sort') == 'gamme-asc') selected @endif>Gamme &#8593; </option>
                    <option value="gamme-desc" @if (request('sort') == 'gamme-desc') selected @endif>Gamme &#8595; </option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
            <form method="POST" action="{{route('admin.marques.clean')}}" class="ml-3">
                @csrf
                <label class="labels wight-700 color-black block"><i><strong>{{ __('Clean empty marques') }}</strong></i></label>
                <x-jet-button type="submit" class="buttonTxt">Clean</x-jet-button>
            </form>
        </div>

        <x-jet-validation-errors class="error-status" />

        <div class="table-list">
            <table class="content">
                <thead>
                    <td>ID</td>
                    <td>Marque</td>
                    <td>Gamme</td>
                    <td>N° des vehicules</td>
                    <td>Actions</td>
                </thead>
                @if($marques->isNotEmpty())
                    @foreach ($marques as $marque)
                    <tr>
                        <td>{{$marque->id}}</td>
                        <td><a href="{{route('admin.vehicules.index') . '?search=' . $marque->marque}}"><strong>{{$marque->marque}}</strong></a></td>
                        <td><a href="{{route('admin.vehicules.index') . '?search=' . $marque->gamme}}"><strong>{{$marque->gamme}}</strong></a></td>
                        <td>{{count($marque->vehicules)}}</td>
                        <td class="x-actions">
                            
                            <a href="{{route('admin.marques.edit', ['id' => $marque->id])}}"><x-heroicon-s-pencil class="icon color-info" /></a>
                            @if (count($marque->vehicules) == 0)
                            <form method="POST" class="mx-2" action="{{route('admin.marques.delete')}}" onsubmit="return confirm('Are you sure you want to delete this marque?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$marque->id}}">
                                <button><x-heroicon-s-trash class="icon color-danger" /></button>
                            </form>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                @else 
                    <tr>
                        <td colspan="10" class="text-center">
                            <h2>No marques found</h2>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="mt-5">
            {{$marques->links()}}
        </div>
    </div>

</x-app-layout>


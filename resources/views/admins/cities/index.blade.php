<x-app-layout>

    @section('title', 'Cities')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Cities ({{$cities->total()}})</span>
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
                    <option value="city-asc" @if (request('sort') == 'city-asc') selected @endif>City &#8593; </option>
                    <option value="city-desc" @if (request('sort') == 'city-desc') selected @endif>City &#8595; </option>
                    <option value="secteur-asc" @if (request('sort') == 'secteur-asc') selected @endif>Secteur &#8593; </option>
                    <option value="secteur-desc" @if (request('sort') == 'secteur-desc') selected @endif>Secteur &#8595; </option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
            <form method="POST" action="{{route('admin.cities.clean')}}" class="ml-3">
                @csrf
                <label class="labels wight-700 color-black block"><i><strong>{{ __('Clean empty cities') }}</strong></i></label>
                <x-jet-button type="submit" class="buttonTxt">Clean</x-jet-button>
            </form>
        </div>

        <x-jet-validation-errors class="error-status" />

        <div class="table-list">
            <table class="content" x-data="xcities()">
                <thead>
                    <td>ID</td>
                    <td>Ville</td>
                    <td>Secteur</td>
                    <td>N° d'agence</td>
                    <td>Actions</td>
                </thead>
                @if($cities->isNotEmpty())
                    @foreach ($cities as $city)
                    <tr x-show="row == {{$city->id}}">
                        <td colspan="5">
                            <form x-show="row == {{$city->id}}" x-ref="update_city_{{$city->id}}" action="{{route('admin.cities.update')}}" method="post" onsubmit="return confirm('Are you sure you want to update this city?');">
                                @csrf
                                <input type="hidden" name="city_id" value="{{$city->id}}">
                                <input type="text" value="{{$city->city}}" name="city">
                                <input type="text" value="{{$city->secteur}}" name="secteur">
                                <span @click="save({{$city->id}})" class="btn bgc-success color-white">Save</span>
                                <span @click="row = null" class="btn bgc-info color-white">Cancel</span>
                            </form>
                        </td>
                    </tr>
                    <tr x-show="row != {{$city->id}}">
                        <td>{{$city->id}}</td>
                        <td><a href="{{route('admin.users.index') . '?search=' . $city->city}}"><strong>{{$city->city}}</strong></a></td>
                        <td><a href="{{route('admin.users.index') . '?search=' . $city->secteur}}"><strong>{{$city->secteur}}</strong></a></td>
                        <td>{{count($city->agences)}}</td>
                        <td class="x-actions">
                            
                            <a @click="row = {{$city->id}}"><x-heroicon-s-pencil class="icon color-info" /></a>
                            @if (count($city->agences) == 0)
                            <form method="POST" class="mx-2" action="{{route('admin.cities.delete')}}" onsubmit="return confirm('Are you sure you want to delete this city?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$city->id}}">
                                <button><x-heroicon-s-trash class="icon color-danger" /></button>
                            </form>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                @else 
                    <tr>
                        <td colspan="10" class="text-center">
                            <h2>No cities found</h2>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="mt-5">
            {{$cities->links()}}
        </div>
    </div>

    <script>
        function xcities(){
            return {
                row: null,
                save($id){
                    this.$refs['update_city_' + $id].submit()
                    this.row = null
                }
            }
        }
    </script>

</x-app-layout>
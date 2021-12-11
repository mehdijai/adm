<x-app-layout>

    @section('title', 'Subscriptions')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Subscriptions ({{$subscriptions->total()}})</span>
        </div>

        <div class="search-bar">
            <form method="GET">
                <x-jet-label class="labels wight-500 color-blue" for="search" value="{{ __('Search') }}" />
                <x-jet-input placeholder="Search for a subscription" type="text" value="{{request('search')}}" name="search" />
                <x-jet-button type="submit" class="buttonTxt">Search</x-jet-button>
            </form>
            <form method="GET" class="ml-3">
                <x-jet-label class="labels wight-500 color-blue" for="show-only" value="{{ __('Show Only') }}" />
                <select class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="show-only">
                    <option value="" @if (request('show-only') == '') selected @endif >All</option>
                    <option value="active" @if (request('show-only') == 'active') selected @endif>Active</option>
                    <option value="expired" @if (request('show-only') == 'expired') selected @endif>Expired</option>
                    <option value="pending" @if (request('show-only') == 'pending') selected @endif>Pending</option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
            <form method="GET" class="ml-3">
                <x-jet-label class="labels wight-500 color-blue" for="sort" value="{{ __('Sort') }}" />
                <select class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="sort">
                    <option value="created_at-asc" @if (request('sort') == 'created_at-asc') selected @endif >Oldest</option>
                    <option value="created_at-desc" @if (request('sort') == 'created_at-desc') selected @endif >Newest</option>
                    <option value="activation_date-asc" @if (request('sort') == 'activation_date-asc') selected @endif>Activation Date &#8593; </option>
                    <option value="activation_date-desc" @if (request('sort') == 'activation_date-desc') selected @endif>Activation Date &#8595; </option>
                    <option value="expiration_date-asc" @if (request('sort') == 'expiration_date-asc') selected @endif>Expiration Date Date &#8593; </option>
                    <option value="expiration_date-desc" @if (request('sort') == 'expiration_date-desc') selected @endif>Expiration Date &#8595; </option>
                    <option value="user_id-asc" @if (request('sort') == 'user_id-asc') selected @endif>User &#8593; </option>
                    <option value="user_id-desc" @if (request('sort') == 'user_id-desc') selected @endif>User &#8595; </option>
                    <option value="plan_id-asc" @if (request('sort') == 'plan_id-asc') selected @endif>Plan &#8593; </option>
                    <option value="plan_id-desc" @if (request('sort') == 'plan_id-desc') selected @endif>Plan &#8595; </option>
                </select>
                <x-jet-button type="submit" class="buttonTxt">Filter</x-jet-button>
            </form>
        </div>

        <div class="table-list">
            <table class="content">
                <thead>
                    <td>ID</td>
                    <td>User ID</td>
                    <td>User Email</td>
                    <td>User Tel</td>
                    <td>Plan Name</td>
                    <td>State</td>
                    <td>State Date</td>
                    <td>N° Vehicules</td>
                    <td>Period</td>
                    <td>Created at</td>
                    <td>Actions</td>
                </thead>
                @if($subscriptions->isNotEmpty())
                    @foreach ($subscriptions as $subs)    
                    @php
                        
                        $state = "";

                        if($subs->active){
                            $state = "active";
                        }else{
                            if($subs->expired){
                                $state = "expired";
                            }else{
                                $state = "pending";
                            }
                        }
                        
                    @endphp
                    <tr>
                        <td>{{$subs->id}}</td>
                        <td>{{$subs->user_id}}</td>
                        <td>{{$subs->user->email}}</td>
                        <td>{{$subs->user->agence->tel}}</td>
                        <td>{{$subs->plan->name}}</td>
                        <td class="state-{{$state}}">
                            {{ucfirst($state)}}
                        </td>
                        <td>
                            @if ($state == "active")
                                {{$subs->activation_date}}
                            @elseif ($state == "expired")
                                {{$subs->expiration_date}}
                            @elseif ($state == "pending")
                                {{$subs->created_at}}
                            @endif
                        </td>
                        <td>{{count(json_decode($subs->vehicules_ids))}}</td>
                        <td>
                            {{$subs->periode}} jrs
                        </td>
                        <td>{{$subs->created_at}}</td>
                        <td class="x-actions bgc-white">

                            @if (!$subs->active && !$subs->expired)
                            <form method="POST" action="{{route('admin.subscriptions.activate')}}" onsubmit="return confirm('Are you sure you want to active this subscription?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$subs->id}}" >
                                <button><x-heroicon-s-check class="icon color-success" /></button>
                            </form>
                            @endif

                            <form method="POST" action="{{route('admin.subscriptions.delete')}}" onsubmit="return confirm('Are you sure you want to delete this subscription?');">
                                @csrf
                                <input name="id" type="hidden" value="{{$subs->id}}" >
                                <button><x-heroicon-s-trash class="icon color-danger" /></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else 
                <tr>
                    <td colspan="11" class="text-center">
                        <h2>No subscription found</h2>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="mt-5">
            {{$subscriptions->links()}}
        </div>
    </div>

</x-app-layout>


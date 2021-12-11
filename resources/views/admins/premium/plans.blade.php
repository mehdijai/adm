<x-app-layout>

    @section('title', 'Plans')

    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Plans ({{$plans->total()}})</span>
        </div>

        <div class="table-list">
            <table class="content">
                <thead>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Price / Day</td>
                    <td>N° max Vehicules</td>
                    <td>Offres</td>
                    <td>Active subscriptions</td>
                    <td>Actions</td>
                </thead>
                @foreach ($plans as $plan)
                <tr class="text-center">
                    <td>{{$plan->id}}</td>
                    <td>{{$plan->name}}</td>
                    <td>{{$plan->price}} DH</td>
                    <td>{{$plan->max_vehs}}</td>
                    <td class="text-left">
                        @foreach (json_decode($plan->features) as $feature)
                            <span class="block">{{$feature}}</span>
                        @endforeach
                    </td>
                    <td>{{$plan->subscriptions()->count()}}</td>
                    <td class="x-actions">
                        <a href="{{route('admin.plans.edit', $plan->id)}}"><x-heroicon-s-pencil-alt class="icon color-info" /></a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>  
        <div class="mt-5">
            {{$plans->links()}}
        </div>        
    
    </div>

</x-app-layout>
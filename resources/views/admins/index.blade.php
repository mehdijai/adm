<x-app-layout>

    @section('title', 'Admin')

    <div class="panel">
        <div class="menu">
            <span class="title color-red">Menu</span>
            <ul>
                <li><a class="color-black navLinks" href="{{route('admin.admins.index')}}">Manage admins</a></li>
                <li><a class="color-black navLinks" href="{{route('admin.users.index')}}">Manage users</a></li>
                <li><a class="color-black navLinks" href="{{route('admin.vehicules.index')}}">Manage vehicules</a></li>
                <li><a class="color-black navLinks" href="{{route('admin.plans.index')}}">Manage plans</a></li>
                <li><a class="color-black navLinks" href="{{route('admin.subscriptions.index')}}">Manage subscriptions</a></li>
                <li><a class="color-black navLinks" href="{{route('admin.settings.index')}}">Manage settings</a></li>
            </ul>
        </div>

        <div class="statistics">
            <span class="title color-red">Statistics</span>
            <ul>
                <li><span class="color-blue navLinks">Users / Agences</span> <span class="color-red">{{$statisctics['users']}}</span> </li>
                <li><span class="color-blue navLinks">Vehicules</span> <span class="color-red">{{$statisctics['vehicules']}}</span> </li>
                <li><span class="color-blue navLinks">Active Subscription</span> <span class="color-red">{{$statisctics['active_subscriptions']}}</span> </li>
                <li><span class="color-blue navLinks">Pending Subscriptions</span> <span class="color-red">{{$statisctics['pending_subscriptions']}}</span> </li>
                <li><span class="color-blue navLinks">Expired Subscriptions</span> <span class="color-red">{{$statisctics['expired_subscriptions']}}</span> </li>
            </ul>
        </div>
    </div>

</x-app-layout>


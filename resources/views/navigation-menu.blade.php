<nav class="bgc-white navBar">
    
    <div class="logo">
        <a href="{{ route('home') }}">
            <x-jet-application-logo  />
        </a>
    </div>

    @if (auth()->user()->role_id == 1)
        
    <div class="nvLink">
        <x-jet-nav-link href="{{ route('dashboard') }}" class="color-black navLinks" :active="request()->routeIs('dashboard')">
            {{ __('Mes véhicules') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink">
        <x-jet-nav-link href="{{ route('support') }}" class="color-black navLinks" :active="request()->routeIs('support')">
            {{ __('Support') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink">
        <x-jet-nav-link href="{{ route('premium.index') }}" class="color-black navLinks" :active="request()->routeIs('premium.*')">
            {{ __('ADM Premium') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink nvDropdown" x-data="{open: false}" @click.away="open = false" @close.stop="open = false">
        <div id="trigger" class="color-black navLinks" @click="open = ! open" >
            <span>{{strtoupper(Auth::user()->name)}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
        <div id="list" 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        style="display: none;"
        @click="open = false">

            <div class="item">
                <x-jet-dropdown-link class="color-black navLinks" href="{{ route('profile.show') }}">
                    {{ __('Mon compte') }}
                </x-jet-dropdown-link>
            </div>

            <div class="border-t border-gray-100"></div>
            
            <div class="item">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-dropdown-link class="color-black navLinks" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Déconnection') }}
                    </x-jet-dropdown-link>
                </form>
            </div>
            
        </div>
    </div>

    @endif

    @if (auth()->user()->role_id == 2)
    <div class="nvLink">
        <x-jet-nav-link href="{{ route('admin.index') }}" class="color-black navLinks" :active="request()->routeIs('admin.index')">
            {{ __('Dashboard') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink">
        <x-jet-nav-link href="{{ route('profile.show') }}" class="color-black navLinks" :active="request()->routeIs('profile.*')">
            {{ __('Mon compte') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-jet-dropdown-link class="color-black navLinks" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">
                {{ __('Déconnection') }}
            </x-jet-dropdown-link>
        </form>
    </div>
    @endif

    <div id="menu">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
        </svg>
    </div>
</nav>



<div id="nav-list" class="bgc-white">

    <div id="close">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </div>

    <ul>
        <li>
            <x-jet-nav-link href="{{ route('dashboard') }}" class="color-black navLinks" :active="request()->routeIs('dashboard')">
                {{ __('Mes véhicules') }}
            </x-jet-nav-link>
        </li>
        <li>
            <x-jet-nav-link href="{{ route('support') }}" class="color-black navLinks" :active="request()->routeIs('support')">
                {{ __('Support') }}
            </x-jet-nav-link>
        </li>
        <li>
            <x-jet-nav-link href="{{ route('premium.index') }}" class="color-black navLinks" :active="request()->routeIs('premium.*')">
                {{ __('ADM Premium') }}
            </x-jet-nav-link>
        </li>
        <li>
            <x-jet-dropdown-link class="color-black navLinks" href="{{ route('profile.show') }}">
                {{ __('Mon compte') }}
            </x-jet-dropdown-link>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-jet-dropdown-link class="color-black navLinks" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                this.closest('form').submit();">
                    {{ __('Déconnection') }}
                </x-jet-dropdown-link>
            </form>
        </li>
    </ul>
</div>

<script>
    let menuBtn = document.getElementById('menu')
    let navlist = document.getElementById('nav-list')
    let closeBtn = document.getElementById('close')

    menuBtn.addEventListener('click', (e) => {
        navlist.style.display = 'flex'
    })

    closeBtn.addEventListener('click', (e) => {
        navlist.style.display = 'none'
    })
</script>
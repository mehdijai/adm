<nav class="bgc-white navBar">
    
    <div class="logo">
        <a href="{{ route('home') }}">
            <x-jet-application-logo  />
        </a>
    </div>

    <div class="nvLink">
        <x-jet-nav-link href="{{ route('home') }}" class="color-black navLinks" :active="request()->routeIs('home')">
            {{ __('Acceuil') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink">
        <x-jet-nav-link href="{{ route('vehicules') }}" class="color-black navLinks" :active="request()->routeIs('vehicules')">
            {{ __('Les véhicules') }}
        </x-jet-nav-link>
    </div>

    <div class="nvLink">
        <x-jet-nav-link href="{{ route('home') }}/#contact" class="color-black navLinks">
            {{ __('Contactez nous') }}
        </x-jet-nav-link>
    </div>
    
    @auth
        <div class="nvLink">
            <x-jet-nav-link href="{{ route('dashboard') }}" class="color-black navLinks" :active="request()->routeIs('dashboard')">
                {{ __('Mon profile') }}
            </x-jet-nav-link>
        </div>
    @else
        <div class="nvLink">
            <x-jet-nav-link href="{{ route('login') }}" class="color-black navLinks" :active="request()->routeIs('login')">
                {{ __('Se connecter') }}
            </x-jet-nav-link>
        </div>
        @if (Route::has('register'))
            <div class="nvLink">
                <x-jet-nav-link href="{{ route('register') }}" class="color-black navLinks" :active="request()->routeIs('register')">
                    {{ __("S'inscrire") }}
                </x-jet-nav-link>
            </div>
        @endif
    @endauth

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
            <x-jet-nav-link href="{{ route('home') }}" class="color-black navLinks" :active="request()->routeIs('home')">
                {{ __('Acceuil') }}
            </x-jet-nav-link>
        </li>
        <li>
            <x-jet-nav-link href="{{ route('vehicules') }}" class="color-black navLinks" :active="request()->routeIs('vehicules')">
                {{ __('Les véhicules') }}
            </x-jet-nav-link>
        </li>
        <li>
            <x-jet-nav-link href="{{ route('home') }}/#contact" class="color-black navLinks">
                {{ __('Contactez nous') }}
            </x-jet-nav-link>
        </li>
        @auth
            <li>
                <x-jet-nav-link href="{{ route('dashboard') }}" class="color-black navLinks" :active="request()->routeIs('dashboard')">
                    {{ __('Mon profile') }}
                </x-jet-nav-link>
            </li>
        @else
            <li>
                <x-jet-nav-link href="{{ route('login') }}" class="color-black navLinks" :active="request()->routeIs('login')">
                    {{ __('Se connecter') }}
                </x-jet-nav-link>
            </li>
            @if (Route::has('register'))
                <li>
                    <x-jet-nav-link href="{{ route('register') }}" class="color-black navLinks" :active="request()->routeIs('register')">
                        {{ __("S'inscrire") }}
                    </x-jet-nav-link>
                </li>
            @endif
        @endauth
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
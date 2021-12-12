<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @if ($external_tags = App\Models\Setting::externalTags())
            {!! $external_tags !!}
        @endif

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Annonces des vehicule de location au Maroc. Trouvez des voitures, bus et minibus avec les conditions que vous désirées. @yield('description')">
        <meta name="keywords" content="annonce voiture, location voiture, location facile, location minibus, location bus, location au maroc, voitures, minibus, bus, @yield('keywords')">

        <meta property="og:title" content="@yield('title')">
        <meta property="og:description" content="@yield('description')">
        <meta property="og:type" content="website">
        <meta property="og:image" content="@yield('og-image')">

        <title>@yield('title') - {{ config('app.name') }}</title>
        <link rel="shortcut icon" href="/favicon.svg" type="image/x-icon">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">
        @livewireStyles
        @bukStyles(true)

        
        <style>
            html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:flex-column{flex-direction: column}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>

    </head>
    <body class="adm-body">
        
        <noscript>
            Veuillez activer JavaScript pour continuer à utiliser cette plateforme!
        </noscript>

        @livewire("components.nav-bar")

        <main>
            {{ $slot }}
        </main>

        <footer class="adm-footer">
            <div>
                <section >
                    <h5 class="color-red"><strong>Liens internes</strong></h5>
                    <a href="{{route('terms.show')}}">les conditions d'utilisation</a>
                    <a href="{{route('policy.show')}}">la politique de confidentialité</a>
                    <a href="{{route('sitemap')}}">Sitemap</a>
                </section>
                <section >
                    <h5 class="color-red"><strong>Contactez-nous</strong></h5>
                    <a href="mailto:contact@autodrive.ma">contact@autodrive.ma</a>
                    @php
                        $contacts = App\Models\Setting::getContact(['whatsapp_link', 'facebook_link', 'instagram_link', 'telegram_link'])
                    @endphp
                    <div class="smlinks">
    
                        <a id="ins" href="{{$contacts['instagram_link']}}" class="sm">
                            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.99731 6.66525C8.16111 6.66525 6.66262 8.16376 6.66262 10C6.66262 11.8362 8.16111 13.3348 9.99731 13.3348C11.8335 13.3348 13.332 11.8362 13.332 10C13.332 8.16376 11.8335 6.66525 9.99731 6.66525ZM19.9989 10C19.9989 8.61907 20.0114 7.25064 19.9338 5.87221C19.8563 4.27113 19.4911 2.85017 18.3203 1.67938C17.147 0.506085 15.7286 0.14334 14.1275 0.065788C12.7466 -0.0117644 11.3782 0.000744113 9.99981 0.000744113C8.61891 0.000744113 7.25051 -0.0117644 5.8721 0.065788C4.27105 0.14334 2.85012 0.508587 1.67935 1.67938C0.506076 2.85267 0.143338 4.27113 0.0657868 5.87221C-0.0117642 7.25314 0.000744099 8.62157 0.000744099 10C0.000744099 11.3784 -0.0117642 12.7494 0.0657868 14.1278C0.143338 15.7289 0.508578 17.1498 1.67935 18.3206C2.85262 19.4939 4.27105 19.8567 5.8721 19.9342C7.25301 20.0118 8.62141 19.9993 9.99981 19.9993C11.3807 19.9993 12.7491 20.0118 14.1275 19.9342C15.7286 19.8567 17.1495 19.4914 18.3203 18.3206C19.4936 17.1473 19.8563 15.7289 19.9338 14.1278C20.0139 12.7494 19.9989 11.3809 19.9989 10V10ZM9.99731 15.131C7.15795 15.131 4.86644 12.8394 4.86644 10C4.86644 7.16058 7.15795 4.86903 9.99731 4.86903C12.8367 4.86903 15.1282 7.16058 15.1282 10C15.1282 12.8394 12.8367 15.131 9.99731 15.131ZM15.3383 5.8572C14.6754 5.8572 14.14 5.32184 14.14 4.65889C14.14 3.99594 14.6754 3.46058 15.3383 3.46058C16.0013 3.46058 16.5366 3.99594 16.5366 4.65889C16.5368 4.81631 16.5059 4.97222 16.4458 5.1177C16.3856 5.26317 16.2974 5.39535 16.1861 5.50666C16.0748 5.61798 15.9426 5.70624 15.7971 5.76639C15.6516 5.82654 15.4957 5.8574 15.3383 5.8572V5.8572Z"/>
                            </svg>            
                        </a>
                        <a id="fb" href="{{$contacts['facebook_link']}}" class="sm">
                            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.2 0H0.8C0.3575 0 0 0.3575 0 0.8V19.2C0 19.6425 0.3575 20 0.8 20H19.2C19.6425 20 20 19.6425 20 19.2V0.8C20 0.3575 19.6425 0 19.2 0ZM16.89 5.8375H15.2925C14.04 5.8375 13.7975 6.4325 13.7975 7.3075V9.235H16.7875L16.3975 12.2525H13.7975V20H10.68V12.255H8.0725V9.235H10.68V7.01C10.68 4.4275 12.2575 3.02 14.5625 3.02C15.6675 3.02 16.615 3.1025 16.8925 3.14V5.8375H16.89Z"/>
                            </svg>            
                        </a>
                        <a id="telg" href="{{$contacts['telegram_link']}}" class="sm">
                            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 0C4.47548 0 0 4.47613 0 10C0 15.5239 4.47613 20 10 20C15.5245 20 20 15.5239 20 10C20 4.47613 15.5239 0 10 0ZM14.9116 6.85097L13.2703 14.5852C13.149 15.1335 12.8226 15.2665 12.3671 15.0084L9.8671 13.1658L8.66129 14.3271C8.52839 14.46 8.41548 14.5729 8.15742 14.5729L8.33484 12.0284L12.9677 7.84258C13.1697 7.66516 12.9232 7.56452 12.6568 7.74194L6.93097 11.3465L4.46323 10.5761C3.9271 10.4071 3.91484 10.04 4.57613 9.78194L14.2174 6.06387C14.6652 5.90258 15.0561 6.1729 14.911 6.85032L14.9116 6.85097Z"/>
                            </svg>            
                        </a>
                        <a id="wa" href="{{$contacts['whatsapp_link']}}" class="sm">
                            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.7619 4.05357C6.59364 4.05357 4.01807 6.69196 4.01371 9.9375C4.01371 11.0491 4.31877 12.1339 4.89403 13.067L5.02912 13.2902L4.44951 15.4598L6.62415 14.875L6.83333 15.0045C7.71365 15.5402 8.7247 15.8259 9.75755 15.8259H9.7619C12.9258 15.8259 15.5711 13.1875 15.5711 9.94196C15.5711 8.37054 14.9087 6.89286 13.8236 5.78125C12.7341 4.66518 11.2959 4.05357 9.7619 4.05357ZM13.1393 12.4643C12.9955 12.8795 12.307 13.2545 11.9758 13.3036C11.4267 13.3884 10.9996 13.3438 9.90572 12.8616C8.1756 12.0938 7.04252 10.308 6.95536 10.192C6.8682 10.0759 6.24936 9.23214 6.24936 8.36161C6.24936 7.49107 6.69388 7.0625 6.85512 6.88393C7.01201 6.70536 7.1994 6.66071 7.31707 6.66071C7.43038 6.66071 7.54804 6.66071 7.64828 6.66518C7.75287 6.66964 7.89668 6.625 8.03614 6.96875C8.17995 7.32143 8.52424 8.19196 8.56781 8.28125C8.61139 8.37054 8.6419 8.47321 8.58089 8.58929C8.24968 9.26786 7.89668 9.24107 8.07536 9.55357C8.74213 10.7277 9.40891 11.1339 10.4243 11.6563C10.5986 11.7455 10.6989 11.7321 10.7991 11.6116C10.8993 11.4955 11.2305 11.0938 11.3439 10.9196C11.4572 10.7411 11.5748 10.7723 11.7317 10.8304C11.8886 10.8884 12.7384 11.317 12.9127 11.4063C13.0871 11.4955 13.2004 11.5402 13.2439 11.6116C13.2832 11.6964 13.2832 12.0536 13.1393 12.4643V12.4643ZM17.432 0H2.09184C0.936969 0 0 0.959821 0 2.14286V17.8571C0 19.0402 0.936969 20 2.09184 20H17.432C18.5868 20 19.5238 19.0402 19.5238 17.8571V2.14286C19.5238 0.959821 18.5868 0 17.432 0ZM9.75755 17.0179C8.59832 17.0179 7.46088 16.7188 6.45419 16.1563L2.78912 17.1429L3.76966 13.4732C3.1639 12.4018 2.84577 11.183 2.84577 9.93304C2.85013 6.03125 5.94866 2.85714 9.75755 2.85714C11.6053 2.85714 13.3398 3.59375 14.6472 4.93304C15.9503 6.27232 16.7347 8.04911 16.7347 9.94196C16.7347 13.8438 13.5664 17.0179 9.75755 17.0179Z"/>
                            </svg>            
                        </a>
                    </div>
                </section>
                <section >
                    <h5 class="color-red"><strong>Liens externes</strong></h5>
                    <a href="https://www.medostudios.com">Medostudios</a>
                    <a href="https://pres.autodrive.ma">Présentation du project</a>
                </section>
            </div>
            <div>
                <section class="cp">
                    <span class="weight-700">AUTODRIVEMAROC © {{ Date("Y") }} - POWERED BY <a class="color-red" href="https://www.medostudios.com">MEDOSTUDIOS</a></span>
                </section>
            </div>
        </footer>

        <div id="to-top">
            <x-heroicon-o-chevron-up class="icon"/>
        </div>

        <script>
            window.onscroll = function() {
                let mybutton = document.getElementById('to-top')

                if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
                    mybutton.style.display = 'flex';
                } else {
                    mybutton.style.display = 'none';
                }
            };

            document.getElementById('to-top').addEventListener('click', (e) => {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            })
        </script>

        <script src="/js/app.js" defer></script>
        @livewireScripts
        @bukScripts(true)
    </body>
</html>
<x-app-layout>

    @section('title', 'Support')

    <div class="contactSection min-h-screen bgc-white-lighter sm:pt-0" id="contact">

        <div class="title-txt">
            
            <span class="hero-headline text-center">Contacter-nous</span>
            <span class="hero-subtitle text-center">Si vous avez un problème, n'hésitez pas de nous contacter sur cette formulaire ou WhatsApp</span>
        
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="contactForm" method="POST" action="{{ route('send-support') }}">
            @csrf

            <div>

                <x-jet-input id="name" placeholder="Votre nom" class="block mt-1 w-full inputTxt bgc-white-full" type="text" name="name" :value="old('name')" required />

                <x-jet-input id="email" placeholder="Votre email ou téléphone" class="block mt-1 w-full inputTxt bgc-white-full" type="text" name="email" :value="old('email')" required />
                
                <x-jet-input id="subject" placeholder="Objet" class="block mt-1 w-full inputTxt bgc-white-full" type="text" name="subject" :value="old('subject')" required />

            </div>

            <div>
                
                <textarea name="message" placeholder="Message" id="message" rows="5" class="block mt-1 w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt"></textarea>
            
            </div>

            <div class="flex items-center justify-center mt-4">

                <x-jet-button class="buttonTxt color-white">
                    {{ __('Envoyer') }}
                </x-jet-button>

            </div>

            <div class="smlinks mt-4">
                <a id="wa" href="{{$contacts["whatsapp_link"]}}" class="sm">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.7619 4.05357C6.59364 4.05357 4.01807 6.69196 4.01371 9.9375C4.01371 11.0491 4.31877 12.1339 4.89403 13.067L5.02912 13.2902L4.44951 15.4598L6.62415 14.875L6.83333 15.0045C7.71365 15.5402 8.7247 15.8259 9.75755 15.8259H9.7619C12.9258 15.8259 15.5711 13.1875 15.5711 9.94196C15.5711 8.37054 14.9087 6.89286 13.8236 5.78125C12.7341 4.66518 11.2959 4.05357 9.7619 4.05357ZM13.1393 12.4643C12.9955 12.8795 12.307 13.2545 11.9758 13.3036C11.4267 13.3884 10.9996 13.3438 9.90572 12.8616C8.1756 12.0938 7.04252 10.308 6.95536 10.192C6.8682 10.0759 6.24936 9.23214 6.24936 8.36161C6.24936 7.49107 6.69388 7.0625 6.85512 6.88393C7.01201 6.70536 7.1994 6.66071 7.31707 6.66071C7.43038 6.66071 7.54804 6.66071 7.64828 6.66518C7.75287 6.66964 7.89668 6.625 8.03614 6.96875C8.17995 7.32143 8.52424 8.19196 8.56781 8.28125C8.61139 8.37054 8.6419 8.47321 8.58089 8.58929C8.24968 9.26786 7.89668 9.24107 8.07536 9.55357C8.74213 10.7277 9.40891 11.1339 10.4243 11.6563C10.5986 11.7455 10.6989 11.7321 10.7991 11.6116C10.8993 11.4955 11.2305 11.0938 11.3439 10.9196C11.4572 10.7411 11.5748 10.7723 11.7317 10.8304C11.8886 10.8884 12.7384 11.317 12.9127 11.4063C13.0871 11.4955 13.2004 11.5402 13.2439 11.6116C13.2832 11.6964 13.2832 12.0536 13.1393 12.4643V12.4643ZM17.432 0H2.09184C0.936969 0 0 0.959821 0 2.14286V17.8571C0 19.0402 0.936969 20 2.09184 20H17.432C18.5868 20 19.5238 19.0402 19.5238 17.8571V2.14286C19.5238 0.959821 18.5868 0 17.432 0ZM9.75755 17.0179C8.59832 17.0179 7.46088 16.7188 6.45419 16.1563L2.78912 17.1429L3.76966 13.4732C3.1639 12.4018 2.84577 11.183 2.84577 9.93304C2.85013 6.03125 5.94866 2.85714 9.75755 2.85714C11.6053 2.85714 13.3398 3.59375 14.6472 4.93304C15.9503 6.27232 16.7347 8.04911 16.7347 9.94196C16.7347 13.8438 13.5664 17.0179 9.75755 17.0179Z"/>
                    </svg>            
                </a> 
            </div>

        </form>

    </div>


</x-app-layout>

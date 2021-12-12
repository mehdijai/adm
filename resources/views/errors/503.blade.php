<x-guest-layout>

    @section('title', 'Sous maintenance')

    <div class="pt-4 bg-gray-100">
        <div class="flex flex-column items-center pt-6 sm:pt-0">
            <div>
                <x-jet-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-2xl mt-5 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg prose text-center">
                <h1 class="weight-700 color-red">Sous maintenance</h1>
                <p class="my-5">
                    <q>
                        <strong>
                            Nous sommes actuellement en train d'améliorer la plateforme afin d'optimiser l'expérience pour vous.<br>
                            Nous vous remercions de votre patience !
                        </strong>
                    </q>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

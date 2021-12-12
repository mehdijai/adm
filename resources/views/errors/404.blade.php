<x-guest-layout>

    @section('title', 'Page non trouvée 404')

    <div class="pt-4 bg-gray-100">
        <div class="flex flex-column items-center pt-6 sm:pt-0">
            <div>
                <x-jet-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-2xl mt-5 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg prose text-center">
                <h1 class="weight-700 color-red">Error 404</h1>
                <h5>Page non trouvée</h5>
                <p class="my-5">
                    <q>
                        <strong>Cette page n'existe pas ou n'existe plus!</strong>
                    </q>
                </p>
                <a class="mb-2 weight-700 color-blue" href="/">Revenez à la page d'accueil.</a>
            </div>
        </div>
    </div>
</x-guest-layout>

<x-guest-layout>

    @section('title', 'Polices')

    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-column items-center pt-6 sm:pt-0">
            <div>
                <x-jet-authentication-card-logo class="h-5" />
            </div>

            <div class="w-full sm:max-w-2xl mt-4 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-guest-layout>

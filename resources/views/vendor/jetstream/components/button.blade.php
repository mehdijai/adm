<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex color-white items-center bgc-red border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bgc-gray-700 active:bgc-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
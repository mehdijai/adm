const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',
    // important: true,
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            lineHeight: {
                'normal': '1.6',
            }
            colors: {
                black: '#222',
                golden: {
                    light: '#CAB44B',
                    DEFAULT: '#AC9E3C',
                    dark: '#977124',
                },
            },
        },
        screens: {
            'sm': '640px',
    
            'md': '816px',
    
            'lg': '1024px',
    
            'xl': '1412px',
    
            '2xl': '1536px',
        },
    },

    plugins: [
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography'),
    ],
};
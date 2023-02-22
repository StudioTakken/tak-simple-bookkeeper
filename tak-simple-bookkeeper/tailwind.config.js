const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                dark: {
                    'eval-0': '#151823',
                    'eval-1': '#222738',
                    'eval-2': '#2A2F42',
                    'eval-3': '#2C3142',
                },
                'takred': {
                    100: '#C91919',
                    200: '#C91919',
                    300: '#C91919',
                    400: '#C91919',
                    500: '#C91919',
                    600: '#C91919',
                    700: '#C91919',
                    800: '#C91919',
                    900: '#C91919',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
}

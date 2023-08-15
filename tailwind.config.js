/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.svelte",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('windy-radix-palette'),
        require('@tailwindcss/typography'),
        require('windy-radix-typography')
    ],
}

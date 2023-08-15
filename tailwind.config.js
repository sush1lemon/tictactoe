/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.svelte",
        // 2. Append the path for the Skeleton NPM package and files:
        require('path').join(require.resolve(
                '@skeletonlabs/skeleton'),
            '../**/*.{html,js,svelte,ts}'
        )
    ],
    theme: {
        extend: {},
    },
    plugins: [
        // require('windy-radix-palette'),
        // require('@tailwindcss/typography'),
        // require('windy-radix-typography')
        ...require('@skeletonlabs/skeleton/tailwind/skeleton.cjs')()
    ],
}

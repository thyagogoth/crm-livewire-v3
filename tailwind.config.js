/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // You will probably also need those lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        extend: {},
    },

    daisyui: {
    //     themes: [
    //         "light",
    //         "dark",
    //         "cupcake",
    //         "bumblebee",
    //         "emerald",
    //         "corporate",
    //         "synthwave",
    //         "retro",
    //         "cyberpunk",
    //         "valentine",
    //         "halloween",
    //         "garden",
    //         "forest",
    //         "aqua",
    //         "lofi",
    //         "pastel",
    //         "fantasy",
    //         "wireframe",
    //         "black",
    //         "luxury",
    //         "dracula",
    //         "cmyk",
    //         "autumn",
    //         "business",
    //         "acid",
    //         "lemonade",
    //         "night",
    //         "coffee",
    //         "winter",
    //     ],
        darkTheme: "dark", // name of one of the included themes for dark mode
        base: true, // applies background color and foreground color for root element by default
        styled: true, // include daisyUI colors and design decisions for all components
        utils: true, // adds responsive and modifier utility classes
        rtl: false, // rotate style direction from left-to-right to right-to-left. You also need to add dir="rtl" to your html tag and install `tailwindcss-flip` plugin for Tailwind CSS.
        prefix: "", // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
        logs: true,
    },

    // Add daisyUI
    plugins: [require("daisyui")]
}

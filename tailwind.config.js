import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
        "node_modules/preline/dist/*.js",
        "./node_modules/flyonui/dist/js/*.js",
        "./node_modules/flyonui/dist/js/accordion.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", "sans-serif"],
                ubuntu: ["Ubuntu", "ui-sans-serif", "system-ui"],
            },
            fontSize: {
                xs: "0.625rem", // Define the font size for xs
            },
            screens: {
                print: { raw: "print" },
                screen: { raw: "screen" },
            },
        },
    },

    plugins: [
        forms,
        require("preline/plugin"),
        require("flyonui"),
        require("flyonui/plugin"),
        require("flowbite/plugin"),
    ],
    darkMode: "false",
    flyonui: {
        themes: ["light"],
    },
};

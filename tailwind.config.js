/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/views/**/*.{blade.php,php}"],
    theme: {
        extend: {},
    },
    plugins: [require("@tailwindcss/forms")],
};

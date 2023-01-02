const colors = require("tailwindcss/colors");

module.exports = {
    mode: "jit",
    purge: ["./resources/views/**/*.{blade.php,php}"],
    darkMode: false, // or 'media' or 'class'
    theme: {
        ...colors,
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [require("@tailwindcss/forms")],
};

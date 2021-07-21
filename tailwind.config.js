module.exports = {
  mode: 'jit',
  purge: [
      './resources/views/**/*.{blade.php,php}'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
  ],
}

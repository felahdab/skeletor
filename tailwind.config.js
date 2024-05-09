/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./Modules/**/*.blade.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  prefix: "tw-",
  corePlugins: {
    preflight: false,
  },
  important: true,
}
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'warehouse-blue': '#2563eb',
        'warehouse-dark': '#1e3a8a',
        'warehouse-light': '#f1f5f9',
      },
      fontFamily: {
        'sans': ['Inter', 'Arial', 'sans-serif'],
      },
    },
  },
  plugins: [],
} 
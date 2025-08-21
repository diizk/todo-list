/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'dark-bg': '#383D3B',
        'dark-card': '#252827',
        'text-light': '#E5E5E5',
        'primary-blue': '#5E4AE3',
        'secondary-purple': '#947BD3',
        'accent-pink': '#F0A7A0',
      },
    },
  },
  plugins: [],
};
/** @type {import('tailwindcss').Config} */
export default {
  content: ["./resources/**/*.{html,js,vue}"],
  theme: {
    extend: {
      colors: {
        pink: '#fbcfe8',
      }
    },
  },
  plugins: [require("daisyui")],
}


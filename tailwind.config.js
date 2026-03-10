/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        // Pastel Colors
        'pastel-blue': '#A8D8EA',
        'pastel-blue-light': '#D4EDF7',
        'pastel-blue-dark': '#7EC8E3',
        'pastel-yellow': '#FFD89B',
        'pastel-yellow-light': '#FFE8C7',
        'pastel-yellow-dark': '#FFCC7A',
        
        // Accent Colors
        'accent-blue': '#7EC8E3',
        'accent-yellow': '#FFCC7A',
        
        // Utility Colors
        'soft-blue': '#A8D8EA',
      },
      fontFamily: {
        'mono': ['JetBrains Mono', 'monospace'],
      },
    },
  },
  plugins: [],
}
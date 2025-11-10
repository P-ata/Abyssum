import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  server: {
    origin: 'http://localhost:5173',
  },
  build: {
    manifest: true,
    rollupOptions: {
      input: {
        main: './public/assets/js/main.js',
        pacts: './public/assets/js/pacts.js',
        demons: './public/assets/js/demons.js',
      }
    }
  }
})
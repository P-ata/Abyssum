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
        abyssum: './public/assets/js/abyssum.js',
        contact: './public/assets/js/contact.js',
        profile: './public/assets/js/profile.js',
        orders: './public/assets/js/orders.js',
        cart: './public/assets/js/cart.js',
        login: './public/assets/js/login.js',
        register: './public/assets/js/register.js',
        pactDetail: './public/assets/js/pact-detail.js',
      }
    }
  }
})
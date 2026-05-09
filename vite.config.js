import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Optimizaciones para producción
        minify: 'terser',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs', 'axios'],
                    sweetalert: ['sweetalert2']
                }
            }
        },
        // Optimizar el tamaño del bundle
        chunkSizeWarningLimit: 1000,
        // Generar source maps solo en desarrollo
        sourcemap: process.env.NODE_ENV !== 'production'
    },
    // Optimizaciones adicionales
    optimizeDeps: {
        include: ['alpinejs', 'axios', 'sweetalert2']
    }
});

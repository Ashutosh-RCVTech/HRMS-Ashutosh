import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin/app.css',
                'resources/js/admin/app.js',
                'resources/css/college/app.css',
                'resources/js/college/app.js',
                'resources/css/candidate/app.css',
                'resources/js/candidate/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // Include hash in filenames for cache busting
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].[hash].js`,
                chunkFileNames: `assets/[name].[hash].js`,
                assetFileNames: `assets/[name].[hash].[ext]`,
            },
        },
        cssCodeSplit: true,
        sourcemap: true,
    },
    css: {
        postcss: {
            plugins: [
                tailwindcss(),
                autoprefixer(),
            ],
        },
        devSourcemap: true,
    },
    optimizeDeps: {
        include: ['@tailwindcss/forms'],
    },
});
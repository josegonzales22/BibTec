import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/css/styleindex.css',
                'resources/css/sb-admin-2.min.css',
                'resources/css/fontawesome-free/css/all.min.css',
                'resources/css/scan.css',

                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'jquery': 'jquery'
        }
    },
    optimizeDeps: {
        include: ['jquery']
    }
});

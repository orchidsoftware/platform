import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import rtl from 'postcss-rtl';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true
        }),
    ],
    css: {
        postcss: {
            plugins: [rtl()],
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import viteRtlCssPlugin from 'vite-plugin-rtl-css';
import { resolve } from 'path';
import manifestSRI from 'vite-plugin-manifest-sri';
import fs from 'fs';
import path from 'node:path';

// Функция для генерации безопасного случайного хеша
const generateHash = (length = 16) => {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
};

// Плагин для добавления случайного хеша в манифест
const addHashToManifest = () => ({
    name: 'vite-plugin-add-hash-to-manifest',
    apply: 'build',
    enforce: 'post',
    closeBundle() {
        const manifestPath = path.resolve('public', 'manifest.json');

        if (fs.existsSync(manifestPath)) {
            const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf-8'));
            const hash = generateHash(16);

            Object.keys(manifest).forEach((key) => {
                manifest[key].file += `?v=${hash}`;
            });

            fs.writeFileSync(manifestPath, JSON.stringify(manifest, null, 2));
            console.log(`✅ Добавлен хеш ?v=${hash} в manifest.json`);
        }
    },
});

export default defineConfig(({ mode }) => ({
    plugins: [
        viteRtlCssPlugin(),
        manifestSRI(),
        //addHashToManifest(),
    ],
    build: {
        emptyOutDir: false,
        outDir: 'public',
        rollupOptions: {
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
            ],
            output: {
                assetFileNames: 'assets/[name].[ext]',
                chunkFileNames: 'assets/[name].js',
                entryFileNames: 'assets/app.js',
            },
        },
        manifest: true,
    },
    resolve: {
        root: resolve(__dirname, './'),
    },
}));

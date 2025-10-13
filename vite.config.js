import { defineConfig } from 'vite';
import { resolve } from 'path';
import fs from 'fs';
import path from 'node:path';
import crypto from 'node:crypto';
import viteRtlCssPlugin from 'vite-plugin-rtl-css';
import manifestSRI from 'vite-plugin-manifest-sri';

/**
 * Custom Vite plugin that appends a version query hash (`?v=HASH`) to the `file`
 * and `css` entries in the manifest.json. This ensures proper cache busting when file
 * contents change by generating an MD5 hash of each asset.
 */
function addQueryHashToManifest() {
    return {
        name: 'add-query-hash-to-manifest',
        apply: 'build',
        enforce: 'post',
        closeBundle() {
            const publicDir = path.resolve(__dirname, 'public');
            const manifestFile = path.resolve(publicDir, 'manifest.json');

            // If the manifest does not exist, exit early.
            if (!fs.existsSync(manifestFile)) {
                return;
            }

            const manifestData = fs.readFileSync(manifestFile, 'utf-8');
            const manifest = JSON.parse(manifestData);

            /**
             * Appends a version query parameter to the given file path based on its content hash.
             *
             * @param {string} filePath - Relative file path from the public directory.
             * @returns {string} - File path with appended version query parameter.
             */
            const appendHash = (filePath) => {
                const [baseFilePath] = filePath.split('?');
                const absolutePath = path.resolve(publicDir, baseFilePath);

                // Return the original filePath if the file does not exist.
                if (!fs.existsSync(absolutePath)) {
                    return filePath;
                }

                const fileBuffer = fs.readFileSync(absolutePath);
                const hash = crypto
                    .createHash('md5')
                    .update(fileBuffer)
                    .digest('hex')
                    .slice(0, 8);

                return `${baseFilePath}?v=${hash}`;
            };

            // Process each manifest entry to append a version query hash.
            Object.entries(manifest).forEach(([key, value]) => {
                if (value.file) {
                    value.file = appendHash(value.file);
                }

                if (Array.isArray(value.css)) {
                    value.css = value.css.map(appendHash);
                }
            });

            // Write the updated manifest back to disk.
            fs.writeFileSync(manifestFile, JSON.stringify(manifest, null, 2));
        },
    };
}

export default defineConfig(() => {
    return {
        plugins: [
            viteRtlCssPlugin(),
            manifestSRI(),
            addQueryHashToManifest(),
        ],
        build: {
            outDir: 'public',
            emptyOutDir: false,
            manifest: 'manifest.json',
            rollupOptions: {
                input: [
                    'resources/js/app.js',
                    'resources/sass/app.scss',
                ],
                output: {
                    assetFileNames: 'assets/[name].[ext]',
                    chunkFileNames: 'assets/[name].js',
                    entryFileNames: 'assets/[name].js',
                },
            },
        },
        resolve: {
            root: resolve(__dirname, './'),
        },
    };
});

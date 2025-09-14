import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
    const paths = [
        'resources/css/app.css',
        'resources/css/tailwind.css',
        'resources/js/app.js',
    ];
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            }),
            tailwindcss(),
            vue(),
        ],
        resolve: {
            alias: {
                'vue': 'vue/dist/vue.esm-bundler.js'
            }
        }
    });
}

export default getConfig();

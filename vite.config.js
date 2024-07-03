import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import path from 'path';
import collectModuleAssetsPaths from './vite-module-loader.js';

// import react from '@vitejs/plugin-react';
import vue from '@vitejs/plugin-vue';


async function getConfig() {
    const topPaths = [
        'resources/js/app.js',
        'resources/css/app.css',
    ];

    //const allPaths = await collectModuleAssetsPaths(topPaths, 'Modules');

    console.log(topPaths);

    return defineConfig({
        build : {
            outDir: './public/assets/build/',
            emptyOutDir: true,
            manifest: true,
        },
        
        resolve: {
            alias: {
                "@mingle": path.resolve("/app/vendor/ijpatricio/mingle/resources/js"),
            },
        },
        plugins: [
            laravel({
                input: topPaths,
                refresh: true,
            }),
            
            // react(),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
        ],
        host: "0.0.0.0"
    });
}

export default getConfig();
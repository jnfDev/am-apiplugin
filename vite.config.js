import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import * as dotenv from 'dotenv'

dotenv.config()

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    source: ['src'],
                    use: ['xlink:href', 'href']
                }
            }
        }),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url)),
            'vue': 'vue/dist/vue.esm-bundler.js',
        }
    },
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
            input: [
                'src/main.js',
            ],
            output: {
                chunkFileNames: '[name].js',
                entryFileNames: '[name].js',
                assetFileNames: ({ name }) => {
                    if (/\.css$/.test(name ?? '')) {
                        return '[name][extname]';
                    }

                    return '[name][extname]';
                },
            }
        },
    },
    server: {
        port: process.env.AM_DEV_PORT,
        strictPort: true,
        hmr: {
            port: process.env.AM_DEV_PORT,
            host: 'localhost',
            protocol: 'ws',
        }
    }
})

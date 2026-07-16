import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { VitePWA } from 'vite-plugin-pwa';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    resolve: {
        alias: {
            vue: resolve(__dirname, 'node_modules/vue/dist/vue.esm-bundler.js'),
        },
    },
    server: {
        host: '0.0.0.0',
        hmr: {
            host: '10.82.1.134'
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/nhanvien.css',
                'resources/js/nhanvien.js',
                'resources/js/bang-thongbao.js',
                'resources/css/bang-thongbao.css',
                'resources/js/home.js',
                'resources/css/home.css',
                'resources/css/login.css'
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'auto',

            devOptions: {
                enabled: true
            },

            manifest: {
                name: 'Hệ thống xếp hàng sinh viên',
                short_name: 'Queue System',
                start_url: '/',
                scope: '/',
                display: 'standalone',
                background_color: '#ffffff',
                theme_color: '#0d6efd',
                icons: [
                    {
                        src: '/icon-192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/icon-512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            },

            workbox: {
                navigateFallback: null
            }
        })
    ],
    define: {
        __VUE_OPTIONS_API__: true,
        __VUE_PROD_DEVTOOLS__: false,
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
    },

});
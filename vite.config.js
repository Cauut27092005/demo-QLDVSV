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
            host: '192.168.1.101'
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
                'resources/css/home.css'
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
            manifest: {
                name: 'Hệ thống xếp hàng sinh viên',
                short_name: 'Queue System',
                theme_color: '#0d6efd',
                background_color: '#ffffff',
                display: 'standalone',
                start_url: '/',
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
            }
        })
    ],

    define: {
        __VUE_OPTIONS_API__: true,
        __VUE_PROD_DEVTOOLS__: false,
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
    },


});
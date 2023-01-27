import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/fullcalendar.js',
                'resources/js/flowbite.js',
                'resources/js/apexcharts.js',
            ],
            refresh: [
                'resources/routes/**',
                'routes/**',
                'resources/views/**',
                'resources/views/**/**',
            ],
        }),
    ],
});

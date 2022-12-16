import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/app.css',
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

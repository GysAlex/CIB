import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: 
            [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/js/pages/home.js',
                'resources/css/pages/home.css',
                'resources/js/pages/project.js',
                'resources/css/pages/project.css',
                'resources/js/pages/contact.js',
                'resources/css/pages/contact.css',
                'resources/css/filament/employee/theme.css'
            ],
            refresh: true,
        }),
        tailwindcss()
    ],
});

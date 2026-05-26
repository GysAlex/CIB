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
                    'resources/js/pages/blog.js',
                    'resources/css/pages/blog.css',
                    'resources/css/pages/blog-show.css',
                    'resources/js/pages/blog-show.js',

                    'resources/css/pages/formation-show.css',
                    'resources/js/pages/formation-show.js',

                    'resources/css/pages/formation.css',
                    'resources/js/pages/formation.js',
                    
                    'resources/css/filament/employee/theme.css',
                    'resources/css/filament/admin/theme.css',
                    'resources/css/filament/client/theme.css'
                ],
            refresh: true,
        }),
        tailwindcss()
    ],
});

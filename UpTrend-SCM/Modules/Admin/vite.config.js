import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                     'resources/js/app.js', 
                     'resources/css/signin.css', 
                     'resources/css/style.css', 
                     'resources/css/dashboard.css'],
            refresh: true,
        }),
    ],
});

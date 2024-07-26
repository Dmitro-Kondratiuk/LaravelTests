import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                'resources/js/user/user.js',
                'resources/js/user/addUser.js',
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
});

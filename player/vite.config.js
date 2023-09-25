import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        // laravel({
        //     input: ['resources/css/app.css', 'resources/js/app.js'],
        //     refresh: true,
        // }),
        laravel([
            'resources/css/lightTheme.css',
            'resources/css/darkTheme.css',
            'resources/css/plyrDarkTheme.css',
            'resources/css/plyrLightTheme.css',
            'resources/js/app.js',
        ])
    ],
});

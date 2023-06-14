import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';


export default defineConfig(({command, mode}) => {
    return {
        plugins: [
            laravel(['resources/js/app.jsx']),
            react(),
        ],
        mode: command === 'build' ? 'production' : 'development',

    }
});

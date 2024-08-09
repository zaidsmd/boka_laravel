import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const boostrap = [

]
const css = [
    'resources/css/app.scss'
]
const js = [
    'resources/js/app.js',
]

export default defineConfig({
    plugins: [
        laravel({
            input: [...boostrap,...css,...js],
            refresh: true,
        }),
    ],
});
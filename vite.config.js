import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss', 
                'resources/js/app.js',
                'resources/js/layout.js',
                'resources/js/profile/load-paginate.js',
                'resources/js/cart/remove-product.js',
                'resources/js/cart/quantitySetter.js',
                'resources/js/cart/checkout-cart.js',
                'resources/js/two-factor/two-factor-challenge.js',
                'resources/js/two-factor/two-factor-code.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources',
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});

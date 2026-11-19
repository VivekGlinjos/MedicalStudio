import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Barlow', ...defaultTheme.fontFamily.sans],
                display: ['Bebas Neue', 'Impact', ...defaultTheme.fontFamily.sans],
                heading: ['Barlow', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                teal: '#0D9488',
            },
            animation: {
                fadeUp: 'fadeUp 0.8s cubic-bezier(0.16,1,0.3,1) both',
                slideDown: 'slideDown 0.35s cubic-bezier(0.16,1,0.3,1) both',
                scaleIn: 'scaleIn 0.4s cubic-bezier(0.16,1,0.3,1) both',
            },
            keyframes: {
                fadeUp: {
                    'from': { opacity: '0', transform: 'translateY(20px)' },
                    'to': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    'from': { opacity: '0', transform: 'translateY(-20px)' },
                    'to': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    'from': { opacity: '0', transform: 'scale(0.95)' },
                    'to': { opacity: '1', transform: 'scale(1)' },
                },
            },
        },
    },

    plugins: [forms],
};

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
        './resources/views/recruitment/admin/**/*.blade.php', 
        './resources/views/recruitment/candidate/**/*.blade.php', 
        './resources/js/**/*.js',
        './resources/js/admin/**/*.js',
        './resources/js/college/**/*.js',
        './resources/js/candidate/**/*.js',
        './resources/css/**/*.css',
        './resources/css/admin/**/*.css',
        './resources/css/college/**/*.css',
        './resources/css/candidate/**/*.css',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#fdf2f8',
                    100: '#fce7f3',
                    500: '#ec4899',
                    600: '#db2777',
                    900: '#831843',
                },
                neutral: {
                    50: '#f9fafb',   // Subtle background
                    100: '#f3f4f6',  // Light gray accents
                    800: '#1f2937'   // Dark text
                }
            },
            boxShadow: {
                'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'
            },
            transitionProperty: {
                'colors': 'background-color, border-color, color, fill, stroke'
            }
        },
    },

    plugins: [forms],
};

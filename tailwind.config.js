import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js'

    ],

    purge: {
      options: {
        safelist: {
          standard: [
              'text-2xl',
              'text-3xl',
              'text-4xl',
              'text-5xl',
              'text-6xl',
              'sm:text-2xl',
              'sm:text-3xl',
              'sm:text-4xl',
              'sm:text-5xl',
              'sm:text-6xl',
              'md:text-2xl',
              'md:text-3xl',
              'md:text-4xl',
              'md:text-5xl',
              'md:text-6xl',
              'lg:text-2xl',
              'lg:text-3xl',
              'lg:text-4xl',
              'lg:text-5xl',
              'lg:text-6xl',
          ],
        },
      },
    },
    theme: {
    screens: {
      'sm': '640px',
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
    },
    colors: {
      primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
    },
    extend: {
      fontFamily: {
        'body': [
          'Inter', 
          'ui-sans-serif', 
          'system-ui', 
          '-apple-system', 
          'system-ui', 
          'Segoe UI', 
          'Roboto', 
          'Helvetica Neue', 
          'Arial', 
          'Noto Sans', 
          'sans-serif', 
          'Apple Color Emoji', 
          'Segoe UI Emoji', 
          'Segoe UI Symbol',
          'Noto Color Emoji'
        ],
        'sans': [
            'Inter', 
            'ui-sans-serif', 
            'system-ui', 
            '-apple-system', 
            'system-ui', 
            'Segoe UI', 
            'Roboto', 
            'Helvetica Neue', 
            'Arial', 
            'Noto Sans', 
            'sans-serif', 
            'Apple Color Emoji', 
            'Segoe UI Emoji', 
            'Segoe UI Symbol', 
            'Noto Color Emoji'
        ]
      },
      spacing: {
        px: '1px',
        0: '0',
        0.5: '0.125rem',
        1: '0.25rem',
        1.5: '0.375rem',
        2: '0.5rem',
        2.5: '0.625rem',
        3: '0.75rem',
        3.5: '0.875rem',
        4: '1rem',
        5: '1.25rem',
        6: '1.5rem',
        7: '1.75rem',
        8: '2rem',
        9: '2.25rem',
        10: '2.5rem',
        11: '2.75rem',
        12: '3rem',
        14: '3.5rem',
        16: '4rem',
        20: '5rem',
        24: '6rem',
        28: '7rem',
        32: '8rem',
        36: '9rem',
        40: '10rem',
        44: '11rem',
        48: '12rem',
        52: '13rem',
        56: '14rem',
        60: '15rem',
        64: '16rem',
        72: '18rem',
        80: '20rem',
        96: '24rem',
      },
    }
  },

    plugins: [

      require('flowbite/plugin')

    ],

};

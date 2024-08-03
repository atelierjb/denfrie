const theme = require('./theme.json');
const tailpress = require("@jeffreyvr/tailwindcss-tailpress");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './*.php',
        './**/*.php',
        './resources/css/*.css',
        './resources/js/*.js',
        './safelist.txt'
    ],
    theme: {
        container: {
            padding: {
                DEFAULT: '0rem',
                sm: '0rem',
                lg: '0rem'
            },
        },
        extend: {
            colors: tailpress.colorMapper(tailpress.theme('settings.color.palette', theme)),
            fontSize: tailpress.fontSizeMapper(tailpress.theme('settings.typography.fontSizes', theme)),
            fontFamily: {
                dfserif: ['DenFrie2024 Serif', 'serif'],
                superclarendon: ['superclarendon', 'serif'],
            },
            lineHeight: {
                xsmall: [],
                small: [],
                regular: ['calc(125% + 0.25vw)'],
                medium: ['calc(110% + 0.25vw)'],
                large: ['calc(115% + 0.25vw)'],
                xl: ['calc(115% + 0.25vw)'],
                xxl: ['calc(115% + 0.25vw)'],
            }
        },
        screens: {
            'xs': '480px',
            'sm': '600px',
            'md': '782px',
            'lg': tailpress.theme('settings.layout.contentSize', theme),
            'xl': tailpress.theme('settings.layout.wideSize', theme),
            '2xl': '1440px'
        }
    },
    plugins: [
        tailpress.tailwind,
        require('daisyui')
    ],
    daisyui: {
        themes: [],
    },
};

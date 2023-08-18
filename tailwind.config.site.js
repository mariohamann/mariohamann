//--------------------------------------------------------------------------
// Tailwind site configuration
//--------------------------------------------------------------------------
//
// Use this file to completely define the current sites design system by
// adding and extending to Tailwinds default utility classes.
//

const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')

module.exports = {
    presets: [],
    theme: {
        // Here we define the default colors available. If you want to include
        // all default Tailwind colors you should extend the colors instead.
        // https://uicolors.app/edit?sv1=soft-amber:50-f9f8f7/100-f3efed/200-eae2de/300-d1c1b8/400-c4b0a5/500-ad9486/600-967b6c/700-7c6659/800-68564c/900-594b43/950-2e2621;mako:50-f5f6f6/100-e4e7e9/200-ccd1d5/300-a9b1b7/400-7e8992/500-636e77/600-555d65/700-454b51/800-40444a/900-393c40/950-232529;secondary:50-fff0f1/100-ffe2e6/200-ffcad2/300-ff9fae/400-ff6983/500-ff2752/600-ed1147/700-c8083c/800-a80939/900-8f0c38/950-500119;primary:50-eaf9ff/100-d1f1ff/200-ade7ff/300-75dbff/400-35c3ff/500-06a0ff/600-007aff/700-0061ff/800-004fd8/900-0048a8/950-052657
        colors: {
            black: '#000',
            white: 'oklch(97.96% 0.00 67.80 / <alpha-value>)',
            'neutral-warm': {
                '50': 'oklch(97.96% 0.00 67.80 / <alpha-value>)',
                '100': 'oklch(95.47% 0.01 48.69 / <alpha-value>)',
                '200': 'oklch(91.80% 0.01 48.61 / <alpha-value>)',
                '300': 'oklch(82.17% 0.02 51.47 / <alpha-value>)',
                '400': 'oklch(77.12% 0.03 50.77 / <alpha-value>)',
                '500': 'oklch(68.51% 0.04 51.04 / <alpha-value>)',
                '600': 'oklch(60.43% 0.04 50.67 / <alpha-value>)',
                '700': 'oklch(52.80% 0.03 52.28 / <alpha-value>)',
                '800': 'oklch(46.82% 0.03 50.73 / <alpha-value>)',
                '900': 'oklch(42.45% 0.02 51.55 / <alpha-value>)',
                '950': 'oklch(27.59% 0.02 53.92 / <alpha-value>)',
            },
            // Neutrals: neutral colors, with a default fallback if you don't need shades. Always set a DEFAULT when you use shades.
            neutral: {
                '50': 'oklch(97.24% 0.00 197.14 / <alpha-value>)',
                '100': 'oklch(92.62% 0.00 236.50 / <alpha-value>)',
                '200': 'oklch(85.80% 0.01 241.68 / <alpha-value>)',
                '300': 'oklch(75.59% 0.01 239.97 / <alpha-value>)',
                '400': 'oklch(62.41% 0.02 242.59 / <alpha-value>)',
                '500': 'oklch(53.21% 0.02 242.68 / <alpha-value>)',
                '600': 'oklch(47.42% 0.02 248.17 / <alpha-value>)',
                '700': 'oklch(40.96% 0.01 248.14 / <alpha-value>)',
                '800': 'oklch(38.52% 0.01 258.37 / <alpha-value>)',
                '900': 'oklch(35.48% 0.01 255.55 / <alpha-value>)',
                '950': 'oklch(26.41% 0.01 264.43 / <alpha-value>)',
                DEFAULT: 'oklch(40.96% 0.01 248.14 / <alpha-value>)',
            },
            // Primary: primary brand color with a default fallback if you don't need shades. Always set a DEFAULT when you use shades.
            'secondary': {
                '50': 'oklch(97.28% 0.02 223.59 / <alpha-value>)',
                '100': 'oklch(93.94% 0.04 226.02 / <alpha-value>)',
                '200': 'oklch(89.64% 0.07 225.36 / <alpha-value>)',
                '300': 'oklch(84.31% 0.11 223.43 / <alpha-value>)',
                '400': 'oklch(76.99% 0.14 231.85 / <alpha-value>)',
                '500': 'oklch(68.50% 0.18 246.39 / <alpha-value>)',
                '600': 'oklch(60.28% 0.22 257.42 / <alpha-value>)',
                '700': 'oklch(55.42% 0.25 261.44 / <alpha-value>)',
                '800': 'oklch(48.54% 0.22 261.70 / <alpha-value>)',
                '900': 'oklch(42.79% 0.17 259.12 / <alpha-value>)',
                '950': 'oklch(27.94% 0.10 258.83 / <alpha-value>)',
                DEFAULT: 'oklch(27.94% 0.10 258.83 / <alpha-value>)' // 950
            },
            'primary': {
                '50': 'oklch(96.72% 0.02 12.78 / <alpha-value>)',
                '100': 'oklch(93.76% 0.03 8.27 / <alpha-value>)',
                '200': 'oklch(88.76% 0.06 8.24 / <alpha-value>)',
                '300': 'oklch(80.34% 0.12 9.85 / <alpha-value>)',
                '400': 'oklch(71.41% 0.18 12.44 / <alpha-value>)',
                '500': 'oklch(64.60% 0.24 18.18 / <alpha-value>)',
                '600': 'oklch(60.34% 0.24 18.22 / <alpha-value>)',
                '700': 'oklch(53.02% 0.21 17.48 / <alpha-value>)',
                '800': 'oklch(46.85% 0.18 14.39 / <alpha-value>)',
                '900': 'oklch(42.05% 0.16 10.40 / <alpha-value>)',
                '950': 'oklch(27.60% 0.11 12.14 / <alpha-value>)',
                DEFAULT: 'oklch(64.60% 0.24 18.18 / <alpha-value>)' // 500
            },

        },
        extend: {
            // Set default transition durations and easing when using the transition utilities.
            transitionDuration: {
                DEFAULT: '300ms',
            },
            transitionTimingFunction: {
                DEFAULT: 'cubic-bezier(0.4, 0, 0.2, 1)',
            },
        },
        // Remove the font families you don't want to use.
        fontFamily: {
            mono: [
                // Use a custom mono font for this site by changing 'Anonymous' to the
                // font name you want and uncommenting the following line.
                'Martian Mono',
                ...defaultTheme.fontFamily.mono,
            ],
            sans: [
                // Use a custom sans serif font for this site by changing 'Gaultier' to the
                // font name you want and uncommenting the following line.
                'B612',
                ...defaultTheme.fontFamily.sans,
            ],
            serif: [
                // Use a custom serif font for this site by changing 'Lavigne' to the
                // font name you want and uncommenting the following line.
                // 'Lavigne',
                ...defaultTheme.fontFamily.serif,
            ],
        },
        // The font weights available for this site.
        fontWeight: {
            // hairline: 100,
            // thin: 200,
            // light: 300,
            normal: 400,
            // medium: 500,
            // semibold: 600,
            bold: 700,
            // extrabold: 800,
            // black: 900,
        },
    },
    plugins: [
        plugin(function ({ addBase, theme }) {
            addBase({
                // Default color transition on links unless user prefers reduced motion.
                '@media (prefers-reduced-motion: no-preference)': {
                    'a': {
                        transition: 'color .3s ease-in-out',
                    },
                },
                'html': {
                    color: theme('colors.neutral.DEFAULT'),
                    //--------------------------------------------------------------------------
                    // Set sans, serif or mono stack with optional custom font as default.
                    //--------------------------------------------------------------------------
                    // fontFamily: theme('fontFamily.mono'),
                    fontFamily: theme('fontFamily.sans'),
                    // fontFamily: theme('fontFamily.serif'),
                },
                'mark': {
                    backgroundColor: theme('colors.primary.DEFAULT'),
                    color: theme('colors.white')
                },
            })
        }),

        // Custom components for this particular site.
        plugin(function ({ addComponents, theme }) {
            const components = {
            }
            addComponents(components)
        }),

        // Custom utilities for this particular site.
        plugin(function ({ addUtilities, theme, variants }) {
            const newUtilities = {
            }
            addUtilities(newUtilities)
        }),
    ]
}

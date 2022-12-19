const mix = require("laravel-mix");
require("laravel-mix-bundle-analyzer");
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

if (!mix.inProduction() && !mix.isWatching()) {
    mix.bundleAnalyzer({
        analyzerMode: "static",
    });
}

mix.js("resources/js/app.js", "public/js")
    .js("resources/js/timetable.js", "public/js")
    .js("resources/js/helpers.js", "public/js")
    .react()
    .sass("resources/sass/app.scss", "public/css");

// Remove these module once Axios drops them.
mix.webpackConfig({
    resolve: {
        fallback: {
            https: require.resolve("https-browserify"),
            stream: require.resolve("stream-browserify"),
            http: require.resolve("stream-http"),
            zlib: require.resolve("browserify-zlib"),
        },
    },
});

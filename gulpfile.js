const { src, dest, watch, parallel, series } = require('gulp');

// CSS
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');

// Imagenes
const newer = require('gulp-newer');
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const avif = require('gulp-avif');

// Javascript
const terser = require('gulp-terser');
const rename = require('gulp-rename');
const rollup = require('gulp-rollup');


const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'src/img/**/*'
}
function css() {
    const plugins = [autoprefixer()];
    if (process.env.NODE_ENV === 'production') {
        plugins.push(cssnano());
    }

    return src(paths.scss)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(postcss(plugins))
        .pipe( sourcemaps.write('.'))
        .pipe(  dest('public/build/css') );
}

function javascript() {
    return src(paths.js)
      .pipe(sourcemaps.init({ loadMaps: true }))
      .pipe(rollup({
        input: 'src/js/app.js', // tu archivo principal
        output: {
            format: 'iife', // para navegador
            name: 'App',
            sourcemap: true, // activa los sourcemaps
            globals: {
                'sortablejs': 'Sortable',
            },
        },
        external: ['sortablejs'],
        allowRealFiles: true // necesario con gulp-rollup
      }))
      .pipe(terser({
        ecma: 2020, // Soporte para optional chaining
        compress: true,
        mangle: true
      }))
      .pipe(rename({ 
        basename: 'bundle', 
        suffix: '.min' 
      }))
      .pipe(sourcemaps.write('.'))
      .pipe(dest('./public/build/js'))
}

function imagenes() {
    return src(paths.imagenes)
        .pipe( newer('public/build/img'))
        .pipe((imagemin({ optimizationLevel: 3})))
        .pipe( dest('public/build/img'))
}

function versionWebp( done ) {
    src('src/img/**/*.{png,jpg}')
        .pipe(webp({ quality: 50 }))
        .pipe(dest('public/build/img'));
    done();
}

function versionAvif( done ) {
    src('src/img/**/*.{png,jpg}')
        .pipe(avif({ quality: 50 }))
        .pipe(dest('public/build/img'));
    done();
}

const procesarImagenes = parallel(imagenes, versionWebp, versionAvif);

function dev(done) {
    watch( paths.scss, css );
    watch( paths.js, javascript );
    watch(paths.imagenes, procesarImagenes);
    done()
}

exports.css = css;
exports.js = javascript;
exports.imagenes = imagenes;
exports.versionWebp = versionWebp;
exports.versionAvif = versionAvif;
exports.build = parallel(css, javascript, procesarImagenes);
exports.dev = series(exports.build, dev);
const elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');
var minify = require('gulp-minifier');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');
var mainBowerFiles = require('gulp-main-bower-files');
var uglify = require('gulp-uglify');
var flatten = require('gulp-flatten');
var watch = require('gulp-watch');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir(mix => {
    mix.sass('app.scss')
        .webpack('app.js');
    mix.copy('resources/assets/theme', 'public/assets/theme');
    mix.copy('Modules/Core/Assets', 'public/assets/core');
    mix.copy('Modules/PhSeller/Assets/pages', 'public/assets/seller/pages');
});
//----------------------------------------------
gulp.task('build', ['bowerjs', 'bowercss', 'sellercss', 'sellerjs', 'sellerjspages']);
//----------------------------------------------
gulp.task('bowercss', function () {
    return gulp.src('./bower.json')
        .pipe(mainBowerFiles('**/*.css'))
        .pipe(minifyCSS())
        .pipe(concat('bower.css'))
        .pipe(gulp.dest('./public/assets/bower'));
});
//----------------------------------------------
gulp.task('bowerjs', function () {
    return gulp.src('./bower.json')
        .pipe(mainBowerFiles('**/*.js'))
        //.pipe(uglify())
        .pipe(concat('bower.js'))
        .pipe(gulp.dest('./public/assets/bower'));
});
//----------------------------------------------
gulp.task('sellercss', function () {
    return gulp.src('Modules/PhSeller/Assets/vendors/**/*.css')
        .pipe(minifyCSS())
        .pipe(concat('seller.css'))
        .pipe(gulp.dest('./public/assets/seller'));
});
//----------------------------------------------
gulp.task('sellerjs', function () {
    return gulp.src('Modules/PhSeller/Assets/vendors/**/*.js')
        //.pipe(uglify())
        .pipe(concat('seller.js'))
        .pipe(gulp.dest('./public/assets/seller'));
});
//----------------------------------------------
gulp.task('sellerjspages', function () {
    return gulp.src('Modules/PhSeller/Assets/pages/**/*.js')

        .pipe(gulp.dest('./public/assets/seller/pages'));
});
//----------------------------------------------
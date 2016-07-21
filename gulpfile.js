/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Jon Torrado <jtorrado@lin3s.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */

'use strict';

var
  gulp = require('gulp'),
  autoprefixer = require('gulp-autoprefixer'),
  concat = require('gulp-concat'),
  cssNano = require('gulp-cssnano'),
  eslint = require('gulp-eslint'),
  livereload = require('gulp-livereload'),
  modernizr = require('gulp-modernizr'),
  rename = require('gulp-rename'),
  sass = require('gulp-sass'),
  scsslint = require('gulp-scss-lint'),
  sourcemaps = require('gulp-sourcemaps'),
  svgSprite = require('gulp-svg-sprite'),
  uglify = require('gulp-uglify');

var folders = {
  assets: './src/LIN3S/AdminBundle/Resources/private',
  web: './src/LIN3S/AdminBundle/Resources/public'
};

var paths = {
  npm: './node_modules',
  sass: folders.assets + '/scss',
  js: folders.assets + '/js',
  svg: folders.assets + '/svg',
  buildCss: folders.web + '/css',
  buildJs: folders.web + '/js',
  buildSvg: folders.web + '/svg'
};

var watch = {
  js: paths.js + '/**/*.js',
  sass: paths.sass + '/**/*.scss',
  svg: paths.svg + '/**/*.svg'
};

gulp.task('sass', [], function () {
  return gulp.src(paths.sass + '/app.scss')
    .pipe(sass({
      errLogToConsole: true
    }))
    .pipe(autoprefixer())
    .pipe(gulp.dest(paths.buildCss))
    .pipe(livereload());
});

gulp.task('scss-lint', function () {
  return gulp.src([
    watch.sass,
    '!' + paths.sass + '/base/_reset.scss',
    '!' + paths.sass + '/base/_grid.scss'
  ])
    .pipe(scsslint({
      'config': './.scss_lint.yml'
    }));
});

gulp.task('eslint', function () {
  return gulp.src(watch.js)
    .pipe(eslint({
      'config': './.eslint.yml'
    }))
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
});

gulp.task('sass:prod', function () {
  return gulp.src(paths.sass + '/app.scss')
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(cssNano({
      keepSpecialComments: 1,
      rebase: false
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(paths.buildCss));
});

gulp.task('sprites', function () {
  return gulp.src(paths.svg + '/*.svg')
    .pipe(svgSprite({
      mode: {
        symbol: {
          dest: '',
          sprite: 'symbols',
          example: {dest: 'symbols'}
        }
      }
    }))
    .pipe(gulp.dest(paths.buildSvg));
});

gulp.task('js', [], function () {
  return gulp.src([paths.js + '/*.js'])
    .pipe(gulp.dest(paths.buildJs));
});

gulp.task('modernizr', function () {
  return gulp.src([paths.js + '/*.js'])
    .pipe(modernizr({
      'options': [
        'setClasses', 'addTest', 'html5printshiv', 'testProp', 'fnBind'
      ],
      'tests': ['objectfit', 'flexbox', 'touchevents']
    }))
    .pipe(uglify())
    .pipe(gulp.dest(paths.buildJs))
});

gulp.task('vendor-css', function () {
});

gulp.task('vendor-js', function () {
  return gulp.src([
    paths.npm + '/jquery/dist/jquery.js',
    paths.npm + '/fastclick/lib/fastclick.js',
    paths.npm + '/svg4everybody/dist/svg4everybody.js'
  ])
    .pipe(concat('vendor.js'))
    .pipe(uglify())
    .pipe(gulp.dest(paths.buildJs));
});

gulp.task('js:prod', function () {
  return gulp.src([paths.js + '/*.js'])
    .pipe(sourcemaps.init())
    .pipe(concat('app.min.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.buildJs));
});

gulp.task('watch', function () {
  livereload.listen();
  gulp.watch(watch.js, ['js']);
  gulp.watch(watch.sass, ['sass']);
  gulp.watch(watch.svg, ['sprites']);
});

gulp.task('default', ['sass', 'sprites', 'js', 'vendor-js', 'vendor-css', 'modernizr', 'prod']);

gulp.task('prod', ['sass:prod', 'js:prod', 'sprites', 'vendor-js', 'vendor-css', 'modernizr']);

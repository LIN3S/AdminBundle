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

import babel from 'gulp-babel';
import babelify from 'babelify';
import browserify from 'browserify';
import buffer from 'vinyl-buffer';
import cssnext from 'postcss-cssnext';
import cssnano from 'gulp-cssnano';
import gulp from 'gulp';
import file from 'gulp-file';
import fs from 'fs';
import livereload from 'gulp-livereload';
import modernizr from 'gulp-modernizr';
import plumber from 'gulp-plumber';
import postcss from 'gulp-postcss';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import source from 'vinyl-source-stream';
import sourcemaps from 'gulp-sourcemaps';
import scsslint from 'gulp-scss-lint';
import svgSprite from 'gulp-svg-sprite';
import uglify from 'gulp-uglify';

const
  folders = {
    assets: './src/LIN3S/AdminBundle/Resources/private',
    web: './src/LIN3S/AdminBundle/Resources/public'
  },
  paths = {
    npm: './node_modules',
    sass: folders.assets + '/scss',
    js: folders.assets + '/js/src',
    svg: folders.assets + '/svg',
    css: folders.web + '/css',
    libJs: folders.assets + '/js/lib',
    distJs: folders.web + '/js',
    buildSvg: folders.web + '/svg'
  },
  watch = {
    js: paths.js + '/**/*.js',
    sass: paths.sass + '/**/*.scss',
    svg: paths.svg + '/**/*.svg'
  },
  plumberOnError = function (err) {
    console.log(err);
    this.emit('end');
  };

gulp.task('scss-lint', () => {
  gulp.src([
    `${paths.sass}/**/*.scss`,
    `!${paths.sass}/base/_reset.scss`,
    `!${paths.sass}/helpers/_grid.scss`,
    `!${paths.sass}/components/_popup.scss`
  ])
    .pipe(plumber({
      errorHandler: plumberOnError
    }))
    .pipe(scsslint({
      'config': '.scss_lint.yml'
    }));
});

gulp.task('magnificPopup', () => {
  const
    header = '// This file is part of the Admin Bundle.\n' +
      '//\n' +
      '// Copyright (c) 2015-2016 LIN3S <info@lin3s.com>\n' +
      '//\n' +
      '// For the full copyright and license information, please view the LICENSE\n' +
      '// file that was distributed with this source code.\n' +
      '//\n' +
      '// @author Beñat Espiña <benatespina@gmail.com>\n' +
      '\n',
    settingsContent = fs.readFileSync('./node_modules/magnific-popup/src/css/_settings.scss', 'utf8'),
    mainContent = fs.readFileSync('./node_modules/magnific-popup/src/css/main.scss', 'utf8'),
    content = settingsContent.concat(mainContent),
    finalContent = header.concat(content);

  return file(
    '_popup.scss',
    finalContent.replace('@import "settings";', ''),
    {src: true}).pipe(gulp.dest(`${paths.sass}/components`)
  );
});

gulp.task('sass', ['scss-lint'], () => {
  gulp.src(`${paths.sass}/app.scss`)
    .pipe(plumber({
      errorHandler: plumberOnError
    }))
    .pipe(sass({
      errLogToConsole: true
    }))
    .pipe(postcss([cssnext]))
    .pipe(cssnano({
      keepSpecialComments: 1,
      rebase: false
    }))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(paths.css))
    .pipe(livereload());
});

gulp.task('modernizr', () => {
  return gulp.src([`${paths.js}/*.js`])
    .pipe(plumber({
      errorHandler: plumberOnError
    }))
    .pipe(modernizr({
      'options': [
        'setClasses', 'addTest', 'html5printshiv', 'testProp', 'fnBind'
      ],
      'tests': ['objectfit', 'flexbox', 'touchevents']
    }))
    .pipe(uglify())
    .pipe(gulp.dest(paths.distJs))
});

gulp.task('sprites', () => {
  return gulp.src(`${paths.svg}/*.svg`)
    .pipe(plumber({
      errorHandler: plumberOnError
    }))
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

gulp.task('js:lib', () => {
  return gulp.src(`${paths.js}/**/*.js`)
    .pipe(babel({
      presets: ['es2015', 'react', 'stage-2'],
      plugins: ['transform-class-properties'],
    }))
    .pipe(plumber({
      errorHandler: plumberOnError
    }))
    .pipe(gulp.dest(paths.libJs));
});

gulp.task('js:dist', () => {
  return browserify(`${paths.js}/app.js`)
    .transform('babelify', {
      presets: ['es2015', 'react', 'stage-2'],
      plugins: ['transform-class-properties'],
      comments: false
    })
    .bundle()
    .pipe(source('app.min.js'))
    .pipe(plumber({
      errorHandler: plumberOnError
    }))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.distJs));
});

gulp.task('watch', () => {
  livereload.listen();
  gulp.watch(watch.js, ['js:dist', 'js:lib']);
  gulp.watch(watch.sass, ['sass']);
  gulp.watch(watch.svg, ['sprites']);
});

gulp.task('js', ['js:dist', 'js:lib']);

gulp.task('default', ['sass', 'sprites', 'js', 'modernizr']);

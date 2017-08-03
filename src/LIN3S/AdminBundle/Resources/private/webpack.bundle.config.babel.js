/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Mikel Tuesta <mikeltuesta@gmail.com>
 */

import autoprefixer from 'autoprefixer';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import ModernizrWebpackPlugin from 'modernizr-webpack-plugin';
import {join, resolve} from 'path';
import StyleLintPlugin from 'stylelint-webpack-plugin';
import precss from 'precss';
import Webpack from 'webpack';

const
  include = join(__dirname, 'js'),
  outputPath = join(__dirname, './../public/');

export default {
  entry: `${include}/bundle.js`,
  output: {
    path: `${outputPath}/js`,
    publicPath: '/',
    filename: 'bundle.min.js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        include: include,
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader'
          },
          {
            loader: 'eslint-loader',
            options: {
              enforce: 'pre'
            }
          }
        ]
      },
      {
        test: /\.(s?css)$/,
        use: ExtractTextPlugin.extract({
          publicPath: '/',
          fallback: 'style-loader',
          use: ['css-loader', 'postcss-loader', 'sass-loader']
        })
      }
    ]
  },
  plugins: [
    new StyleLintPlugin({
      configFile: '.stylelintrc.js',
      sintax: 'scss',
      quiet: false
    }),
    new ExtractTextPlugin('./../css/bundle.min.css'),
    new Webpack.LoaderOptionsPlugin({
      options: {
        postcss: [
          autoprefixer({
            browsers: ['last 2 versions']
          }),
          precss
        ],
        eslint: {
          configFile: join(__dirname, '.eslintrc.js')
        }
      }
    }),
    new ModernizrWebpackPlugin({
      minify: true,
      filename: 'modernizr.js',
      options: [ 'setClasses', 'addTest', 'html5printshiv', 'testProp', 'fnBind' ],
      'feature-detects': [ 'css/flexbox', 'css/objectfit', 'touchevents' ]
    })
  ],
  devtool: 'source-map'
};

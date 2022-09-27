/* eslint-disable @typescript-eslint/no-var-requires */
const webpack = require('webpack');
const path = require('path');
const glob = require('glob');

const isDev = process.env.NODE_ENV !== 'production';
module.exports = {
  mode: process.env.NODE_ENV,
  entry: toObject(glob.sync('./Resources/**/TypeScript/*.ts')),

  module: {
    rules: [
      {
        test: /\.tsx?$/,
        use: 'ts-loader',
        exclude: /node_modules/,
      },
    ],
  },

  externals: {
    bootstrap: true,
  },

  output: {
    path: path.resolve(__dirname, './'),
    filename: '[name].js',
  },

  optimization: {
    minimize: isDev ? false : true,
  },

  resolve: {
    extensions: ['.tsx', '.ts', '.js'],
  },
};

function toObject(paths) {
  var ret = {};
  paths.forEach(function (filePath) {
    ret[filePath.replace('.ts', '').replace('Private/TypeScript', 'Public/JavaScript')] = filePath;
  });

  return ret;
}

const path = require('path')

const config = {
  mode: 'development',

  entry: './src/vtree.js',

  output: {
    path: path.join(__dirname, 'dist'),
    filename: 'vtree.js',
    library: 'VTree'
  },

  module: {
    rules: [
    {
      enforce: 'pre',
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'eslint-loader'
    },
    {
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'babel-loader',
      query: {
        presets: ['es2015']
      }
    }
    ]
  }
}

module.exports = config

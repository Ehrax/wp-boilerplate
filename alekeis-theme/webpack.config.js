const path = require('path')

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const AssetsPlugin = require('assets-webpack-plugin');

const DEV = process.env.NODE_ENV === 'development'

module.exports = {
    entry: './src/js/index.js',
    output: {
      path: path.join(__dirname, 'dist'),
      filename: DEV ? 'bundle.js' : 'bundle.[hash:8].js'
    },
    devtool: DEV && 'eval',
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.s?[ac]ss$/,
                use: [
                  MiniCssExtractPlugin.loader,
                  'css-loader',
                  'postcss-loader',
                  'sass-loader'
                ]
            }
        ]
    },
    optimization: !DEV && {
        minimizer: [
          new UglifyJsPlugin({
            cache: true,
            parallel: true,
            sourceMap: false // set to true if you want JS source maps
          }),
          new OptimizeCSSAssetsPlugin({})
        ]
    },
    plugins: [
        new CleanWebpackPlugin(['dist']),
        new MiniCssExtractPlugin({
            filename: DEV ? '[name].css' : '[name].[hash].css',
            chunkFilename: DEV ? '[id].css' : '[id].[hash].css',
        }),
        !DEV && new BrowserSyncPlugin({
            notify: false,
            host: 'localhost',
            port: 4000,
            files: ['./*.php'],
            browser: 'google chrome',
            logLevel: 'silent',
            proxy: 'http://localhost:9009/',
        }),
        new AssetsPlugin({
            path: path.join(__dirname, 'dist'),
            filename: 'assets.json',
        }),
    ]
}


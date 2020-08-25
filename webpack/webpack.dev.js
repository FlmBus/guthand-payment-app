const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const FriendlyErrorsPlugin = require('@nuxtjs/friendly-errors-webpack-plugin');

module.exports = merge(common, {
    mode: 'development',
    devtool: 'source-map',
    plugins: [
        new FriendlyErrorsPlugin(),
    ],
});

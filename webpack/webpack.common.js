const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin-webpack4');

module.exports = {
    entry: [ '@babel/polyfill', path.resolve(__dirname, '../src/index.js') ],
    output: {
        path: path.resolve(__dirname, '../public/assets'),
        filename: '[name].js',
        publicPath: '/assets/build/',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
            },
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                exclude: /node_modules/,
                options: {
                    appendTsSuffixTo: [/\.vue$/],
                },
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                        'scss': 'vue-style-loader!css-loader!sass-loader',
                        'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
                    },
                },
              },
            {
                test: /\.css$/,
                use: [
                    { loader: MiniCssExtractPlugin.loader },
                    { loader: 'css-loader', options: { sourceMap: true, importLoaders: 1 } },
                    { loader: 'postcss-loader', options: { sourceMap: true } },
                ],
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    { loader: MiniCssExtractPlugin.loader },
                    { loader: 'css-loader', options: { sourceMap: true, importLoaders: 1 } },
                    { loader: 'postcss-loader', options: { sourceMap: true } },
                    { loader: 'sass-loader', options: { sourceMap: true } },
                ],
            },
        ],
    },
    resolve: {
        extensions: ['.ts', '.js', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        }
    },
    target: 'web',
    optimization: {
        splitChunks: {
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/](react|react-dom|lodash|vue)[\\/]/,
                    name: 'vendor',
                    chunks: 'all',
                },
            },
        },
        usedExports: true,
    },
    plugins: [
        new CleanWebpackPlugin({ watch: true, cleanStaleWebpackAssets: false }),
        new MiniCssExtractPlugin({
            filename: 'style.css',
            chunkFilename: 'style.css',
        }),
        new VueLoaderPlugin(),
    ],
};

const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    mode: 'development',
    entry: {
        app: ['./themes/default/js/index.js', './themes/default/scss/index.scss'],
        admin: ['./themes/admin/js/index.js', './themes/admin/scss/index.scss'],
    },
    output: {
        filename: '[name].js',
        path: __dirname + '/public/assets'
    },
    module: {
        rules: [
            {   // sass
                test: /\.(sass|scss)$/,
                use: [
                    // fallback to style-loader in development
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader"
                ]
            },
            {
                // CSS
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "style-loader"
                ]
            },
            {   // Babel
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            // Images
            {
                test: /\.(png|svg|jpg|gif)$/,
                use: {
                    loader: 'file-loader',
                    options: {
                        outputPath: 'images/',
                        publicPath: 'assets/images/'
                    }
                }
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin()
    ]
};

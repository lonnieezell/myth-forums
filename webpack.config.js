const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

//
// Main asset management
//
module.exports = {
    mode: 'development',
    entry: ['./themes/default/js/index.js', './themes/default/scss/index.scss'],
    output: {
        filename: 'front.js',
        path: path.resolve(__dirname, 'public/assets'),
        publicPath: '/assets'
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

// Admin

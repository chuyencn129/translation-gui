module.exports = function (env) {
    const ExtractTextPlugin = require("extract-text-webpack-plugin");
    const WebpackOnBuildPlugin = require('on-build-webpack');
    const notifier = require('node-notifier');
    const cpy = require('cpy');

    return {
        entry: "./resources/js/translation.js",


        output: {
            path: __dirname,
            filename: "public/translation.js"
        },


        module: {
            loaders: [
                {
                    test: /\.(png|jpg|gif)$/,
                    loader: 'file?name=[name].[ext]?[hash]'
                },

                {
                    test: /\.(woff2?|ttf|eot|svg|otf)$/,
                    loader: 'ignore-loader'
                },

                {
                    test: /\.scss$/,
                    loaders: ExtractTextPlugin.extract({
                        fallbackLoader: 'style-loader',
                        loader: [
                            'css-loader',
                            'resolve-url-loader',
                            'sass-loader?sourceMap&precision=8'
                        ]
                    })
                },

                {
                    test: /\.css$/,
                    loader: "css-loader"
                }
            ]
        },


        plugins: [
            new ExtractTextPlugin("public/translation.css")
        ],


        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.common.js'
            }
        }
    };
};


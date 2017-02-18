var path = require('path');
var webpack = require('webpack');
var env = process.env.NODE_ENV;
var outputPath = '../js';
var fileName = env === 'development' ? 'app.dev.bundle.js' : 'app.bundle.js';
var componentPath = path.resolve('./src/js');

// http://stackoverflow.com/questions/28572380/conditional-build-based-on-environment-using-webpack
// https://facebook.github.io/react/docs/optimizing-performance.html#use-the-production-build
var plugins = [
    new webpack.DefinePlugin({
        ENV: env,
        'process.env': {
            NODE_ENV: env
        }
    }),
    new webpack.ProvidePlugin({})
]

if(env != 'development'){
    plugins.push(new webpack.optimize.UglifyJsPlugin());  
}

module.exports = {
    entry: './src/js/app.js',
    output: {
        path: path.resolve(outputPath),
        publicPath: "/js",
        filename: fileName,
    },
    module: {
        rules: [
            { 
                test: /\.js$/, 
                use: 'babel-loader'
            }
        ]
    },
    plugins: plugins,
    devServer: {
        contentBase: "./src",
        port: 8080
    }
};
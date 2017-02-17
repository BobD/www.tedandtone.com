var path = require('path');
var webpack = require('webpack');
var env = process.env.NODE_ENV;
var outputPath = env === 'development' ? './dist/js' : '../js';
var componentPath = path.resolve('./src/js');

// http://stackoverflow.com/questions/28572380/conditional-build-based-on-environment-using-webpack
// https://facebook.github.io/react/docs/optimizing-performance.html#use-the-production-build
var plugins = [
    new webpack.DefinePlugin({
        ENV: JSON.stringify(env),
        'process.env': {
            NODE_ENV: JSON.stringify(env)
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
        path: outputPath,
        publicPath: "/js",
        filename: 'app.bundle.js',
    },
    module: {
        rules: [
            { 
                test: /\.js$/, 
                use: [{
                    loader: 'babel-loader',
                    options: { presets: ['es2015'] },
                    exclude: [/node_modules/],
                }],
            }
        ]
    },
     // See: https://seesparkbox.com/foundry/write_better_frontend_modules_with_webpack
    resolve: {
        root: componentPath,
    },
    plugins: plugins,
    node: {
        fs: "empty" // avoids error messages
    },
    devServer: { inline: true }
};
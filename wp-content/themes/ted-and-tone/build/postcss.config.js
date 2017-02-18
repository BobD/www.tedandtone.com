var env = process.env.NODE_ENV;
var outputPath = env === 'development' ? '../css/styles.dev.css' : '../css/styles.css';

module.exports = {
	input: './src/css/styles.css',
    output: outputPath,
    "use": [
    	"postcss-cssnext",
    	"cssnano"
    ],
    cssnano: {
    	sourcemap: true
    },
  	autoprefixer: {
    	browsers: "> 5%"
  	}
};
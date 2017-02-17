var env = process.env.NODE_ENV;
var outputPath = env === 'development' ? './src/css/styles.css' : '../css/styles.css';

module.exports = {
	input: './src/css/styles.css',
    output: outputPath,
    "use": [
    	"postcss-cssnext"
    ],
  	autoprefixer: {
    	browsers: "> 5%"
  	}
};
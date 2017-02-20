const env = process.env.NODE_ENV;
const outputPath = env === 'development' ? '../css/styles.dev.css' : '../css/styles.css';

const useInDevelopment =  env !== 'development' ? [] : [
];

const useInProduction =  env === 'development' ? [] : [
   "cssnano"
];

module.exports = {
	input: './src/css/styles.css',
    output: outputPath,
    use: [
        "postcss-easy-import",
        "postcss-cssnext",
        ...useInDevelopment,
        ...useInProduction
    ],
    cssnano: {
    	sourcemap: true
    },
  	autoprefixer: {
    	browsers: "> 5%"
  	},
    "postcss-easy-import": {
        onImport: function(sources) {
            global.watchCSS(sources, this.from);
        }
    }
};
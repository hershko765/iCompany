({
	// Directory to copy and minify
	appDir: '../media',
	// Base url for related paths
	baseUrl: 'js',
	// Directory of the minified copied project
	dir: './build',
	inlineText: true,
	// Remove comments
	preserveLicenseComments: false,
	// List of modules/divided parts of the app
	modules: [
		{
			name: 'main'
		}
	],
    optimize: "none",
	// Exclude files
	fileExclusionRegExp: /^(r|build)\.js$/,
	// Optimize CSS files to base.css
	optimizeCss: 'standard',
	removeCombined: true,
	// Main Configuration
	mainConfigFile: '../media/js/main.js'
})

// 
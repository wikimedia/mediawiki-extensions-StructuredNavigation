/* eslint-env node */

module.exports = function ( grunt ) {
	var config = grunt.file.readJSON( 'extension.json' );

	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-eslint' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-stylelint' );

	grunt.initConfig( {
		banana: config.MessagesDirs,
		eslint: {
			all: [
				'*.js',
				'**/*.js',
				'!{node_modules,vendor,docs}/**'
			]
		},
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**',
				'!vendor/**',
				'!extensions/**'
			]
		},
		stylelint: {
			all: [
				'**/*.css',
				'**/*.less',
				'!node_modules/**',
				'!vendor/**',
			]
		},
	} );

	grunt.registerTask( 'test', [ 'banana', 'eslint', 'jsonlint', 'stylelint' ] );
	grunt.registerTask( 'default', 'test' );
};
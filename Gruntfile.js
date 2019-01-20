/* eslint-env node */

module.exports = function ( grunt ) {
	var config = grunt.file.readJSON( 'extension.json' );

	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-stylelint' );

	grunt.initConfig( {
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**',
				'!vendor/**',
				'!extensions/**'
			]
		},
		banana: config.MessagesDirs,
		stylelint: {
			all: [
				'**/*.css',
				'**/*.less',
				'!node_modules/**',
				'!vendor/**',
			]
		}
	} );

	grunt.registerTask( 'test', [ 'jsonlint', 'banana', 'stylelint' ] );
	grunt.registerTask( 'default', 'test' );
};
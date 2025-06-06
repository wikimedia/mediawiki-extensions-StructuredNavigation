/* eslint-env node */

module.exports = function ( grunt ) {
	const config = grunt.file.readJSON( 'extension.json' );

	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-eslint' );
	grunt.loadNpmTasks( 'grunt-stylelint' );

	grunt.initConfig( {
		banana: config.MessagesDirs,
		eslint: {
			options: {
				cache: true
			},
			all: [
				'**/*.{js,json}',
				'!node_modules/**',
				'!vendor/**'
			],
			fix: {
				options: {
					cache: true,
					fix: true
				}
			}
		},
		stylelint: {
			options: {
				cache: true
			},
			all: [
				'**/*.css',
				'**/*.less',
				'!node_modules/**',
				'!vendor/**'
			]
		}
	} );

	grunt.registerTask( 'test', [ 'eslint:all', 'banana', 'stylelint' ] );
	grunt.registerTask( 'fix', 'eslint:fix' );
	grunt.registerTask( 'default', 'test' );
};

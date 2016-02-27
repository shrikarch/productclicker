module.exports = function (grunt) {
	grunt.initConfig({
		sass: {
			dist: {
				files: {
					'css/style.css' : 'sass/style.scss'
				}
			}
		},
		watch: {
			dist: {
				files: ['sass/*.scss','js/main.js','js/base.js'],
				tasks: ['sass']
			},
			grunt: {
				files: ['Gruntfile.js']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default',['watch']);
	grunt.loadNpmTasks('grunt-contrib-sass');
};
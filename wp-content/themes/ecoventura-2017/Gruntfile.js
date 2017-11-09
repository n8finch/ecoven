module.exports = function (grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {                              // Task
      dist: {                            // Target
        options: {                       // Target options
          style: 'expanded'
        },
        files: {                         // Dictionary of files
          'style.css': 'sass/sass/style.scss'       // 'destination': 'source'
        }
      }
    },

    postcss: {
      options: {
        map: true, // inline sourcemaps

		processors: [
        require('pixrem')(), // add fallbacks for rem units
        require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixes
        require('cssnano')() // minify the result
      ]
      },
      dist: {
        src: 'style.css'
      }
    },

	concat: {
		options: {
			stripBanners: true,
      sourceMap: true,
			banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
			  '<%= grunt.template.today("yyyy-mm-dd") %> */',
		},
		dist: {
			src: [ 'js/10up-tabs.js', 'js/custom.js' ],
			dest: 'js/custom.min.js',
		},
	},

	uglify: {
		options: {
			mangle: false,
      sourceMap: true,
      sourceMapIncludeSources: true,
      sourceMapIn: 'js/custom.min.js.map'
		},
		my_target: {
			files: {
				'js/custom.min.js': ['js/custom.min.js']
			}
		}
	},


	browserSync: {
		dev: {
				bsFiles: {
					src : [
						'style.css',
						'*.php',
						'*/*.php',
			            '*.js',
			            'js/*.js',
					]
				},
				options: {
					watchTask: true,
					proxy: 'ecoventura.app'
				}
		}
	},

    watch: {
      files: ['sass/css/*.css', 'js/**/*.js', 'sass/sass/**/*.scss'],
      tasks: ['build']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-browser-sync');

  grunt.registerTask('default', ['sass', 'browserSync', 'watch']);
  grunt.registerTask('build', ['sass', 'postcss', 'concat', 'uglify']);
  grunt.registerTask('post', 'postcss');

};

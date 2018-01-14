var gulp = require('gulp');
var initGulpTasks = require('react-component-gulp-tasks');

var webpack   = require('webpack-stream');

var header    = require('gulp-header');
var jshint    = require('gulp-jshint');
var rename    = require('gulp-rename');
var react     = require('gulp-react');
var streamify = require('gulp-streamify');

/**
 * Tasks are added by the react-component-gulp-tasks package
 *
 * See https://github.com/JedWatson/react-component-gulp-tasks
 * for documentation.
 *
 * You can also add your own additional gulp tasks if you like.
 */

var taskConfig = {

	component: {
		name: 'ReactPercentageCircle',
		dependencies: [
			'classnames',
			'react',
			'react-dom'
		],
		lib: 'lib'
	},

	example: {
		src: 'example/src',
		dist: 'example/dist',
		files: [
			'index.html',
			'.gitignore'
		],
		scripts: [
			'example.js'
		],
		less: [
			'example.less'
		]
	}

};

initGulpTasks(gulp, taskConfig);

gulp.task('bundle-js', ['build'], function() {
        var stream = gulp.src('./lib/*.js')
            .pipe(streamify(header(distHeader, {
                            pkg: pkg,
                            devBuild: devBuild
                        })))
        .pipe(webpack(require('./webpack.config.js')))
            .pipe(gulp.dest('./dist'))
            .pipe(rename('ReactPercentageCircle.min.js'))
            .pipe(streamify(uglify()))
            .pipe(streamify(header(distHeader, {
                            pkg: pkg,
                            devBuild: devBuild
                        })))
        .pipe(gulp.dest('./dist'));

            return stream;
});

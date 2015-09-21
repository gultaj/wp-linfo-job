var gulp = require('gulp'),
	sass = require('gulp-sass');

gulp.task('sass', function() {
	return gulp.src('public/sass/linfo-job.sass')
		.pipe(sass({
			outputStyle: 'compressed'
			// outputStyle: 'nested'
		}))
		.pipe(gulp.dest('public/css'));
});
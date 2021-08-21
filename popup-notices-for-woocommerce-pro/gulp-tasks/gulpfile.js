// Include project requirements.
var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    livereload = require('gulp-livereload'),
    watch = require('gulp-watch'),
    concat = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    rename = require("gulp-rename");

// Sets assets folders.
var dirs = {
	admin: {
		src: {
			js: '../src/assets/src/admin/js',
			sass: '../src/assets/src/admin/scss'
		},
		dist: {
			js: '../src/assets/dist/admin/js',
			css: '../src/assets/dist/admin/css',
			vendor: '../src/assets/dist/admin/vendor'
		}
	},
	frontend: {
		src: {
			js: '../src/assets/src/frontend/js',
			sass: '../src/assets/src/frontend/scss'
		},
		dist: {
			js: '../src/assets/dist/frontend/js',
			css: '../src/assets/dist/frontend/css',
			vendor: '../src/assets/dist/frontend/vendor'
		}
	}
};

var scripts_name = 'ttt-pnwc-pro';

gulp.task('js-admin-custom', function () {
	return gulp.src([dirs.admin.src.js + '/*.js'])
		.pipe(concat(scripts_name+'.js'))
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest(dirs.admin.dist.js))
		.pipe(concat(scripts_name+'.min.js'))
		.pipe(uglify({

		}).on('error', function(e){
			console.log(e.message); return this.end();
		}))
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest(dirs.admin.dist.js))
		.pipe(livereload());
});

gulp.task('sass-admin', function () {
	gulp.src(dirs.admin.src.sass + '/*.scss')
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.on('error', sass.logError)
		.pipe(rename(scripts_name+".min.css"))
		.pipe(autoprefixer({
			browsers: ['last 3 versions'],
			cascade: false
		}))
		.pipe(gulp.dest(dirs.admin.dist.css));

	return gulp.src(dirs.admin.src.sass + '/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'expanded'
		}))
		.on('error', sass.logError)
		.pipe(rename(scripts_name+".css"))
		.pipe(autoprefixer({
			browsers: ['last 3 versions'],
			cascade: false
		}))
		.pipe(gulp.dest(dirs.admin.dist.css))
		.pipe(livereload())
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest(dirs.admin.dist.css));
});

gulp.task('js-frontend-custom', function () {
    return gulp.src([dirs.frontend.src.js + '/*.js'])
        .pipe(concat(scripts_name+'.js'))
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest(dirs.frontend.dist.js))
        .pipe(concat(scripts_name+'.min.js'))
        .pipe(uglify({
            
        }).on('error', function(e){
            console.log(e.message); return this.end();
        }))
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest(dirs.frontend.dist.js))
        .pipe(livereload());
});

gulp.task('sass-frontend', function () {
    gulp.src(dirs.frontend.src.sass + '/*.scss')
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .on('error', sass.logError)
        .pipe(rename(scripts_name+".min.css"))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(dirs.frontend.dist.css));

    return gulp.src(dirs.frontend.src.sass + '/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .on('error', sass.logError)
        .pipe(rename(scripts_name+".css"))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(dirs.frontend.dist.css))
        .pipe(livereload())
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest(dirs.frontend.dist.css));
});

//gulp.task('watch', ['sass-frontend', 'js-frontend-custom','sass-admin', 'js-admin-custom'], function () {
gulp.task('watch', ['sass-frontend', 'js-frontend-custom'], function () {
    livereload.listen();
    watch(dirs.frontend.src.js + '/*.js', function () {
        gulp.start('js-frontend-custom');
    });
    watch(dirs.frontend.src.sass + '/**/*.scss', function () {
        gulp.start('sass-frontend');
    });
	//watch(dirs.admin.src.js + '/*.js', function () {
	//	gulp.start('js-admin-custom');
	//});
	//watch(dirs.admin.src.sass + '/**/*.scss', function () {
	//	gulp.start('sass-admin');
	//});
});

gulp.task('default', function () {
	gulp.start(['sass-frontend', 'js-frontend-custom']);
    //gulp.start(['sass-frontend', 'js-frontend-custom','sass-admin', 'js-admin-custom']);
});
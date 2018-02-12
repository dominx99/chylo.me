
var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    compass = require('gulp-compass'),
    imagemin = require('gulp-imagemin'),
    autoprefixer = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber');

gulp.task('image-optimize', function(){
    gulp.src('src/assets/img/*')
        .pipe(imagemin({
            interlaced: true,
            progressive: true,
            optimizationLevel: 5
        }))
        .pipe(gulp.dest('dist/img'));
});

gulp.task('js', function(){
    gulp.src(['src/assets/js/**/*.js', '!src/assets/js/**/*.min.js'])
        .pipe(plumber())
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('scss', function(){
    gulp.src('src/assets/scss/main.scss')
        .pipe(plumber())
        .pipe(compass({
            config_file: 'config.rb',
            css: 'dist/css',
            sass: 'src/assets/scss',
            require: ['susy'],
        }))
        .pipe(autoprefixer())
        .pipe(gulp.dest('dist/css/'));
});

gulp.task('watch', function(){
    gulp.watch('src/assets/js/**/*.js', ['js']);
    gulp.watch('src/assets/scss/**/*.scss', ['scss']);
});

gulp.task('default', [
    'image-optimize',
    'js',
    'scss',
    'watch',
]);

const   gulp = require('gulp'),
        uglify = require('gulp-uglify'),
        rename = require('gulp-rename'),
        compass = require('gulp-compass'),
        imagemin = require('gulp-imagemin'),
        csso = require('gulp-csso'),
        imageResize = require('gulp-image-resize'),
        autoprefixer = require('gulp-autoprefixer'),
        plumber = require('gulp-plumber');

gulp.task('css', () => {
    return gulp.src(['src/assets/css/**/*.css', '!src/assets/css/**/*.min.css'])
        .pipe(plumber())
        .pipe(csso())
        .pipe(autoprefixer())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('dist/css'));
});

gulp.task('img', function(){
    return gulp.src('src/assets/img/**/*')
        .pipe(imagemin({
            interlaced: true,
            progressive: true,
            optimizationLevel: 5
        }))
        .pipe(gulp.dest('dist/img'));
});

gulp.task('js', function(){
    return gulp.src(['src/assets/js/**/*.js', '!src/assets/js/**/*.min.js'])
        .pipe(plumber())
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('dist/js'));
});

gulp.task('scss', function(){
    return gulp.src('src/assets/scss/main.scss')
        .pipe(plumber())
        .pipe(compass({
            config_file: 'config.rb',
            css: 'dist/css',
            sass: 'src/assets/scss',
            require: ['susy'],
        }))
        .pipe(autoprefixer())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('dist/css'));
});

gulp.task('watch', function(){
    gulp.watch('src/assets/js/**/*.js', ['js']);
    gulp.watch('src/assets/scss/**/*.scss', ['scss']);
    gulp.watch('src/assets/css/**/*.css', ['css']);
});

gulp.task('thumbs', () => {
    return gulp.src('src/assets/img/projects/**/*')
        .pipe(plumber())
        .pipe(imageResize({
            width: 550,
            height: 450,
            cover: true,
            quality: 0.9
        }))
        .pipe(gulp.dest('dist/img/projects/thumbs'));
});

gulp.task('default', [
    'css',
    'js',
    'scss',
    'img',
    'thumbs',
    'watch',
]);

var gulp    = require('gulp');
// var gutil = require('gulp-util');
var replace = require('gulp-replace');
var prompt  = require('gulp-prompt');
var rename  = require('gulp-rename');
var sass = require('gulp-sass');
var ftp = require('gulp-ftp');
var browserSync = require('browser-sync').create();

gulp.task('default', function() {
  console.log(config);
});

gulp.task('replace', function(){
  gulp.src('style.css')
    .pipe(prompt.prompt([
    {
        type: 'input',
        name: 'themeName',
        message: 'Theme name?'
    },
    {
        type: 'input',
        name: 'host',
        message: 'Ftp host?'
    },
    {
        type: 'input',
        name: 'user',
        message: 'Ftp user?'
    },
    {
        type: 'input',
        name: 'password',
        message: 'Ftp password?'
    },
    {
        type: 'input',
        name: 'remotePath',
        message: 'Ftp Remote Path?'
    }
    ],
    function(res){
      gulp.src([
          'style.css'
        ])
       .pipe(replace('WPBP', res.themeName))
       .pipe(gulp.dest(function (data) {
      return data.base;
      }));

      gulp.src(['functions.php'])
       .pipe(replace('WPBP_SCRIPT', res.themeName))
       .pipe(gulp.dest(function (data) {
      return data.base;
      }));

      gulp.src(['assets/js/WPBP.js'])
       .pipe(rename( res.themeName + '.js'))
       .pipe(gulp.dest(function (data) {
      return data.base;
      }));

      gulp.src(['sftp-config-temp.json'])
       .pipe(replace('WPBP_HOST', res.host))
       .pipe(replace('WPBP_USER', res.user))
       .pipe(replace('WPBP_PASSWORD', res.password))
       .pipe(replace('WPBP_REMOTEPATH', res.remotePath))
       .pipe(rename('sftp-config.json'))
       .pipe(gulp.dest(function (data) {
      return data.base;
      }));
    }));

});

// {outputStyle: 'compressed'}

gulp.task('sass', function () {
  return gulp.src('assets/css/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('assets/css'));
});

gulp.task('ftp-deploy',['sass'], function () {
    return gulp.src('assets/css/style.css')
        .pipe(ftp({
            host: '',
            user: '',
            pass: '',
            remotePath : ''
        }));
});

gulp.task('browser-stream',['ftp-deploy'], function () {
  return gulp.src([
      'assets/css/style.css'
    ])
    .pipe(browserSync.stream());
});

gulp.task('sync', function() {
  browserSync.init({
    proxy: "",
    notify: false
  });
  gulp.watch('assets/css/*.scss', ['browser-stream']);
});

// 묶음 명령
gulp.task('theme', ['replace']);

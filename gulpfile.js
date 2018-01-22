var gulp    = require('gulp');
var replace = require('gulp-replace');
var prompt  = require('gulp-prompt');
var rename  = require('gulp-rename');
var sass = require('gulp-sass');
var ftp = require('gulp-ftp');
var browserSync = require('browser-sync').create();

gulp.task('default', function() {
  console.log('hello');
});

gulp.task('replace', function(){
  gulp.src('style.css')
    .pipe(prompt.prompt([
    {
        type: 'input',
        name: 'themeName',
        message: '테마 이름(영문)을 입력하세요'
    },
    {
        type: 'input',
        name: 'host',
        message: 'Ftp 호스트를 입력하세요(sftp-config)'
    },
    {
        type: 'input',
        name: 'user',
        message: 'Ftp 아이디를 입력하세요(sftp-config)'
    },
    {
        type: 'input',
        name: 'password',
        message: 'Ftp 비밀번호를 입력하세요(sftp-config)'
    },
    {
        type: 'input',
        name: 'remotePath',
        message: 'Ftp 원격(remote) 경로를 입력하세요(sftp-config)'
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

      gulp.src(['gulp-ftp-temp.json'])
       .pipe(replace('WPBP_HOST', res.host))
       .pipe(replace('WPBP_USER', res.user))
       .pipe(replace('WPBP_PASSWORD', res.password))
       .pipe(replace('WPBP_REMOTEPATH', res.remotePath))
       .pipe(rename('gulp-ftp.json'))
       .pipe(gulp.dest(function (data) {
      return data.base;
      }));

    }));

});

gulp.task('sass', function () {
  return gulp.src('assets/css/style.scss')
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest('assets/css'));
});

gulp.task('ftp-deploy',['sass'], function () {
    var ftpSetting = require('./gulp-ftp.json');
    return gulp.src('assets/css/style.css')
        // 아래 내용을 입력해주세요.
        .pipe(ftp(ftpSetting));
});

gulp.task('browser-stream',['ftp-deploy'], function () {
  return gulp.src([
      'assets/css/style.css'
    ])
    .pipe(browserSync.stream());
});

gulp.task('sync', function() {
  browserSync.init({
    proxy: '', // proxy(작업 주소) 입력
    notify: false
  });
  gulp.watch('assets/css/*.scss', ['browser-stream']);
});

// 묶음 명령
gulp.task('theme', ['replace']);

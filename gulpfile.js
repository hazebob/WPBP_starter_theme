var gulp    = require('gulp');
var replace = require('gulp-replace');
var prompt  = require('gulp-prompt');
var rename  = require('gulp-rename');
// var favicons = require('gulp-favicons');

gulp.task('default', function() {
  console.log('hi!');
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

// gulp.task('favicon', function () {
//     gulp.src('assets/images/favicon/favicon.png')
//       .pipe(favicons({
//         html: "assets/images/favicon/favicon.html"
//       }))
//       .pipe(gulp.dest('assets/images/favicon/'));
// });

// 묶음 명령
gulp.task('theme', ['replace']);

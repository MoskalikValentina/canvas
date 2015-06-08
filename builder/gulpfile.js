//TODO add style.css whithout minification
//TODO solve problem with plugin loads. See 'gulp-minify-css'
//TODO add diff files fo r js-libs and js-plugins

'use strict'

//Requires
var gulp = require('gulp');
var plugins = {
    'rename': require('gulp-rename'),
    'rigger': require('gulp-rigger'),
    'htmlclean': require('gulp-htmlclean'),
    'sourcemaps': require('gulp-sourcemaps'),
    'sass': require('gulp-ruby-sass'),
    'prefixer': require('gulp-autoprefixer'),
    'cssmin': require('gulp-minify-css'),
    'imagemin': require('gulp-imagemin'),
    'pngquant': require('imagemin-pngquant'),
    'uglify': require('gulp-uglify'),
    'versionAppend': require('gulp-version-append'),
    'watch': require('gulp-watch'),
    'browserSync': require("browser-sync"),
    'rimraf': require('rimraf'),
    'plumber': require('gulp-plumber'),
    'zip': require('gulp-zip'),
    'spritesmith': require('gulp.spritesmith'),
    'ttf2woff': require('gulp-ttf2woff'),
    'ttf2eot': require('gulp-ttf2eot')
}

var reload = plugins.browserSync.reload;

//Path config
var path = {
    build: {
        html: '../build/',
        css: '../build/css/',
        js: '../build/js/',
        img: '../build/img/',
        fonts: '../build/fonts/',
        php: '../build/',
        add_files: '../build/'
    },
    src: {
        src: '../src/',
        html: '../src/*.html',
        css: '../src/css/style.scss',
        js: {
            def: '../src/js/*.js',
            script: '../src/js/*.js',
            libs: '../src/js/libs/*.js',
            plugins: '../src/js/plugins/*js'
        },
        img: '../src/img/**/*.*',
        fonts: '../src/fonts/**/*.*',
        php: '../src/php/**/*.*',
        sprites: '../src/img/sprites/*.*',
        add_files: '../src/add-files/**/*.*'
    },
    watch: {
        html: '../src/*.html',
        css: '../src/css/**/*.scss',
        js: '../src/js/**/*.js',
        img: '../src/img/**/*.*',
        fonts: '../src/fonts/**/*.*',
        php: '../src/php/**/*.*',
        sprite: '../src/img/sprites/*.*',
        add_files: '../src/add-files/**/*.*'
    },
    clean: '../build/'
};

var serv_config = {
    server: {
        baseDir: "../build/"
    },
    tunnel: true,
    host: 'localhost',
    port: 9000,
    logPrefix: "Frontend_Devil"
};

//Tasks
gulp.task('html:build', function() {
    gulp.src(path.src.html)
        .pipe(plugins.plumber())
        .pipe(plugins.rigger())
        .pipe(plugins.versionAppend(['html', 'js', 'css']))
        .pipe(plugins.htmlclean())
        .pipe(gulp.dest(path.build.html))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('html:dev', function() {
    gulp.src(path.src.html)
        .pipe(plugins.plumber())
        .pipe(plugins.rigger())
        .pipe(gulp.dest(path.build.html))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('sprite', function() {
    var spriteData = gulp.src(path.src.sprites).pipe(plugins.spritesmith({
        imgName: '../img/sprite.png',
        cssName: '_sprite.scss',
        cssVarMap: function(sprite) {
            sprite.name = 's-' + sprite.name
        }
    }));
    spriteData.css.pipe(gulp.dest('../src/css/4_common'));
    spriteData.img.pipe(gulp.dest(path.build.img));
});

gulp.task('css:build', function() {
    gulp.src(path.src.css)
        .pipe(plugins.plumber())
    return plugins.sass(path.src.css)
        .pipe(plugins.prefixer())
        .pipe(plugins.rename('style.dist.css'))
        .pipe(gulp.dest(path.build.css))
        .pipe(plugins.cssmin())
        .pipe(plugins.rename('style.css'))
        .pipe(gulp.dest(path.build.css))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('css:dev', function() {
    gulp.src(path.src.css)
        .pipe(plugins.plumber())
    return plugins.sass(path.src.css, {
            sourcemap: true
        })
        .pipe(plugins.cssmin())
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(path.build.css))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('js:build', function() {
    gulp.src(path.src.js.def)
        .pipe(plugins.plumber())
        .pipe(plugins.rigger())
        .pipe(plugins.rename('script.dist.js'))
        .pipe(gulp.dest(path.build.js))
        .pipe(plugins.uglify({
            mangle: false //Need for angular normal work. Off renaming
        }))
        .pipe(plugins.rename('script.js'))
        .pipe(gulp.dest(path.build.js))
        .pipe(reload({
            stream: true
        }));
})

gulp.task('js:dev', function() {
    gulp.src(path.src.js.def)
        .pipe(plugins.plumber())
        .pipe(plugins.rigger())
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(path.build.js))
        .pipe(reload({
            stream: true
        }));
})

gulp.task('img:build', function() {
    gulp.src(path.src.img)
        .pipe(plugins.plumber())
        .pipe(plugins.imagemin({
            progressive: true,
            svgoPlugins: [{
                removeViewBox: false
            }],
            use: [plugins.pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest(path.build.img))
        .pipe(reload({
            stream: true
        }));
})

gulp.task('img:dev', function() {
    gulp.src(path.src.img)
        .pipe(gulp.dest(path.build.img))
        .pipe(reload({
            stream: true
        }));
})

gulp.task('fonts:build', function() {
    gulp.src("../src/fonts/*.ttf")
        .pipe(gulp.dest(path.build.fonts))
        .pipe(plugins.ttf2eot())
        .pipe(gulp.dest(path.build.fonts));
    gulp.src("../src/fonts/*.ttf")
        .pipe(plugins.ttf2woff())
        .pipe(gulp.dest(path.build.fonts));
})

//Additinal files build
gulp.task('add-files:build', function() {
    gulp.src([path.src.add_files, path.src.src + 'add-files/*.{ico,png,txt}', path.src.src + 'add-files/.htaccess'])
        .pipe(gulp.dest(path.build.add_files));
})

//PHP build
gulp.task('php:build', function() {
    gulp.src(path.src.php)
        .pipe(gulp.dest(path.build.php));
})

//Create zip file
gulp.task('zip', function() {
    return gulp.src('../build/**/*.*')
        .pipe(plugins.zip('build.zip'))
        .pipe(gulp.dest('../'));
});


gulp.task('webserver', function() {
    plugins.browserSync(serv_config);
});

gulp.task('clean', function(cb) {
    plugins.rimraf(path.clean, cb);
});

//All build task
gulp.task('build', [
    'sprite',
    'html:build',
    'js:build',
    'css:build',
    'fonts:build',
    'img:build',
    'add-files:build',
    'php:build',
]);

//Develop build task
gulp.task('dev', [
    'sprite',
    'html:dev',
    'js:dev',
    'css:dev',
    'fonts:build',
    'img:dev',
    'add-files:build',
    'php:build',
]);

//Watch task
gulp.task('watch', function() {
    plugins.watch([path.watch.html], function(event, cb) {
        gulp.start('html:dev');
    });
    plugins.watch([path.watch.css], function(event, cb) {
        gulp.start('css:dev');
    });
    plugins.watch([path.watch.sprite], function(event, cb) {
        gulp.start('sprite');
    });
    plugins.watch([path.watch.js], function(event, cb) {
        gulp.start('js:dev');
    });
    plugins.watch([path.watch.img], function(event, cb) {
        gulp.start('img:dev');
    });
    plugins.watch([path.watch.fonts], function(event, cb) {
        gulp.start('fonts:build');
    });
    plugins.watch([path.watch.add_files], function(event, cb) {
        gulp.start('add-files:build');
    });
    plugins.watch([path.watch.php], function(event, cb) {
        gulp.start('php:build');
    });
});

//Default task
gulp.task('default', ['dev', 'webserver', 'watch']);

//.htaccess move
//todo add it to task
gulp.task('htaccess', function() {
    gulp.src('../src/add-files/**/.*')
        .pipe(gulp.dest('../build/'))
})

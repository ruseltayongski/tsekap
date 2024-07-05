const gulp = require("gulp");
const browserify = require("browserify");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");
const babelify = require("babelify");
const sass = require("gulp-sass")(require("sass"));
const path = require("path");
const cleanCSS = require("gulp-clean-css");
const sourcemaps = require("gulp-sourcemaps");
const concat = require("gulp-concat");

// Compile JavaScript
function compileJs() {
  return browserify({
    entries: "./resources/assets/js/Components/main.js", // Entry point of your application
    extensions: [".jsx", ".js"],
    debug: true,
  })
    .transform(
      babelify.configure({
        presets: ["@babel/preset-env", "@babel/preset-react"],
      })
    )
    .bundle()
    .pipe(source("bundle.js")) // Output filename
    .pipe(buffer())
    .pipe(gulp.dest("./public/js")); // Destination folder
}

// Compile Sass
function compileSass() {
  return gulp
    .src("./resources/assets/sass/app.scss")
    .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
    .pipe(gulp.dest("./public/css"));
}

function processCss() {
  return gulp
    .src("resources/assets/js/css/*.css")
    .pipe(sourcemaps.init())
    .pipe(concat("styles.css"))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest("public/css"));
}

// Watch files
function watchFiles() {
  gulp.watch("./resources/assets/js/**/*.js", compileJs);
  gulp.watch("./resources/assets/js/**/*.jsx", compileJs);
  gulp.watch("./resources/assets/sass/**/*.scss", compileSass);
  gulp.watch("resources/assets/js/css/*.css", processCss);
}

// Default task
const build = gulp.series(gulp.parallel(compileJs, compileSass, processCss));
gulp.task("default", build);
gulp.task("watch", gulp.series(build, watchFiles));

exports.compileJs = compileJs;
exports.compileSass = compileSass;
exports.processCss = processCss;
exports.watch = watchFiles;
exports.default = build;

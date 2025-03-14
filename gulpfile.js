const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const pug = require("gulp-pug");
const replace = require("gulp-replace");
const rename = require("gulp-rename");
const autoprefixer = require("gulp-autoprefixer");
const svgSprite = require("gulp-svg-sprite");
const browserSync = require("browser-sync").create();
const del = require("del");
const concat = require("gulp-concat");
const sourcemaps = require("gulp-sourcemaps");
const realFavicon = require("gulp-real-favicon");
const faviconData = "faviconData.json";
const imagemin = require("gulp-imagemin");
const imageminJpg = require("imagemin-jpeg-recompress");
const imageminPng = require("imagemin-pngquant");
const changed = require("gulp-changed");

let jsLibs = [
  "node_modules/swiper/swiper-bundle.min.js",
  "node_modules/@fancyapps/ui/dist/fancybox.umd.js",
  "node_modules/inputmask/dist/inputmask.min.js",
  "node_modules/flatpickr/dist/flatpickr.min.js",
  "node_modules/flatpickr/dist/l10n/ru.js",
  "node_modules/@popperjs/core/dist/umd/popper.min.js",
  "node_modules/tippy.js/dist/tippy.umd.min.js",
];
let cssLibs = [
  "node_modules/swiper/swiper-bundle.min.css",
  "node_modules/@fancyapps/ui/dist/fancybox.css",
  "node_modules/flatpickr/dist/flatpickr.min.css",
  "node_modules/tippy.js/dist/tippy.css",
  "resources/app/css/font-awesome.min.css",
];
let commonJsLibs = [
  "resources/app/js/custom-libs/adaptive-height.js",
  "resources/app/js/custom-libs/fade-toggle.js",
  "resources/app/js/custom-libs/slide-toggle.js",
  "resources/app/js/custom-libs/scrolling-toggle.js",
  "resources/app/js/custom-libs/form-validate-class.js",
  "resources/app/js/custom-libs/thanks.js",
  "resources/app/js/custom-libs/modal.js",
  "resources/app/js/custom-libs/tooltip.js",
  "resources/app/js/custom-libs/counter.js",
  // 'resources/app/js/custom-libs/anchor-scroll.js',
  // 'resources/app/js/custom-libs/password-toggle-toggle.js',
  "resources/app/js/custom-libs/select.js",
  "resources/app/js/custom-libs/accordion.js",
  "resources/app/js/custom-libs/tabs.js",
  // 'resources/app/js/custom-libs/input-file-class.js',
  "resources/app/js/custom-libs/simple-map.js",
];
function clean() {
  return del("public/dist");
}
function style() {
  return (
    gulp
      .src(cssLibs)
      .pipe(sourcemaps.init())
      .pipe(concat("libs.css"))
      .pipe(gulp.dest("public/dist/css")),
    gulp
      .src("resources/app/sass/style.scss")
      .pipe(sourcemaps.init())
      .pipe(
        sass({ includePaths: ["resources/app/blocks", "resources/app/pages"] }).on(
          "error",
          sass.logError
        )
      )
      .pipe(
        autoprefixer(["last 15 versions", "> 1%", "ie 8", "ie 7"], {
          cascade: true,
        })
      )
      .pipe(sourcemaps.write("."))
      .pipe(gulp.dest("public/dist/css"))
      .on("end", browserSync.reload)
  );
}
function html() {
  return gulp
    .src("resources/app/pages/**/*.pug")
    .pipe(
      pug({
        pretty: true,
        basedir: "resources/app",
        locals: {
          addClass: function (name, mods, addClass) {
            mods = mods || [];
            addClass = addClass || "";
            let value = "";

            mods.forEach(function (element) {
              value += " " + name + "_" + element;
            });

            return (value + " " + addClass).trim();
          },
        },
      })
    )
    .pipe(
      rename({
        dirname: "",
      })
    )
    .pipe(gulp.dest("public/dist/"))
    .on("end", browserSync.reload);
  // .pipe(browserSync.stream())
}
function fontsTransfer() {
  return gulp.src("resources/app/fonts/**/*.*").pipe(gulp.dest("public/dist/fonts"));
}
function tempJS() {
  return gulp
    .src(["resources/app/js/backend-temp.js", "resources/app/js/dev-temp.js"])
    .pipe(gulp.dest("public/dist/js"))
    .on("end", browserSync.reload);
}
function bundleJS() {
  return (
    gulp
      .src(jsLibs)
      .pipe(concat("libs.js"))
      .pipe(gulp.dest("public/dist/js"))
      .on("end", browserSync.reload),
    gulp
      .src(["resources/app/blocks/**/*.js", "resources/app/pages/**/*.js", "resources/app/js/main.js"])
      .pipe(concat("scripts.js"))
      .pipe(gulp.dest("public/dist/js"))
      .on("end", browserSync.reload),
    gulp
      .src(commonJsLibs)
      .pipe(concat("common.js"))
      .pipe(gulp.dest("public/dist/js"))
      .on("end", browserSync.reload)
  );
}
function faviconSvg() {
  return gulp
    .src("resources/app/favicon.svg")
    .pipe(gulp.dest("public/dist/"))
    .on("end", browserSync.reload);
}
function images() {
  return gulp
    .src("resources/app/img/**/*.*")
    .pipe(changed("public/dist/img"))
    .pipe(
      imagemin(
        [
          imageminPng(),
          imageminJpg({
            progressive: true,
            max: 85,
            min: 80,
          }),
        ],
        { verbose: true }
      )
    )
    .pipe(gulp.dest("public/dist/img"));
}
function icons() {
  return gulp
    .src("resources/app/icons/single/*.svg")
    .pipe(replace("&gt;", ">"))
    .pipe(rename({ prefix: "icon-" }))
    .pipe(
      svgSprite({
        mode: {
          symbol: {
            dest: "",
            sprite: "icons.svg",
          },
        },
        svg: {
          namespaceClassnames: false,
          xmlDeclaration: false,
          doctypeDeclaration: false,
          namespaceIDs: false,
          dimensionAttributes: false,
        },
      })
    )
    .pipe(gulp.dest("resources/app/icons/"));
}
function watch() {
  browserSync.init({
    server: {
      baseDir: "./public/dist",
    },
  });
  gulp.watch("resources/app/**/*.scss", style);
  // gulp.watch("resources/app/**/**/*.pug", html);
  gulp.watch("resources/app/img/**/*.{png,jpg,jpeg,gif,webp,svg}", gulp.series(images));
  gulp.watch("resources/app/icons/single/*.svg", gulp.series(icons));
  gulp.watch(["resources/app/**/**/*.js", "resources/app/**/*.js"], gulp.series(bundleJS, tempJS));
}

gulp.task("favicon", function (done) {
  realFavicon.generateFavicon(
    {
      masterPicture: "resources/app/favicon.svg",
      dest: "public/dist/favicon",
      iconsPath: "./favicon",
      design: {
        ios: {
          pictureAspect: "noChange",
          assets: {
            ios6AndPriorIcons: false,
            ios7AndLaterIcons: false,
            precomposedIcons: false,
            declareOnlyDefaultIcon: true,
          },
        },
        desktopBrowser: {
          design: "raw",
        },
        windows: {
          pictureAspect: "noChange",
          backgroundColor: "#da532c",
          onConflict: "override",
          assets: {
            windows80Ie10Tile: false,
            windows10Ie11EdgeTiles: {
              small: false,
              medium: true,
              big: false,
              rectangle: false,
            },
          },
        },
        androidChrome: {
          pictureAspect: "noChange",
          themeColor: "#ffffff",
          manifest: {
            display: "standalone",
            orientation: "notSet",
            onConflict: "override",
            declared: true,
          },
          assets: {
            legacyIcon: false,
            lowResolutionIcons: false,
          },
        },
        safariPinnedTab: {
          pictureAspect: "blackAndWhite",
          threshold: 10,
          themeColor: "#510094",
        },
      },
      settings: {
        scalingAlgorithm: "Mitchell",
        errorOnImageTooSmall: false,
        readmeFile: false,
        htmlCodeFile: false,
        usePathAsIs: false,
      },
      markupFile: faviconData,
    },
    function () {
      done();
    }
  );
});

gulp.task(
  "build",
  gulp.series(
    clean,
    icons,
    style,
    images,
    fontsTransfer,
    faviconSvg,
    bundleJS,
    tempJS,
    html,
    function (done) {
      done();
    }
  )
);

gulp.task(
  "prod",
  gulp.series(
    clean,
    icons,
    style,
    images,
    fontsTransfer,
    faviconSvg,
    bundleJS,
    tempJS,
    // html,
    function (done) {
      done();
    }
  )
);

gulp.task("watch:dev", gulp.series("build", gulp.parallel(watch)));

exports.style = style;
exports.html = html;
exports.bundleJS = bundleJS;
exports.tempJS = tempJS;
exports.icons = icons;
exports.fontsTransfer = fontsTransfer;
exports.images = images;
exports.watch = watch;
exports.clean = clean;

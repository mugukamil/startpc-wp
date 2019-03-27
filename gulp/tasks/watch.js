var gulp = require("gulp");
var config = require("../config");

gulp.task("watch", [
    "copy:watch",

    // 'jade:watch',
    // 'sprite:svg:watch',
    // 'sprite:png:watch',
    "svgo:watch",
    // 'list-pages:watch',
    "js:watch",
    "sass:watch"
]);

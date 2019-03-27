var gulp = require("gulp");
var runSequence = require("run-sequence");
var config = require("../config");

function build(cb) {
    runSequence(
        // "clean",
        // "sprite:svg",
        // "sprite:png",
        "svgo",
        "sass",
        // "jade",
        "js",
        "copy",
        // 'list-pages',
        cb
    );
}

gulp.task("build", function(cb) {
    build(cb);
});

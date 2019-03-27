var gulp = require("gulp");
var server = require("browser-sync").create();
var util = require("gulp-util");
var config = require("../config");

// in CL 'gulp server --open' to open current project in browser
// in CL 'gulp server --tunnel siteName' to make project available over http://siteName.localtunnel.me

gulp.task("server", () => {
    server.init(
        [
            config.dest.root + "/*.php",
            config.dest.css + "/*.css",
            config.dest.js + "/*.js",
            config.dest.img + "/**/*"
        ],
        {
            proxy: "wp.localhost:8888",
            notify: false,
            open: false
        }
    );
});

module.exports = server;

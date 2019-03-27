var util = require("gulp-util");

var destPath = ".";

var config = {
    src: {
        root: "src",
        templates: "src/templates",
        templatesData: "src/templates/data",
        pagelist: "src/index.yaml",
        sass: "src/sass",
        // path for sass files that will be generated automatically via some of tasks
        sassGen: "src/sass/generated",
        js: "src/js",
        img: "src/img",
        svg: "src/img/svg",
        icons: "src/icons",
        // path to png sources for sprite:png task
        iconsPng: "src/icons",
        // path to svg sources for sprite:svg task
        iconsSvg: "src/icons",
        // path to svg sources for iconfont task
        iconsFont: "src/icons",
        fonts: "src/fonts",
        lib: "src/lib"
    },
    dest: {
        root: destPath,
        html: destPath,
        css: destPath + "/css",
        js: destPath + "/js",
        img: destPath + "/img",
        fonts: destPath + "/fonts",
        lib: destPath + "/lib"
    },

    errorHandler: require("./util/handle-errors")
};

module.exports = config;

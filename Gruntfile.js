module.exports = function (grunt) {
    const sass = require("sass");

    // require it at the top and pass in the grunt instance
    require("time-grunt")(grunt);

    // Load all Grunt tasks
    require("jit-grunt")(grunt, {});

    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),

        browserify: {
            dev: {
                files: {
                    "assets/js/modal-window.js": "assets/src/js/modal-window.js",
                },
                options: {
                    transform: [["babelify", { presets: ["@babel/preset-env"] }]],
                    browserifyOptions: {
                        debug: true,
                    },
                },
            },
        },

        // Concat and Minify our js.
        uglify: {
            prod: {
                files: {
                    "assets/js/modal-window.min.js": "assets/js/modal-window.js",
                    "assets/js/customizer.min.js": "assets/js/customizer.js",
                    "assets/js/metabox.min.js": "assets/js/metabox.js",
                },
            },
        },

        // Compile our sass.
        sass: {
            dev: {
                options: {
                    implementation: sass,
                    outputStyle: "expanded",
                    sourceMap: false,
                },
                files: {
                    "assets/css/style.css": "assets/css/style.scss",
                    "assets/css/metabox.css": "assets/css/metabox.scss",
                },
            },
            prod: {
                options: {
                    implementation: sass,
                    outputStyle: "compressed",
                    sourceMap: false,
                },
                files: {
                    "assets/css/style.min.css": "assets/css/style.scss",
                    "assets/css/metabox.min.css": "assets/css/metabox.scss",
                },
            },
        },

        // Autoprefixer.
        autoprefixer: {
            options: {
                browsers: ["last 8 versions", "ie 8", "ie 9"],
            },
            main: {
                files: {
                    "assets/css/style.css": "assets/css/style.css",
                    "assets/css/style.min.css": "assets/css/style.min.css",
                    "assets/css/metabox.css": "assets/css/metabox.css",
                    "assets/css/metabox.min.css": "assets/css/metabox.min.css",
                },
            },
        },

        // Sorting our CSS properties.
        csscomb: {
            options: {
                config: ".csscomb.json",
            },
            main: {
                files: {
                    "assets/css/style.css": ["assets/css/style.css"],
                    "assets/css/metabox.css": ["assets/css/metabox.css"],
                },
            },
        },

        // Newer files checker
        newer: {
            options: {
                override: function (detail, include) {
                    if (detail.task === "php" || detail.task === "sass") {
                        include(true);
                    } else {
                        include(false);
                    }
                },
            },
        },

        // Watch for changes.
        watch: {
            options: {
                livereload: 35733,
                livereloadOnError: false,
                spawn: false,
            },
            scss: {
                files: ["assets/css/**/*.scss"],
                tasks: ["newer:sass:dev", "newer:sass:prod", "newer:autoprefixer:main"],
            },
            js: {
                files: ["assets/src/**/**.js"],
                tasks: ["newer:browserify:dev", "newer:uglify:prod"],
            },
        },

        // Copy the theme into the build directory
        copy: {
            build: {
                expand: true,
                src: [
                    "**",
                    "!node_modules/**",
                    "!build/**",
                    "!src/**",
                    "!omw-src/**",
                    "!.git/**",
                    "!changelog.txt",
                    "!vendor/**",
                    "!composer.json",
                    "!composer.lock",
                    "!phpcs.xml.dist",
                    "!Gruntfile.js",
                    "!package.json",
                    "!package-lock.json",
                    "!.csscomb.json",
                    "!.tern-project",
                    "!.editorconfig",
                    "!.gitignore",
                    "!.jshintrc",
                    "!.DS_Store",
                    "!*.map",
                    "!**/*.map",
                    "!**/Gruntfile.js",
                    "!**/package.json",
                    "!**/*~",
                ],
                dest: "build/<%= pkg.name %>/",
            },
        },

        // Compress build directory into <name>.zip
        compress: {
            build: {
                options: {
                    mode: "zip",
                    archive: "./build/<%= pkg.name %>.zip",
                },
                expand: true,
                cwd: "build/<%= pkg.name %>/",
                src: ["**/*"],
                dest: "<%= pkg.name %>/",
            },
        },
    });

    // Dev task
    grunt.registerTask("default", [
        "browserify:dev",
        "uglify:prod",
        "sass:dev",
        "sass:prod",
        "autoprefixer:main",
        "csscomb:main",
    ]);

    // Production task
    grunt.registerTask("build", ["copy"]);

    // Package task
    grunt.registerTask("package", ["compress"]);

    grunt.registerTask("final", [
        "browserify:dev",
        "uglify:prod",
        "sass:dev",
        "sass:prod",
        "autoprefixer:main",
        "csscomb:main",
        "copy",
        "compress"
    ]);
};

'use strict';
module.exports = function(grunt) {

    var d = new Date();

    var globalConf = {
        ruta_dist: './dist/',
        ruta_dist_dev: './dev/',
        ruta_jgTools: '../../../jgTools/dist/current/',
        ruta_web_f: '../../public/f/admin/appw/',
        ruta_web_p: '../../module/Admin/view/layout/',
        ruta_ionic_f: '../../app/admin/www/appi/',
        ruta_ionic_p: '../../app/admin/www/',
        codigo_unico: Math.floor(Math.random() * 999) + '' + d.getDate() + '' +
            Math.floor(Math.random() * 999) + '' + d.getHours() + '' +
            Math.floor(Math.random() * 999) + '' + d.getFullYear() + '' +
            Math.floor(Math.random() * 999) + '' + d.getMonth() + '' +
            Math.floor(Math.random() * 999),
        version_compilacion: d.getTime(),
    };


    // copia los css y js generados en al carpeta desarrollo

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        globalConfig: globalConf,
        watch: {
            sass: {
                files: ['app/sass/**/*.scss'],
                tasks: ['sass', 'copy:dev']
            },
            js: {
                files: ['app/js/**/*.js'],
                tasks: ['concat:app_js', 'copy:dev']
            },
            html: {
                files: ['app/views/**/*.html'],
                tasks: ['ngtemplates']
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    '.tem/css/all.css': 'app/sass/all.scss',
                    '.tem/css/core.css': 'app/sass/core.scss',
                    '.tem/css/user.css': 'app/sass/user.scss',
                    '.tem/css/iconos.css': 'app/sass/iconos.scss',
                    //'.tem/css/skin-1.css':'app/sass/skin/skin-1.scss',
                    //'.tem/css/font-md.css':'app/sass/font-md.scss'
                }
            }
        },
        cssmin: {
            my_target: {
                files: [{
                    expand: true,
                    cwd: '.tem/css',
                    src: ['**/*'], //['*.css','!*.min.css'],
                    dest: '.tem/cssmin',
                    ext: '.min.css'
                }]
            }
        },
        uglify: {
            app: {
                files: [{
                    expand: true, // required when using cwd
                    cwd: '.tem/js', // set working folder / root to copy
                    src: '**/*.js', // copy all files and subfolders
                    dest: '.tem/jsmin' // destination folder
                }]
            },
            bw: {
                files: {
                    '.tem/jsmin/app.all.js': [ // genera un archivo unico dpnde esta toda la logica del negocio
                        '.tem/plugins/angular.min.js',
                        '.tem/plugins/plugins.js',
                        '.tem/jsmin/app.js'
                    ],
                    '.tem/jsmin/app.js': [ // genera un archivo de la logica del negocio sin angularjs
                        '.tem/plugins/plugins.js',
                        '.tem/jsmin/app.js'
                    ],
                    '.tem/jsmin/jsapi.js': [ // genera un archivo de la logica del negocio sin angularjs
                        '.tem/plugins/jsapi.min.js'

                    ],
                }
            }

        },
        concat: {
            app_js: {
                options: {
                    seperator: ";"
                },
                files: {
                    '.tem/js/app.js': ['app/js/app.js', 'app/js/appController.js', './dev/js/template.js'],
                    '.tem/js/dashboard.js': ['app/js/dashboard/*.js'],
                    '.tem/js/entity/user.js': ['app/js/entity/user/*.js'],
                    '.tem/js/entity/identity-type.js': ['app/js/entity/identity-type/*.js'],
                    '.tem/js/entity/phone-type.js': ['app/js/entity/phone-type/*.js'],
                    '.tem/plugins/plugins.js': [
                        'bower_components/angular-touch/angular-touch.min.js',
                        'bower_components/angular-messages/angular-messages.min.js',
                        'bower_components/oclazyload/dist/ocLazyLoad.min.js',
                        'bower_components/angular-ui-router/release/angular-ui-router.min.js',
                        './plugins/jgtools/jg-tools.min.js'
                    ],
                    '.tem/plugins/angular.min.js': ['bower_components/angular/angular.js'],
                    '.tem/plugins/jsapi.min.js': ['./plugins/jgtools/jsapi.min.js'],
                }
            },
            dist_css: {
                options: {
                    process: function(src, filepath) {
                        console.log('saludos')
                            //grunt.file.write('./nconcat/css.php','<?php return array( "app"=>"'+globalConf.codigo_unico+'");');
                        return src;
                    },
                },
                files: {
                    '<%= globalConfig.ruta_dist  %>css/app/<%= globalConfig.codigo_unico %>.min.css': [
                        //'bower_components/angular-material/angular-material.min.css',
                        //'bower_components/components-font-awesome/css/font-awesome.min.css',
                        '.tem/css/app.min.css'
                    ]
                }
            },
            dist_js: {
                options: {
                    process: function(src, filepath) {
                        //grunt.file.write('./nconcat/app.php','<?php return array( "app"=>"'+globalConf.codigo_unico+'");');
                        //grunt.file.write('./nconcat/app.php','<?php return array( "app"=>"'+globalConf.codigo_unico+'");');
                        return src;
                    },
                },
                files: {
                    '<%= globalConfig.ruta_dist  %>js/app.all.js': [
                        '.tem/jsbw/bw.min.js',
                        //'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
                        //'bower_components/angular-ui-mask/dist/mask.min.js',
                        //'bower_components/angular/angular.min.js',
                        //'bower_components/angular-animate/angular-animate.min.js',
                        //'bower_components/angular-aria/angular-aria.min.js',
                        //'bower_components/angular-resource/angular-resource.min.js',
                        //'bower_components/angular-route/angular-route.min.js',
                        //'bower_components/angular-material/angular-material.min.js',
                        '.tem/jsmin/app.js'
                    ],
                    '<%= globalConfig.ruta_dist  %>js/jsapi.js': ['./plugins/jgtools/jsapi.min.js'],
                }
            },
            bld:{
                options: {
                    seperator: ""
                },
                files: {
                    '<%= globalConfig.ruta_web_p  %>/layout.phtml': ['<%= globalConfig.ruta_dist  %>web.html'],
                    '<%= globalConfig.ruta_ionic_p  %>/index.html': ['<%= globalConfig.ruta_dist  %>ionic.html'],
                }
            }
        },
        jshint: {
            options: {
                "bitwise": true,
                "browser": true,
                "curly": true,
                "eqeqeq": true,
                "esnext": true,
                "latedef": true,
                "noarg": true,
                "node": true,
                "strict": true,
                "undef": true,
                "unused": true,
                "globals": {
                    "angular": false
                },
                reporter: require('jshint-stylish')
            },
            all: {
                src: [
                    '.tem/app.js', '.tem/app.min.js'
                ]
            },
            unit: {
                src: [
                    'app/js/**/*.js' //'app/js/{,*/}*.js'
                ]
            }
        },
        clean: {
            dist: {
                options: {
                    force: true,
                },
                files: [{
                    dot: true,
                    src: [
                        '<%= globalConfig.ruta_dist  %>', '.tem','<%= globalConfig.ruta_web_f  %>','<%= globalConfig.ruta_ionic_f  %>'
                    ]
                }]
            },
            dev: {
                options: {
                    force: true,
                },
                files: [{
                    dot: true,
                    src: [
                        '<%= globalConfig.ruta_dist_dev  %>', '.tem'
                    ]
                }]
            },
            tem: {
                options: {
                    force: true,
                },
                files: [{
                    dot: true,
                    src: [
                        '.tem'
                    ]
                }]
            },
        },
        copy: {
            plg:{
                files: [
                    {
                        cwd: '<%= globalConfig.ruta_jgTools  %>', // set working folder / root to copy
                        src: '**/*', // copy all files and subfolders
                        dest: './plugins/jgtools', // destination folder
                        expand: true // required when using cwd
                    },
                ],
            },
            dist: {
                files: [{
                    expand: true,
                    flatten: true,
                    src: ['./plugins/jgtools/skin-1/*'],
                    dest: '<%= globalConfig.ruta_dist  %>app/<%= globalConfig.codigo_unico  %>/css/skin-1',
                    filter: 'isFile'
                }, {
                    expand: true,
                    flatten: true,
                    src: ['.tem/cssmin/*'],
                    dest: '<%= globalConfig.ruta_dist  %>app/<%= globalConfig.codigo_unico  %>/css/',
                    filter: 'isFile'
                }, {
                    cwd: '.tem/jsmin', // set working folder / root to copy
                    src: '**/*', // copy all files and subfolders
                    dest: '<%= globalConfig.ruta_dist  %>app/<%= globalConfig.codigo_unico  %>/js/', // destination folder
                    expand: true
                }, {
                    expand: true,
                    flatten: true,
                    src: ['bower_components/material-design-icons/iconfont/*'],
                    dest: '<%= globalConfig.ruta_dist  %>app/<%= globalConfig.codigo_unico  %>/font/material-design-icons',
                    filter: 'isFile'
                }, ],
            },
            dev: {
                files: [
                    // includes files within path
                    {
                        expand: true,
                        flatten: true,
                        src: ['.tem/css/*'],
                        dest: '<%= globalConfig.ruta_dist_dev  %>css/',
                        filter: 'isFile'
                    },
                    //{expand: true,flatten: true, src: ['.tem/js/*'], dest: '<%= globalConfig.ruta_dist_dev  %>js/', filter: 'isFile'},
                    {
                        cwd: '.tem/js', // set working folder / root to copy
                        src: '**/*', // copy all files and subfolders
                        dest: '<%= globalConfig.ruta_dist_dev  %>js/', // destination folder
                        expand: true // required when using cwd
                    }, {
                        cwd: '.tem/plugins', // set working folder / root to copy
                        src: '**/*', // copy all files and subfolders
                        dest: '<%= globalConfig.ruta_dist_dev  %>plugins/', // destination folder
                        expand: true // required when using cwd
                    },
                ],
            },
            bw: {
                files: [
                    // includes files within path
                    //{expand: true,flatten: true, src: ['bower_components/angular/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-animate/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-animate', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-touch/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-touch', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-messages/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-messages', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-aria/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-aria', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-resource/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-resource', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-route/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-route', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-ui-router/release/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-ui-router', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/oclazyload/dist/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/oclazyload/', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-material/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-material', filter: 'isFile'},
                    {
                        expand: true,
                        flatten: true,
                        src: ['bower_components/material-design-icons/iconfont/*'],
                        dest: '<%= globalConfig.ruta_dist_dev  %>font/material-design-icons',
                        filter: 'isFile'
                    },
                    //{expand: true,flatten: true, src: ['bower_components/jquery/dist/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/jquery', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-ui-mask/dist/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-ui-mask', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/bootstrap/dist/css/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/bootstrap/css', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/bootstrap/fonts', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/bootstrap/dist/js/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/bootstrap/js', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/font-awesome/css/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/font-awesome/css', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/font-awesome/fonts/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/font-awesome/fonts', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['plugins/toolsjj/2.0.1/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/toolsjj/', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['bower_components/angular-bootstrap/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-bootstrap', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['../../../helpers/jgTools/dist/current/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/jgtools', filter: 'isFile'},
                    {
                        expand: true,
                        flatten: true,
                        src: ['./plugins/jgtools/skin-1/*'],
                        dest: '<%= globalConfig.ruta_dist_dev  %>css/skin-1',
                        filter: 'isFile'
                    },

                    //{expand: true,flatten: true, src: ['../../../helpers/js/jtools/jtools-service-angularjs/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/jtools/service-angularjs', filter: 'isFile'},
                    //{expand: true,flatten: true, src: ['../../../helpers/js/jtools/jtools-google-chart-angularjs/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/jtools/google-chart-angularjs', filter: 'isFile'},
                    //{
                    //    cwd: '../../../helpers/jgTools/dist',  // set working folder / root to copy
                    //    src: '**/*',           // copy all files and subfolders
                    //    dest: '<%= globalConfig.ruta_dist_dev  %>plugin/jgtools/',    // destination folder
                    //    expand: true           // required when using cwd
                    //},
                ],
            },
            bld:{
                files:[
                    {
                        expand: true,
                        cwd: '<%= globalConfig.ruta_dist  %>app/',
                        src: '**/*',  
                        dest: '<%= globalConfig.ruta_web_f  %>',
                    },
                    {
                        expand: true,
                        cwd: '<%= globalConfig.ruta_dist  %>app/',
                        src: '**/*',  
                        dest: '<%= globalConfig.ruta_ionic_f  %>',
                    },
                ]
                
            },
        },
        ngtemplates: {
            app: {
                src: 'app/views/**/*.html',
                dest: './dev/js/template.js',
                options: {
                    prefix: '/',
                    htmlmin: {
                        collapseBooleanAttributes: true,
                        collapseWhitespace: true,
                        removeAttributeQuotes: true,
                        removeComments: true, // Only if you don't use comment directives! 
                        removeEmptyAttributes: true,
                        removeRedundantAttributes: true,
                        removeScriptTypeAttributes: true,
                        removeStyleLinkTypeAttributes: true
                    },
                    bootstrap: function(module, script) {
                        return "(function() {" +
                            "angular" +
                            ".module('Admin.template', [])" +
                            ".run(['$templateCache', function($templateCache) {" +
                            script +
                            "}]);" +
                            "})();"
                    }
                }
            }
        },
        htmlmin: { // Task
            app: { // Target
                options: { // Target options
                    removeComments: true,
                    collapseWhitespace: true
                },
                files: [{
                        expand: true,
                        cwd: './app/views/',
                        src: ['**/*.html'],
                        dest: '.tem/htmlmin/'
                    }]
                    //files: { // Dictionary of files
                    //    'dist/index.html': 'src/index.html', // 'destination': 'source'
                    //    'dist/contact.html': 'src/contact.html'
                    //}
            },
            dist: { // Target
                options: { // Target options
                    removeComments: true,
                    collapseWhitespace: true
                },
                files: [{
                    expand: true,
                    cwd: '.tem/html/',
                    src: ['**/*.html'],
                    dest: '<%= globalConfig.ruta_dist  %>'
                }]
            }
        },
        htmlbuild: {
            dist: {
                src: './html/*.html',
                dest: '.tem/html',
                options: {
                    beautify: false,
                    prefix: '',
                    relative: true,
                    data: {
                        version: "<%= globalConfig.version_compilacion  %>",
                        codigo_unico: "<%= globalConfig.codigo_unico  %>",
                    },
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-angular-templates');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-html-build');


    grunt.registerTask('versiondist', 'genera un verisonador para la distribucion', function() {

        //grunt.file.delete('<%= globalConfig.ruta_dist  %>js/app.js');


        //var fileVersion = './nconcat/version';
        //var version = 0;
        //if (grunt.file.exists(fileVersion)) {
        //    version = parseInt(grunt.file.read(fileVersion));
        //    if (isNaN(version)) {
        //        version = 0;
        //    }
        //}
        //version++;
        //grunt.file.write(fileVersion, version);
        //grunt.file.write('./nconcat/app.php', '<?php return array("app"=>"' + globalConf.codigo_unico + '", "version"=>"' + version + '");');

    });

    grunt.registerTask('versiondev', 'genera un verisonador para el desarrollo', function() {
        var fileVersion = './nconcat/versiondev';
        var version = 0;
        if (grunt.file.exists(fileVersion)) {
            version = parseInt(grunt.file.read(fileVersion));
            if (isNaN(version)) {
                version = 0;
            }
        }
        version++;
        grunt.file.write(fileVersion, version);
        grunt.file.write('./nconcat/appdev.php', '<?php return array("app"=>"' + globalConf.codigo_unico + '", "version"=>"' + version + '");');
    });


    grunt.registerTask('lint', [
        'jshint:unit', // verifica la sintaxis en cada archivo js de lacarpeta app/js
    ]);

    grunt.registerTask('template', [
        'ngtemplates', // verifica la sintaxis en cada archivo js de lacarpeta app/js
    ]);

    grunt.registerTask('htmin', [
        'htmlmin', // verifica la sintaxis en cada archivo js de lacarpeta app/js
    ]);

    grunt.registerTask('plugins', [
        'copy:plg',
    ]);

    grunt.registerTask('build', [

        //'jshint:unit',        // verifica la sintaxis en cada archivo js de lacarpeta app/js

        'clean:dist', // borra todo los archivos del public/f
        'ngtemplates', // genera un archivo js de plantillas de todas las vistas
        'concat:app_js', // une todos los archivos de la carpeta app/js
        'uglify:app', // minimiza el archivo temporal 
        'uglify:bw',
        //'jshint',             // revisa todo la sintaxis js
        //'concat:dist_js', // genera un archivo unico de distribucion


        'sass', // compila el sass y lo copia dentro de la carpeta css 
        'cssmin', // minimiza el archivo temporal
        //'concat:dist_css',    // genera un archivo unico de distribucion

        'copy:dist', // copia las fuentes que sean necesarias en produccion
        'htmlbuild',
        'htmlmin:dist',
        'copy:bld',
        'concat:bld'
        //'versiondist'
    ]);

    grunt.registerTask('default', [
        //'clean:tem',
        'clean:dev', // borra todo los archivos del public/f
        'copy:bw', // copia todos los archivos generados por bower en al carpeta desarrollo

        'sass', // compila el sass y lo copia dentro de la carpeta css 
        'concat:app_js', // une todos los archivos de la carpeta app/js
        'copy:dev', // copia los css y js generados en al carpeta desarrollo
        'ngtemplates', // genera un archivo js de plantillas de todas las vistas
        'versiondev',
        'watch' // se pone a escuchar posibles cambios en los archivos

    ]);


};

/**
* modo desarrollo y produccion
** grunt :   borra los temporales y copia los archivos en diferentes carpetas para que se pueda testear,
            constantemente esta escuchando cambios en el js o css y los copia los archivos cambiados
** grunt lint : revisa la sintaxis de los archivos js
** grunt built : genera los archivos compilados y minificados de js y css. 
*/
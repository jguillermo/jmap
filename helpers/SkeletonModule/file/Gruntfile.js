'use strict';
module.exports = function (grunt) {

    var d = new Date();

    var globalConf = {
        ruta_dist: './../../../public/f/skeleton-module/',
        ruta_dist_dev: './../../../public/f/skeleton-module-dev/',
        codigo_unico:Math.floor(Math.random()*999)+''+d.getDate()+''+
                    Math.floor(Math.random()*999)+''+d.getHours()+''+
                    Math.floor(Math.random()*999)+''+d.getFullYear()+''+
                    Math.floor(Math.random()*999)+''+d.getMonth()+''+
                    Math.floor(Math.random()*999)
    };


    // copia los css y js generados en al carpeta desarrollo

    grunt.initConfig({
        pkg:grunt.file.readJSON('package.json'),
        globalConfig: globalConf,
        watch:{
            sass:{
                files:['app/sass/**/*.scss'],
                tasks:['sass','copy:dev']
            },
            js:{
                files:['app/js/**/*.js'],
                tasks:['concat:app_js','copy:dev']
            }
        },
        sass:{
            dist:{
                options: {        
                    style: 'expanded'
                },
                files:{
                    '.tem/css/app.css':'app/sass/app.scss',
                    '.tem/css/skin-1.css':'app/sass/skin/skin-1.scss',
                    //'.tem/css/font-md.css':'app/sass/font-md.scss'
                }
            }
        },
        cssmin:{
        	my_target:{
        		files:[{
        			expand:true,
        			cwd:'.tem/css',
        			src:['*.css','!*.min.css'],
        			dest:'.tem/css',
        			ext:'.min.css'
        		}]
        	}
        },
        uglify: {
        	options:{
        		
        	},
            my_target: {
                files: {
                    '.tem/js/app.min.js': [
                      '.tem/js/app.js'
                    ]
                }
            }
        },
        concat:{
        	app_js:{
                options: {
                	seperator:";"
                },
                files: {
                    '.tem/js/app.js': ['app/js/**/*.js'],
                }
        	},
            dist_css:{
                options: {
                    process: function(src, filepath) {
                        
                      grunt.file.write('./nconcat/css.php','<?php return array( "app"=>"'+globalConf.codigo_unico+'");');
                      return src;
                    },
                },
                files: {
                    '<%= globalConfig.ruta_dist  %>css/app<%= globalConfig.codigo_unico %>.min.css': [
                    //'bower_components/angular-material/angular-material.min.css',
                    //'bower_components/components-font-awesome/css/font-awesome.min.css',
                    '.tem/css/app.min.css'],
                    '<%= globalConfig.ruta_dist  %>css/skin-1-<%= globalConfig.codigo_unico %>.min.css': ['.tem/css/skin-1.min.css'],
                }
            },
            dist_js:{
                options: {
                    process: function(src, filepath) {
                      grunt.file.write('./nconcat/js.php','<?php return array( "app"=>"'+globalConf.codigo_unico+'");');
                      return src;
                    },
                },
                files: {
                    '<%= globalConfig.ruta_dist  %>js/app<%= globalConfig.codigo_unico %>.min.js': [
                    'bower_components/angular-ui-router/release/angular-ui-router.min.js',
                    'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
                    //'bower_components/angular-ui-mask/dist/mask.min.js',
                    //'bower_components/angular/angular.min.js',
                    //'bower_components/angular-animate/angular-animate.min.js',
                    //'bower_components/angular-aria/angular-aria.min.js',
                    //'bower_components/angular-resource/angular-resource.min.js',
                    //'bower_components/angular-route/angular-route.min.js',
                    //'bower_components/angular-material/angular-material.min.js',
                    '.tem/js/app.min.js'],
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
                    '.tem/app.js','.tem/app.min.js'
                ]
            },
            unit: {
                src: [
                    'app/js/**/*.js'//'app/js/{,*/}*.js'
                ]
            }
        },
        clean:{
            dist: {
                    options:{
                      force:true,  
                    },
                  files: [{
                    dot: true,
                    src: [
                      '<%= globalConfig.ruta_dist  %>','.tem'
                    ]
                  }]
            },
            dev: {
                options:{
                      force:true,  
                    },
                  files: [{
                    dot: true,
                    src: [
                      '<%= globalConfig.ruta_dist_dev  %>','.tem'
                    ]
                  }]
            },
            tem: {
                options:{
                      force:true,  
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
            dist: {
                files: [
                  // includes files within path
                  //{expand: true,flatten: true, src: ['bower_components/components-font-awesome/fonts/*'], dest: '<%= globalConfig.ruta_dist  %>fonts', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['.tem/css/skin-1.min.css'], dest: '<%= globalConfig.ruta_dist  %>css/', filter: 'isFile'},
                  //{expand: true,flatten: false, cwd: '.tem/css/',src: 'skin-1.min.css',dest: '<%= globalConfig.ruta_dist  %>css'}
                ],
            },
            dev: {
                files: [
                  // includes files within path
                  {expand: true,flatten: true, src: ['.tem/css/*'], dest: '<%= globalConfig.ruta_dist_dev  %>css/', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['.tem/js/*'], dest: '<%= globalConfig.ruta_dist_dev  %>js/', filter: 'isFile'},

                ],
            },
            bw: {
                files: [
                  // includes files within path
                  {expand: true,flatten: true, src: ['bower_components/angular/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/angular-animate/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-animate', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/angular-touch/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-touch', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/angular-messages/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-messages', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['bower_components/angular-aria/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-aria', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['bower_components/angular-resource/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-resource', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['bower_components/angular-route/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-route', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/angular-ui-router/release/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-ui-router', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['bower_components/angular-material/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-material', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['bower_components/material-design-icons/iconfont/*'], dest: '<%= globalConfig.ruta_dist_dev  %>font/material-design-icons', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/jquery/dist/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/jquery', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/angular-ui-mask/dist/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-ui-mask', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/bootstrap/dist/css/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/bootstrap/css', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/bootstrap/fonts', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['bower_components/bootstrap/dist/js/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/bootstrap/js', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/font-awesome/css/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/font-awesome/css', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/font-awesome/fonts/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/font-awesome/fonts', filter: 'isFile'},
                  //{expand: true,flatten: true, src: ['plugins/toolsjj/2.0.1/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/toolsjj/', filter: 'isFile'},
                  {expand: true,flatten: true, src: ['bower_components/angular-bootstrap/*'], dest: '<%= globalConfig.ruta_dist_dev  %>plugin/angular-bootstrap', filter: 'isFile'},
                ],
            },
        },
    });


    

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    
    
    grunt.registerTask('lint',[
        'jshint:unit',        // verifica la sintaxis en cada archivo js de lacarpeta app/js
    ]);

    grunt.registerTask('build',[

        //'jshint:unit',        // verifica la sintaxis en cada archivo js de lacarpeta app/js
        
        'clean:dist',              // borra todo los archivos del public/f

        'concat:app_js',      // une todos los archivos de la carpeta app/js
        'uglify',             // minimiza el archivo temporal 
        //'jshint',             // revisa todo la sintaxis js
        'concat:dist_js',     // genera un archivo unico de distribucion


        'sass',               // compila el sass y lo copia dentro de la carpeta css 
        'cssmin',             // minimiza el archivo temporal
        'concat:dist_css',    // genera un archivo unico de distribucion
      
        'copy:dist'          // copia las fuentes que sean necesarias en produccion
    ]);

    grunt.registerTask('default',[
        //'clean:tem',
        'clean:dev',          // borra todo los archivos del public/f
        'copy:bw',            // copia todos los archivos generados por bower en al carpeta desarrollo

        'sass',               // compila el sass y lo copia dentro de la carpeta css 
        'concat:app_js',      // une todos los archivos de la carpeta app/js
        'copy:dev',           // copia los css y js generados en al carpeta desarrollo

        'watch'               // se pone a escuchar posibles cambios en los archivos
        ]);


};

/**
* modo desarrollo y produccion
** grunt :   borra los temporales y copia los archivos en diferentes carpetas para que se pueda testear,
            constantemente esta escuchando cambios en el js o css y los copia los archivos cambiados
** grunt lint : revisa la sintaxis de los archivos js
** grunt built : genera los archivos compilados y minificados de js y css. 
*/
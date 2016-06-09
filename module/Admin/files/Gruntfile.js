'use strict';
module.exports = function (grunt) {

    var d = new Date();

    var globalConf = {
        ruta_dist: './../../../public/f/admin/',
        ruta_dist_dev: './../../../public/f/admin-dev/',
        ruta_app: '../../../helpers/admin-template/dist/',
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
                  {
                      cwd: '<%= globalConfig.ruta_app  %>',  // set working folder / root to copy
                      src: '**/*',           // copy all files and subfolders
                      dest: '<%= globalConfig.ruta_dist  %>/app<%= globalConfig.codigo_unico %>/',    // destination folder
                      expand: true  
                    },
                ],
            }
            
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    
    grunt.registerTask('versiondist','genera un verisonador para la distribucion',function(){
          var fileVersion='./nconcat/version';
          var version = 0;
          if (grunt.file.exists(fileVersion)) {
            version = parseInt(grunt.file.read(fileVersion));
            if(isNaN(version)){
              version = 0;
            }
          }
          version++;
          grunt.file.write(fileVersion,version);

          grunt.file.write('./nconcat/app.php','<?php return array("app"=>"'+globalConf.codigo_unico+'", "version"=>"'+version+'");');

    });

    grunt.registerTask('default',[
        'clean:dist',              // borra todo los archivos del public/f
        'copy:dist',         // copia las fuentes que sean necesarias en produccion
        'versiondist'
        ]);
};

/**
* modo desarrollo y produccion
** grunt :   borra los temporales y copia los archivos en diferentes carpetas para que se pueda testear,
            constantemente esta escuchando cambios en el js o css y los copia los archivos cambiados
** grunt lint : revisa la sintaxis de los archivos js
** grunt built : genera los archivos compilados y minificados de js y css. 
*/
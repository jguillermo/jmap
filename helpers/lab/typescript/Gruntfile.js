'use strict';
module.exports = function(grunt) {

  var d = new Date();

  var globalConf = {
    ruta_dist: './dist/',
    ruta_dist_dev: './dev/',
    codigo_unico: Math.floor(Math.random() * 999) + '' + d.getDate() + '' +
      Math.floor(Math.random() * 999) + '' + d.getHours() + '' +
      Math.floor(Math.random() * 999) + '' + d.getFullYear() + '' +
      Math.floor(Math.random() * 999) + '' + d.getMonth() + '' +
      Math.floor(Math.random() * 999)
  };


  // copia los css y js generados en al carpeta desarrollo

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    globalConfig: globalConf,
    watch: {
      ts: {
        files: ['./pruebas/**/*.ts'],
        tasks: ['typescript']
      },
    },
    uglify: {
      app: {
        files: [{
          expand: true, // required when using cwd
          cwd: '.tem/js', // set working folder / root to copy
          src: '**/*.js', // copy all files and subfolders
          dest: '.tem/jsmin' // destination folder
        }]
      }
    },
    typescript: {
      base: {
        src: ['./pruebas/**/*.ts'],
        dest: './js/files',
        options: {
          module: 'amd', //or commonjs 
          target: 'es5', //or es3 
          basePath: 'hola/ruta',
          sourceMap: true,
          declaration: true
        }
      }
    },
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-typescript');



  grunt.registerTask('default', [
    'typescript',
    'watch'
  ]);


};

/**
* modo desarrollo y produccion
** grunt :   borra los temporales y copia los archivos en diferentes carpetas para que se pueda testear,
            constantemente esta escuchando cambios en el js o css y los copia los archivos cambiados
** grunt lint : revisa la sintaxis de los archivos js
** grunt built : genera los archivos compilados y minificados de js y css. 
*/
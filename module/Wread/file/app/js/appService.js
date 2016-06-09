(function() {
    'use strict';

    localStorage.removeItem('appch');

    function cacheListService($http, $q, md5) {

        //console.log('cache service');

        function getMemory(ruta) {
            var cacheList = {};
            if (localStorage.appch) {
                cacheList = JSON.parse(localStorage.appch);
            }

            if (typeof cacheList[ruta] !== "undefined") {

                return cacheList[ruta];
            } else {

                return '';
            }
        }

        function setMemory(data, list) {
            var cacheList = {};
            if (localStorage.appch) {
                cacheList = JSON.parse(localStorage.appch);
            }
            cacheList[ruta] = {
                data: list
            };
            localStorage.appch = angular.toJson(cacheList);
        }

        // almacena los resultados en un solo local storage llamado appch
        this.getDatasdfsdf = function(ruta) {
            var list = getMemory(ruta);
            if (list === '') {
                return $http.post(ruta).then(function(rpta) {
                    setMemory(ruta, rpta.data);
                    return rpta;
                });
            } else {
                return $q.when(list);
            }
        };



        function getMemoryStorage(ruta_name) {

            if (localStorage[ruta_name]) {
                return JSON.parse(localStorage[ruta_name]);
            } else {
                return false;
            }
        }
        function setMemoryStorage(ruta_name, data) {

            //localStorage[ruta_name] = angular.toJson({data:data});
            localStorage[ruta_name] = JSON.stringify({
                data: data
            });

        }
        // almacena los datos en diferentes losca storages, nombrados por el nombre
        this.getOnceDataLocalStorage = function(ruta, data, prefix) {
            prefix = prefix || '';
            data = data || {};

            //console.log('------------------------------');
            //console.log(prefix);
            //console.log(md5.createHash(prefix));
            //console.log('-------------------------');
            //console.log(ruta);
            //console.log(md5.createHash(ruta));
            //console.log('-------------------------------');

            var ruta_name = md5.createHash(prefix) + md5.createHash(ruta);

            var dataStorage = getMemoryStorage(ruta_name);
            if (dataStorage === false) {
                return $http.post(ruta, data).then(function(rpta) {

                    setMemoryStorage(ruta_name, rpta.data);

                    return $q.when(rpta);
                });
            } else {
                return $q.when(dataStorage);
            }
        };
    }

    angular
        .module('App')
        .service('cacheListService', ['$http', '$q', 'md5', cacheListService]);


})();



(function() {
    'use strict';


    

    function cacheIndexedDBService($http, $q, md5) {

        var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
        var dataBase = null;
        //console.log('indexDB');

        function init() {

            var defered = $q.defer();
            

            //if(dataBase !== null) {
            //    defered.resolve(true);
            //}

            dataBase = indexedDB.open("listdataurl", 1);

            dataBase.onupgradeneeded = function(e) {

                var active = dataBase.result;
                var object = active.createObjectStore('tbl_cache', {
                    keyPath: 'id',
                    autoIncrement: false
                });


            };

            dataBase.onsuccess = function(e) {
                //alert('Database loaded');
                defered.resolve(true);
            };

            dataBase.onerror = function(e) {
                alert('Error loading database');
                defered.reject(false);
            };

            return defered.promise;
        }



        function putData(id, data_url) {



            var defered = $q.defer();
            

            init().then(function() {


                var active = dataBase.result;
                var data = active.transaction(["tbl_cache"], "readwrite");
                var object = data.objectStore("tbl_cache");

                var request = object.put({
                    id: id,
                    data: data_url
                });

                request.onerror = function(e) {
                    console.log(request.error.name + ' - ' + request.error.message);
                    defered.reject(request.error.name);
                };

                data.oncomplete = function(e) {
                    //console.log('Object successfully added');
                    defered.resolve(true);
                };

            });

            return defered.promise;
        }

        function getData(id) {

            var defered = $q.defer();
            

            init().then(function() {

                var active = dataBase.result;
                var data = active.transaction(["tbl_cache"], "readonly");
                var object = data.objectStore("tbl_cache");

                var request = object.get(id);

                request.onsuccess = function() {
                    defered.resolve(request.result);
                };

            });

            return defered.promise;
        }

        // almacena los datos en diferentes losca storages, nombrados por el nombre
        this.getIndexUrl = function(ruta, data, prefix) {

            var defered = $q.defer();
            


            prefix = prefix || '';
            data = data || {};
            var ruta_name = md5.createHash(prefix) + md5.createHash(ruta);
            getData(ruta_name).then(function(result) {
                //console.log(result);
                if (result === undefined) {
                    $http.post(ruta, data).then(function(rpta) {
                        putData(ruta_name, rpta.data).then(function() {
                            defered.resolve(rpta);
                        });
                    });
                } else {
                    defered.resolve(result);
                }
            });

            return defered.promise;

        };
    }

    angular
        .module('App')
        .service('cacheIndexedDBService', ['$http', '$q', 'md5', cacheIndexedDBService]);


})();
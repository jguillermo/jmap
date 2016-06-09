(function() {
    'use strict';

    localStorage.removeItem('admch');

    function cacheListService($http, $q) {

        function getMemory(ruta) {
            var cacheList = {};
            if (localStorage.admch) {
                cacheList = JSON.parse(localStorage.admch);
            }

            if (typeof cacheList[ruta] !== "undefined") {

                return cacheList[ruta];
            } else {

                return '';
            }
        }

        function setMemory(ruta, list) {
            var cacheList = {};
            if (localStorage.admch) {
                cacheList = JSON.parse(localStorage.admch);
            }
            cacheList[ruta] = {
                data: list
            };
            localStorage.admch = angular.toJson(cacheList);
        }

        this.get = function(ruta) {
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
    }

    angular
        .module('Admin')
        .service('cacheListService', ['$http', '$q', cacheListService]);


})();
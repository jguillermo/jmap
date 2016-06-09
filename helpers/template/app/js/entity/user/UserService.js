(function() {
    'use strict';

    function UserService($http, ADM_ROUTES,cacheListService) {
        return {
            getList: function() {
                return $http.post(ADM_ROUTES.base_url + 'user/list');
            },
            search: function(data) {
                return $http.post(ADM_ROUTES.base_url + 'user/search', data);
            },
            getByIdE: function(id) {
                return $http.post(ADM_ROUTES.base_url + 'user/get-by-id', {id:id});
            },
            phoneEntityBlock: function() {
                return cacheListService.get(ADM_ROUTES.base_url + 'user/phone-entity-block');
            },
            byIdentityType: function() {
                return $http.post(ADM_ROUTES.base_url + 'user/list-identity-type');
            }
        };
    }
    angular
        .module('Admin.User')
        .service('userService', ['$http', 'ADM_ROUTES','cacheListService', UserService]);


})();
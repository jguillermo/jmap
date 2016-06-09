(function() {
    'use strict';

    function EntIdentityTypeService($http, ADM_ROUTES, cacheListService) {
        return {
            getAllList: function() {
                return cacheListService.get(ADM_ROUTES.base_url + 'identity-type/list-all');//$http.post(ADM_ROUTES.base_url + 'identity-type/list-all');
            }
        };
    }
    angular
        .module('Entity.IdentityType')
        .service('entIdentityTypeService', ['$http', 'ADM_ROUTES','cacheListService', EntIdentityTypeService]);


})();
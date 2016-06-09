(function() {
    'use strict';

    function EntPhoneTypeService(ADM_ROUTES, cacheListService) {
        return {
            getAllList: function() {
                return cacheListService.get(ADM_ROUTES.base_url + 'phone-type/list-all');
            }
        };
    }
    angular
        .module('Entity.PhoneType')
        .service('entPhoneTypeService', ['ADM_ROUTES','cacheListService', EntPhoneTypeService]);


})();
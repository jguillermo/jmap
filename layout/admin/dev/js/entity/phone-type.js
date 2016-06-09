(function() {
    'use strict';
    angular
        .module('Entity.PhoneType', []);
})();
(function() {
    'use strict';

    function EntPhoneTypeService(ADMINCONFIG, jgsJsonpServices) {
        return {
            getAllList: function() {
                return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'phone-type/list-all');
            }
        };
    }
    angular
        .module('Entity.PhoneType')
        .service('entPhoneTypeService', ['ADMINCONFIG','jgsJsonpServices', EntPhoneTypeService]);


})();
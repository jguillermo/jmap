(function() {
    'use strict';

    function EntIdentityTypeService( ADMINCONFIG, jgsJsonpServices) {
        return {
            getAllList: function() {
                // se deberia guardar esta informaciom por motivo de tiemp no se guarda
                return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'identity-type/list-all'); //$http.post(ADMINCONFIG.base_url + 'identity-type/list-all');
            }
        };
    }
    angular
        .module('Entity.IdentityType')
        .service('entIdentityTypeService', [
             'ADMINCONFIG', 'jgsJsonpServices', 
            EntIdentityTypeService]);


})();
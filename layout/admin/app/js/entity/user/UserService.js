(function() {
    'use strict';

    function UserService(ADMINCONFIG, jgsJsonpServices) {

        this.getList = function() {
            return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'user/lista');
        }
        this.search = function(data) {
            return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'user/search',data);
        }
        this.getByIdE = function(id) {
            return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'user/get-by-id',{id:id});
        }
        this.phoneEntityBlock = function() {
            return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'user/phone-entity-block');
            //return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'user/phone-entity-block?callback=JSON_CALLBACK');
        }
        this.byIdentityType = function() {
            return jgsJsonpServices.jsonp(ADMINCONFIG.base_url + 'user/list-identity-type');
        }

    }
    angular
        .module('Admin.User')
        .service('userService', [
            'ADMINCONFIG', 'jgsJsonpServices',
            UserService
        ]);


})();
(function() {
    'use strict';
    angular
        .module('Admin.User', [])
        .config(['$stateProvider', 'ADM_ROUTES', function($stateProvider, ADM_ROUTES) {
            $stateProvider
                .state('sis.user_list', {
                    url: "/user_list",
                    templateUrl: ADM_ROUTES.base_url + 'user/lista',
                    controller: 'UserCtrl',
                    data: {
                        pageTitle: 'Usuario'
                    }
                })
                .state('sis.user_editar', {
                    url: "/user_editar/:userID",
                    templateUrl: ADM_ROUTES.base_url + 'user/edit-new',
                    controller: 'UserEditNewCtrl',
                    data: {
                        pageTitle: 'Editar Usuario'
                    }
                });
        }]);
})();
(function() {
    'use strict';
    angular.module('App', [
            'ngAnimate',
            'ngTouch',
            'ngMessages',
            'ui.bootstrap',
            'ui.router',
            'App.config',
            'App.Dashboard'
        ])
        .config(['$urlRouterProvider','$stateProvider', 'ADM_ROUTES', function($urlRouterProvider,$stateProvider, ADM_ROUTES) {
            $urlRouterProvider.otherwise("/app/dashboard");
            $stateProvider
                .state('app', {
                    abstract: true,
                    url: "/app",
                    templateUrl: ADM_ROUTES.base_url + 'app/layout'
                });
        }]);
})();

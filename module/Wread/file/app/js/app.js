(function() {
    'use strict';
    angular.module('App', [
            'ngAnimate',
            'ngTouch',
            'ngMessages',
            'ui.bootstrap',
            'ui.router',
            'angular-md5',
            'App.config',
            'App.Dashboard',
            'App.ReadWeb',
            'ngClipboard',
            'App.Geocode'
        ])
        .config(['$urlRouterProvider','$stateProvider', 'ADM_ROUTES','ngClipProvider', function($urlRouterProvider,$stateProvider, ADM_ROUTES,ngClipProvider) {
            
            ngClipProvider.setPath("http://192.168.1.128/devmap/public/f/wread-dev/plugin/zeroclipboard/ZeroClipboard.swf");


            $urlRouterProvider.otherwise("/app/dashboard");
            $stateProvider
                .state('app', {
                    abstract: true,
                    url: "/app",
                    templateUrl: ADM_ROUTES.base_url + 'app/layout'
                });
        }]);
})();



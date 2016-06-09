(function() {
    'use strict';
    angular.module('Admin', [
            'ngAnimate',
            'ngTouch',
            'ngMessages',
            'ui.bootstrap',
            'ui.router',
            'JtoolsGC',
            'Admin.config',
            'Admin.Dashboard',
            'Admin.User',
            'Entity.IdentityType',
            'Entity.PhoneType'
        ])
        .config(['$urlRouterProvider','$stateProvider', 'ADM_ROUTES', function($urlRouterProvider,$stateProvider, ADM_ROUTES) {
            $urlRouterProvider.otherwise("/sis/dashboard");
            $stateProvider
                .state('sis', {
                    abstract: true,
                    url: "/sis",
                    templateUrl: ADM_ROUTES.view_url + 'sis/layout-sis' +ADM_ROUTES.view_sufix
                });
        }]).run(['jtCacheLinkServices', function(jtCacheLinkServices) {

            if (typeof jsApiLoadLink === "undefined" || typeof jsApiLoadLinkCache === "undefined") {
                return;
            }

            if (jsApiLoadLinkCache.length === jsApiLoadLink.length) {

                var prefix="adm_";

                jtCacheLinkServices.deleteLink(jsApiLoadLinkCache,prefix);

                for (var i = 0; i < jsApiLoadLink.length; i++) {
                    if (!localStorage[jsApiLoadLinkCache[i]]) {
                        jtCacheLinkServices.saveLink(jsApiLoadLink[i],prefix);
                    }
                }
            }

        }]);
})();

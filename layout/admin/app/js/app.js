(function() {
    'use strict';
    angular.module('Admin', [
            'ngTouch',
            'ngMessages',
            'oc.lazyLoad',
            'ui.router',
            'jgTools',
            'Admin.config',
            'Admin.template'
        ])
        .config(['$jgConfigProvider', '$urlRouterProvider', '$stateProvider', 'ADMINCONFIG', function($jgConfigProvider, $urlRouterProvider, $stateProvider, ADMINCONFIG) {


            $jgConfigProvider.setBaseFile(ADMINCONFIG.base_path);
            $jgConfigProvider.setSkin(ADMINCONFIG.skin);
            $jgConfigProvider.setSkinSufix(ADMINCONFIG.skinSufix);
            $jgConfigProvider.setLoadModule(ADMINCONFIG.loadModule);

            $jgConfigProvider.setCache(ADMINCONFIG.cache);
            $jgConfigProvider.setVersion(ADMINCONFIG.version);

            $urlRouterProvider.otherwise("/sis/dashboard");
            $stateProvider
                .state('sis', {
                    abstract: true,
                    url: "/sis",
                    templateUrl: '/app/views/sis/layout-admin.html',
                    //templateUrl: '/devmap/helpers/admin-template/app/views/sis/layout-admin.html',
                    //templateProvider: ['$http', function($http) {
                    //    return $http
                    //        .post(ADMINCONFIG.base_url + 'sis/layout-admin')
                    //        .then(function(response) {
                    //            return response.data;
                    //        });
                    //}],
                    controller: 'AdminCtrl',
                })
                .state('sis.dashboard', {
                    url: '/dashboard',
                    templateUrl: '/app/views/dashboard/index.html',
                    //templateUrl: '/devmap/helpers/admin-template/app/views/dashboard/index.html',
                    //templateProvider: ['$http', function($http) {
                    //    return $http
                    //        .post(ADMINCONFIG.base_url + 'dashboard/index')
                    //        .then(function(response) {
                    //            return response.data;
                    //        });
                    //}],
                    controller: 'DashboardCtrl',
                    resolve: {
                        foo: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'moduleDashboard',
                                files: [
                                    ADMINCONFIG.base_path + 'js/dashboard.js'
                                ]
                            }])
                        }]
                    }
                })
                .state('sis.user', {
                    url: '/user',
                    templateUrl: '/app/views/user/list.html',
                    //templateProvider: ['$http', function($http) {
                    //    return $http
                    //        .post(ADMINCONFIG.base_url + 'user/list')
                    //        .then(function(response) {
                    //            return response.data;
                    //        });
                    //}],
                    controller: 'UserCtrl',
                    resolve: {
                        foo: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'moduleUser',
                                files: [
                                    ADMINCONFIG.base_path + 'js/entity/user.js'
                                ]
                            }])
                        }]
                    }
                })
                .state('sis.user_editar', {
                    url: "/user_editar/:userID",
                    templateUrl: '/app/views/user/edit-new.html',
                    //templateProvider: ['$http', function($http) {
                    //    return $http
                    //        .post(ADMINCONFIG.base_url + 'user/edit-new')
                    //        .then(function(response) {
                    //            return response.data;
                    //        });
                    //}],
                    controller: 'UserEditNewCtrl',
                    resolve: {
                        foo: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([{
                                name: 'moduleUser',
                                files: [
                                    ADMINCONFIG.base_path + 'js/entity/phone-type.js',
                                    ADMINCONFIG.base_path + 'js/entity/identity-type.js',
                                    ADMINCONFIG.base_path + 'js/entity/user.js'
                                ]
                            }])
                        }]
                    }
                });
        }])
        .run(['$jgConfig', 'jgsLinkAsyncServices', 'jgsCacheLinkServices', function($jgConfig, jgsLinkAsyncServices, jgsCacheLinkServices) {

            jgsCacheLinkServices.deleteOldVersion($jgConfig.version);

            if ($jgConfig.loadModule) {
                jgsLinkAsyncServices.putLink($jgConfig.baseFile + 'css/' + $jgConfig.skin + '/core' + $jgConfig.skinSufix, $jgConfig.version, $jgConfig.cache);
            } else {
                jgsLinkAsyncServices.putLink($jgConfig.baseFile + 'css/' + $jgConfig.skin + '/all' + $jgConfig.skinSufix, $jgConfig.version, $jgConfig.cache);
            }
            if ($jgConfig.cache) {
                // carga los archivos que aun no estan guardadso en memoria storage
                for (var i = 0; i < jsApiModule.link.length; i++) {
                    jgsLinkAsyncServices.putLink($jgConfig.baseFile  + jsApiModule.link[i].href, $jgConfig.version, true);
                };
            }
        }]);
})();
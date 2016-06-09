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
                    controller: 'AdminCtrl',
                })
                .state('sis.dashboard', {
                    url: '/dashboard',
                    templateUrl: '/app/views/dashboard/index.html',
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
(function() {
	'use strict';

	function AdminCtrl($scope, $jgcLayout) {

		$scope.itemenu = [{
			title: 'Dashboard',
			sref: 'sis.dashboard'
		}, {
			title: 'Components',
			submenu: [{
				title: 'Layout',
				sref: 'sis.layout'
			}, {
				title: 'Menu',
				sref: 'sis.menu'
			}, {
				title: 'Card',
				sref: 'sis.card'
			}, {
				title: 'Tool Bar',
				sref: 'sis.toolbar'
			}, {
				title: 'Title',
				sref: 'sis.title'
			}, {
				title: 'Google Chart',
				sref: 'sis.googlechart'
			}]
		}, {
			title: 'Core',
			submenu: [{
				title: 'Hash',
				sref: 'sis.hash'
			}, {
				title: 'Utf8',
				sref: 'sis.utf8'
			}, {
				title: 'Cache Link',
				sref: 'sis.cachelink'
			}, {
				title: 'Script Async',
				sref: 'sis.scriptasync'
			}, {
				title: 'Registry',
				sref: 'sis.registry'
			}]
		}, {
			title: 'Plugins',
			submenu: [{
				title: 'jsApi',
				sref: 'sis.jsapi'
			}]
		}];


		$scope.changePrincipalWest = function() {
			$jgcLayout.getInstance('layout_principal').changeToogleWest();
		}


	}
	angular
		.module('Admin')
		.controller('AdminCtrl', [
			'$scope', '$jgcLayout',
			AdminCtrl
		]);


})();
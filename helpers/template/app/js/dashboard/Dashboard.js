(function() {
	'use strict';
	angular
		.module('Admin.Dashboard', [])
		.config(['$stateProvider', 'ADM_ROUTES', function($stateProvider, ADM_ROUTES) {
			$stateProvider
				.state('sis.dashboard', {
					url: "/dashboard",
					templateUrl: ADM_ROUTES.view_url + 'dashboard'+ADM_ROUTES.view_sufix + '?' + Math.random(),
					data: {
						pageTitle: 'Dashboard'
					},
					controller: 'DashboardCtrl'
				});
		}]);
})();
(function() {
	'use strict';
	angular
		.module('App.Dashboard', [])
		.config(['$stateProvider', 'ADM_ROUTES', function($stateProvider, ADM_ROUTES) {
			$stateProvider
				.state('app.dashboard', {
					url: "/dashboard",
					templateUrl: ADM_ROUTES.base_url + 'dashboard/index',
					data: {
						pageTitle: 'Dashboard'
					},
					controller: 'DashboardCtrl'
				});
		}]);
})();
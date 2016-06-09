(function() {
	'use strict';
	angular
		.module('App.ReadWeb', [])
		.config(['$stateProvider', 'ADM_ROUTES', function($stateProvider, ADM_ROUTES) {
			$stateProvider
				.state('app.read-web', {
					url: "/read-web",
					templateUrl: ADM_ROUTES.base_url + 'app/read-web',
					data: {
						pageTitle: 'Leer WS'
					},
					controller: 'ReadWebCtrl'
				})
				.state('app.showsql', {
                    url: "/loadsql/:guid",
                    templateUrl: ADM_ROUTES.base_url + 'app/read-web-sql',
                    controller: 'ReadWebSaveCtrl'
                });
		}]);
})();
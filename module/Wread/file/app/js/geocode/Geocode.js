(function() {
	'use strict';
	angular
		.module('App.Geocode', [])
		.config(['$stateProvider', 'ADM_ROUTES', function($stateProvider, ADM_ROUTES) {
			$stateProvider
				.state('app.geocode', {
					url: "/geocode",
					templateUrl: ADM_ROUTES.base_url + 'geocode/index',
					data: {
						pageTitle: 'Geocode'
					},
					controller: 'GeocodeCtrl'
				});
		}]);
})();
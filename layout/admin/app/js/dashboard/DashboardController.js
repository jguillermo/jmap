(function() {
	'use strict';

	function DashboardCtrl($scope) {
		$scope.user = {
			options: {
				title: 'Usuarios por tipo de documento',
				//backgroundColor:'red'
				//width: '290',
				//height: '200'
			},
			data: []
		}


		//userService.byIdentityType().then(function(rpta){
		//	console.log(rpta.data);
		//	$scope.user.data=rpta.data;
		//});


		
	}
	angular
		.module('Admin.Dashboard')
		.controller('DashboardCtrl', [
			'$scope',
			DashboardCtrl
		]);


})();
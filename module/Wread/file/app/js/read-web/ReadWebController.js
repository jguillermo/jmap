(function() {
	'use strict';

	function ReadWebCtrl($scope, readWebService, $uibModal) {
		$scope.search = {
			ent: 'msi',
			url: 'http://datosabiertos.msi.gob.pe/dashboards/9230/obras/',
			loading: false
		}

		$scope.guids = [];
		$scope.parents = [];
		$scope.guidTables = {};

		$scope.guidTableLoading = false;

		$scope.analizar = function() {

			if ($scope.search.loading) {
				return false;
			}
			$scope.search.loading = true;
			$scope.guids = [];
			$scope.parents = [];
			$scope.guidTables = {};
			readWebService.processUrl($scope.search)
				.then(function(rpta) {
					//console.log(rpta);
					$scope.search.loading = false;
					$scope.guids = rpta.data.guid;
					$scope.parents = rpta.data.parents;
				});

		}

		$scope.loadGuid = function(guid) {

			if ($scope.guidTableLoading) {
				return false;
			}
			$scope.guidTableLoading = true;

			$scope.guidTables[guid] = {
				loading: true
			};
			readWebService.getTableGuid(guid, $scope.search.ent)
				.then(function(rpta) {
					//console.log(rpta);
					$scope.guidTableLoading = false;
					$scope.guidTables[guid] = rpta.data;
					$scope.guidTables[guid].show = true;

					//console.log($scope.guidTables);
				});

		}

		$scope.loadParent = function(url) {
			$scope.search.url = url;
			$scope.analizar();
		}


		$scope.open = function(guid) {

			var modalInstance = $uibModal.open({
				animation: false,
				templateUrl: readWebService.templateModal(),
				//template: '<div>saludos {{guid}}</div>',
				controller: 'ReadWebListCtrl',
				size: 'lg',
				resolve: {
					guid: function() {
						return guid;
					},
					ent: function() {
						return $scope.search.ent;
					}
				}
			});


		};


		$scope.save = function(guid) {

			var modalInstance = $uibModal.open({
				animation: false,
				templateUrl: readWebService.templateModal(),
				//template: '<div>saludos {{guid}}</div>',
				controller: 'ReadWebSaveCtrl',
				size: 'lg',
				resolve: {
					guid: function() {
						return guid;
					},
					ent: function() {
						return $scope.search.ent;
					}
				}
			});


		};


		//$scope.save = function(guid) {
		//	readWebService.getTableGuid(guid, $scope.search.ent)
		//	.then(function(rpta) {
		//		//console.log(rpta.data);
		//		readWebService.saveTableGuid(rpta.data);
//
		//	});
		//	
		//};



	}

	angular
		.module('App.ReadWeb')
		.controller('ReadWebCtrl', [
			'$scope', 'readWebService', '$uibModal',
			ReadWebCtrl
		]);


})();

(function() {
	'use strict';

	function ReadWebListCtrl($scope, readWebService, guid, ent) {


		
		$scope.list = {};
		readWebService.getTableGuid(guid, ent)
			.then(function(rpta) {
				$scope.list = rpta.data;
				//console.log(rpta.data);
			});

	}

	angular
		.module('App.ReadWeb')
		.controller('ReadWebListCtrl', [
			'$scope', 'readWebService', 'guid', 'ent',
			ReadWebListCtrl
		]);

})();



(function() {
	'use strict';

	function ReadWebSaveCtrl($scope, readWebService,$stateParams) {

		
		$scope.sqlserver='';

		console.log($stateParams.guid);

		//$scope.listasql = {};
		readWebService.getTableGuid($stateParams.guid, 'msi')
			.then(function(rpta) {
				readWebService.saveTableGuid(rpta.data).then(function(rptaserver){
					$scope.sqlserver=rptaserver.data.sql;
					
				});
				//$scope.listasql.id=rpta.data.id;
				//$scope.listasql.result=rpta.data.result;
				//console.log(rpta.data);
			});

	}

	angular
		.module('App.ReadWeb')
		.controller('ReadWebSaveCtrl', [
			'$scope', 'readWebService', '$stateParams',
			ReadWebSaveCtrl
		]);

})();
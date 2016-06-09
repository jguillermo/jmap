(function() {
	'use strict';

	function GeocodeCtrl($scope, GeocodeService, $uibModal) {
		$scope.listdb = [];

		$scope.table = {
			name: '',
			catastro: '',
			address: '',
			number: '',
			dist: ',San isidro, Lima',
			columns: []
		};

		GeocodeService.getListDb().then(function(rpta) {
			//console.log(rpta);
			$scope.listdb = rpta.data.tables;
		});



		$scope.loadtable = function(table) {
			//console.log(table);
			$scope.table.name = table;
			$scope.table.catastro = '';
			$scope.table.address = '';
			$scope.table.number = '';

			GeocodeService.getColumnsTable(table).then(function(rpta) {
				//console.log(rpta);
				$scope.table.columns = rpta.data.columns;
			});
		}



		$scope.loadgeocode = function() {
			
			GeocodeService.processGeocode($scope.table)
				.then(function() {
					console.log('success');
				}, function() {
					console.log('error');
				}, function(e) {
					console.log('noti' + e);
				});
		}

	}

	angular
		.module('App.Geocode')
		.controller('GeocodeCtrl', [
			'$scope', 'GeocodeService', '$uibModal',
			GeocodeCtrl
		]);


})();
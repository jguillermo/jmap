(function() {
	'use strict';
	function readWebService($http, ADM_ROUTES, $q, $timeout, cacheIndexedDBService) {


		this.processUrl = function(data) {
			//return $http.post(ADM_ROUTES.base_url + 'read-web/process-url', data);
			return cacheIndexedDBService.getIndexUrl(ADM_ROUTES.base_url + 'read-web/process-url',data,data.url);
		};

		this.getTableGuid = function(guid, ent) {
			//return $http.post(ADM_ROUTES.base_url + 'read-web/get-table-guid', {guid: guid,ent: ent});

			return cacheIndexedDBService.getIndexUrl(ADM_ROUTES.base_url + 'read-web/get-table-guid', {guid: guid,ent: ent},guid+ent);
		}

		this.getListTableGuid = function(list, ent) {

			var defered = $q.defer();
			var promise = defered.promise;

			$timeout(function() {
				try {
					var resultado = 5;
					defered.resolve(resultado);
				} catch (e) {
					defered.reject(e);
				}
			}, 3000);

			return promise;

		}

		this.templateModal = function () {
			return ADM_ROUTES.base_url + 'app/read-web-modal';
		}

		this.saveTableGuid = function (data) {
			return $http.post(ADM_ROUTES.base_url + 'app/saveguid',data);
		}
	}
	angular
		.module('App.ReadWeb')
		.service('readWebService', ['$http', 'ADM_ROUTES', '$q', '$timeout', 'cacheIndexedDBService', readWebService]);
})();
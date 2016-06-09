(function() {
	'use strict';

	function GeocodeService($http, ADM_ROUTES, $q, $timeout, cacheIndexedDBService, partialAjax) {

		this.getListDb = function() {

			return $http.post(ADM_ROUTES.base_url + 'geocode/get-list-db');
		}

		this.getColumnsTable = function(table) {

			return $http.post(ADM_ROUTES.base_url + 'geocode/get-columns-table', {
				table: table
			});
		}


		this.processGeocode = function(data) {

			return partialAjax.start(ADM_ROUTES.base_url + 'geocode/process-total', ADM_ROUTES.base_url + 'geocode/process-ajax', 10, data);
		}


	}
	angular
		.module('App.Geocode')
		.service('GeocodeService', ['$http', 'ADM_ROUTES', '$q', '$timeout', 'cacheIndexedDBService', 'partialAjax', GeocodeService]);
})();



(function() {
	'use strict';

	function partialAjax($http, $q) {

		var ajaxPage = 0;
		var pages = 0;

		function getTotal(urlTotal, rp, data, deferedStart) {

			var defered = $q.defer();


			$http.post(urlTotal,data)
				.then(function(rpta, data) {
					ajaxPage = 1;
					pages = Math.ceil(rpta.data.total / rp);
					deferedStart.notify('cargando datos...');
					defered.resolve(true);
				}, function() {
					defered.reject(false);
				});
			return defered.promise;
		}


		function getPercent() {

			return Math.floor(ajaxPage * 100 / (pages + 1)) + " % ";
		}


		function procesardata(urlAjax, rp, data, deferedStart, deferedDescargar, cberror) {
			var d = {
				data: data,
				rp: rp,
				ajaxPage: ajaxPage
			};
			$http.post(urlAjax, d)
				.then(function(rpta) {
					ajaxPage++;
					if (ajaxPage <= pages) {
						deferedStart.notify('ajaxPage : ' + getPercent());
						procesardata(urlAjax, rp, data, deferedStart, deferedDescargar, cberror);
					} else {
						deferedDescargar.resolve(true);
					}

				}, function() {
					if (typeof cberror == "function") {
						cberror();
					}
					// error
				});
		}



		function descargar(deferedStart, urlAjax, rp, data) {
			var defered = $q.defer();
			procesardata(urlAjax, rp, data, deferedStart, defered, function() {
				defered.reject(false);
			});
			return defered.promise;
		}



		this.start = function(urlTotal, urlAjax, rp, data) {

			data = data || {};

			var defered = $q.defer();


			getTotal(urlTotal, rp, data, defered)
				.then(function() {
						descargar(defered, urlAjax, rp, data)
							.then(function() {
								defered.resolve(true);
							}, function() {
								defered.reject(false);
							});

					},
					function() {
						defered.reject(false);
					});


			//defered.resolve(resultado);



			return defered.promise;

		}


	}
	angular
		.module('App.Geocode')
		.service('partialAjax', ['$http', '$q', partialAjax]);
})();
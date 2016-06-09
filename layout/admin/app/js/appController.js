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
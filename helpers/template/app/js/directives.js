(function() {
    'use strict';
    /**
     * pageTitle - Directive for set Page title - mata title
     */
    function pageTitle($rootScope, $timeout) {
        return {
            link: function(scope, element) {
                var listener = function(event, toState) { //event, toState, toParams, fromState, fromParams
                    // Default title - load on Dashboard 1
                    var title = 'Admin';
                    // Create your own title pattern
                    if (toState.data && toState.data.pageTitle) {
                        title = 'Admin | ' + toState.data.pageTitle;
                    }
                    $timeout(function() {
                        element.text(title);
                    });
                };
                $rootScope.$on('$stateChangeStart', listener);
            }
        };
    }
    angular
        .module('Admin')
        .directive('pageTitle', [
            '$rootScope', '$timeout',
            pageTitle
        ]);
})();


(function() {
    'use strict';

    function jmProfileMenu(ADM_ROUTES) {

        return {
            restrict: "E",
            //replace: true,
            templateUrl: ADM_ROUTES.view_url + 'sis/profile-menu' + ADM_ROUTES.view_sufix,
            //template='<nav class="menu-profile"><ul><li></li></ul></nav>',
            scope: {},
            controller: ['$scope', function($scope) {

                $scope.items = [{
                    title: 'menu1',
                    sref: 'sis.dashboard'
                }, {
                    title: 'menu2',
                    submenu: [{
                        title: 'submenu 1',
                        sref: 'sis.dashboard12'
                    }, {
                        title: 'submenu 2',
                        sref: 'sis.dashboard12b'
                    }, {
                        title: 'submenu 3',
                        sref: 'sis.dashboard12c'
                    }, ]
                }, {
                    title: 'menu3',
                    sref: 'sis.dashboard3'
                }];

                angular.forEach($scope.items, function(item) {
                    item.open = false;
                });


            }],
            //link: function($scope, element, attributes) {}
        };
    }
    angular
        .module('Admin')
        .directive('jmProfileMenu', [
            'ADM_ROUTES',
            jmProfileMenu
        ]);
})();

(function() {
    'use strict';

    function jmProfileHeader(ADM_ROUTES) {
        return {
            restrict: "E",
            //replace: true,
            templateUrl: ADM_ROUTES.view_url + 'sis/profile-header' + ADM_ROUTES.view_sufix + '?' + Math.random(),
            scope: {},
            //link: function($scope, element, attributes) {}
        };
    }
    angular
        .module('Admin')
        .directive('jmProfileHeader', [
            'ADM_ROUTES',
            jmProfileHeader
        ]);
})();


(function() {
    'use strict';
    /*
    -------------------
          north
    west center east
          south
    ------------------
    */
    function jmLayout(ADM_ROUTES) {
        return {
            restrict: "E",
            replace: true,
            transclude: true,
            templateUrl: ADM_ROUTES.view_url + 'sis/layout/layout' + ADM_ROUTES.view_sufix + '?' + Math.random(),
            scope: {},
            controller: ['$scope', function($scope) {

                $scope.toogleWest = false;

                this.changeToogleWest = function() {
                    $scope.toogleWest = !$scope.toogleWest;
                }
                
            }],
            //link: function($scope, element, attributes) {}
        };
    }
    angular
        .module('Admin')
        .directive('jmLayout', [
            'ADM_ROUTES',
            jmLayout
        ]);
})();

(function() {
    'use strict';

    function jmLayoutWest(ADM_ROUTES) {
        return {
            require: '^jmLayout',
            restrict: "E",
            replace: true,
            transclude: true,
            templateUrl: ADM_ROUTES.view_url + 'sis/layout/west' + ADM_ROUTES.view_sufix + '?' + Math.random(),
            link: function(scope, element, attrs, controller) {
                
                scope.toogle=function(){
                    controller.changeToogleWest();
                }
            }
        };
    }
    angular
        .module('Admin')
        .directive('jmLayoutWest', [
            'ADM_ROUTES',
            jmLayoutWest
        ]);
})();

(function() {
    'use strict';

    function jmLayoutCenter(ADM_ROUTES) {
        return {
            require: '^jmLayout',
            restrict: "E",
            replace: true,
            transclude: true,
            templateUrl: ADM_ROUTES.view_url + 'sis/layout/center' + ADM_ROUTES.view_sufix + '?' + Math.random(),
            link: function(scope, element, attrs, controller) {
                
                scope.toogleWest=function(){
                    controller.changeToogleWest();
                }
            }
        };
    }
    angular
        .module('Admin')
        .directive('jmLayoutCenter', [
            'ADM_ROUTES',
            jmLayoutCenter
        ]);
})();
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
                    var title = 'App';
                    // Create your own title pattern
                    if (toState.data && toState.data.pageTitle) {
                        title = 'App | ' + toState.data.pageTitle;
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
        .module('App')
        .directive('pageTitle', [
            '$rootScope', '$timeout',
            pageTitle
        ]);
})();

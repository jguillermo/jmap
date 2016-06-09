(function() {
    'use strict';


    /**
     * Main Controller for the Angular Material Starter App
     */
    function UserCtrl($scope, userService) {

        $scope.search = {
            value: ''
        };
        $scope.users = [];
        $scope.yasebusco = false;
        userService.getList().then(function(rpta) {
            //console.log(rpta.data.users);
            $scope.users = rpta.data.users;
        });


        $scope.buscarPersona = function() {
            $scope.users = null;
            userService.search($scope.search).then(function(rpta) {
                $scope.yasebusco = true;
                $scope.users = rpta.data.users;
            });
        };

    }
    angular.module('Admin.User')
        .controller('UserCtrl', [
            '$scope', 'userService',
            UserCtrl
        ]);



})();


(function() {
    'use strict';

    /**
     * Main Controller for the Angular Material Starter App
     */
    function UserEditNewCtrl($scope, $stateParams, userService, entIdentityTypeService, entPhoneTypeService) {

        $scope.user = [];
        $scope.identityTypes = [];
        $scope.phoneTypes = {};

        $scope.block = {
            phone: {
                loading: false,
                validator: {}
            }
        };


        $scope.addphone = function() {
            if ($scope.block.phone.loading) {
                return false;
            }
            $scope.block.phone.loading = true;
            userService.phoneEntityBlock().then(function(rpta) {
                //console.log(rpta);
                $scope.user.phone.push(rpta.data.list);
                $scope.block.phone.loading = false;
            });
        };

        $scope.deletePhone = function(index) {
            //userService.phoneEntityBlock().then(function(rpta) {
            //    //console.log(rpta);
            //    $scope.user.phone.push(rpta.data.list);
            //});

            $scope.user.phone.splice(index, 1);
        };



        $scope.save = function() {

            console.log($scope.user);
            if ($scope.frm_edit_new_user.$valid) {
                console.log('guardar y redirect');
            } else {
                angular.forEach($scope.frm_edit_new_user, function(value, key) {
                    if (typeof value === "object" && key.indexOf("$") === -1) {
                        value.$touched = true;
                    }
                });
                $scope.frm_edit_new_user.$touched = true;
            }


        };


        entIdentityTypeService.getAllList().then(function(rpta) {
            $scope.identityTypes = rpta.data.list;
        });

        entPhoneTypeService.getAllList().then(function(rpta) {
            //console.log(rpta.data.list);
            $scope.phoneTypes = rpta.data.list;

            angular.forEach(rpta.data.list, function(value) {
                
                $scope.block.phone.validator[value.id]={pattern:value.pattern,pattern_msg:value.pattern_msg};
                
            });

            console.log($scope.block.phone.validator);


        });

        userService.getByIdE($stateParams.userID).then(function(rpta) {
            //console.log(rpta.data.user);
            $scope.user = rpta.data.user;
        });

    }

    angular.module('Admin.User')
        .controller('UserEditNewCtrl', [
            '$scope', '$stateParams', 'userService', 'entIdentityTypeService', 'entPhoneTypeService',
            UserEditNewCtrl
        ]);



})();
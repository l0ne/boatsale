'use strict';

/**
 * @ngdoc function
 * @name boatsalesApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the boatsalesApp
 */
angular.module('boatsalesApp')
  .controller('LoginCtrl', function ($scope, Api, $location) {

    Api.User.logout(function (d) { });

    $scope.formData = {};

    $scope.submit = function() {
      Api.User.login($scope.formData, function (d) {
        if (d.redirect) $location.path('#' + d.redirect);
      });
    }

  });

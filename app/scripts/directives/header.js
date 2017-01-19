'use strict';

/**
 * @ngdoc directive
 * @name boatsalesApp.directive:header
 * @description
 * # header
 */
angular.module('boatsalesApp')
  .directive('header', function () {
    return {
      templateUrl: 'views/directives/header.html',
      restrict: 'E'
    };
  });

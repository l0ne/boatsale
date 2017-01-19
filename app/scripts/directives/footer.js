'use strict';

/**
 * @ngdoc directive
 * @name boatsalesApp.directive:footer
 * @description
 * # footer
 */
angular.module('boatsalesApp')
  .directive('footer', function () {
    return {
      templateUrl: 'views/directives/footer.html',
      restrict: 'E'
    };
  });

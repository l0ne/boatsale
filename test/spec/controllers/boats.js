'use strict';

describe('Controller: BoatsCtrl', function () {

  // load the controller's module
  beforeEach(module('boatsalesApp'));

  var BoatsCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    BoatsCtrl = $controller('BoatsCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});

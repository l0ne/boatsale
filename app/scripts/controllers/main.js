'use strict';

/**
 * @ngdoc function
 * @name boatsalesApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the boatsalesApp
 */
angular.module('boatsalesApp')
  .controller('MainCtrl', function ($scope, Api, $location) {

    // TODO Need refactoring this controller!

    Api.User.getUser(function (d) {
      if (d.redirect) $location.path(d.redirect);
      $scope.user = d.data;

      Api.Invite.getInvite(function (d) {
        $scope.invites = d.data;
      });
    });

    Api.Boat.getBoats (function (d) {
      if (d.redirect) $location.path(d.redirect);
      $scope.boats = d.data;
    });

    $scope.boatStatus = {
      0: 'Available',
      1: 'Not booked',
      2: 'Booked'
    }

    $scope.startBookBoat = function(boatId) {
      Api.Boat.startBookBoat(boatId, function (d) {
        $scope.boats = d.data;
      });
    }

    $scope.acceptBookBoat = function(boatId) {
      Api.Boat.acceptBookBoat(boatId, function (d) {
        $scope.boats = d.data;
      });
    }

    $scope.canselBookBoat = function(boatId) {
      Api.Boat.canselBookBoat(boatId, function (d) {
        $scope.boats = d.data;
      });
    }

    Api.User.getUsers(function (d) {
      $scope.users = d.data;
    });

    $scope.sendInvite = function(userId, boatId) {
      Api.Invite.sendInvite({user: userId, boat: boatId}, function (d) {

      });
    }

    $scope.acceptInvite = function(id) {
      Api.Invite.acceptInvite(id, function (d) {
        Api.Boat.getBoats (function (d) {
          $scope.boats = d.data;
        });
        $scope.invites = d.data;
      });
    }

    $scope.declineInvite = function(id) {
      Api.Invite.declineInvite(id, function (d) {
        $scope.invites = d.data;
      });
    }

    Api.Boat.getTypes(function (d) {
      $scope.boatTypes = d.data;
    });

    Api.Boat.getSizes(function (d) {
      $scope.boatSizes = d.data;
    });

    $scope.filters = {size: '', type: ''};
    $scope.changeFilter = function(field, value) {
      $scope.filters[field] = value;
    }

  });

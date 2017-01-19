'use strict';

/**
 * @ngdoc overview
 * @name boatsalesApp
 * @description
 * # boatsalesApp
 *
 * Main module of the application.
 */
angular
  .module('boatsalesApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {

    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/login', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl'
      })
      .when('/profile', {
        templateUrl: 'views/profile.html',
        controller: 'ProfileCtrl'
      })
      .when('/boats', {
        templateUrl: 'views/boats.html',
        controller: 'BoatsCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });

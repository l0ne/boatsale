'use strict';

angular.module('boatsalesApp').factory('Api', function ($http) {

  var api = '/api/';

  return {

    User: {
      login: function (data, successCallback) {
        return $http.post(api + 'user/login', data).success(function (d) {
          successCallback(d);
        });
      },
      logout: function (successCallback) {
        return $http.get(api + 'user/logout').success(function (d) {
          successCallback(d);
        });
      },
      getUser: function (successCallback) {
        return $http.get(api + 'user').success(function (d) {
          successCallback(d);
        });
      },
      getUsers: function (successCallback) {
        return $http.get(api + 'user/all').success(function (d) {
          successCallback(d);
        });
      }
    },

    Boat: {
      getBoats: function (successCallback) {
        return $http.get(api + 'boat').success(function (d) {
          successCallback(d);
        });
      },
      startBookBoat: function (data, successCallback) {
        return $http.post(api + 'boat/book/start', data).success(function (d) {
          successCallback(d);
        });
      },
      acceptBookBoat: function (data, successCallback) {
        return $http.post(api + 'boat/book/accept', data).success(function (d) {
          successCallback(d);
        });
      },
      canselBookBoat: function (data, successCallback) {
        return $http.post(api + 'boat/book/cansel', data).success(function (d) {
          successCallback(d);
        });
      },
      getTypes: function (successCallback) {
        return $http.get(api + 'boat/types').success(function (d) {
          successCallback(d);
        });
      },
      getSizes: function (successCallback) {
        return $http.get(api + 'boat/sizes').success(function (d) {
          successCallback(d);
        });
      },
    },

    Invite: {
      sendInvite: function (data, successCallback) {
        return $http.post(api + 'invite', data).success(function (d) {
          successCallback(d);
        });
      },
      getInvite: function (successCallback) {
        return $http.get(api + 'invite').success(function (d) {
          successCallback(d);
        });
      },
      acceptInvite: function (data, successCallback) {
        return $http.post(api + 'invite/accept', data).success(function (d) {
          successCallback(d);
        });
      },
      declineInvite: function (data, successCallback) {
        return $http.post(api + 'invite/decline', data).success(function (d) {
          successCallback(d);
        });
      },
    }
  };
});

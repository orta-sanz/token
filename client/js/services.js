'use strict';

G.factory('httpG', ['$http', '$window', function ($http, $window) {
    var serviceToken, serviceHost, serviceEmail;

    var tokenKey  = 'token',
        userEmail = '';

    if(localStorage.getItem(tokenKey)) {
        serviceToken = $window.localStorage.getItem(tokenKey);
    };
    if(localStorage.getItem(userEmail)) {
        serviceEmail = $window.localStorage.getItem(userEmail);
    };

    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

    return {
        setHost: function (host) {
            serviceHost = host;
        },

        setToken: function (token, email) {
            serviceToken = token;
            serviceEmail = email;

            $window.localStorage.setItem(tokenKey, token);
            $window.localStorage.setItem(userEmail, email);
        },

        getToken: function () {
            return serviceToken;
        },

        removeToken: function() {
            serviceToken = undefined;
            serviceEmail = undefined;

            $window.localStorage.removeItem(tokenKey);
            $window.localStorage.removeItem(userEmail);
        },

        get: function (uri, params) {
            params = params || {};

            params['_token'] = serviceToken;
            params['_userEmail'] = serviceEmail;

            return $http.get(serviceHost + uri, {params: params});
        },

        post: function (uri, params) {
            params = params || {};

            params['_token'] = serviceToken;
            params['_userEmail'] = serviceEmail;

            return $http.post(serviceHost + uri, params);
        }
    };
}]);

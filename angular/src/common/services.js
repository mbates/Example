angular.module('example.services', [
    'ngResource'
])

.factory( 'AuthenticationService', function($resource, $rootScope) {
    return $resource(
        $rootScope.url+'/oauth/v2/token?client_id=:clientId&client_secret=:clientSecret&grant_type=password&username=:username&password=:password',
        {
            clientId:'@clientId',
            clientSecret:'@clientSecret',
            username:'@username',
            password:'@password'
        },
        {
            get: { method: 'JSONP', params: { callback: 'JSON_CALLBACK' }, isArray: false }
        }
    );
})

.factory( 'GameDetails', function() {
    var gameDetails = {};

    return {
        getGameDetails: function() {
            return gameDetails;
        },
        setGameDetails: function(value) {
            gameDetails = value;
        }
    };
})

.factory( 'GameData', function($rootScope) {
    var gameData = {};

    return {
        getGameData: function() {
            return gameData;
        },
        setGameData: function(value) {
            gameData = value;
        },
        initializeGameData: function() {
            gameData.gameId = null;
            gameData.title = null;
            gameData.notes = null;

            return gameData;
        }
    };
})

.factory( 'GameIndexService', function($resource, $rootScope) {
    return $resource(
        $rootScope.url+'/api/games.json?access_token=:accessToken',
        {},
        {
            get: { method: 'JSONP', params: { callback: 'JSON_CALLBACK' }, isArray: true }
        }
    );
})

.factory( 'GameServices', function($resource, $rootScope) {
    return $resource(
        $rootScope.url+'/api/games/:gameId.json?access_token=:accessToken',
        { gameId:'@gameId' },
        {
            get: { method: 'JSONP', params: { callback: 'JSON_CALLBACK' }, isArray: false },
            list: { method: 'JSONP', params: { callback: 'JSON_CALLBACK' }, isArray: false },
            create: { method: 'POST', isArray: false },
            update: { method: 'PUT', isArray: false },
            patch: { method: 'PATCH', isArray: false }
        }
    );
});
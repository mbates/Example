angular.module('example.game', [])

.config(function config( $stateProvider, $datepickerProvider, $popoverProvider ) {
    $stateProvider
        .state( 'game', {
            abstract: true,
            url: '/game',
            templateUrl: 'game/game.tpl.html'
        })
        .state( 'game.index', {
            url: '/index',
            templateUrl: 'game/game.index.tpl.html',
            controller: 'GameIndexCtrl',
            data:{ pageTitle: 'Game Index' }
        })
        .state( 'game.details', {
            url: '/:gameId/details',
            templateUrl: 'game/game.details.tpl.html',
            controller: 'GameDetailsCtrl',
            data:{ pageTitle: 'Game Details' }
        })
        .state( 'game.edit', {
            url: '/:gameId/edit',
            templateUrl: 'game/game.edit.tpl.html',
            controller: 'GameEditCtrl',
            data:{ pageTitle: 'Edit Game' }
        })
        .state( 'game.add', {
            url: '/add',
            templateUrl: 'game/game.add.tpl.html',
            controller: 'GameAddCtrl',
            data:{ pageTitle: 'Add Game' }
        })
        .state( 'game.confirm', {
            url: '/confirm',
            templateUrl: 'game/game.confirm.tpl.html',
            controller: 'GameConfirmCtrl',
            data:{ pageTitle: 'Confirm Details' }
        });
})

.controller('GameIndexCtrl', function GameIndexCtrl( $scope, $rootScope, $stateParams, GameIndexService ) {
    GameIndexService.get({'accessToken':$rootScope.accessToken})
        .$promise.then(function(response){
            $scope.games = response;
        });
})

.controller('GameDetailsCtrl', function GameDetailsCtrl( $scope, $rootScope, $stateParams, $state, $cordovaCamera, GameServices, GameDetails ) {
    $scope.gameImage = '';
    $scope.baseString = 'data:image/jpeg;base64';

    GameServices.get({'gameId':$stateParams.gameId,'accessToken':$rootScope.accessToken})
        .$promise.then(function(response){
            $scope.gameDetails = response;
            GameDetails.setGameDetails($scope.gameDetails);
        });

    $scope.takePhoto = function() {
        var options = { 
            quality : 40,
            targetWidth: 500,
            targetHeight: 300,
            destinationType : Camera.DestinationType.DATA_URL, 
            sourceType : Camera.PictureSourceType.CAMERA, 
            allowEdit : false,
            encodingType: Camera.EncodingType.JPEG,
            popoverOptions: CameraPopoverOptions,
            saveToPhotoAlbum: true,
            correctOrientation: true
        };

        $cordovaCamera.getPicture(options).then(function(imageData) {
            $scope.gameImage = imageData;

            // Send Image to Server
            var game = {};
            game.id = $stateParams.gameId;
            game.image = imageData;

            GameServices.patch( {'gameId':$stateParams.gameId,'accessToken':$rootScope.accessToken}, angular.toJson( game ),
                function(data){
                    toastr.success('Image Uploaded');

                    $state.transitionTo($state.current, $stateParams, {
                        reload: true,
                        inherit: false,
                        notify: true
                    });
                },
                function(error){
                    $log.error(error);
                }
            );
        }, function(error) {
            $scope.error += error;
        });
    };
})

.controller('GameAddCtrl', function GameAddCtrl( $scope, $rootScope, $location, toastr, $log, GameServices, GameData ) {

    // Get FormData
    // Did we come from Confirm page?
    if ($rootScope.fromState.controller === 'AddConfirmCtrl') {
        $scope.formData = GameData.getGameData();
    } else {
        GameData.setGameData({});

        $scope.formData = GameData.initializeGameData();
    }

    // Create Game
    $scope.postGame = function() {
        var formValid = true;
        var requiredFields = ['title'];
        angular.forEach($scope.formData, function(value, key) {
            if (requiredFields.indexOf(key) > -1 && value == null) {
                formValid = false;
            }
        });

        if (!formValid) {
            toastr.error('You have to fill out all required fields.');
        } else {
            GameData.setGameData($scope.formData);
            $location.path('/game/confirm');
        }
    };
})

.controller('GameEditCtrl', function GameEditCtrl( $scope, $rootScope, $stateParams, $location, GameServices, GameDetails, GameData ) {
    // Game Details
    $scope.gameDetails = GameDetails.getGameDetails();

    // Did we come from Confirm page?
    if ($rootScope.fromState.controller === 'GameConfirmCtrl') {
        $scope.formData = GameData.getGameData();
    } else {
        $scope.formData = GameData.initializeGameData();

        $scope.formData.gameId = $scope.gameDetails.id;
        $scope.formData.title = $scope.gameDetails.title;
        $scope.formData.notes = $scope.gameDetails.notes;
    }

    // Save Game
    $scope.postGame = function() {
        var formValid = true;
        var requiredFields = ['title'];
        angular.forEach($scope.formData, function(value, key) {
            if (requiredFields.indexOf(key) > -1 && value == null) {
                formValid = false;
            }
        });

        if (!formValid) {
            toastr.error('You have to fill out all required fields.');
        } else {
            GameData.setGameData($scope.formData);
            $location.path('/game/confirm');
        }
    };
})

.controller('GameConfirmCtrl', function GameConfirmCtrl( $scope, $rootScope, $stateParams, $location, $log, GameServices, GameData ) {
    $scope.gameData = GameData.getGameData();

    var game = {};
    game.title = $scope.gameData.title;
    game.notes = $scope.gameData.notes;

    $scope.postGame = function() {
        if ($rootScope.fromState.controller === 'GameAddCtrl') {
            GameServices.create( {'accessToken':$rootScope.accessToken}, angular.toJson( game ),
                function(data){
                    $location.path('/game/'+data.id+'/details');
                },
                function(error){
                    $log.error(error);
                }
            );
        } else if($rootScope.fromState.controller === 'GameEditCtrl') {
            game.id = $scope.gameData.gameId;
            GameServices.update( {'gameId':game.id,'accessToken':$rootScope.accessToken}, angular.toJson( game ),
                function(data){
                    $location.path('/game/'+game.id+'/details');
                },
                function(error){
                    $log.error(error);
                }
            );
        }
    };
});
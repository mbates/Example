angular.module( 'example', [
    'templates-app',
    'templates-common',
    'ngSanitize',
    'ngAnimate',
    'mgcrea.ngStrap',
    'ui.router',
    'slugifier',
    'ngCordova',
    'placeholders',
    'toastr',
    'example.login',
    'example.game',
    'example.services'
])

.config( function myAppConfig( $stateProvider, $urlRouterProvider, $httpProvider ) {
    $urlRouterProvider.otherwise( '/login/authorize' );
})

.run( function run($rootScope, $location) {
    $rootScope.url = 'http://api.mbates.net';
    $rootScope.clientId = '1_iixnj9osjfkk4ooo8sok0scswwcsswksgggg8gs8o8sw4wc04';
    $rootScope.clientSecret = '3ltcpi36lrk0oc4040kgs00gkgsg8wcoo8o4skcoso8oc0wssg';
    $rootScope.loginRedirect = '/game/index';
    $rootScope.showNav = false;

    // Phonegap or browser
    if (typeof(cordova) === 'undefined') {
        $rootScope.phoneGap = false;
    } else {
        $rootScope.phoneGap = true;
    }

    dt = new Date();
    $rootScope.timezoneOffset = dt.getTimezoneOffset();

    $rootScope.$on( "$locationChangeStart", function(event, next, current) {
        if ( $rootScope.accessToken == null ) {
            if ( next.templateUrl !== 'login/login.tpl.html' ) {
                $location.path( '/login/authorize' );
            }
        }
    });
})

.controller( 'AppCtrl', function AppCtrl ($scope, $rootScope, $location, $log, toastr) {
    $scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams){
        $rootScope.fromState = fromState;
        if ( angular.isDefined( toState.data.pageTitle ) ) {
            $scope.pageTitle = toState.data.pageTitle + ' | mbates' ;
        }
    });

    $scope.$back = function() {
        window.history.back();
    };
})

.directive('container', function(){
    return function (scope, element, attrs) {
        element.css('padding-top', angular.element('.nav-bar').prop('offsetHeight'));
    };
})

.directive('goClick', function ( $location ) {
    return function ( scope, element, attrs ) {
        var path;

        attrs.$observe( 'goClick', function (val) {
            path = val;
        });

        element.bind( 'click', function () {
            scope.$apply( function () {
                $location.path( path );
            });
        });
    };
})

.directive('ngReallyClick', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                var message = attrs.ngReallyMessage;
                if (message && confirm(message)) {
                    scope.$apply(attrs.ngReallyClick);
                }
            });
        }
    };
});
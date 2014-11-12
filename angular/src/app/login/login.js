angular.module( 'example.login', [])

.config(function config( $stateProvider ) {
	$stateProvider
		.state( 'login', {
			url: '/login/:type',
			controller: 'LoginCtrl',
			templateUrl: 'login/login.tpl.html',
			data:{ pageTitle: 'Login' }
		});
})

.controller( 'LoginCtrl', function LoginCtrl( $scope, $rootScope, $stateParams, $location, toastr, AuthenticationService ) {
    $rootScope.showNav = false;
	$scope.loginData = {};
    $scope.loginData.username = "markbates";
    //$scope.loginData.username = "dehliahatten";
    $scope.loginData.password = "secret";

    $scope.message = "";

    if ($stateParams.type == 'refresh') {
        toastr.error('Authentication expired, you need to sign in again.');
    }

    $scope.login = function () {
        AuthenticationService.get({
            'clientId':$rootScope.clientId,
            'clientSecret':$rootScope.clientSecret,
            'username':$scope.loginData.username,
            'password':$scope.loginData.password

        })
        .$promise.then(function(response){
            $rootScope.accessToken = response.access_token;
            $rootScope.refreshToken = response.refresh_token;
            console.log($rootScope.loginRedirect);
            $location.path($rootScope.loginRedirect);
        });
    };
});
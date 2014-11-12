angular.module('uiRouterSample.contacts', [
	'ui.router'
])
	
.config(
	[ '$stateProvider', '$urlRouterProvider',
		function ($stateProvider,   $urlRouterProvider) {
			

			$stateProvider
				.state('contacts', {
					abstract: true,
					url: '/contacts',
					templateUrl: 'app/contacts/contacts.html',
					resolve: {
						contacts: ['contacts',
							function( contacts){
								return contacts.all();
							}]
					},
					controller: ['$scope', '$state', 'contacts', 'utils',
						function (  $scope,   $state,   contacts,   utils) {
							$scope.contacts = contacts;
							$scope.goToRandom = function () {
								var randId = utils.newRandomKey($scope.contacts, "id", $state.params.contactId);
								$state.go('contacts.detail', { contactId: randId });
							};
						}]
				})

				.state('contacts.list', {
					url: '',
					templateUrl: 'app/contacts/contacts.list.html'
				})

				.state('contacts.detail', {
					url: '/{contactId:[0-9]{1,4}}',
					views: {
						'': {
							templateUrl: 'app/contacts/contacts.detail.html',
							controller: ['$scope', '$stateParams', 'utils',
								function (  $scope,   $stateParams,   utils) {
									$scope.contact = utils.findById($scope.contacts, $stateParams.contactId);
								}]
						},
						'hint@': {
							template: 'This is contacts.detail populating the "hint" ui-view'
						},
						'menuTip': {
							templateProvider: ['$stateParams',
								function (        $stateParams) {
									return '<hr><small class="muted">Contact ID: ' + $stateParams.contactId + '</small>';
								}]
						}
					}
				})

				.state('contacts.detail.item', {

					url: '/item/:itemId',
					views: {
						'': {
							templateUrl: 'app/contacts/contacts.detail.item.html',
							controller: ['$scope', '$stateParams', '$state', 'utils',
								function (  $scope,   $stateParams,   $state,   utils) {
									$scope.item = utils.findById($scope.contact.items, $stateParams.itemId);

									$scope.edit = function () {
										$state.go('.edit', $stateParams);
									};
								}]
						},
						'hint@': {
							template: ' This is contacts.detail.item overriding the "hint" ui-view'
						}
					}
				})

				.state('contacts.detail.item.edit', {
					views: {
						'@contacts.detail': {
							templateUrl: 'app/contacts/contacts.detail.item.edit.html',
							controller: ['$scope', '$stateParams', '$state', 'utils',
								function (  $scope,   $stateParams,   $state,   utils) {
									$scope.item = utils.findById($scope.contact.items, $stateParams.itemId);
									$scope.done = function () {
										$state.go('^', $stateParams);
									};
								}]
						}
					}
				});
		

		}
	]
);
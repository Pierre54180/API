angular.module('backend', [])


.run(['$rootScope',function($rootScope){
	

}]);

/*.config( ['$routeProvider', function($routeProvider) {

	 $routeProvider
            .when('/', {
                templateUrl: "index.html",
                controller: ConnexionController
            })
            .when('/accueil', {
                templateUrl: "app/templates/accueil.html",
                controller: AccueilController,
                resolve: {
                    factory: checkRouting
                }
            })
            .otherwise({ redirectTo: '/' });

}] )*/
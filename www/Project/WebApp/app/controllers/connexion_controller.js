angular.module('backend').controller('ConnexionController',
	['$scope','$http','$rootScope',

	function($scope, $http, $rootScope){
	
			$scope.testCo = function() {
				
				if($scope.user!=undefined && $scope.user.pseudo!=undefined && $scope.user.mdp!=undefined){

					$http.get('http://php.vmprojet/Project/API/apistaff.php/testCo/'+$scope.user.pseudo+'/'+$scope.user.mdp)
					.then(function(response){

	     				 	$rootScope.pseudo=response.data.pseudo;

							if($rootScope.pseudo!=undefined){

								

							}else{
								alert('Connexion echouée ... Réessayer !');

							}
	
					},function(error){
						

					});		

				}else{

					alert('Veuillez remplir tout les champs !');
				}

					
				

				
			}

	

	}]);


myAppControllers.controller('NavbarCtrl',['$rootScope','$scope','$state',function($rootScope,$scope,$state) {
    $rootScope.$on('$stateChangeSuccess', 
            function(event, toState, toParams, fromState, fromParams){
        $scope.activeStep = $state.href($state.current.name); 
        });
}]);
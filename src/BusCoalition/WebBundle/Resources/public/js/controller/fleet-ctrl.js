myAppControllers.controller('fleetCtrl',['$scope','$state','$modal','$ajaxHelper',function($scope,$state,$modal,$ajaxHelper) {

    $scope.company = sessionStorage.getObject('company');
    
    //if no company object initialized go first step
    if(!angular.isDefined($scope.company)){
        $state.go('step1');
    }

    if(!angular.isDefined($scope.company.fleet)){
        $ajaxHelper.ajax_get($scope,ajax_urls.FLEET_BOOTSTRAP,undefined,function(data){
            $scope.company.fleet = data.fleet;
        });
    }
    
    $scope.next = function(){
        sessionStorage.setObject('company',$scope.company);
        $state.go('step4');
    };
    
    $scope.back = function(){
        sessionStorage.setObject('company',$scope.company);
        $state.go('step2');
    };
    
    $scope.addEditVehicle= function(vehicle){
        var modalInstance = $modal.open({
            templateUrl: "/bundles/buscoalitionweb/html/vehicle-modal.html",
            size: 'lg',
            controller: 'vehicleCtrl',
            resolve: {
              selectedVehicle: function () {
                return angular.copy(vehicle);
              }
            }
          });
        
        modalInstance.result.then(function (selectedVehicle) {
            vehicle.replacements = selectedVehicle.replacements;
            vehicle.price = selectedVehicle.price;
            vehicle.amount = selectedVehicle.amount;
            sessionStorage.setObject('company',$scope.company);
          });
    };
    
    $scope.addVehicleType= function(){
        var modalInstance = $modal.open({
            templateUrl: "/bundles/buscoalitionweb/html/vehicle-type-modal.html",
            size: 'lg',
            controller: 'vehicleTypeCtrl',
          });
        
        modalInstance.result.then(function (vehicleType) {
            $scope.company.fleet.push(vehicleType);
        });
    };
}]);
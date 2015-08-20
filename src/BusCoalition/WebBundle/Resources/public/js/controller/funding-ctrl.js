myAppControllers.controller('fundingCtrl',['$scope','$state','$modal','$ajaxHelper',function($scope,$state,$modal,$ajaxHelper) {
    $scope.showErrors=false;
    $scope.company = sessionStorage.getObject('company');
    
    //if no company object initialized go first step
    if(!angular.isDefined($scope.company)){
        $state.go('step1');
    }

    if(!angular.isDefined($scope.company.fundSources)){
        $ajaxHelper.ajax_get($scope,ajax_urls.FUNDING_BOOTSTRAP,undefined,function(data){
            $scope.company.fundSources = data.fund_sources;
        });
    }
    
    $scope.next = function(){
        sessionStorage.setObject('company',$scope.company);
        $state.go('step3');
        $scope.showErrors=true;
    };
    
    $scope.back = function(){
        sessionStorage.setObject('company',$scope.company);
        $state.go('step1');
    };
    
    $scope.addEditFundSource= function(fundSource){
        var modalInstance = $modal.open({
            templateUrl: "/bundles/buscoalitionweb/html/fund-source-modal.html",
            size: 'lg',
            controller: 'fundSourceCtrl',
            resolve: {
              selectedFundSource: function () {
                return angular.copy(fundSource);
              }
            }
          });
        
        modalInstance.result.then(function (donations) {
            fundSource.donations= donations;
          });
    };
    
    $scope.$watch('company',function(){
        sessionStorage.setObject('company',$scope.company);
    });
}]);
myAppControllers.controller('fundingCtrl',['$scope','$state','$modal','$ajaxHelper',function($scope,$state,$modal,$ajaxHelper) {
    $scope.showErrors=false;
    $scope.company = sessionStorage.getObject('company');
    
    if(!angular.isDefined($scope.company.fund_sources)){
        $ajaxHelper.ajax_get($scope,ajax_urls.FUNDING_BOOTSTRAP,undefined,function(data){
            $scope.company.fund_sources = data.fund_sources;
        });
    }
    $scope.next = function(){
        if(!$scope.form.$invalid){
            sessionStorage.company = $scope.company;
            $state.go('step3');
        }
        
        $scope.showErrors=true;
    };
    
    $scope.addEditFundSource= function(fundSource){
        var modalInstance = $modal.open({
            templateUrl: "/bundles/buscoalitionweb/html/fund-source-modal.html",
            size: 'lg',
            controller: 'fundSourceCtrl',
            resolve: {
              fundSource: function () {
                return fundSource;
              }
            }
          });
        return modalInstance.result;
    };
}]);
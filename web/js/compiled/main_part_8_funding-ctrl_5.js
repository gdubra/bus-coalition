myAppControllers.controller('fundingCtrl',['$scope','$state','$ajaxHelper',function($scope,$state,$ajaxHelper) {
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
}]);
myAppControllers.controller('confirmCtrl',['$scope','$state','$ajaxHelper',function($scope,$state,$ajaxHelper) {
    
    $scope.company = sessionStorage.getObject('company');
    
    //if no company object initialized go first step
    if(!angular.isDefined($scope.company)){
        $state.go('step1');
    }
    
    $scope.next = function(){
        $scope.generating_reports = true; 
        $ajaxHelper.ajax_post($scope,ajax_urls.CONFIRM,$scope.company,function(data){
            $scope.company.report_link = data.report_link;
            $scope.company.input_link = data.input_link;
            sessionStorage.setObject('company',$scope.company);
            $state.go('downloads');
        },function(){$scope.generating_reports = false;});

        
    };
    
    $scope.back = function(){
        $state.go('step3');
    };
}]);
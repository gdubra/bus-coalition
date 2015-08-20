myAppControllers.controller('basicInfoCtrl',['$scope','$state','$ajaxHelper',function($scope,$state,$ajaxHelper) {
    $scope.showErrors=false;
    $scope.company = sessionStorage.getObject('company');
    if(!angular.isDefined($scope.company)){
        $ajaxHelper.ajax_get($scope,ajax_urls.FORM_BOOTSTRAP,undefined,function(data){
            $scope.company = data.company_template;
            sessionStorage.setObject('company',$scope.company);
        });
    }
    
    $scope.next = function(){
        if(!$scope.form.$invalid){
            sessionStorage.setObject('company',$scope.company);
            $state.go('step2');
        }
        
        $scope.showErrors=true;
    };
}]);

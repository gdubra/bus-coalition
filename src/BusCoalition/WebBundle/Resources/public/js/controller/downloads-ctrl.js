myAppControllers.controller('downloadsCtrl',['$scope','$state','$ajaxHelper',function($scope,$state,$ajaxHelper) {
    
    $scope.company = sessionStorage.getObject('company');
    $scope.back = function(){
        $state.go('step1');
    };
}]);
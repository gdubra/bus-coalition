var buscoalitionfn = angular.module('fn.buscoalition',  []);
buscoalitionfn.factory('$ajaxHelper', ['$http','$interval','$rootScope', function($http,$interval,$rootScope) {
    return {
        update_model: 
            function($scope,model){
                for (var key in model) {
                    $scope[key] = model[key];
                }
            },
        ajax_post: 
            function($scope,url,data, sucess_callback, fail_callback,allow_concurrent){
                if(angular.isDefined(data)){
                    data.csrf = url.csrf;
                }else{
                    data = {csrf: url.csrf};
                }
                return $http.post(url.url,data)
                .success(angular.bind(this,function(retrieved_data) {
                    if(angular.isDefined(retrieved_data.data)){
                        this.update_model($scope,retrieved_data.data);
                    }
                    
                    if(angular.isDefined(retrieved_data.alerts)){
                        $rootScope.alerts = angular.isArray(retrieved_data.alerts)?retrieved_data.alerts:[retrieved_data.alerts];
                    }
                    
                    if(retrieved_data.success){
                        if(angular.isDefined(sucess_callback)){
                            sucess_callback(retrieved_data);
                        }
                    }else{
                        if(angular.isDefined(fail_callback)){
                            fail_callback(retrieved_data);
                        }else if(!angular.isDefined(retrieved_data.alerts)){//por si no hay otra alerta defindia 
                            $rootScope.alerts=[{type:'danger',msg:' Fatal Error: server is not responding'}];
                        }
                    }
                }))
                .error(function() {
                     $rootScope.alerts=[{type:'danger',msg:' Fatal Error : Server is not responding'}];
                });
            },
        //make get and handle sync and anwsers
        ajax_get: 
            function($scope,url,config, sucess_callback, fail_callback){
                return $http.get(url.url,config)
                .success(angular.bind(this,function(retrieved_data) {
                    
                    if(angular.isDefined(retrieved_data) && !angular.isDefined(sucess_callback)){
                        this.update_model($scope,retrieved_data.data);
                    }
                    
                    if(retrieved_data.success){
                        if(angular.isDefined(sucess_callback)){
                            sucess_callback(retrieved_data.data);
                        }
                    }else{
                        if(angular.isDefined(fail_callback)){
                            fail_callback(retrieved_data);
                        }else if(!angular.isDefined(retrieved_data.alerts)){//por si no hay otra alerta defindia 
                            $scope.error_response++;
                            $rootScope.alerts=[{type:'danger',msg:' Fatal Error : Server is not responding'}];
                            $scope.error_response=0;
                        }
                    }
                        
                    
                    if(angular.isDefined(retrieved_data.alerts)){
                        $rootScope.alerts = angular.isArray(retrieved_data.alerts)?retrieved_data.alerts:[retrieved_data.alerts];
                    }
                }))
                .error(function() {
                        $rootScope.alerts=[{type:'danger',msg:' Fatal Error( Server is not responding )'}];
                        $scope.error_response=0;
                });
            }
    };
}]);

var buscoalitionfilters = angular.module('filters.buscoalition',  []);
buscoalitionfilters.filter('fundSourceLifetime',function(){
    return function(fundSource){
        var endYear = angular.isDefined(fundSource.endYear) &&  fundSource.endYear!=null? fundSource.endYear:  new Date().getFullYear();
        var startYear = fundSource.startYear;
        var yearList = [];
        for (var i = startYear; i <= endYear; i++) {
            yearList.push(i);
        }
        
        return yearList;
    };
});

buscoalitionfilters.filter('vehicleLifetime',function(){
    return function(currentYear){
        var yearList = [];
        for (var i = currentYear; i <= currentYear+6; i++) {
            yearList.push(i);
        }
        
        return yearList;
    };
});

buscoalitionfilters.filter('activeFundSource',function(){
    return function(fundSources){
        
        var activeFundSources = [];
        for (var i = 0; i < fundSources.length; i++) {
            if(angular.isDefined(fundSources[i].donations)){
                activeFundSources.push(fundSources[i]);
            }
        }
        
        return activeFundSources;
    };
});

buscoalitionfilters.filter('activeFleet',function(){
    return function(fleet){
        var activeVehicles = [];
        for (var i = 0; i < fleet.length; i++) {
            if(angular.isDefined(fleet[i].amount)){
                activeVehicles.push(fleet[i]);
            }
        }
        
        return activeVehicles;
    };
});

buscoalitionfilters.filter('sourceType',function(){
    return function(fundSources,type){
        var fundSourcesType = [];
        for (var i = 0; i < fundSources.length; i++) {
            if(fundSources[i].type==type){
                fundSourcesType.push(fundSources[i]);
            }
        }
        
        return fundSourcesType;
    };
});

buscoalitionfilters.filter('keylength', function(){
    return function(input){
      if(!angular.isObject(input)){
        throw Error("Usage of non-objects with keylength filter!!");
      }
      return Object.keys(input).length;
    }
  });
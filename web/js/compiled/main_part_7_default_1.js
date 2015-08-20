myApp.config(function($stateProvider, $urlRouterProvider, $urlMatcherFactoryProvider) {
    
    $urlMatcherFactoryProvider.strictMode(false);
    $urlRouterProvider.otherwise( function($injector) {
        var $state = $injector.get("$state");
        $state.go("step1");
    });
    
    
    
    $stateProvider.state('step1', {
        url: "/basic-info",
        isEditing: false,
        views: {
            'container@': {
                templateUrl: "/bundles/buscoalitionweb/html/basic-info.html",
                controller: "basicInfoCtrl"
            }
        }
    });
    
    $stateProvider.state('step2', {
        url: "/funding",
        isEditing: false,
        views: {
            'container@': {
                templateUrl: "/bundles/buscoalitionweb/html/funding.html",
                controller: "fundingCtrl"
            }
        }
    });
    
    $stateProvider.state('step3', {
        url: "/fleet",
        isEditing: false,
        views: {
            'container@': {
                templateUrl: "/bundles/buscoalitionweb/html/fleet.html",
                controller: "fleetCtrl"
            }
        }
    });
    
    $stateProvider.state('step4', {
        url: "/confirm",
        isEditing: false,
        views: {
            'container@': {
                templateUrl: "/bundles/buscoalitionweb/html/confirm.html",
                controller: "confirmCtrl"
            }
        }
    });
    
    $stateProvider.state('report', {
        url: "/report",
        isEditing: false,
        views: {
            'container@': {
                templateUrl: "/bundles/buscoalitionweb/html/report.html",
                controller: "reportCtrl"
            }
        }
    });
    
});

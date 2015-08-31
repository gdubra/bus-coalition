//'angular-loading-bar'
var myApp = angular.module('myApp', [,'ngSanitize','myAppControllers','ui.router','ui.bootstrap','fn.buscoalition','filters.buscoalition']);
var myAppControllers = angular.module('myAppControllers', []);

Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
};

Storage.prototype.getObject = function(key) {
    var item = this.getItem(key);
    return item == null? undefined : JSON.parse(this.getItem(key));
};
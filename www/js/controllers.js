angular.module('starter.controllers', []).

controller('EmployeesController', function($scope, $http, Employee){
  $scope.employees = [];
  $scope.remove = function(id)
  {
    Employee.remove(id).
    success(function(data, status, headers){
      console.log(data+" "+status);
    }).
    error(function(data, status, headers){
      console.log(data+" "+status);
    });

  };
  Employee.all().

  success(function(data, status, headers){
    $scope.employees = data;
    console.log(data);
  }).
  error(function(data, status, headers){
    console.log("Error : "+status);
  });

}).
controller('EmployeeController', function($scope, $stateParams, Employee) {
  $scope.id = $stateParams.id;
  $scope.employee = {};
  Employee.get($scope.id).
  success(function(data, status, headers){
    $scope.employee = data;
    console.log(data);
  }).
  error(function(data, status, headers){
    console.log("Error : "+status);
  });


}).
controller('HomeController', function($scope, Posts){
  $scope.posts = [];
  Posts.all().
  success(function(data, status, headers){
    $scope.posts = data;
  }).
  error(function(data, status, headers){
    console.log("Error : "+status);
  });
});

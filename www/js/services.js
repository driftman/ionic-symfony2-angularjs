angular.module('starter.services', [])

.factory('Employee', function($http){

  return {
    all : function() {
      return $http.get('http://localhost:8000/api/v1/user');
    },
    remove: function(_id) {
      console.log("Starting ...");
      return $http.delete('http://localhost:8000/api/v1/user/'+_id);
    },
    get : function(id){
      return $http.get('http://localhost:8000/api/v1/user/'+id);
    }
  };

}).
factory('Posts', function($http){
  return {
    all : function() {
      return $http.get('http://localhost:8000/api/v1/posts');
    }
  };
});

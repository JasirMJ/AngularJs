<!DOCTYPE html>
<html>
     <head>
          <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js">
          </script>
     </head>  
     <body>  
          <div class="container" ng-app="myapp" ng-controller="myController" ng-init="select()">  
               <div class="col-md-4">  
               <br><br><br>
                    <div ng-init="get_data()">
                         data :
                         <select ng-model="select_data"  ng-options="items.name for items in array_data" ng-change="show()">
                              <option value="">Select Location</option>
                              <option ng-repeat="items in array_data" value="{{items.id}}"  >
                              {{items.name}}
                              </option>
                         </select>selected id : {{selected_value}}  
                    </div>
               </div>
          </div>
     </body>
</html>
<script>  
var app = angular.module("myapp", []);  
app.controller("myController", function($scope, $http){  
     $scope.get_data=function(){
          console.log("get_data worked");
          $scope.array_data = [
               {"id":1,"name":"Apple"},
               {"id":2,"name":"mango"},
               {"id":3,"name":"banana"},
               {"id":4,"name":"grape"}
          ]
          console.log($scope.array_data[2].id)
          $scope.select_data = $scope.array_data[2]; //this work
          // $scope.select_data = $scope.array_data[2].id; // this wont work [i want this get worked , how?]
          // $scope.select_data = 3; // this wont work  [i want this get worked , how?]
          $scope.valueToBeSelected = 2;
          $scope.show()
     }
     $scope.show=function(){
          console.log($scope.select_data.id)
          $scope.selected_value = $scope.select_data.id;
     }
});  
</script>  
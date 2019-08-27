<?php 
session_start();
$act = 4;
if (!isset($_SESSION["pk_int_user_id"])) {
    header("Location: ../index.php");
}
include 'header.php';
?>
<div class="container" ng-app="app_location" >
	<section class="content" ng-controller="locationctrl">
		<div ng-show="addbtn">
			<button ng-click='add_location()' class='btn btn-success'>ADD(أضف)</button><input class='form-control search_home' type='text' ng-model='search.vchr_location_name' placeholder="Search">
		</div>
		<div class="table-responsive" ng-show="view">
			<table class="table table-striped" ng-init="initial()">
				<th>Slno</th>
                <th>Image</th>
				<th>Location Name</th>
                <th>Action</th>
				<tr ng-repeat='value in location | filter:search | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit''>
					<td>{{$index+1}}</td>
                    <td><img src="../apigateofqtr/upload/{{value.vchr_image_name || vchr_image_name}}" class="img-responsive img-thumbnail" width="100"></td>
					<td>{{value.vchr_location_name}}</td>
					<td class='buttons'>
                        <button ng-click='current_edit(value.pk_int_location_id);'>
                        	<a href='#' title='Update'><span class='glyphicon glyphicon-edit' ></span></a>
                        </button>
                        <button ng-click='delete_location(value.pk_int_location_id);'><a href='#'  title='Delete'>
                        	<span class='glyphicon glyphicon-remove' ></span></a>
                        </button>
                    </td>
				</tr>
			</table>
		</div>
		<div class="table-responsive" ng-show="current_view">
			<table class="table table-striped">
				<tr>
					<td>Location Name : </td>
					<td><span>{{current_location.vchr_location_name}}</span></td>
				</tr>
				<tr>
					<td><button ng-click='Back()' class='btn btn-success'>BACK</button></td>
				</tr>
			</table>
		</div>
		<div class="table-responsive" ng-show="add">
		<form name = "adding">
			<table class="table table-striped">
				<tr>
					<td>Location Name : </td>
					<td><input type="text" name="" ng-model="ng_cat" required="" ng-change="check_location()" ></td>
				</tr>
                <tr>
					<td>موقعك : </td>
					<td><input type="text" name="" ng-model="ng_cat_ar" required="" ng-change="check_location()" ></td>
				</tr>
                <tr>
					<td>Premium :</td>
					<td><input type="checkbox"  ng-model="ng_premium" required="" ng-checked="checkVal" ng-true-value=1 ng-false-value=0> check this box to set as premium</td>
				</tr>
				<tr>
                    <td>Image (صورة) : </td>
                    <td>
                        <input type="file" name="file" multiple="true" accept="image/jpeg,jpg,png,PNG" id="fileUpload" ng-model="form.image" onchange="angular.element(this).scope().uploadedFile(this)">
                    </td>
                </tr>
                <tr>
                    <td>(Image size must be 650px x 150px)</td>
                </tr>
                <tr>
					<td><button class="btn btn-success buttonload" ng-show="loading"><i class=" fa fa-circle-o-notch fa-spin"></i>Loading</button><button ng-click='add_location_save()' ng-disabled='adding.$pending || adding.$invalid' class='btn btn-success' id="hide" ng-show="add_btn" >ADD(أضف)</button>
					<button ng-click='update_location_save()' ng-disabled='adding.$pending || adding.$invalid' class='btn btn-success' ng-show="add_updt_btn" >UPDATE(تحديث)</button>&nbsp;<button ng-click='Back()' class='btn btn-success'>BACK(رجوع)</button></td>
				</tr>
			</table>
			</form>
           <!--  <div class='col-md-12' ng-show='filteredItems > 0'>    
              <div pagination='' page='currentPage' on-select-page='setPage(page)' boundary-links='true' total-items='filteredItems' items-per-page='entryLimit' class='pagination-small' previous-text='&laquo;' next-text='&raquo;'>
              <button ng-click='setPage(currentPage+1)' class='btn btn-primary' ng-show='totalItems/entryLimit>currentPage'>Next</button>
              <button ng-click='setPage(currentPage-1)' class='btn btn-primary' ng-show='currentPage>1'>Prev</button>
              </div>
		</div> -->
	</section>
</div>
<script type="text/javascript">
    var base_url='../apigateofqtr/index.php/Apilocation/';
    var app_location = angular.module('app_location', []);
    app_location.filter('startFrom', function() {
                return function(input, start) {
                    if (input) {
                        start = +start; //parse to int
                        return input.slice(start);
                    }
                    return [];
                    }
});
	
     app_location.controller('locationctrl', function($scope, $http, $filter, $timeout) {
        $scope.form = [];       
        $scope.files = [];
        $scope.image_deleted = [];
        $scope.length_of_images = 0;
		
    $scope.initial = function(){
				    	$scope.get_location();
        $scope.addbtn = true;
        $scope.view = true;
        $scope.add = false;

    }	
    $scope.Back = function(){
		$scope.addbtn = true;
    	$scope.view = true;
    	$scope.add = false;
    	$scope.current_view = false;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 5; //max no of items to display in a page
        $scope.filteredItems = $scope.location.length; //Initially for no filter 
        $scope.totalItems = $scope.location.length;
		$scope.get_location();
    }	
    $scope.check_location = function() 
    {
        // alert($scope.ng_cat);
        $scope.url = base_url+'check_location';
            $http.post($scope.url, 
            {
                'location': $scope.ng_cat,
                'location_id':$scope.add?$scope.ng_id:'' 
            }).success(function (data, status) 
                {
                    // alert(JSON.stringify(data.data));
                    if (data.count > 0)
                    {
                        $scope.Color3 = "red";
                        $scope.Message3 = "EXIST";
                        alert("exist");
                        $scope.flagcat = false;
                    }
                    else
                    {
                        $scope.Color3 = "green";
                        $scope.Message3 = "";
                        $scope.flagcat = true;
                        $scope.mainMessage="";
                    }
                });
    }    
    $scope.add_location = function(){
        $scope.addbtn = false;
        $("#hide").show();
    	$scope.view = false;
    	$scope.add = true;
    	$scope.add_updt_btn = false;
        $scope.add_btn = true;
        $scope.loading = false;
                        $scope.ng_cat= "";
                        $scope.ng_cat_ar= "";
                        $scope.ng_id="";
                        $scope.ng_premium=0;
    }
    $scope.uploadedFile = function(element) 
        {
            $scope.currentFile = element.files;
            // alert(element.files);
            var reader = new FileReader();
            var $fileUpload = $("input[type='file']");
             if (parseInt($fileUpload.get(0).files.length)>1)
             {
                $scope.form.image = [];
                alert("You can only upload a maximum of 1 files");
             }
            reader.onload = function(event) {
                $scope.image_source = event.target.result;
                $scope.$apply(function($scope) {
                    $scope.files = element.files;
                });
            }
            reader.readAsDataURL(element.files[0]);
        }
    $scope.add_location_save = function() {
        // alert($scope.ng_cat);
                        $scope.loading = true;
                        $scope.add_btn = false;
                        $scope.ng_stat=false;
                        $scope.lat=1;
                        $scope.lng=2;
                        $scope.url = base_url+'add_location';
                        // if($scope.flagcat == false) alert("please enter anathor location!");
                        // if ($scope.flagcat) {
                        // $http.post($scope.url, {
                        //   'cat': $scope.ng_cat
                        // }).then(function(response) {
                        //     alert(JSON.stringify(response.data));
                        //     $scope.initial();
                        // })
                        // }
                      $scope.form.image = $scope.files[0];
                      var fileInput = document.getElementById('fileUpload');
                      if(fileInput.files.length > 1) alert('please select only 1 pictures');
                      else
                      $http({
                        method  : 'POST',
                        url     : $scope.url,
                        processData: false,
                        transformRequest: function (data) {
                            var formData = new FormData();
                            var daa={ 
                                'location': $scope.ng_cat,
                                'locationar':$scope.ng_cat_ar,
                                'is_premium':$scope.ng_premium,
                                'lat':$scope.lat,
                                'lng':$scope.lng,
                                'strtview':$scope.ng_stat       
                            };
                            var str_daa = JSON.stringify(daa);
                                $scope.loading = false;

                            for(var i = 0;i < fileInput.files.length;i++){
                                formData.append("image[]", fileInput.files[i]);
                            }
                            formData.append("data",str_daa);                                
                            return formData;  
                        },  
                        data : $scope.form,
                        headers: {
                               'Content-Type': undefined
                        }
                     }).success(function(data){
                          alert(data);
                          $scope.initial();
                     });
                    }

	$scope.update_location_save = function(){
                        $scope.loading = true;
                        $scope.add_updt_btn = false;
                        $scope.ng_stat=false;
                        $scope.lat=1;
                        $scope.lng=2;
						$scope.url = base_url+'update_location';
                    //     if($scope.flagcat == false) alert("please enter anathor location!");
                    //     if ($scope.flagcat) {
                    //     $http.post($scope.url, {'id': $scope.current_location_edit.pk_int_location_id,'cat': $scope.ng_cat
                    //     }).then(function(response) {
                    //         alert(JSON.stringify(response.data));
                    //         $scope.initial();
                    //     })
                    // }
                     $scope.form.image = $scope.files[0];
                      var fileInput = document.getElementById('fileUpload');
                      if(fileInput.files.length > 1) alert('please select only 1 pictures');
                      else
                      $http({
                        method  : 'POST',
                        url     : $scope.url,
                        processData: false,
                        transformRequest: function (data) {
                            var formData = new FormData();
                            var daa={
                                'id': $scope.current_location_edit.pk_int_location_id,
                                'location': $scope.ng_cat,
                                'locationar':$scope.ng_cat_ar,
                                'is_premium':$scope.ng_premium,
                                'lat':$scope.lat,
                                'lng':$scope.lng,
                                'strtview':$scope.ng_stat
                            };
                            var str_daa = JSON.stringify(daa);
                            $scope.loading = false;

                            for(var i = 0;i < fileInput.files.length;i++){
                                formData.append("image[]", fileInput.files[i]);
                            }
                            formData.append("data",str_daa);                                
                            return formData;  
                        },  
                        data : $scope.form,
                        headers: {
                               'Content-Type': undefined
                        }
                     }).success(function(data){
                          alert(data);
                          $scope.initial();
                     });   
					}				
	$scope.get_location = function(){
                        $scope.url = base_url+'select_location';
                            $scope.token = "token";
                            $http.post($scope.url,{'token':$scope.token}).then(function(response){
                                // alert(JSON.stringify(response.data));
                                $scope.location = response.data;
                                 $scope.vchr_image_name = "location.jpg";
                            }); 
                        }
    $scope.view_full = function(id) {
    $scope.addbtn = false;
   
	$scope.view = false;
	$scope.add = false;
	$scope.current_view = true;	
    					$scope.id = id;
                        $scope.url = base_url+'select_current_location';
    	 				$http.post($scope.url,{'id':$scope.id}).then(function(response){
                                // alert(JSON.stringify(response.data[0]));
                        $scope.current_location = response.data[0];
                        $scope.get_location();
                            });
    }
    $scope.current_edit = function(id){
    $scope.addbtn = false;
    $("#hide").hide();
	$scope.view = false;
	$scope.add = true;
	$scope.current_view = false;
	$scope.add_updt_btn = true;
    					$scope.id = id;
                        $scope.url = base_url+'select_current_location';
    	 				$http.post($scope.url,{'id':$scope.id}).then(function(response){
                                // alert(JSON.stringify(response.data[0]));
                        $scope.current_location_edit = response.data[0];
                        // alert(JSON.stringify($scope.current_location_edit));
                        $scope.ng_id = id;
                        $scope.ng_cat = $scope.current_location_edit.vchr_location_name;
                        $scope.ng_cat_ar = $scope.current_location_edit.vchr_location_name_ar;
                        $scope.ng_premium_x = $scope.current_location_edit.int_is_premium;
                        $scope.checkVal=1;
                    });
     }
     $scope.delete_location = function(id){
     	if(confirm("Are You Sure Want To Delete?")){
						$scope.id = id;
                        $scope.url = base_url+'delete_location';
    	 				$http.post($scope.url,{'id':$scope.id}).then(function(response){
                                alert(JSON.stringify(response.data));
                                $scope.initial();
                        $scope.location = data;
                        $scope.currentPage = 1; //current page
                        $scope.entryLimit = 5; //max no of items to display in a page
                        $scope.filteredItems = $scope.location.length; //Initially for no filter 
                        $scope.totalItems = $scope.location.length;
                        
                            });
    	 			}
     }
     $scope.setPage = function(pageNo) {
                        $scope.currentPage = pageNo;
                    };
    $scope.filter = function() {
        $timeout(function() {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
     });
</script>
</html>
<?php include 'footer.php';?>
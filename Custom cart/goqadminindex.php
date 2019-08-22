<?php 
session_start();
$act = 1;
if (!isset($_SESSION["pk_int_user_id"])) {
	header("Location: ../index.php");
}
include 'header.php';
?>



<!--<style> Modall
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
display: none; /* Hidden by default */
position: fixed; /* Stay in place */
z-index: 1; /* Sit on top */
padding-top: 100px; /* Location of the box */
left: 0;
top: 0;
width: 100%; /* Full width */
height: 100%; /* Full height */
overflow: auto; /* Enable scroll if needed */
background-color: rgb(0,0,0); /* Fallback color */
background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
background-color: #fefefe;
margin: auto;
padding: 20px;
border: 1px solid #888;
width: 80%;
}

/* The Close Button */
.close {
color: #aaaaaa;
float: right;
font-size: 28px;
font-weight: bold;
}

.close:hover,
.close:focus {
color: #000;
text-decoration: none;
cursor: pointer;
}
</style>-->
<style>
	.w3-card-2 {
		box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12)
	}
	.w3-margin{
		margin:16px!important
	}
	.w3-container{
		padding: 0.01em 16px
	}
	.w3-container:after,
	.w3-container:before{
		content: "";
		display: table;
		clear: both
	}

	.w3-light-grey
	{
		color: #000!important;
		background-color: #f1f1f1!important
	}
	.w3-padding-16 {
		padding-top: 16px!important;
		padding-bottom: 16px!important
	}
	.w3-ul {
		background-color: rgb(255, 255, 255);
		list-style-type: none;
		padding: 0;
		margin: 0
	}
	.w3-ul li {
		padding: 8px 16px;
		border-bottom: 1px solid #ddd
	}
	.w3-ul li:last-child {
		border-bottom: none
	}
	.w3-right {
		float: right!important
	}
	.w3-right-align {
		text-align: right!important
	}
	.w3-margin-right {
		margin-right: 16px!important
	}
	.w3-margin-top {
		margin-top: 16px!important
	}

	.w3-col
	{
		float: left;
		width: 100%
	}
	.w3-col.s1 {
		width: 8.33333%
	}

	.w3-col.s2 {
		width: 16.66666%
	}

	.w3-col.s3 {
		width: 24.99999%
	}

	.w3-col.s4 {
		width: 33.33333%
	}

	.w3-col.s5 {
		width: 41.66666%
	}

	.w3-col.s6 {
		width: 49.99999%
	}

	.w3-col.s7 {
		width: 58.33333%
	}

	.w3-col.s8 {
		width: 66.66666%
	}

	.w3-col.s9 {
		width: 74.99999%
	}

	.w3-col.s10 {
		width: 83.33333%
	}

	.w3-col.s11 {
		width: 91.66666%
	}

	.w3-col.s12 {
		width: 99.99999%
	}
	.w3-input {
		padding: 8px;
		display: block;
		border: none;
		border-bottom: 1px solid #ccc;
		width: 88%
	}
	.w3-border {
		border: 1px solid #ccc!important
	}
	.w3-padding {
		padding: 8px 16px!important
	}
	.w3-btn{
		border: none;
		display: inline-block;
		padding: 8px 16px;
		vertical-align: middle;
		overflow: hidden;
		text-decoration: none;
		/* color: inherit; */
		/* background-color: inherit; */
		background-color: rgb(204, 127, 64);
		text-align: center;
		cursor: pointer;
		white-space: nowrap;
		width: 100%;

		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none
	}
	.w3-green{
		color: #fff!important;
		background-color: rgb(216, 167, 30)!important
	}
	.w3-text-red,
	.w3-hover-text-red:hover {
		color: #f44336!important
	}
</style>

<div class="container" ng-app="app_Buisiness" >
	<section class="content" ng-controller="buisinessctrl" id="buisinessctrlId">
		<div ng-show="addbtn">
			<button ng-click='add_Buisiness()' class='btn btn-success'>ADD(أضف)</button><input class='form-control search_home' type='text' ng-model='search.vchr_name' placeholder="Search">
		</div>
		<div class="table-responsive" ng-show="view">
			<table class="table table-striped" ng-init="initial()">
				<th>Slno</th>
				<th>Image</th>
				<th>Pdf</th>
				<th>Business Name</th>
				<th>Location</th>
				<th>Action</th>

				<tr ng-repeat="value in buisiness | filter:search">
					<td>{{$index+1}}</td>
					<td><img src="../apigateofqtr/upload/{{value.vchr_image_name || vchr_image_name}}" class="img-responsive img-thumbnail" width="100"></td>
					<td>

						<button ng-show={{value.vchr_pdf}} ><a href='../apigateofqtr/upload/buipdf/{{value.vchr_pdf}}' download  title='PDF'>
							<span class='glyphicon glyphicon-file' ></span></a>
						</button>
						<button ng-show={{!value.vchr_pdf}} >
							<span class='glyphicon glyphicon-file' ></span>
						</button>
					</td>
					<td>{{value.vchr_name}}</td>
					<td>{{value.vchr_location_name}}</td>
					<td class='buttons'>
						<button ng-click='view_full(value.pk_int_business_id);'>
							<a href='#'  title='View'><span class='glyphicon glyphicon-eye-open' ></span></a>
						</button>
						<button ng-click='current_edit(value.pk_int_business_id);'>
							<a href='#'  title='Update'><span class='glyphicon glyphicon-edit' ></span></a>
						</button>
						<button ng-click='delete_buisiness(value.pk_int_business_id,value.fk_int_address_id);'><a href='#'  title='Delete'>
							<span class='glyphicon glyphicon-remove' ></span></a>
						</button>
					</td>
				</tr>
			</table>
		</div>

		<div class="table-responsive" ng-show="current_view">
			<table class="table table-striped">
				<tr>
					<td>Business Name : </td>
					<td><span>{{current_buisiness.vchr_name}}</span></td>
				</tr>
				<tr>
					<td>اسم : </td>
					<td><span>{{current_buisiness.vchr_name_ar}}</span></td>
				</tr>
				<!--<tr>-->
					<!--	<td>Pincode : </td>-->
					<!--	<td><span>{{current_buisiness.int_pincode}}</span></td>-->
					<!--</tr>-->
					<!--<tr>-->
						<!--	<td>City : </td>-->
						<!--	<td><span>{{current_buisiness.vchr_city}}</span></td>-->
						<!--</tr>-->
						<!--<tr>-->
							<!--	<td>State : </td>-->
							<!--	<td><span>{{current_buisiness.vchr_state}}</span></td>-->
							<!--</tr>-->
							<!--<tr>-->
								<!--	<td>حالة : </td>-->
								<!--	<td><span>{{current_buisiness.vchr_state_ar}}</span></td>-->
								<!--</tr>-->
								<tr>
									<td>Mobile : </td>
									<td><span>{{current_buisiness.int_mobile}}</span></td>
								</tr>
								<tr>
									<td>Alternate Mobile Number : </td>
									<td><span>{{current_buisiness.int_alt_mobile}}</span></td>
								</tr>

								<tr>
									<td>Email (ايميل) : </td>
									<td><span>{{current_buisiness.vchr_email}}</span></td>
								</tr>
								<tr>
									<td>Category (الفئة) : </td>
									<td><span>{{current_buisiness.vchr_category_name}}</span></td>
								</tr>
								<tr>
									<td>Location (موقعك) : </td>
									<td><span>{{current_buisiness.vchr_location_name}}</span></td>
								</tr>
								<tr>
									<td>Opening Time (وقت مفتوح) : </td>
									<td><span>{{opening}}</span></td>
								</tr>
								<tr>
									<td>Closing Time (وقت الإغلاق) : </td>
									<td><span>{{closing}}</span></td>
								</tr>
								<tr>
									<td>Web URL (رابط الموقع) : </td>
									<td><span>{{current_buisiness.vchr_weburl}}</span></td>
								</tr>
								<tr>
									<td>Youtube Video Id ( رابط الفيديو ) : </td>
									<td><span>{{current_buisiness.vchr_video_link}}</span></td>
								</tr>
								<tr>
									<td>Description : </td>
									<td><span>{{current_buisiness.text_description}}</span></td>
								</tr>
								<tr>
									<td>وصف : </td>
									<td><span>{{current_buisiness.text_description_ar}}</span></td>
								</tr>
								<!--<tr>-->
									<!--	<td>Featured :</td>-->
									<!--	<td><span>{{current_buisiness.text_description_ar}}</span></td>-->
									<!--</tr>-->
									<tr>
										<td>Tags : </td>
										<td><span>{{current_buisiness.vchr_tag}}</span></td>
									</tr>
									<tr>
										<td colspan="2" ><img ng-repeat="option in ng_img_fully" src="../apigateofqtr/upload/{{option.vchr_image_name}}" class="img-responsive img-thumbnail" width="100"></td>

<!-- <option ng-repeat="option in ng_img_fully" value="{{option.vchr_image_name}}" 
>
</option> -->
</tr>
<tr>
	<td><button ng-click='Back()' class='btn btn-success'>BACK(رجوع)</button></td>
</tr>
</table>
</div>




<div class="table-responsive" ng-show="add">
	<form name = "adding">
		<table class="table table-striped">
			<tr>
				<td>Business Name : </td>
				<td><input type="text" name="" ng-model="ng_name" id="hide" / ></td>
			</tr>
			<tr>
				<td>اسم : </td>
				<td><input type="text" name="" ng-model="ng_name_ar" id="hide" / ></td>
			</tr>
			<!--<tr>-->
				<!--	<td>Pincode : </td>-->
				<!--	<td><input type="number" name="" ng-model="ng_pincode" required/ ></td>-->
				<!--</tr>-->
				<!--<tr>-->
					<!--	<td>City : </td>-->
					<!--	<td><input type="text" name="" ng-model="ng_city" required/ ></td>-->
					<!--</tr>-->
					<!--<tr>-->
						<!--	<td>State : </td>-->
						<!--	<td><input type="text" name="" ng-model="ng_state" required/ ></td>-->
						<!--</tr>-->
						<!--<tr>-->
							<!--	<td>حالة : </td>-->
							<!--	<td><input type="text" name="" ng-model="ng_state_ar" required/ ></td>-->
							<!--</tr>-->
							<tr>
								<td>Mobile : </td>
								<td><input type="number" name="" ng-model="ng_mobile" / ></td>
							</tr>
							<tr>
								<td>Alternate Mobile Number : </td>
								<td><input type="number" name="" ng-model="ng_alt_mobile"></td>
							</tr>
							<tr>
								<td>Email (ايميل) : </td>
								<td><input type="email" name="" ng-model="ng_email" / ></td>
							</tr>
							<tr>
								<td>Category (الفئة) : </td>
								<td ng-init='get_category()'>
									<select ng-model="ng_cat" />
									<option value="">Select Category</option>
									<option ng-repeat="option in category" value="{{option.pk_int_category_id}}" 
									ng-selected='option.pk_int_category_id==current_buisiness_edit.fk_int_category_id'>
								{{option.vchr_category_name}}</option>
							</select>
							<select ng-model="ng_cat" />
							<option value="">اختر الفئة</option>
							<option ng-repeat="option in category" value="{{option.pk_int_category_id}}" ng-selected='option.pk_int_category_id==current_buisiness_edit.fk_int_category_id'>
							{{option.vchr_category_name_ar}}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Location (موقعك) : </td>
					<td ng-init="get_location()">
						<select ng-model="ng_locatn" />
						<option value="">Select Location</option>
						<option ng-repeat="option in location" value="{{option.pk_int_location_id}}" 
						ng-selected='option.pk_int_location_id==current_buisiness_edit.fk_int_location_id'>
					{{option.vchr_location_name}}</option>
				</select>
				<select ng-model="ng_locatn" required/>
				<option value="">اختر موقعا</option>
				<option ng-repeat="option in location" value="{{option.pk_int_location_id}}" 
				ng-selected='option.pk_int_location_id==current_buisiness_edit.fk_int_location_id'>
			{{option.vchr_location_name_ar}}</option>
		</select>
	</td>
</tr>
<tr hidden="">
	<td>StreetView : </td>
	<td>
		<input type="text" id="stat" ng_model="ng_stat" disabled>
	</td>
</tr>
<tr>
	<td hidden="">Latitude (خط العرض): </td>
	<td hidden="">
		<input type="text" name="" id="latitude" ng-model="ng_lat" disabled/ >

	</td>

	<td colspan="4" >
		<input type="text" name="" placeholder="Type Location" id="searchname"ng-model="ng_searcht"  ng-change="searcht()" style="width: 100%; " />

		<p><div id="map" style="width:100%;height:300px "></div></p>
	</td>

</tr>
<tr>
	<td hidden="">Longitude (خط الطول) : </td>
	<td hidden="">
		<input type="text" name="" id="longitude" ng-model="ng_log" disabled/ >
	</td>
</tr>
<tr>
	<td>Opening Time (وقت مفتوح) : </td>
	<td><input type="time" name="" ng-model="ng_opn_time" / ></td>
</tr>
<tr>
	<td>Closing Time (وقت الإغلاق) : </td>
	<td><input type="time" name="" ng-model="ng_cls_time" id="clsingtime" / ></td>
</tr>
<tr>
	<td>Web URL (رابط الموقع) : </td>
	<td><input type="text" name="" ng-model="ng_url" / ></td>
</tr>

<tr>
	<td>Youtube Video Id ( رابط الفيديو ) :  </td>

	<td><img src="./assets/img/videoIDYoutube.png" height='100' /><br><br><input type="text" name="" ng-model="ng_video" / >    </td>
</tr>
<tr>
	<td>Description : </td>
	<td><input type="text" name="" ng-model="ng_desc" / ></td>
</tr>
<tr>
	<td>وصف : </td>
	<td><input type="text" name="" ng-model="ng_desc_ar" / ></td>
</tr>
<tr><td>
	Upload Special offer Pdf : <input type="checkbox" ng-checked="pdfshow" ng-click="pdfshow = !pdfshow" />
</td>
</tr>
<tr ng-show="pdfshow">
	<td>Select A Pdf File(سيليسيت صورة) : </td>
	<td>
		<input type="file" name="file"  accept="application/pdf" id="fileUpload1" ng-model="form.pdf" >
	</td>
</tr>

<tr ng-hide="add_updt_btn">
	<td><span ng-show="add_updt_btn">Replace All</span> Image (صورة) : </td>
	<td>
		<input type="file" name="file" multiple="true" accept="image/jpeg,jpg,png,PNG" id="fileUpload" ng-model="form.image" onchange="angular.element(this).scope().uploadedFile(this)">
	</td>
</tr>
<tr ng-show="add_updt_btn" >
	<td>Add Image (صورة) : </td>
	<td>
		<input type="file" name="file" multiple="true" accept="image/jpeg,jpg,png,PNG" id="buiimg_upload" ng-model="buiimg_upload" onchange="angular.element(this).scope().edit_img_set_save(this)">
	</td>
</tr>	
<tr>
	<td>
		(Image size must be 650px x 350px)
	</td>
</tr>
<tr>
	<td colspan=2>
		<center>
			<!--<div ng-app="myShoppingList" ng-controller="buisinessctrl">-->
				<!--     <ul>-->
					<!--       <li ng-repeat="x in products">{{x}}</li>-->
					<!--     </ul>-->
					<!--     <input ng-model="addMe">-->
					<!--       <button ng-click="addItem()">Add</button>-->
					<!--   </div>-->

					<div ng-app="myTagList" ng-cloak ng-controller="buisinessctrl" class="w3-card-2 w3-margin" style="max-width:400px;">
						<header class="w3-container w3-light-grey w3-padding-16">
							<h3>Tag List</h3>
						</header>
						<ul class="w3-ul">
							<li ng-repeat="x in tag" class="w3-padding-16">{{x}}<span ng-click="removeItem($index)" style="cursor:pointer;" class="w3-right w3-margin-right">×</span></li>
						</ul>
						<div class="w3-container w3-light-grey w3-padding-16">
							<div class="w3-row w3-margin-top">
								<div class="w3-col s10">
									<input placeholder="Add Tag items here" ng-model="addMe" class="w3-input w3-border w3-padding">
								</div>
								<div class="w3-col s2">
									<button ng-click="addItem()" class="w3-btn w3-padding w3-green">Add</button>
								</div>
							</div>
							<br> <br>
							<p class="w3-text-red">{{errortext}}</p>
						</div>
					</div>
					<!-- Trigger/Open The Modal -->
					<!--<button id="myBtn">Open Modal</button>-->

					<!-- The Modal -->
					<!--<div id="myModal" class="modal">-->

						<!-- Modal content -->
						<!--<div class="modal-content">-->
							<!--  <span class="close">&times;</span>-->
							<!--  <p>Some text in the Modal..</p>-->
							<!--</div>-->
						</div>
					</center>
				</td>
			</tr>
			<tr ng-show="add_updt_btn" >
				<td colspan="2" >
					<span  ng-repeat="option in ng_img_fully" class="upload-butn-wrapper">
						<img src="../apigateofqtr/upload/{{option.vchr_image_name}}" class="img-responsive img-thumbnail" width="100">

<!-- <button ng-click='delete_buisiness_image(option.pk_int_image_id);'><a href='#'  title='edit' style="cursor:pointer;">
<span class='glyphicon glyphicon-edit' ></span></a></button>
<input type="file" ng-click='edit_img_set(option.pk_int_image_id);' onchange="angular.element(this).scope().edit_img_set_save(this)" accept="image/jpeg,jpg,png,PNG" name="buiimg_upload"  id="buiimg_upload" ng-model="buiimg"> -->

<button ng-click='delete_buisiness_image(option.pk_int_image_id);'><a href='#'  title='Delete'>
	<span class='glyphicon glyphicon-remove' ></span></a>
</button>
<br>
<br>
</span>
</td>
</tr>
<tr>
	<td colspan="2"> 
		<button class="btn btn-success buttonload" ng-show="loading"><i class=" fa fa-circle-o-notch fa-spin"></i>Loading</button>
		<button ng-click='add_Buisiness_save()' ng-disabled='adding.$pending || adding.$invalid' class='btn btn-success' ng-show="add_btn">ADD(أضف)</button>
		<button ng-click='update_Buisiness_save()' ng-disabled='adding.$pending' class='btn btn-success' ng-show="add_updt_btn" >UPDATE(تحديث)</button>&nbsp;<button ng-click='Back()' class='btn btn-success' style="">BACK(رجوع)</button></td>
	</tr>
</table>
</form>
</div>
</section>
</div>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBvdGtRvUQ3sl4l2fua0FGcZLiqjlnnyvg&libraries=places'></script>

<script type="text/javascript">
/*
Open modale
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}*/
// if ng_name

function validateYouTubeUrl(url){
// alert(document.getElementById('youTubeUrl').value)
// var url = $('#youTubeUrl').val();
// var url = document.getElementById('youTubeUrl').value
var url = url
if (url != undefined || url != '') {
	var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
	var match = url.match(regExp);
	if (match && match[2].length == 11) {
// Do anything for being valid
// if need to change the url to embed url then use below line
// alert('true youtube url')
return true
// $('#ytplayerSide').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
}
else {
// alert('invalid youtube url')
return false
// Do anything for not being valid
}
}
}

var base_url='../apigateofqtr/index.php/ApiBuisiness/';
var app_Buisiness = angular.module('app_Buisiness', []);

var app = angular.module("myShoppingList", []); 

app_Buisiness.service('Map', function($q) {

	this.init = function() {
		var options = {
			center: new google.maps.LatLng(25.158525,51.2608477),
			zoom: 9,
			disableDefaultUI: true    
		}

		this.map = new google.maps.Map(
			document.getElementById("map"), options
			);
		this.places = new google.maps.places.PlacesService(this.map);
	}

	this.search = function(str) {
		var d = $q.defer();
		this.places.textSearch({query: str}, function(results, status) {
			if (status == 'OK') {
				d.resolve(results[0]);
			}
			else d.reject(status);
		});
		return d.promise;
	}

	this.addMarker = function(res) {
		if(this.marker) this.marker.setMap(null);
		this.marker = new google.maps.Marker({
			map: this.map,
			position: res.geometry.location,
			animation: google.maps.Animation.DROP,
			draggable: true
		});

		this.map.setCenter(res.geometry.location);

		document.getElementById('latitude').value = res.geometry.location.lat();
		document.getElementById('longitude').value = res.geometry.location.lng();
		var lati =  res.geometry.location.lat();
		var long =  res.geometry.location.lng();
		var streetViewService = new google.maps.StreetViewService();
		var STREETVIEW_MAX_DISTANCE = 100;
		var latLng = new google.maps.LatLng(lati, long);
		streetViewService.getPanoramaByLocation(latLng, STREETVIEW_MAX_DISTANCE, function (streetViewPanoramaData, status) {

			if (status === google.maps.StreetViewStatus.OK) {
// ok
console.log("ok");
document.getElementById('stat').value = "true";
// angular.element(document.getElementById('newPlaceCtrl')).scope().changeLanguageToarabic_ang();
// $scope.streetview = "true";
} else {
	console.log("notok");
	document.getElementById('stat').value = "false";
// $scope.streetview = "false";

// no street view available in this range, or some error occurred
}
});

		google.maps.event.addListener(this.marker, 'dragend', function(event) {

// console.log(event.latLng.lng());
document.getElementById('latitude').value = event.latLng.lat();
document.getElementById('longitude').value = event.latLng.lng();
var lati =  event.latLng.lat();
var long =  event.latLng.lng();
var streetViewService = new google.maps.StreetViewService();
var STREETVIEW_MAX_DISTANCE = 100;
var latLng = new google.maps.LatLng(lati, long);
streetViewService.getPanoramaByLocation(latLng, STREETVIEW_MAX_DISTANCE, function (streetViewPanoramaData, status) {
	if (status === google.maps.StreetViewStatus.OK) {
// ok
console.log("ok");
document.getElementById('stat').value = "true";
// $scope.streetview = "true";
} else {
	console.log("notok");
	document.getElementById('stat').value = "false";
// $scope.streetview = "false";

// no street view available in this range, or some error occurred
}
});

});


	}

});


app_Buisiness.controller('buisinessctrl', function($scope, $http, $filter, $timeout,Map) {

// $scope.changeLanguage = function (langKey) {
// 	$translate.use(langKey);
// };
$scope.addbtn = true;
$scope.view = true;
$scope.add = false;
$scope.form = [];       
$scope.files = [];
$scope.image_deleted = [];
$scope.length_of_images = 0;

// ADDING TAG
strtag=""
if (!$scope.tag){
	console.log("tag is null")
// alert("tag is null")
$scope.tag = [];
}

$scope.addItem = function () {
	$scope.errortext = "";
	if (!$scope.addMe) {return;}
	if ($scope.tag.indexOf($scope.addMe) == -1) {
		$scope.tag.push($scope.addMe);
		$scope.addMe = "";
		console.log($scope.tag)
	} else {
		$scope.errortext = "You have already added this tag.";
	}
	console.log($scope.tag.join('-'));
	strtag = $scope.tag.join('-')
}
$scope.removeItem = function (x) {
	$scope.errortext = "";    
	$scope.tag.splice(x, 1);
	console.log($scope.tag)
	strtag = $scope.tag.join('-')
}

$scope.pdf = [];     
$scope.files1 = [];
$scope.image_deleted1 = [];
$scope.length_of_images1 = 0; 

$scope.buiimg = [];     
$scope.buiimg_file = [];
$scope.buiimg_del = [];
$scope.buiimg_len = 0;  

$scope.place = {};
// $scope.searchPlace= "thootha";

$scope.initial = function(){
	$scope.addbtn = true;
	$scope.view = true;
	$scope.add = false;
	$scope.get_Buisiness();
// $scope.search();

// 		$scope.ng_searcht = "qatar"; 
// 		$scope.searcht();

}	

$scope.searcht = function() {
	Map.search($scope.ng_searcht)
	.then(
		function(res) { 
			Map.addMarker(res);
		}
		);
}


$scope.pdfshow=false;
$scope.Back = function(){
	$scope.addbtn = true;
	$scope.view = true;
	$scope.add = false;
	$scope.current_view = false;
// 		$scope.get_Buisiness();
document.location.reload(true);
$scope.pdfshow=false;
}	
$scope.add_Buisiness = function(){
// $scope.searcht();
$scope.addbtn = false;
$scope.view = false;
$scope.add = true;
$scope.add_btn = true;
$scope.add_updt_btn = false;
$scope.loading = false;
$scope.ng_name = ""; // required
$scope.ng_name_ar = ""; // required
$scope.ng_pincode = "";
$scope.ng_city = "";
$scope.ng_state = "";
$scope.ng_state_ar = "";
$scope.ng_mobile = "";
$scope.ng_alt_mobile = "";// required
$scope.ng_email = "";
$scope.ng_cat= "";// required
$scope.ng_locatn = "";// required
$scope.ng_desc= "";
$scope.ng_desc_ar= "";
// $scope.ng_opn_time= new Date(1576031430000);
// $scope.ng_cls_time= new Date(1576067430000);
$scope.ng_cls_time= new Date(2019, 11, 11, 18, 00, 0); //required
// document.getElementById("clstime").value = "08:00:00";
// document.getElementById("opntime").value = "18:00:00";
$scope.ng_opn_time= new Date(2019, 11, 11, 08, 00, 0); //required
$scope.ng_url= "";
$scope.ng_video= "";
$scope.ng_lat="";
$scope.ng_log="";
$scope.ng_stat="";
$scope.tag=[];
// $scope.form.image="";

}
$scope.uploadedFile = function(element) 
{
	$scope.currentFile = element.files;
// alert(element.files);
var reader = new FileReader();
var $fileUpload = $("input[type='file']");
if (parseInt($fileUpload.get(0).files.length)>5)
{
	$scope.form.image = [];
	alert("You can only upload a maximum of 5 files");
}
reader.onload = function(event) {
	$scope.image_source = event.target.result;
	$scope.$apply(function($scope) {
		$scope.files = element.files;
	});
}
reader.readAsDataURL(element.files[0]);
}
$scope.add_Buisiness_save = function() {
// 	if (validateYouTubeUrl($scope.ng_video) || $scope.ng_video=="") {
	if ($scope.ng_name == "") {
		alert("Business Name must be filled out");
		return false;
	}

	if ($scope.ng_name_ar == "") {
		alert("Business Name in arabic must be filled out");
		return false;
	}

	if ($scope.ng_mobile == "") {
		alert("Mobile number must be filled out");
		return false;
	}

	if ($scope.ng_alt_mobile == "") {
		alert("Alternate mobile number must be filled out");
		return false;
	}
	if ($scope.ng_cat == "") {
		alert("Category must be chosen");
		return false;
	}
	if ($scope.ng_locatn == "") {
		alert("location must be chosen");
		return false;
	}
	if ($scope.ng_opn_time == "") {
		alert("Opening time must be filled out");
		return false;
	}

	if ($scope.ng_cls_time == "") {
		alert("Closing time must be filled out");
		return false;
	}

	$scope.loading = true;
	$scope.add_btn = false;
	$scope.ng_state = "a";
	$scope.ng_state_ar = "abc";
	var new_hour_op = $scope.ng_opn_time.getHours();
	var new_minute_op = $scope.ng_opn_time.getMinutes();
	var op_time = new Date(2019, 11, 11, new_hour_op, new_minute_op);
// alert(d.getTime());return;
console.log("op t",op_time)

var new_hour_cl = $scope.ng_cls_time.getHours();
var new_minute_cl = $scope.ng_cls_time.getMinutes();
var cl_time = new Date(2019, 11, 11, new_hour_cl, new_minute_cl);
console.log("cls t",cl_time)
// alert();return;

$scope.ng_opn_time = op_time.getTime();
$scope.ng_cls_time = cl_time.getTime(); 

$scope.ng_pincode = 1;
$scope.ng_city = 2;
$scope.ng_stat = document.getElementById('stat').value;
$scope.ng_lat = document.getElementById('latitude').value;
$scope.ng_log = document.getElementById('longitude').value;

$scope.url = base_url+'add_Buisiness';

$scope.form.pdf = $scope.files1[0];



var fileInput1 = document.getElementById('fileUpload1');
$scope.form.image = $scope.files[0];
var fileInput = document.getElementById('fileUpload');
//   if(fileInput.files.length){
	if(fileInput.files.length > 5) alert('please select only 5 pictures');

	else
	{
        console.log(strtag)
        $http({
            
            method  : 'POST',
            url     : $scope.url,
            processData: false,
            transformRequest: function (data) {
                var formData = new FormData();
                var daa={ 
                    'name': $scope.ng_name,
                    'namear': $scope.ng_name_ar, 
                    'pincode': $scope.ng_pincode,
                    'city': $scope.ng_city,
                    'state': $scope.ng_state,
                    'statear': $scope.ng_state_ar,
                    'mobile': $scope.ng_mobile,
                    'alt_mobile': $scope.ng_alt_mobile,
                    'email': $scope.ng_email,
                    'cat': $scope.ng_cat,
                    'locatn': $scope.ng_locatn,
                    'desc':$scope.ng_desc,
                    'descar':$scope.ng_desc_ar,
                    'opntime':$scope.ng_opn_time,
                    'clstime':$scope.ng_cls_time,
                    'lat':$scope.ng_lat,
                    'log':$scope.ng_log,
                    'weburl':$scope.ng_url,
                    'videolink':$scope.ng_video,
                    'stat':$scope.ng_stat,
                    'tag':strtag,
        };

		var str_daa = JSON.stringify(daa);
		$scope.loading = false;
		for(var i = 0;i < fileInput.files.length;i++){
			formData.append("image[]", fileInput.files[i]);
		}
		for(var i = 0;i < fileInput1.files.length;i++){
			formData.append("pdf[]", fileInput1.files[0]);
		}
		formData.append("data",str_daa);                                
		return formData;  
	},  
	data : $scope.form,
	headers: {
		'Content-Type': undefined
	}
}).success(function(data){

	$scope.initial();
	alert(data);
});


// alert($scope.ng_video);


}

//   }
//   else{

//   	alert('invalid youtube url')
//   }


//  else
//  	{alert("please select image");}
}

$scope.update_Buisiness_save = function(){
// 		if (validateYouTubeUrl($scope.ng_video) || $scope.ng_video==""){
	$scope.loading = true;
	$scope.add_updt_btn = false;
	$scope.url = base_url+'update_Buisiness';
	var new_hour_op = $scope.ng_opn_time.getHours();
	var new_minute_op = $scope.ng_opn_time.getMinutes();
	var op_time = new Date(2019, 11, 11, new_hour_op, new_minute_op, 30, 0);
	var new_hour_cl = $scope.ng_cls_time.getHours();
	var new_minute_cl = $scope.ng_cls_time.getMinutes();
	var cl_time = new Date(2019, 11, 11, new_hour_cl, new_minute_cl, 30, 0);
	$scope.ng_opn_time = op_time.getTime();
	$scope.ng_cls_time = cl_time.getTime(); 
	$scope.ng_pincode = 1;
	$scope.ng_city = 2;

	$scope.ng_stat = document.getElementById('stat').value;
	$scope.ng_lat = document.getElementById('latitude').value;
	$scope.ng_log = document.getElementById('longitude').value;
	$scope.form.pdf = $scope.files1[0];
	var fileInput1 = document.getElementById('fileUpload1');
	$scope.form.image = $scope.files[0];
	var fileInput = document.getElementById('fileUpload');
	if(fileInput.files.length > 5) alert('please select only 5 pictures');

	else
		$http({
			method  : 'POST',
			url     : $scope.url,
			processData: false,
			transformRequest: function (data) {
				var formData = new FormData();
				$scope.loading = false;
				var daa={
					'img':$scope.ng_img,
					'pdf':$scope.ng_pdf,
					'bid': $scope.current_buisiness_edit.pk_int_business_id,
					'aid': $scope.current_buisiness_edit.pk_int_address_id, 
					'name': $scope.ng_name,
					'namear': $scope.ng_name_ar, 
					'pincode': $scope.ng_pincode,
					'city': $scope.ng_city,
					'statear': $scope.ng_state_ar,
					'state': $scope.ng_state,
					'mobile': $scope.ng_mobile,
					'alt_mobile': $scope.ng_alt_mobile,
					'email': $scope.ng_email,
					'cat': $scope.ng_cat,
					'locatn': $scope.ng_locatn,
					'desc':$scope.ng_desc,
					'descar':$scope.ng_desc_ar,
					'lat':$scope.ng_lat,
					'log':$scope.ng_log,
					'opntime':$scope.ng_opn_time,
					'clstime':$scope.ng_cls_time,
					'weburl':$scope.ng_url,
					'videolink':$scope.ng_video,
					'stat':$scope.ng_stat,
					'tag':strtag,
				};
				var str_daa = JSON.stringify(daa);
				for(var i = 0;i < fileInput.files.length;i++){
					formData.append("image[]", fileInput.files[i]);
				}
				for(var i = 0;i < fileInput1.files.length;i++){
					formData.append("pdf[]", fileInput1.files[0]);
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
// 		}
// 		else{
// 				alert('invalid youtube link')
// 		}



}

$scope.get_Buisiness = function(){
	$scope.url = base_url+'select_Buisiness';
	$scope.token = "token";
	$http.post($scope.url,{'token':$scope.token}).then(function(response){
// alert(JSON.stringify(response.data[0].vchr_opn_time));
$scope.buisiness = response.data;
$scope.vchr_image_name = "dummy.jpg";
}); 
}

/*GET BY CATEGORY START*/
$scope.get_Buisiness_by_category = function(){
	$scope.url = base_url+'select_Buisiness_by_category';
	$scope.token = "token";
	$http.post($scope.url,{'token':$scope.token}).then(function(response){
// alert(JSON.stringify(response.data[0].vchr_opn_time));
$scope.buisiness = response.data;
$scope.vchr_image_name = "dummy.jpg";
}); 
}
/*GET BY CATEGORY END*/

$scope.get_category = function(){
	var req = {
		method: 'POST',
		url: base_url+'select_category',
		headers: {'Content-Type': undefined }
	};
	$http(req).then(function(response){
// alert(JSON.stringify(response.data));
$scope.category = response.data;
}); 
}
$scope.get_location = function(){
	var req = {
		method: 'POST',
		url: base_url+'select_location',
		headers: {'Content-Type': undefined }
	};
	$http(req).then(function(response){
// alert(JSON.stringify(response.data));
$scope.location = response.data;
}); 
}                                                
$scope.view_full = function(id) {
// alert("sdas");
$scope.current_edit_img(id);
$scope.addbtn = false;
$scope.view = false;
$scope.add = false;
$scope.current_view = true;	
$scope.id = id;
$scope.url = base_url+'select_current_Buisiness';
$http.post($scope.url,{'id':$scope.id}).then(function(response){
// alert(JSON.stringify(response.data[0]));
$scope.current_buisiness = response.data[0];
$scope.openin = new Date($scope.current_buisiness.vchr_opn_time);
$scope.hour = $scope.openin.getHours($scope.current_buisiness.vchr_opn_time);
$scope.minute = $scope.openin.getMinutes($scope.current_buisiness.vchr_opn_time);
$scope.opening = JSON.stringify($scope.hour) + " : " + JSON.stringify($scope.minute);   

$scope.closin= new Date($scope.current_buisiness.vchr_cls_time);
$scope.hourc = $scope.closin.getHours($scope.current_buisiness.vchr_cls_time);
$scope.minutec = $scope.closin.getMinutes($scope.current_buisiness.vchr_cls_time);
$scope.closing = JSON.stringify($scope.hourc) + " : " + JSON.stringify($scope.minutec);  
$scope.get_Buisiness();
});
}
$scope.current_edit = function(id){
// 	document.getElementById("hide").readOnly = true;
$scope.current_edit_img(id);
$scope.addbtn = false;
$scope.view = false;
$scope.add = true;
$scope.current_view = false;
$scope.add_updt_btn = true;

$scope.id = id;
$scope.url = base_url+'select_current_Buisiness';
// alert("select business");
$http.post($scope.url,{'id':$scope.id}).then(function(response){
// alert(JSON.stringify(response.data[0]));
$scope.current_buisiness_edit = response.data[0];
// alert(JSON.stringify($scope.current_buisiness_edit));
$scope.ng_img = $scope.current_buisiness_edit.vchr_image_name;
$scope.ng_pdf = $scope.current_buisiness_edit.vchr_pdf;

$scope.ng_name = $scope.current_buisiness_edit.vchr_name;
$scope.ng_name_ar = $scope.current_buisiness_edit.vchr_name_ar;
$scope.ng_pincode = $scope.current_buisiness_edit.int_pincode;
$scope.ng_city = $scope.current_buisiness_edit.vchr_city;
$scope.ng_state = $scope.current_buisiness_edit.vchr_state;
$scope.ng_state_ar = $scope.current_buisiness_edit.vchr_state_ar;
$scope.ng_mobile = $scope.current_buisiness_edit.int_mobile;
$scope.ng_alt_mobile = $scope.current_buisiness_edit.int_alt_mobile;
$scope.ng_email = $scope.current_buisiness_edit.vchr_email;
$scope.ng_cat= $scope.current_buisiness_edit.fk_int_category_id;
$scope.ng_locatn = $scope.current_buisiness_edit.fk_int_location_id;
$scope.ng_desc= $scope.current_buisiness_edit.text_description;
$scope.ng_desc_ar= $scope.current_buisiness_edit.text_description_ar;
$scope.ng_opn_time= new Date($scope.current_buisiness_edit.vchr_opn_time);
$scope.ng_cls_time= new Date($scope.current_buisiness_edit.vchr_cls_time);
$scope.ng_url= $scope.current_buisiness_edit.vchr_weburl;
$scope.ng_video= $scope.current_buisiness_edit.vchr_video_link;
$scope.ng_lat=$scope.current_buisiness_edit.float_lat;
$scope.ng_log=$scope.current_buisiness_edit.float_log;
$scope.ng_stat=$scope.current_buisiness_edit.vchr_status;
// $scope.tag=$scope.current_buisiness_edit.vchr_tag.split("-");

// $scope.tag = $scope.current_buisiness_edit.vchr_tag.split("-");
console.log("lenght",$scope.tag)
$scope.tag =  $scope.current_buisiness_edit.vchr_tag.split("-");
console.log("lenght",$scope.tag)
if ($scope.tag == ""){
	$scope.tag=[]
	console.log("re initialised")
}

$scope.addItem = function () {
	$scope.errortext = "";
	if (!$scope.addMe) {return;}
	if ($scope.tag.indexOf($scope.addMe) == -1) {
		$scope.tag.push($scope.addMe);
		$scope.addMe = "";
		console.log($scope.tag)
	} else {
		$scope.errortext = "The item is already in your shopping list.";
	}
	console.log($scope.tag.join('-'));
	strtag = $scope.tag.join('-')
}
$scope.removeItem = function (x) {
	$scope.errortext = "";    
	$scope.tag.splice(x, 1);
	console.log($scope.tag)
	strtag = $scope.tag.join('-')
}

console.log($scope.ng_tag);


});
}
$scope.delete_buisiness = function(bid,aid){
	if(confirm("Are You Sure Want To Delete?")){
		$scope.bid = bid;
		$scope.aid = aid;
		$scope.url = base_url+'delete_business';
		$http.post($scope.url,{'aid':$scope.aid,'bid':$scope.bid}).then(function(response){
// alert(JSON.stringify(response.data));
$scope.get_Buisiness();
});
	}
}
$scope.current_edit_img = function(id){
	$scope.id = id;
	$scope.url = base_url+'select_business_images';
	$http.post($scope.url,{'id':$scope.id}).then(function(response){ 
// alert(JSON.stringify(response.data));
$scope.ng_img_fully = response.data;

});
}
$scope.delete_buisiness_image = function(biid){
//  alert(bid);
if(confirm("Are You Sure Want To Delete?")){
	$scope.biid = biid;
	$scope.url = base_url+'delete_business_image';
	$http.post($scope.url,{'biid':$scope.biid}).then(function(response){
		$scope.initial();

// alert(JSON.stringify(parseInt(response.data)));
// $scope.current_edit_img(parseInt($scope.biid));
});
}
}
$scope.edit_img_set = function(biid){
	$scope.biid = biid;
}
$scope.edit_img_set_save = function(){
// 		alert($scope.id);
// $scope.buiimg = $scope.buiimg_file[0];
var fileInput_buiimg = document.getElementById('buiimg_upload');
$scope.url = base_url+'edit_bui_img';
$http({
	method  : 'POST',
	url     : $scope.url,
	processData: false,
	transformRequest: function (data) {
		var formData = new FormData();
		$scope.loading = false;
		var daa={'biid':$scope.id,

	};
	var str_daa = JSON.stringify(daa);
	for(var i = 0;i < fileInput_buiimg.files.length;i++){
		formData.append("image[]", fileInput_buiimg.files[i]);
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
$scope.filter = function() {
	$timeout(function() {
		$scope.filteredItems = $scope.filtered.length;
	}, 10);
};
Map.init();
});
</script>
</html>
<?php include 'footer.php';?>
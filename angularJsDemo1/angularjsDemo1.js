
/*<!-- ============================== ANGULAR JS ================================ -->*/

/*Phần này dùng để chính sửa data (phần admin) cho project angularJsDemo1 
	-> view tại /application/views/AngularHome.php
	-> controller tại /application/controllers/AngularDemo1.php
*/
﻿var app = angular.module('angularDemo1',['ngMaterial', 'ui.select', 'ngSanitize']);
/*'	ui.select', 'ngSanitize' là thư viện phụ thuộc để set up cho chức năng angular ui select
	2 thư viện này đưa vòa module thì ko thể chạy ngRoute đc -> báo lỗi*/


var linkRootGetData = "http://127.0.0.1:8888/phpBasic4/AngularDemo1/"

app.controller('AngularJsControllerDemo1',  function($scope, $http, $mdToast){
	/*lấy data ra*/
	$http.get(linkRootGetData+"selectAngularDemo1")	/*xử lý trong page update (Angular Home.php)*/
		.then(function (argument) {
			console.log(argument.data);
			$scope.datasAngDemo1 = argument.data;	/*argument.data là 1 chuỗi json*/
		}, function (er) {
			console.log(er);
		});
	$scope.changeDisplayAngDemo1 = function (aDataAngDemo1) {
		aDataAngDemo1.displayDataAngDemo1 = !aDataAngDemo1.displayDataAngDemo1;
	}

	/*lưu data vào*/
	$scope.saveDatabaseAngDemo1 = function (aDataAngDemo1) {						/*xử lý trong page update (Angular Home.php)*/
		aDataAngDemo1.displayDataAngDemo1 = !aDataAngDemo1.displayDataAngDemo1;
		var data =$.param({
			idAngDemo1 : aDataAngDemo1.id,
			pageAngDemo1 : aDataAngDemo1.page,
			titleAngDemo1 : aDataAngDemo1.title,
			subtitleAngDemo1 : aDataAngDemo1.subtitle,
			contentAngDemo1 : aDataAngDemo1.content,
			imageAngDemo1 : aDataAngDemo1.image,
			authorAngDemo1 : aDataAngDemo1.author,
			dateAngDemo1 : aDataAngDemo1.date
		})
		console.log(data);
		var config = {
			headers:{
				'content-type': 'application/x-www-form-urlencoded;charset=UTF-8'   /*config utf-8*/
			}
		}
		$http.post(linkRootGetData+'updateAngularDemo1', data, config)
			.then(function function_name(res) {
				if (res.data=='success') {
					$scope.showSimpleToast();
					console.log("ok");
				}
			}, function function_name(er) {
				if (er.data=="fail") {
					console.log("not ok");
				}
			});
	}

	/*ANGULAR MATERIAL TOAST (chỉ cần copy vào đây là đủ)*/
	var last = {
      bottom: false,
      top: true,
      left: false,
      right: true};
	$scope.toastPosition = angular.extend({},last);
	$scope.getToastPosition = function() {
		sanitizePosition();
		return Object.keys($scope.toastPosition)
		  .filter(function(pos) { return $scope.toastPosition[pos]; })
		  .join(' ');};
	function sanitizePosition() {
		var current = $scope.toastPosition;

		if ( current.bottom && last.top ) current.top = false;
		if ( current.top && last.bottom ) current.bottom = false;
		if ( current.right && last.left ) current.left = false;
		if ( current.left && last.right ) current.right = false;

		last = angular.extend({},current);}
	$scope.showSimpleToast = function() {
		var pinTo = $scope.getToastPosition();
		$mdToast.show(
		  $mdToast.simple()
			    .textContent('Cập nhật thành công!')
			    .position(pinTo )
			    .hideDelay(3000)
			);};
	$scope.showActionToast = function() {
		var pinTo = $scope.getToastPosition();
		var toast = $mdToast.simple()
		  .textContent('Marked as read')
		  .action('UNDO')
		  .highlightAction(true)
		  .highlightClass('md-accent')// Accent is used by default, this just demonstrates the usage.
		  .position(pinTo);
		$mdToast.show(toast).then(function(response) {
			  if ( response == 'ok' ) {
			    alert('You clicked the \'UNDO\' action.');
			  }
			});};











  /*XỬ LÝ ANGULAR UI SELECT



  	ANGULAR UI SELECT BASIC
  	Bước 1: setup: link các file css và js tại file này và load tại đây
  	*/
  	// $scope.itemArray = [	/*itemArray là 1 biến đc định nghĩa trong scope -> angular ui select sẽ truyền đến view thông qua biến này*/
   //      {id: 1, name: 'first'},
   //      {id: 2, name: 'second'},
   //      {id: 3, name: 'third'},
   //      {id: 4, name: 'fourth'},
   //      {id: 5, name: 'fifth'},
   //  ];
    



    /*Bước 2: Sử dụng thư viện, kiểm soát data trả về*/
    /*Lấy data từ database, tại cột nameAttribute, dòng menuDacap ra truyền vào view AngularHome.php thông qua link tại $http.get(<link>)*/
    $http.get(linkRootGetData+"selectAngularUiSelect").then(function (res) {
	    	console.log(res.data);	/*Sau khi lấy đc data thì đặt vào mảng itemArray trên và truyền vào view hiển thị ra*/
	    	$scope.itemArray = res.data;
	    	$scope.selected = { value: $scope.itemArray[0] };	/*khi select thì mặc định lựa chọn phần tử đầu tiên*/
	    }, function (res) {
    	
    });
    $scope.getDataAngUiSelect = function () {			/*Click vào button Save Data, data từ view trả về tại function này*/
    	console.log($scope.selected["value"]["id"]);	/*lấy đc id*/
    	console.log($scope.selected["value"]["title"]);	/*và title, id và title này chính là tại trường id và title trong db*/
    }











    /*ANGULAR UI SELECT MULTIPLE SELECTION*/
    vm = this;
    // vm.availableDatas = ['Red','Green','Blue','Yellow','Magenta','Maroon','Umbra','Turquoise'];
	// vm.singleDemo = {};
	// console.log("vm"+vm.multipleDemo)
	
	$http.get(linkRootGetData+"selectAngularUiSelect").then(function (res) {
		console.log(res.data);
		vm.availableDatas = res.data;
		vm.multipleDemo={};
		vm.multipleDemo.element=[];
	}, function (res) {
		// body...
	});

	$scope.getDataAngUiMultipleSelect= function ($dataMultipleSelect) {	/*click vào button Save data*/
		console.log($dataMultipleSelect);
		for (var i = 0; i < $dataMultipleSelect.length; i++) {
			console.log($dataMultipleSelect[i].id);	/*.id:trường id trong database,cột valueAttribute,dòng menuDacap,lấy id để updata data*/
		}
	}











	/*XỬ LÝ FORM TRONG ANGULAR (xử lý tại file này, file js và file css)*/
	$scope.resetInputFormAngular = function (checkFormByAngular) {
		checkFormByAngular.$setPristine();	/*setPristine: xóa trắng tất cả input đc điền vào trong form và các div liên quan*/
	}
})
























/*Phần này dùng để hiển thị data (phần view cho user) cho project angularJsDemo1 
	-> view tại /angularJsDemo1/index.html
	-> controller tại /application/controllers/AngularDemo1.php
*/
var app2 = angular.module('angularDemoForRoute',['ngMaterial', 'ngRoute']);

app2.config(function ($routeProvider, $locationProvider) {	/*set đường dẫn cho từng phần của one page*/
	$locationProvider.html5Mode(true);
	$routeProvider
		.when('/', {
		templateUrl: 'content_index.html',
		controller: "homeController"	
	})
		.when('/about', {
		templateUrl: 'content_about.html',	/*fix bug refresh lại page about => search key: angular htaccess redirect route */
		controller: "aboutController"		/*tạo file mới .htaccess tại angularJsDemo1/.htaccess  => paste code copy đc vào*/
	})
		.when('/contact', {					/*trong file .htaccess chú ý đổi lại đường dẫn cơ sở tại line 12 file .htaccess*/
		templateUrl: 'content_contact.html',/*đường dẫn cơ sở zống vs đường dẫn cơ sở tại line 9 file angularJsDemo1/index.html*/
		controller: "contactController"
	})
		.when('/post', {
		templateUrl: 'content_post.html'
	})
	.otherwise({ redirectTo: '/' })
})


/*Controller cho page About*/
app2.controller('aboutController',function ($scope, $http) { 		/*$http đề lấy data từ backend*/
	var linkGetData = linkRootGetData+"selectAngularDemo1ById/0";	/*đẩy dữ liệu ra view, dữ liệu about có id=0*/
	$http.get(linkGetData)
		.then(function (argument) {
			// console.log(argument.data);
			/*zải thích chỗ này:
				để từ js đưa data ra view, thì phải đưa argument.data vào view (index.html). tức là đẩy ra frontend
				Mà muốn đẩy ra frontend thì phải gán vào scope thì ở frontend mới nhận đc (đẩy biến datasAngDemo1 qua content_about.html)
			*/
			$scope.datasAngDemo1=argument.data;/*argument.data là 1 chuỗi json, đặt 1 biến tên là datasAngDemo1, frontend sẽ nhận biến này*/
			console.log(linkGetData);
		}, function (er) {
			console.log(er);
		});
})

/*Controller cho page Content*/
app2.controller('contactController',function ($scope, $http) { 		/*$http đề lấy data từ backend*/
	var linkGetData = linkRootGetData+"selectAngularDemo1ById/1";	/*đẩy dữ liệu ra view, dữ liệu contact có id=1*/
	$http.get(linkGetData)
		.then(function (argument) {
			// console.log(argument.data);
			/*zải thích chỗ này:
				để từ js đưa data ra view, thì phải đưa argument.data vào view (index.html). tức là đẩy ra frontend
				Mà muốn đẩy ra frontend thì phải gán vào scope thì ở frontend mới nhận đc (đẩy biến datasAngDemo1 qua content_about.html)
			*/
			$scope.datasAngDemo1=argument.data;/*argument.data là 1 chuỗi json, đặt 1 biến tên là datasAngDemo1, frontend sẽ nhận biến này*/
			console.log(linkGetData);
		}, function (er) {
			console.log(er);
		});
})

/*Tương tự, có thể làm controller cho phần Home và phần post*/

/*Controller cho page Home*/
app2.controller('homeController',function ($scope, $http) { 			/*$http đề lấy data từ backend*/
	var linkGetData = linkRootGetData+"selectAngularDemo1ById/2";	/*đẩy dữ liệu ra view, dữ liệu home có id=2*/
	$http.get(linkGetData)
		.then(function (argument) {
			// console.log(argument.data);
			/*zải thích chỗ này:
				để từ js đưa data ra view, thì phải đưa argument.data vào view (index.html). tức là đẩy ra frontend
				Mà muốn đẩy ra frontend thì phải gán vào scope thì ở frontend mới nhận đc (đẩy biến datasAngDemo1 qua content_about.html)
			*/
			$scope.datasAngDemo1=argument.data;/*argument.data là 1 chuỗi json, đặt 1 biến tên là datasAngDemo1, frontend sẽ nhận biến này*/
			console.log(linkGetData);
		}, function (er) {
			console.log(er);
		});

	var linkGetAllData = linkRootGetData+"selectAngularDemo1";		/*Lấy hết toàn bộ dữ liệu ra*/
	$http.get(linkGetAllData).then(function (argument) {
		$scope.datasContentAngDemo1 = argument.data;
	}, function (er) {
		console.log(er);
	})
})


/*<!-- ============================== ANGULAR JS (xử lý cho phần frontend)================================ -->*/

/*Phần này dùng để hiển thị data (phần view cho user) cho project angularJsDemo1 
	-> view tại /angularJsDemo1/index.html
	-> controller tại /application/controllers/AngularDemo1.php
*/
var app2 = angular.module('angularDemoForRoute',['ngMaterial', 'ngRoute']);

var linkRootGetData = "http://127.0.0.1:8888/phpBasic4/AngularDemo1/"

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

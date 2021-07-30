(function($) {
/*<!-- ============================== ANGULAR JS ================================ -->*/

﻿var app = angular.module('angularDemo2',['ngMaterial','ngRoute']);	  /*xử lý route:add thêm thư viện phụ thuộc ngRoute*/

var urlAPI = "http://127.0.0.1:8888/phpBasic4/AngularDemo1/";/*xử lý route:add thêm biến phụthuộc $routeProvider,$locationProvider*/

app.config(function ($routeProvider, $locationProvider) {
	$locationProvider.html5Mode(true);/*Đầu tiên bật chế độ html5mode, bật html5 thì ở file index.html phải để base tại line7(index.html)*/
	$routeProvider 					  /*chú ý add và chỉnh sửa thêm file angularJsDemo2/milestone-120/html/app/.htaccess */
		.when('/',{
			templateUrl: 'navData/adminHome.html',	/*trang chủ của page admin*/
			controller: 'adminHomeController'
		})
		.when('/adminHome',{
			templateUrl: 'navData/adminHome.html',	/*trang chủ của page admin*/
			controller: 'adminHomeController'
		})
		.when('/userList',{
			templateUrl: 'navData/userList.html',	/*trang chủ của page admin*/
			controller: 'userListController'
		})
		.when('/userAdd',{
			templateUrl: 'navData/userAdd.html',	/*trang chủ của page admin*/
			controller: 'userAddController'
		})
		.when('/userLogin',{
			templateUrl: 'navData/userSignIn.html',	/*trang chủ của page admin*/
			controller: 'userSignInController'
		})
		.otherwise({ redirectTo: '/' })	
});
app.controller('adminHomeController',  function($scope, $http, $mdToast, $rootScope, $location){	
	if (!$rootScope.loginStatus) {		/*đầu tiên phải kiểm tra xem trạng thái đăng nhập này có quyền admin hay k*/
		$location.path("/userLogin");	/*loginStatus đc định nghĩa tại controller userSignInController (khi đăng nhập Admin thành công)*/
	}	/*nếu chưa đc đăng nhập thì chuyển hướng đến trang đăng nhập*/
});














/*xử lý phần listcontroller*/
app.controller('userListController',  function($scope, $http, $mdToast, $rootScope, $location){	
	if (!$rootScope.loginStatus) {		/*đầu tiên phải kiểm tra xem trạng thái đăng nhập này có quyền admin hay k*/
		$location.path("/userLogin");	/*loginStatus đc định nghĩa tại controller userSignInController (khi đăng nhập Admin thành công)*/
	}	/*nếu chưa đc đăng nhập thì chuyển hướng đến trang đăng nhập*/

	$rootScope.titlePage="Dữ liệu người dùng";
	$http.get(urlAPI+'getAll').then(function (res) {	/*lấy hết data user ra, đưa và hiển thị ra view (chức năng select)*/
		// console.log(res.data);
		$scope.users = res.data;
	}, function (er) {
		// body...
	})

	$scope.changeDisplayUserDemo2 =function (aUser) {	/*chuyển đổi phần hiển thị và phần chỉnh sửa*/
		aUser.displayUserDemo2=!aUser.displayUserDemo2;
	}

	/*UPDATE DATA TỪ VIEW VÀO DATABASE*/
	$scope.saveChangeDataUserDemo2 = function (aUser) {	/*update vào db sau khi chỉnh sửa (chức năng update và delete)*/
		aUser.displayUserDemo2=!aUser.displayUserDemo2;
		var newData = $.param({
			idLogin : aUser.idLogin,
			usernameLogin : aUser.nameLogin,
			emailLogin : aUser.emailLogin,
			// dateCreateUpdate : aUser.dateCreate,
			adminLogin : aUser.adminLogin,
			isDeleteLogin : aUser.isDeleteLogin,
		});
		var config = {
			headers:{
				'content-type': 'application/x-www-form-urlencoded;charset=UTF-8'
			}
		}
		// console.log(urlAPI+'updateUserOrAdmin/'+aUser.idLogin);
		$http.post(urlAPI+'updateUserOrAdmin/'+aUser.idLogin, newData, config)
			.then(function(res) {
				if (res.data=='success') {
					$scope.showSimpleToast('success');
				}
				else{
					$scope.showSimpleToast('fail');
				}
			}, function(er) {
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
	  right: true
	};
	$scope.toastPosition = angular.extend({},last);
	$scope.getToastPosition = function() {
		sanitizePosition();
	
		return Object.keys($scope.toastPosition)
		  .filter(function(pos) { return $scope.toastPosition[pos]; })
		  .join(' ');
	};
	function sanitizePosition() {
		var current = $scope.toastPosition;
	
		if ( current.bottom && last.top ) current.top = false;
		if ( current.top && last.bottom ) current.bottom = false;
		if ( current.right && last.left ) current.left = false;
		if ( current.left && last.right ) current.right = false;
	
		last = angular.extend({},current);
	}
	$scope.showSimpleToast = function(successOrFail) {
		var pinTo = $scope.getToastPosition();
	
		$mdToast.show(
		  $mdToast.simple()
			    .textContent('Update '+successOrFail+'!')
			    .position(pinTo )
			    .hideDelay(3000)
			);
	};
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
			});
	};
});














/*Xử lý angular phần add user*/
app.controller('userAddController',  function($scope, $http, $mdToast, $rootScope, $location){	
	if (!$rootScope.loginStatus) {		/*đầu tiên phải kiểm tra xem trạng thái đăng nhập này có quyền admin hay k*/
		$location.path("/userLogin");	/*loginStatus đc định nghĩa tại controller userSignInController (khi đăng nhập Admin thành công)*/
	}	/*nếu chưa đc đăng nhập thì chuyển hướng đến trang đăng nhập*/

	/*khi chuyển zữa các route khác nhau thì vẫn zữ zá trị này (đưa zá trị này ra ngoài controller userAddController) -> cần có rootScope*/
	$rootScope.titlePage = "Add User to database into login table";
	/*nhấn vào button submit thì gửi data đến server, check data và feedback zề*/
	$scope.insertUserDemo2 = function () {	/*Lấy thông tin người dùng nhập vào -> dùng ng-model trong */
		// console.log($scope.usernameDemo2);/*userAdd.html và sử dụng scope để nhận usernameDemo2 từ userAdd.html. function này ở submit*/
		var newData = $.param({
			usernameLogin : $scope.usernameDemo2,
			emailLogin : $scope.emailDemo2,
			passwordLogin : $scope.passwordDemo2,
			adminLogin : '0'
		});
		console.log(newData);

		var config = {
			headers:{
				'content-type': 'application/x-www-form-urlencoded;charset=UTF-8'
			}
		}
		$http.post(urlAPI+'addUserOrAdmin', newData, config)
			.then(function(res) {
				console.log(res.data);
				if (res.data=='success') {
					$scope.showSimpleToast(res.data);
					$scope.usernameDemo2 = '';	/*sau khi xử lý xong, đẩy vào đc db thì set cho các input về rỗng*/
					$scope.emailDemo2 = '';
					$scope.passwordDemo2 = '';
					console.log("ok");
				}
			}, function(er) {
				if (er.data=="fail") {
					$scope.showSimpleToast(res.data);
					console.log("not ok");
				}
			});
	}
	/*ANGULAR MATERIAL TOAST (chỉ cần copy vào đây là đủ)	-> phím tắt: toast -> tab*/
	var last = {
	  bottom: true,
	  top: false,
	  left: true,
	  right: false
	};
	$scope.toastPosition = angular.extend({},last);
	$scope.getToastPosition = function() {
		sanitizePosition();
	
		return Object.keys($scope.toastPosition)
		  .filter(function(pos) { return $scope.toastPosition[pos]; })
		  .join(' ');
	};
	function sanitizePosition() {
		var current = $scope.toastPosition;
	
		if ( current.bottom && last.top ) current.top = false;
		if ( current.top && last.bottom ) current.bottom = false;
		if ( current.right && last.left ) current.left = false;
		if ( current.left && last.right ) current.right = false;
	
		last = angular.extend({},current);
	}
	$scope.showSimpleToast = function(successOrFail) {
		var pinTo = $scope.getToastPosition();
		console.log('msg')
		$mdToast.show(
		  $mdToast.simple()
			    .textContent('Update '+successOrFail+'!')
			    .position(pinTo )
			    .hideDelay(3000)
			);
	};
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
			});
	};
});















/*Xử lý angular phần login*/
app.controller('userSignInController',  function($scope, $http, $mdToast, $rootScope, $location){	/*$location cho phép chuyển hướng*/
	$rootScope.appDemo2="offcanvas";/*tắt menu bêntrái mànhình khi chứcnăng đăngnhập đc sửdụng,$rootScope.appDemo2 vì ngoài controllernày*/
	$rootScope.displayHeader=false;	/*đồng thời tắt header*/
	$rootScope.titlePage = "Login";	/*và title zờ là Login*/
	$scope.checkLoginDemo2 = function (userSignIn) {	/*nhấn vào button Login thì gửi data đến server, check data và feedback zề*/
		var checkdata = $.param({	/*gõ sendApiAngular -> tab*/
			emailLogin : $scope.userSignIn.emailDemo2,
			passwordLogin: $scope.userSignIn.passwordDemo2
		});
		var config = {
			headers:{
				'content-type': 'application/x-www-form-urlencoded;charset=UTF-8'
			}
		}
		$http.post(urlAPI+'checkLogin', checkdata, config)
			.then(function(res) {
				console.log(res.data);	/*res.data là 1 chuỗi json, res.data.emailLogin là 1 thuộc tính của chuỗi json này, nếu thuộc*/
				if (res.data.emailLogin==$scope.userSignIn.emailDemo2) {	/*tính này bằng vs emailDemo2 từ view nhập vào thì success*/
					if(res.data.adminLogin==1){		/*nếu thuộc tính adminLogin trong res.data =1 thì là admin. Ngược lại thì là user*/
						$scope.showSimpleToast('success. '+res.data.nameLogin+' có quyền Admin');

						$location.path("/");			/*Nếu đăng nhập thành công và admin thì cho phép chuyển hướng đến page quyền admin*/
						$rootScope.displayHeader=true;	/*đồng thời cho hiển thị header*/
						$rootScope.titlePage="Home Admin";/*và hiển thị title của page là Home Admin */
						$rootScope.appDemo2="";			/*mở menu bên trái ra (bỏ offcanvas tại class="app")*/

						$rootScope.loginStatus = "Admin";/*Nếu đăng nhập thành công thì lưu trạng thái đăng nhập vào 1 biến là loginStatus*/
					}	/*loginStatus sẽ kiểm tra tại các pages, nếu đúng ="Admin" thì mới có quyền admin, còn k thì chuyểnhướng đến login*/
					else{
						$scope.showSimpleToast('user. '+res.data.nameLogin+' không đủ quyền admin');
					}
				}	
				else
					$scope.showSimpleToast("login fail. Check your email or password again");
			}, function(er) {
				if (er.data=="fail") {
					$scope.showSimpleToast('fail');
					console.log("login fail");
				}
			});
	}

	/*ANGULAR MATERIAL TOAST (chỉ cần copy vào đây là đủ)*/
	var last = {
	  bottom: false,
	  top: true,
	  left: false,
	  right: true
	};
	$scope.toastPosition = angular.extend({},last);
	$scope.getToastPosition = function() {
		sanitizePosition();
	
		return Object.keys($scope.toastPosition)
		  .filter(function(pos) { return $scope.toastPosition[pos]; })
		  .join(' ');
	};
	function sanitizePosition() {
		var current = $scope.toastPosition;
	
		if ( current.bottom && last.top ) current.top = false;
		if ( current.top && last.bottom ) current.bottom = false;
		if ( current.right && last.left ) current.left = false;
		if ( current.left && last.right ) current.right = false;
	
		last = angular.extend({},current);
	}
	$scope.showSimpleToast = function(successOrFail) {
		var pinTo = $scope.getToastPosition();
	
		$mdToast.show(
		  $mdToast.simple()
			    .textContent('check '+successOrFail+"!")
			    .position(pinTo )
			    .hideDelay(3000)
			);
	};
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
			});
	};
});












/*AngularJsControllerDemo2: controller toàn cục (tại index.html)*/
app.controller('AngularJsControllerDemo2',  function($scope, $http, $mdToast, $rootScope, $location){	
	if (!$rootScope.loginStatus) {		/*đầu tiên phải kiểm tra xem trạng thái đăng nhập này có quyền admin hay k*/
		$location.path("/userLogin");	/*loginStatus đc định nghĩa tại controller userSignInController (khi đăng nhập Admin thành công)*/
	}	/*nếu chưa đc đăng nhập thì chuyển hướng đến trang đăng nhập*/

	/*XỬ LÝ ĐĂNG XUẤT*/
	$rootScope.logoutUserDemo2 =function () {
		$rootScope.loginStatus="";		/*logout thì xóa trạng thái login (loginStatus="")*/
		$location.path("/userLogin");	/*và chuyển hướng đến login*/
		// return false;
	}
});


})(jQuery);




/*<!-- ============================== ANGULAR JS ================================ -->*/

﻿var app = angular.module('angularJsAppDemo',['ngMaterial', 'ngRoute']);
app.controller('AngularJsControllerDemo',  function($scope, $http, $mdToast){


    /*ZẢI THÍCH SCOPE*/
    $scope.caiNayDungODauCungDuoc = "Cái này dùng ở đâu cũng đc";   /*khai báo 1 biến, biến này zống y chang ng-model, $scope. nghĩa là */
    $scope.truyenFunction = function () {   /*gửi tham số vào scope, đồng thời ở view nhận đc thông qua dấu {{}} hoặc thông qua ng-model*/
        $scope.caiNayDungODauCungDuoc = "Cái này chỉ dùng ở đây";   /*scope zống như 1 kho, có thể truyền vào 1 function và thực hiện*/
    }   /*function tại view, function này thay đổi zá trị của caiNayDungODauCungDuoc*/





    /*DEMO 2*/
    $scope.displayDemo2 = true;
    $scope.changeDisplayDemo2 = function () {
        $scope.displayDemo2 = !$scope.displayDemo2; /*đảo ngược lại, nếu = true => thành false, nếu = false => thành true*/
    }
    $scope.newValueDemo2 = "Nguyễn Đức Long"







    /*NG-REPEATE =======>>>>>>>>> TƯƠNG TÁC VS DB (SELECT, UPDATE)*/

    /*XỬ LÝ LẤY TOÀN BỘ DỮ LIỆU TRONG JSON RA, VÀ ĐƯA VÀO VIEW*/
    $http.get("http://127.0.0.1:8888/phpBasic4/AttributeHomejson/selectAttributeUserAngular") /*.get  -> lấy data*/
         .then(function(res) {                                                         /*.then -> sau đó, gọi function trả về res*/
        // console.log(res.data);
        $scope.ngUserRepeat = res.data;    /*đưa data ra view (đưa vào biến ngUserRepeat trong scope) */
    });

    $scope.changeDisplayDemoNgrepeat = function (aUserRepeat) {
        aUserRepeat.displayDemoNgrepeat = !aUserRepeat.displayDemoNgrepeat; 
    }

    /*UPDATA DATA TỪ VIEW VÀO DATABASE*/
    $scope.saveDatachangeDemoNgrepeat = function (aUserRepeat) {
        aUserRepeat.displayDemoNgrepeat = !aUserRepeat.displayDemoNgrepeat;/*Đầu tiên, thay đổi frontend, ẩn div hiển thị, hiện div chỉnh sửa*/
        var data = $.param({  /*data là dữ liệu gửi đi(data ở đây là 1 param chứa...). */
            idUserAngular: aUserRepeat.id,      /*chứa id, lưu vào idUserAngular => idUserAngular này đc lấy ra tại controller và đưa*/
            nameUserAngular: aUserRepeat.name,  /*vào model để xử lý. Tương tự đối với nameUserAngular, dobUserAngular, ...*/
            dobUserAngular: aUserRepeat.dob,
            fbUserAngular: aUserRepeat.fb,
            phoneUserAngular: aUserRepeat.phone
            // isDelete: aUserRepeat.isDelete
        }) 
        var config = {  /*các zá trị config khi gửi*/
            headers:{
                'content-type': 'application/x-www-form-urlencoded;charset=UTF-8'   /*config utf-8*/
            }
        } /*Bước 2: sử dụng post để kết nối vs api và send data đi*/
        $http.post('http://127.0.0.1:8888/phpBasic4/AttributeHomejson/updateAttributeUserAngular', data, config)    /*gửi data và config*/
             .then(function function_name(res) { /*.then -> sau đó, nếu thành công thì gọi 1 function, lấy zề data định nghĩa là res*/
                 if (res.data=='success') {      /*Nếu bằng vs chuỗi trả về trong hàm updateAttributeUserAngular (ở controller) thì in ra ok*/
                    $scope.showSimpleToast();
                    console.log("ok")
                    // $scope.showSimpleToast();
                 }
             }, function function_name(res) {    /*thất bại cũng gọi 1 function, tương tự thành công*/
                 if (res.data=='fail') {      /*Nếu bằng vs chuỗi trả về trong hàm updateAttributeUserAngular (ở controller) thì in ra not ok*/
                    console.log("not ok")
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

    $scope.showSimpleToast = function() {
    var pinTo = $scope.getToastPosition();

    $mdToast.show(
      $mdToast.simple()
        .textContent('Cập nhật thành công!')
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






/*DEMO 3: ng-route --> cần config vs app hiện tại, ko dùng controller (config khi dùng single web app)*/
app.config(function ($routeProvider, $locationProvider) {   /*để bỏ dấu # trong đường dẫn -> bật chế độ html5 bằng $locationProvider*/
    $routeProvider      /*$routeProvider thư viện lấy ra từ ng-route, để sử dụng đc cần add ngRoute tại angular.module...*/
    .when('/', {
        templateUrl: 'FirstHtml.html',   /*sử dụng when để điều hướng routeProvider*/
        controller: 'firstController'   /*đi đến controller này (tại controller này thì lấy data ra)*/
    })
    .when('/social', {
        templateUrl: 'SecondHtml.html'  /*Làm tương tự đối với SecondHtml.html -> cũng phải tạo 1 controller để thao tác vs view*/
    })
    .when('/ad', {
        templateUrl: 'ThirdHtml.html'
    })
    .otherwise({ redirectTo: '/' })     /*Nếu k phải 3 trang này thì tự động zề trang chủ*/

    $locationProvider.html5Mode(true);  /*bật chế độ html5, cần tạo đường dẫn cơ sở tại line 8 (AttributeHome.php)*/
})



app.controller('firstController', function ($scope, $http) {
    $http.get('http://127.0.0.1:8888/phpBasic4/AttributeHomejson/selectAttributeUserAngular')  /*lấy data ra*/
         .then(function (res) {
             console.log(res.data);
             $scope.dataFirstHtml = res.data;   /*in ra tại FirstHtml.html*/
         }, function (res) {
             // body...
         })
});



/*    <!-- ajax  hỗ trợ gửi nhận data trực tiếp, k cần load lại page (phần này là xử lý jquery)-->*/

$(function () {
    
    /*===== XỬ LÝ ADD CATEGORY =======*/
    /*khi dùng ajax mặc định chỉ lắng nghe những phần tử nào có sẵn lúc load nội dung ban đầu. Nếu dùng jquery để vẽ phần tử khác, thì jquery k thể bắt đc sự kiện click của phần tử này. Muốn bắt đc sự kiện của các phần tử mới cần sử dụng $("body").on...*/
    $('body').on('click', '.btnInsertNewsCategory', function(event) {   /*$('body').on lắng nghe body xem có thay đổi zì k*/
        /*lắng nghe zì, lắng nghe click, lắng nghe tại phần tử nào, phần tử btnInsertNewsCategory*/
        /*PHẦN 1: PHẦN XỬ LÝ DỮ LIỆU BÊN TRONG (đưa dữ liệu đc add vào database)*/
        $.ajax({
            url: 'AttributeHomejson/insertNewsCategoryAjax',
            type: 'POST',
            dataType: 'json',
            data: {nameNewsCatAjax: $("#inputNameNewsCatAjax").val()},
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        /*PHẦN 2: PHẦN XỬ LÝ ZAO DIỆN BÊN NGOÀI (hiển thị data ra ngoài trên view)*/
        .always(function(res) { /*lấy res từ controller ra (tại json_encode($this->db->insert_id()); trong controller*/
            // console.log(res);   /*res là data nhận về từ controllers vs đkiện controller in ra nội dung trả về json như trên*/
            insertEmpCompleted = 
            '<li class="nav-item pr-2 dropdown" >'
            +        '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
            +            $("#inputNameNewsCatAjax").val()+'    <!-- nameNewsCat: cột nameNewsCat trong database -->'
            +        '</a>' /*res: thuộc tính ID (đc lấy từ controller tại dòng lệnh json_encode($this->db->insert_id());  */

            +        '<!-- Update theo cách php (thông thường) -->'
            +        '<a href="<?= base_url() ?>AttributeHomejson/updateNewsCategoryOpenning/'+res+'" class="btn btn-warning" ><i class="fas fa-pencil-alt"></i></a>'
            +        '<!-- Delete theo cách php (thông thường) -->'
            +        '<a href="<?= base_url() ?>AttributeHomejson/deleteNewsCategory/'+res+'" class="btn btn-danger" ><i class="fas fa-trash"></i></a>'

            +        '<!-- Update theo jquery (ajax) -->'
            +        '<a data-href="<?= base_url() ?>AttributeHomejson/updateNewsCategoryOpenning/'+res+'"  class="btn btn-warning btnUpdateCategoryByAjaxOpenning" >'
            +            '<div>Ajax</div>'
            +            '<i class="fas fa-pencil-alt"></i>'
            +        '</a>'
            +        '<!-- Delete theo jquery (ajax) -->'
            +        '<a data-href="'+res+'" class="btn btn-danger btnDeleteCategoryByAjax">'
            +            '<div>Ajax</div>'
            +            '<i class="fas fa-trash"></i>'
            +        '</a>  <!-- hidden-xs-up: từ màn hình mobile trở lên thì 2 input này sẽ bị ẩn đi -->'

            +        '<div class="row hidden-xs-up">'
            // +            '<form action="AttributeHomejson/insertNewsCategory" method="POST" enctype="multipart/form-data">'
            +                '<div class="form-group row text-center">'
            +                    '<div class="col-sm-6 push-sm-1">'
            +                        '<input type="hidden" class="form-control " name="updateIdNewsCatAjax" id="updateIdNewsCatAjax" value="'+res+'">'
            +                        '<input type="text" class="form-control" name="updateNameNewsCatAjax" id="updateNameNewsCatAjax" placeholder="Update" value="'+$("#inputNameNewsCatAjax").val()+'">'
            +                    '</div>'
            +                    '<div class="col-sm-5" style="margin-left: 5px;">'
            +                        '<div href="" class="btn btn-primary btnUpdateCategoryByAjax" >Update</div>'
            +                    '</div>'
            +                '</div>'
            // +            '</form>'
            +        '</div>'
            +        '<div class="dropdown-menu ml-3" aria-labelledby="navbarDropdown">'
            +            '<a class="dropdown-item" href="#">Action</a>'
            +            '<a class="dropdown-item" href="#">Another action</a>'
            +            '<div class="dropdown-divider"></div>'
            +            '<a class="dropdown-item" href="#">Something else here</a>'
            +        '</div>'
            +    '</li>'
            $(".navbar-nav.allCategories").append(insertEmpCompleted);
            $("#inputNameNewsCatAjax").val("");
        });
        
    });






    /*===== XỬ LÝ DELETE CATEGORY =======*/
    /*khi dùng ajax mặc định chỉ lắng nghe những phần tử nào có sẵn lúc load nội dung ban đầu. Nếu dùng jquery để vẽ phần tử khác, thì jquery k thể bắt đc sự kiện click của phần tử này. Muốn bắt đc sự kiện của các phần tử mới cần sử dụng $("body").on...*/
    $('body').on('click', '.btnDeleteCategoryByAjax', function(event) {    /*$('body').on lắng nghe body xem có thay đổi zì k*/
        /*tức là lắng nghe xem btnDeleteCategoryByAjax có phần tử nào mới k, nếu có thì add vào bộ nhớ đệm để xử lý luôn*/
        /*PHẦN 1: PHẦN XỬ LÝ DỮ LIỆU BÊN TRONG (đưa dữ liệu đc add vào database)*/
        var deleteObject = $(this).parent();    /*lấy parent của phần tử xóa: $(this): là .btnDeleteCategoryByAjax
                                                      .parent() thứ nhất: là <li class="nav-item pr-2 dropdown" >
                                                      .parent() thứ 2: là div cha của <li class="nav-item pr-2 dropdown" >
                                                      ...*/
        $.ajax({/*lấy thuộc tính data-href để delete, mỗi data-href có chữa mã  idNewsCat => chỉ cần truy xuất đển mã đó là lấy đc*/
            url: 'AttributeHomejson/deleteNewsCategory/'+ $(this).data('href'), /*data('href'):lấy thuộc tính data-hrefcủa button*/
            type: 'POST',   /*Phần này (url: 'Att...) là xóa trên dữ liệu*/
            dataType: 'json'

        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {    /*dùng jquery xóa luôn phần tử, ở trên dữ liệu đã đc xóa, phần này là xóa trên zao diện*/
        /*PHẦN 2: PHẦN XỬ LÝ ZAO DIỆN BÊN NGOÀI (hiển thị data ra ngoài trên view)*/
            deleteObject.remove();
            
        });
    });




    /*===== XỬ LÝ HIỂN THỊ CỬA SỔ UPDATE CATEGORY (UPDATE CATEGORY OPPENING)=======*/
    $("body").on('click', '.btnUpdateCategoryByAjaxOpenning', function(event) {
        /*BƯỚC 1: XỬ LÝ TRÊN ZAO DIỆN (ẨN CỬA SỔ HIỂN THỊ, HIỆN CỬA SỔ CHỈNH SỬA)*/
        $(this).parent().children('a').addClass('hidden-xs-up');/*parent():đến thẻ parent của a là thẻ li, và tìm (find) thẻ a. Sau đó*/
        $(this).next().next().removeClass('hidden-xs-up')   /*cho tất cả thẻ a addClass. Và ở đây cho thẻ 2 lần kế tiếp hiện lên*/
                      
    });


    /*===== XỬ LÝ UPDATE CATEGORY (UPDATE CATEGORY)=======*/
    $("body").on('click', '.btnUpdateCategoryByAjax', function(event) {
        // $(this).parent().parent().parent().parent().addClass('hidden-xs-up');
        // $(this).parent().parent().parent().parent().parent().children('a').removeClass('hidden-xs-up');
        var idUpdateAjax = $(this).parent().parent().children().children('#updateIdNewsCatAjax').val();
        var nameUpdateAjax = $(this).parent().parent().children().children('#updateNameNewsCatAjax').val();
        console.log(idUpdateAjax);  /*lấy id của phần tử đc click*/
        console.log(nameUpdateAjax);/*lấy name của phần tử đc click*/
        /*BƯỚC 2: XỬ LÝ DỮ LIỆU (SỬ DỤNG ajax để KẾT NỐI VS CONTROLLER ĐỂ CẬP NHẬT DATA*/
        $.ajax({
            url: 'AttributeHomejson/updateNewsCategoryAjax',    /*update đc truyền đến controller tại updateNewsCategoryAjax để update*/
            type: 'POST',
            dataType: 'json',
            data: {
                updateIdNewsCatAjax: idUpdateAjax,   /*id*/
                updateNameNewsCatAjax: nameUpdateAjax/*name*/
            },
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        /*BƯỚC 3: XỬ LÝ UPDATE DỮ LIỆU XONG THÌ HIỂN THỊ LẠI TRẠNG THÁI BAN ĐẦU*/
        $(this).parent().parent().parent().addClass('hidden-xs-up');                            /*thẻ row trong ul li bị ẩn đi*/
        $(this).parent().parent().parent().parent().children('a.nav-link').html(nameUpdateAjax);/*add lại tên cho thẻ a.nav-link*/
        $(this).parent().parent().parent().parent().children('a').removeClass('hidden-xs-up');  /*các thẻ a trong ul li hiện ra*/
    });







    /*PHẦN XỬ LÝ NEWS (BẢNG DATABASE: newscontent)*/
    /*XỬ LÝ ckeditor*/
    CKEDITOR.replace( 'newsCon', {
        filebrowserBrowseUrl: 'ckeditor/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckeditor/ckfinder/ckfinder.html?Type=Images',
        filebrowserUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserWindowWidth : '1000',
        filebrowserWindowHeight : '700'
    });
    CKEDITOR.replace( 'summaryNews', {
        filebrowserBrowseUrl: 'ckeditor/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckeditor/ckfinder/ckfinder.html?Type=Images',
        filebrowserUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserWindowWidth : '1000',
        filebrowserWindowHeight : '700'
    });
});




















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







    /*NG-REPEATE*/

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
        var data = $.param({  /*data là dữ liệu gửi đi(data ở đây là 1 param chứa...). Bước 2: sử dụng post để kết nối vs api và send data đi*/
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
        }
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


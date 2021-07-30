<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<!-- xử lý load các file css, js trong application.config/autoload.php
			-> search url -> thay đổi array trong file autoload.php
			và xử lý trong file config.php -> search base_url -> set config trong file config.php

			Bước 1: kích hoạt url trong file autoload.php
			Bước 2: kích hoạt base_url trong file config.php
			Bước 3: thêm đường dẫn css, js bằng cách < ? php echo base_url(); ?>
			Bước 4: kết nối database trong file config/database.php (username, pass, databasename,etc.)
			 -->
		<!-- my css, add thêm < ? php echo base_url(); ?> để link đến file css -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>FirstCss.css">    
    

    <!-- BOOTSTRAP4 (ko đc dùng chung vs thư viện fancy box)-->
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- js -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->


    <!-- Bootstrap5 core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
        <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script> -->
    

    <!-- thư viện boostrap và font-awesome, tương tự, add thêm < ?php echo base_url(); ?> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/bootstrap.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendor/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">


    <!-- TÍCH HỢP ANGULAR JS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendor/angular-material.min.css">
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/angular-1.5.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/angular-animate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/angular-aria.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/angular-messages.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/angular-material.min.js"></script>  


    <!-- Để setup cho ANGULAR UI SELECT, add thêm các thư viện sau (Search từ khóa: angular ui select): -->
    <!--
      IE8 support, see AngularJS Internet Explorer Compatibility https://docs.angularjs.org/guide/ie
      For Firefox 3.6, you will also need to include jQuery and ECMAScript 5 shim
    -->
    <!--[if lt IE 9]>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/2.2.0/es5-shim.js"></script>
      <script>
        document.createElement('ui-select');
        document.createElement('ui-select-match');
        document.createElement('ui-select-choices');
      </script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.js"></script>  <!-- sanitize -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendor/select-angular-ui.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>vendor/select-angular-ui.js"></script>  
  

    <!-- my js, tương tự trên, add thêm < ?php echo base_url(); ?> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>Firstjs.js"></script>
</head>
<body ng-app='angularDemo1' class="ng-cloak"  ng-controller="AngularJsControllerDemo1 as controllerDemo1">
    <!-- ĐỊNH NGHĨA ng-app ĐỂ PHỤC VỤ CHO ANGULAR JS , controllerDemo1 đặt bí danh cho AngularJsControllerDemo1-->
    <div class="jumbotron text-center">
        <h1 class="display-4">Update Data</h1>
        <p class="lead">Update data của page</p>\
    </div>
    <div class="container-fluid"> <!--sử dụng ng-repeat để lấy hết data trong backend ra-->
        <div class="row" ng-repeat="aDataAngDemo1 in datasAngDemo1" ng-init="aDataAngDemo1.displayDataAngDemo1=true">
            <div class="card col-sm-10 push-sm-1 text-center" > <!--ng-init để ban đầu chỉ hiển thị khối hiển thị-->
                <div class="card-header" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                    <div class="row">
                        <h5 class="card-title col-sm-3" style="padding: 8px 0 0 0"><b>Page: </b></h5> <!--ng-model: lấy page ra-->
                        <input type="text" class="form-control form-control-sm col-sm-7" ng-model="aDataAngDemo1.page">
                        <button class="float-xs-right col-sm-1 btn btn-outline-success" style="border: white;" ng-click="saveDatabaseAngDemo1(aDataAngDemo1)"><i class="fas fa-check"></i></button> <!--ng-click: lưu vào db-->
                        <button class="float-xs-right col-sm-1 btn btn-outline-secondary" style="border: white;" ng-click="changeDisplayAngDemo1(aDataAngDemo1)"><i class="fas fa-times"></i></button> <!--ng-click: cancel ko lưu-->
                    </div>
                </div>
                <div class="card-header" ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                    <div class="container">
                        <div class="row">
                            <div class="">
                                <div class="row">   <!--{{aDataAngDemo1.page}}: lấy page ra-->
                                    <h5 class="card-title col-sm-10 push-sm-1"><b>Page: </b><i>{{aDataAngDemo1.page}}</i> </h5>
                                    <button class="float-xs-right col-sm-1 push-sm-1 btn btn-outline-warning" style="border: white;" ng-click="changeDisplayAngDemo1(aDataAngDemo1)"><i class="fas fa-pencil-alt"></i></button><!--ng-click-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container"> <!--ng-model="aDataAngDemo1.id" : lấy id ra-->
                        <div class="row"><input type="hidden" class="form-control form-control-sm" ng-model="aDataAngDemo1.id"></div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <h6 class="col-sm-3"><b>Title: </b></h6> <!--ng-model="aDataAngDemo1.title: lấy title ra-->
                            <input type="text" class="form-control form-control-sm col-sm-7" ng-model="aDataAngDemo1.title">
                        </div>
                        <div class="row"  ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                            <div class="">
                                <div class="row">   <!--{{aDataAngDemo1.title}}: lấy title ra-->
                                    <h6 class="col-sm-10 push-sm-1"><b>Title: </b><i>{{aDataAngDemo1.title}}</i> </h6>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <h6 class="col-sm-3"><b>Subtitle: </b></h6> <!--ng-model="aDataAngDemo1.subtitle": lấy subtitle ra-->
                            <input type="text" class="form-control form-control-sm col-sm-7" ng-model="aDataAngDemo1.subtitle">
                        </div>
                        <div class="row"  ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                            <div class="">
                                <div class="row">   <!--ng-model="aDataAngDemo1.subtitle": lấy subtitle ra-->
                                    <h6 class="col-sm-10 push-sm-1"><b>Subtitle: </b><i>{{aDataAngDemo1.subtitle}}</i> </h6>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <h6 class="col-sm-3"><b>Content: </b></h6>
                            <div class="col-sm-7"></div>
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <textarea rows="10" class="form-control form-control-sm col-sm-12" ng-model="aDataAngDemo1.content"></textarea>
                        </div>      <!--ng-model="aDataAngDemo1.content": lấy content ra-->
                        <div class="row"  ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                            <div class="">
                                <div class="row">
                                    <h6 class="col-sm-10 push-sm-1"><b>Content: </b></h6>
                                </div>
                                <div class="row">
                                    <div class="text-left">{{aDataAngDemo1.content}}</div><!--{{aDataAngDemo1.content}}: lấy content ra-->
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <h6 class="col-sm-3"><b>Image: </b></h6>    <!--ng-model="aDataAngDemo1.image": lấy image ra-->
                            <input type="file" class="form-control form-control-sm col-sm-7" ng-model="aDataAngDemo1.image">
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <img src="{{aDataAngDemo1.image}}" alt="" class="img-fluid col-sm-4 push-sm-3">
                        </div>  <!--{{aDataAngDemo1.image}}: lấy image ra-->
                        <div class="row"  ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                            <div class="">
                                <div class="row">
                                    <h6 class="col-sm-10 push-sm-1"><b>Image: </b></h6>
                                </div>
                                <div class="row text-center">   <!--{{aDataAngDemo1.image}}: lấy image ra-->
                                    <img src="{{aDataAngDemo1.image}}" alt="" class="img-fluid col-sm-6 push-sm-3">
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <h6 class="col-sm-3"><b>Author: </b></h6>       <!--ng-model="aDataAngDemo1.author": lấy author ra-->
                            <input type="text" class="form-control form-control-sm col-sm-7" ng-model="aDataAngDemo1.author">
                        </div>
                        <div class="row"  ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                            <div class="">
                                <div class="row">        <!--{{aDataAngDemo1.author}}: lấy author ra-->
                                    <h6 class="col-sm-10 push-sm-1"><b>Author: </b><i>{{aDataAngDemo1.author}}</i> </h6>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-hide="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần chỉnh sửa (ng-hide=true)-->
                            <h6 class="col-sm-3"><b>Date: </b></h6>     <!--ng-model="aDataAngDemo1.date": lấy date ra-->
                            <input type="text" class="form-control form-control-sm col-sm-7" ng-model="aDataAngDemo1.date">
                        </div>
                        <div class="row"  ng-show="aDataAngDemo1.displayDataAngDemo1">   <!-- Phần hiển thị (ng-show=true)-->
                            <div class="">
                                <div class="row">       <!--{{aDataAngDemo1.date}}: lấy date ra-->
                                    <h6 class="col-sm-10 push-sm-1"><b>Date: </b><i>{{aDataAngDemo1.date}}</i> </h6>
                                </div>
                            </div>
                        </div>
                    </div><!-- end container -->
                </div><!-- end card-body -->
            </div><!-- end card -->
            
        </div><!-- end row -->
    </div>  <!-- end container-fluid -->
<!-- </div> -->










    <!-- XỬ LÝ ANGULAR UI SELECT 
        Bước 1: setup: link các file css và js tại file này và load tại đây
        Bước 2: Sử dụng thư viện, kiểm soát data trả về-->
    <div class="container">

        <!-- ANGULAR UI SELECT BASIC -->
        <div class="row mb-2">
            <div class="col-sm-2 push-sm-1">Ui Select Basic</div>
            <div class="col-sm-4 push-sm-1">
                <ui-select ng-model="selected.value">
                    <ui-select-match>
                        <span ng-bind="$select.selected.title"></span>  <!-- trường title trong db -->
                    </ui-select-match>
                    <ui-select-choices repeat="item in (itemArray | filter: $select.search) track by item.id">
                        <span ng-bind="item.title"></span>
                    </ui-select-choices>
                </ui-select>
            </div>
            <b class="btn btn-outline-success col-sm-2 push-sm-2" ng-click="getDataAngUiSelect()">Save Data</b>
        </div>



        <!-- ANGULAR UI SELECT MULTIPLE SELECTION -->
        <div class="row text-center">
            <div class="col-sm-8 push-sm-2">Ui Select Multiple selection</div>
        </div>
        <div class="row mb-2 text-center">
            <div class="col-sm-6 push-sm-3">
                <ui-select multiple ng-model="controllerDemo1.multipleDemo.element" theme="bootstrap" ng-disabled="controllerDemo1.disabled" close-on-select="false" style="width: 100%;" title="Choose a color">
                    <ui-select-match placeholder="Select element...">{{$item.title}}</ui-select-match>
                    <ui-select-choices repeat="anElement in controllerDemo1.availableDatas | filter:$select.search">
                      {{anElement.title}}
                    </ui-select-choices>
                </ui-select>
            </div>
        </div>
        <div class="row text-center">
            <b class="btn btn-outline-success col-sm-2 push-sm-5" ng-click="getDataAngUiMultipleSelect(controllerDemo1.multipleDemo.element)">Save Data</b>
        </div>
        <div class="row text-center"><p>Selected: {{controllerDemo1.multipleDemo.element}}</p></div>
        <hr>


    </div>















    <!-- XỬ LÝ FORM TRONG ANGULAR (xử lý tại file này, file js và file css)-->
    <div class="container"> <!-- novalidate : thuộc tính bỏ check html5, ở đây check = angular, để check = angular các thuộc tính cần-->
        <form class="row text-center" name="checkFormByAngular" novalidate=""> <!-- có name, bao gồm name của form, name của từng input -->
            <div class="col-sm-3">
                <input type="email" class="form-control" placeholder="Your Email *" name="checkEmailByAngular" ng-model="checkEmailByAngular" required=""> <!-- trường required nghĩa là bắt buộc phải điền vào input này -->
            </div>  <!-- zả sử input email này, user gõ sai(ko có @) thì angular sẽ phát sinh ra class trong này có tên là invalid ->css nó-->
            <div class="col-sm-3">
                <input type="password" class="form-control" placeholder="Your password" name="checkPassByAngular" ng-model="checkPassByAngular" required="" minlength="8">  <!-- password phải có ít nhất 8 ký tự -->
            </div>
            <div class="col-sm-2">
                <input type="submit" class="btn btn-outline-primary" value="Send Email">
            </div>
            <div class="col-sm-2">
                <input type="reset" class="btn btn-outline-secondary" value="Reset Data" ng-click="resetInputFormAngular(checkFormByAngular)">
            </div>
        </form>

        <div class="row" ng-show="checkFormByAngular.$submitted"><!--khi form trên đc submit,nếu sai mới hiểnthị lỗi,true nếu form đc submit-->
            <!-- CHECK CHO TRƯỜNG EMAIL -->
            <!-- Để tổng hợp những error của form, search: angular formcontroller -> tìm đến page của angular -> tìm đến lỗi $error -->
            <div class="col-sm-4 alert alert-warning pb-0 mb-0 pt-0" role="alert" ng-show="checkFormByAngular.checkEmailByAngular.$error.email"><!--ng-show này trả về true nếu có lỗi, trả về false nếu k lỗi, (.email là 1 token trong mục tổng hợp các lỗi $error của form)-->
                <strong>Error! </strong> Please input correct your email (...@...)!
            </div>
            <div class="col-sm-4 alert alert-warning pb-0 mb-0 pt-0" role="alert" ng-show="checkFormByAngular.checkEmailByAngular.$error.required">    <!-- tương tự zải thích trên. required là lỗi bắt buộc phải nhập-->
                <strong>Error! </strong> You have to enter an email!
            </div>
            
            <!-- CHECK CHO TRƯỜNG PASSWORD -->
            <div class="col-sm-4 alert alert-warning pb-0 mb-0 pt-0" role="alert" ng-show="checkFormByAngular.checkPassByAngular.$error.minlength">    <!-- tương tự zải thích trên. lỗi này là phải nhập số-->
                <strong>Error! </strong> Please input correct your password (more than 8 characters)!
            </div>
        </div>

    </div>

















    <!-- DEMO2: SỬ DỤNG TEMPLATE ADMIN ĐỂ LÀM BACKEND -> search từ khóa: milestones template admin download themelock, tải template về -->
</body>
</html>
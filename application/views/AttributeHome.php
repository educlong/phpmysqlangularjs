<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
    <base href="/phpBasic4/">
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
  
    <!-- my js, tương tự trên, add thêm < ?php echo base_url(); ?> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>Firstjs.js"></script>
</head>
<body ng-app='angularJsAppDemo' >   <!-- ĐỊNH NGHĨA ng-app ĐỂ PHỤC VỤ CHO ANGULAR JS -->

    
<!-- ============================== ANGULAR JS ================================ -->


<div ng-controller="AngularJsControllerDemo" class="angularJS"  ng-init="selectList='columnList'; showJumbotron='false'" style="overflow-x: hidden;">     <!--ng-init="selectList='columnList'"->tạo zátrị ban đầu của biến=columnList-->


    <!-- VD VỀ ANGULAR JS (ng-model) -->
    <div class="container" style="margin-top: 100px"><div class="row text-center"><h1>ANGULAR JS</h1></div></div>
    <div class="row text-center">
        <input type="text" ng-model='Name' class="col-sm-2 push-sm-5"><!--khi đặt ng-model vào 1 thẻ input->zátrị trong thẻ đó sẽ là 1 biến-->
        <h2>{{Name}}</h2>   <!--lấy tên biến là ng-model='Name' tại input trên truyền vào-->
    </div>
    

    <!-- SỬ DỤNG NG-MODEL VS SELECT -->
    <div class="container">             
        <div class="row text-center">
            <select name="" id="" ng-model='color' class="col-sm-2 push-sm-5">
                <option value="blue">Xanh lam</option>
                <option value="red">Màu đỏ</option>
            </select>
            <h5 class="{{color}}">{{color}}</h5> <!--lấy tên biến là ng-model='color' tại select trên truyền vào-->
        </div>
    </div>

    <!-- SỬ DỤNG NG-MODEL VS RADIO -->
    <div class="container">             
        <div class="row text-center">
            <label> <input type="radio" name="color2" ng-model='color2' value="blue"> Xanh lam<br></label>
            <label> <input type="radio" name="color2" ng-model='color2' value="red"> Màu đỏ</label>

            <h5 class="{{color2}}">{{color2}}</h5> <!--lấy tên biến là ng-model='color' tại các input trên truyền vào-->
        </div>
    </div>
    




    <!-- DEMO 01: SỬ DỤNG ng-model VÀ CSS ĐIỀU CHỈNH CHẾ ĐỘ HIỂN THỊ CỦA LIST (ko tương tác vs file First.js)-->
    <div class="jumbotron text-center" ng-show='{{showJumbotron}}'><!--ng-show='false' = ng-hide='true' và ng-show='true' = ng-hide='false'-->
        <h1 class="display-4">Jumbotron heading</h1>               <!--khởi tạo showJumbotron tại ng-app -->
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <hr class="my-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 float-right text-right">
                <select name="" id="" class="form-control" ng-model="selectList">
                    <option value="columnList">Hiển thị theo cột</option>
                    <option value="rowList">Hiển thị theo lưới</option>
                </select>
            </div>
        </div>
    </div>  <!-- thay vì code jquery để thực hiện hiển thị => dùng angularJs truyền {{selectList}} đc lấy từ ng-model trong thẻ select-->
    <div class="container displayList {{selectList}}" > <!--ở đây sẽ add thêm class columnList hay rowList, chỉ cần css cho class này là đc-->
        <div class="row">   <!--cần tạo zá trị ban đầu của biến selectList bằng columnList hoặc rowList, tạo zá trị ngay tại ng-app-->
            <div class="displayElement">
                <div class="borderlist">
                    <img src="<?= base_url() ?>files/1.png" alt="" class="float-left img-fluid pr-2" width="150px" >
                    <b>Lorem, ipsum dolor sit amet consectetur adipisicing elit</b>
                    <small>27/6/2021 6:41</small>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, placeat minima exercitationem praesentium aperiam quia perferendis incidunt amet ab deleniti minus voluptate aut maxime, reprehenderit consequatur. Veniam rem est incidunt.</p>
                </div>
            </div>
            <div class="displayElement">
                <div class="borderlist">
                    <img src="<?= base_url() ?>files/2.JPG" alt="" class="float-left img-fluid pr-2" width="150px" >
                    <b>Lorem, ipsum dolor sit amet consectetur adipisicing elit</b>
                    <small>27/6/2021 6:41</small>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, placeat minima exercitationem praesentium aperiam quia perferendis incidunt amet ab deleniti minus voluptate aut maxime, reprehenderit consequatur. Veniam rem est incidunt.</p>
                </div>
            </div>
            <div class="displayElement">
                <div class="borderlist">
                    <img src="<?= base_url() ?>files/5.JPG" alt="" class="float-left img-fluid pr-2" width="150px" >
                    <b>Lorem, ipsum dolor sit amet consectetur adipisicing elit</b>
                    <small>27/6/2021 6:41</small>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, placeat minima exercitationem praesentium aperiam quia perferendis incidunt amet ab deleniti minus voluptate aut maxime, reprehenderit consequatur. Veniam rem est incidunt.</p>
                </div>
            </div>
            <div class="displayElement">
                <div class="borderlist">
                    <img src="<?= base_url() ?>files/6.JPG" alt="" class="float-left img-fluid pr-2" width="150px" >
                    <b>Lorem, ipsum dolor sit amet consectetur adipisicing elit</b>
                    <small>27/6/2021 6:41</small>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, placeat minima exercitationem praesentium aperiam quia perferendis incidunt amet ab deleniti minus voluptate aut maxime, reprehenderit consequatur. Veniam rem est incidunt.</p>
                </div>
            </div>
        </div>
    </div>





    <!-- VD VỀ CONTROLLER VÀ SCOPE (khai báo scope trong file Firstjs.js) -->
    <div class="container">
        <div class="row text-center">
            <h1>CONTRONLLER & SCOPE</h1>
            <h6>{{caiNayDungODauCungDuoc}}</h6>
            <input type="text" ng-model="caiNayDungODauCungDuoc"> <!--đi kèm vs controller có thê khái niệm ng-click (sự kiện click chuột)-->
            <button class="btn btn-danger" ng-click="truyenFunction()">thay đổi dòng text Cái này dùng ở đâu cũng đc</button>
        </div>
    </div>






    <!-- DEMO 2 -->
    <div class="container">
        <div class="row text-center"><h6>Demo 2</h6></div>
        <div class="row">
            <div class="card-group">
                <!--tips: replace .card-group by .card-deck to obtain cards that aren’t attached to one another-->
                <!--Card1-->
                <div class="card" ng-show='displayDemo2'>  <!-- ban đầu displayDemo2='true'-->
                    <div class="row">
                        <b class="col-sm-8">{{newValueDemo2}}</b>
                        <button class="btn btn-info col-sm-1" ng-click="changeDisplayDemo2()"><i class="fas fa-pencil-alt"></i></button>
                    </div>  <!-- khi click zô button thì sẽ đổi zá trị displayDemo2 từ true->false hoặc từ false->true (xử lý tại file js)-->
                </div>  
                <!--Card2-->
                <div class="card" ng-show='!displayDemo2'>   <!-- ban đầu displayDemo2='true', ở đây là !displayDemo2, tức là false -->
                    <div class="row">
                        <input type="text" class="col-sm-8 form-control-danger" ng-model="newValueDemo2">
                        <button class="btn btn-danger col-sm-1" ng-click="changeDisplayDemo2()"><i class="fas fa-check"></i></button>
                        <!-- <button class="btn btn-secondary col-sm-1" ng-click="changeDisplayDemo2()"><i class="fas fa-times"></i></button> -->
                    </div>
                </div>
            </div> 
        </div>
    </div>



    <!-- NG-REPEAT -->
    <div class="container"><div class="row"><div class="col-sm-6 push-sm-3">
        <div class="jumbotron">
            <h1 class="display-6">Demo về ng-repeat</h1>
            <p>
                <div layout="row" layout-align="space-around">
                    <div class="spacer"></div>
                    <md-button ng-click="showSimpleToast()"> <!--VD về angular material (Toast)-->
                      Show Simple
                    </md-button>
                    <md-button class="md-raised" ng-click="showActionToast()">
                      Show With Action  <!--VD về angular material (Toast)-->
                    </md-button>
                    <div class="spacer"></div>
                  </div>
            </p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            <div class="container mb-1"><div class="row text-right">
                <div class="searchAngular col-sm-6 push-sm-5">
                    <input type="text" class="form-control" placeholder="search" ng-model='keySearchAngular'>  <!--SEARCH TRONG ANGULAR-->
                </div>
                
            </div></div>
            <ul style="list-style: none;"><!--ng-repeat, ng-init, | filter:keySearchAngular để lọc data theo từ khóa keySearchAngular trên 
            (keySearchAngular chỉ thực hiện tại view, k có trong file js) -->
                <li ng-repeat="aUserRepeat in ngUserRepeat | filter:keySearchAngular" ng-init="aUserRepeat.displayDemoNgrepeat=false"> 
                    <!--lấy zá trị 1 user(aUserRepeat) trong 1 dãy scope nhiều user(ngUserRepeat), ng-init->khởi tạo zá trị hiểnthị ban đầu-->
                    <!-- Khối chỉnh sửa (zống hệt khối hiển thị). Dùng để chỉnh sửa -->
                    <div class="card text-center" style="width: 18rem;" ng-show="aUserRepeat.displayDemoNgrepeat">            <!--ng-show-->
                        <div class="card-header">
                            <div class="row">
                                <h6 class="card-title col-sm-5" style="padding: 8px 0 0 0;"><i>Thông tin về</i></h6>
                                <input type="text" class="form-control form-control-sm col-sm-3" ng-model="aUserRepeat.name"><!--ng-model-->
                                <button class="float-xs-right col-sm-2 btn btn-outline-success" style="border: white;" ng-click="saveDatachangeDemoNgrepeat(aUserRepeat)"><i class="fas fa-check"></i></button>               <!--ng-click-->
                                <button class="float-xs-right col-sm-2 btn btn-outline-secondary" style="border: white;" ng-click="changeDisplayDemoNgrepeat(aUserRepeat)"><i class="fas fa-times"></i></button>               <!--ng-click-->
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <input type="hidden" class="form-control form-control-sm col-sm-8" ng-model="aUserRepeat.id">
                                <div class="row"><b class="col-sm-4">DOB: </b><input type="text" class="form-control form-control-sm col-sm-8" ng-model="aUserRepeat.dob"><br></div>                                                        <!--ng-model-->
                                <div class="row"><b class="col-sm-4">FB: </b><input type="text" class="form-control form-control-sm col-sm-8" ng-model="aUserRepeat.fb"><br></div>                                                          <!--ng-model-->
                                <div class="row"><b class="col-sm-4">Phone: </b><input type="text" class="form-control form-control-sm col-sm-8" ng-model="aUserRepeat.phone"><br></div>                                             <!--ng-model-->
                                <input type="hidden" class="form-control form-control-sm col-sm-8" ng-model="aUserRepeat.isDelete">
                            </div>
                            
                        </div>
                    </div>
                    <!-- Khối hiển thị (zống hệt khối chỉnh sửa). Dùng để hiển thị -->
                    <div class="card text-center" style="width: 18rem;" ng-hide="aUserRepeat.displayDemoNgrepeat">           <!--ng-hide-->
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title col-sm-10"><b>Thông tin về </b><i>{{aUserRepeat.name}}</i></h5>
                                <button class="float-xs-right col-sm-2 btn btn-outline-warning" style="border: white;" ng-click="changeDisplayDemoNgrepeat(aUserRepeat)"><i class="fas fa-pencil-alt"></i></button>           <!--ng-click-->
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <b>DOB: </b><i>{{aUserRepeat.dob}}</i><br>
                            <b>FB: </b><i>{{aUserRepeat.fb}}</i><br>
                            <b>Phone: </b><i>{{aUserRepeat.phone}}</i><br>
                        </div>
                    </div>
                    
                </li>
            </ul>
        </div>
    </div></div></div>






    <!-- DEMO 3: ng-route -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="AttributeHomejson">Main mail</a></li>
        <li class="breadcrumb-item"><a href="social">Socil mail</a></li>
        <li class="breadcrumb-item"><a href="ad">Ad mail</a></li>
    </ol>
    <div class="container">
        <div ng-view></div>
    </div>
</div>

</body>
</html>
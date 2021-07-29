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

    <!-- sử dụng thư viện ngoài để hiển thị chức năng như microsoft office word -->
    <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
    <!-- sử dụng thư viện ngoài để hiển thị chức năng như microsoft office word (quản lý hình ảnh)-->
    <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckfinder/ckfinder.js"></script>


    <!-- sử dụng thư viện table2excel để xuất data từ table ra bảng excel -->
    <script src="<?php echo base_url(); ?>exportTable2excelUsingJQuery/src/jquery.table2excel.js"></script>
    <!-- sử dụng thư viện table2excel để xuất data từ table ra bảng excel -->
    <script>
            $(function() {
                $(".ExportData2Excel").click(function(){
                    $(".exportAllUser2excel").table2excel({
                        exclude: ".noExl",
                        name: "Excel Document Name"
                    }); 
                });
            });
    </script>

    <!-- my js, tương tự trên, add thêm < ?php echo base_url(); ?> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>Firstjs.js"></script>
</head>
<body >

    
    <div class="alert alert-success" role="alert">
        <?php if ($this->session->has_userdata('username')              /*kiểm tra xem có thuộc tính username ko*/
                && $this->session->has_userdata('password')             /*kiểm tra xem có thuộc tính password ko*/
                && $this->session->userdata('username') == 'educlonghx' /*kiểm tra xem có thuộc tính username có bằng educlonghx hay k*/
                && $this->session->userdata('password') == '1001'){     /*kiểm tra xem có thuộc tính password có bằng 1001 hay k */
        ?> 
                <strong><?= $this->session->userdata('username'); ?> đã đc đăng nhập thành công</strong>  <!-- nếu đúng thì thông báo -->
        <?php } 
             else {
                redirect(base_url().'AttributeHomejson/login','refresh');  /*nếu sai thì cho chuyển hướng đến trang login (chưa viết)*/
             } ?>
    </div>





    <?php 
        include "AttributeHeaderView.php";
     ?>




     <!-- XỬ LÝ MENU ĐA CẤP VÀ TẠO ĐƯỜNG DẪN THÂN THIỆN SEO -->
     <div class="container-fluid">
         <div class="row text-center">
            <div class="col-sm-6 push-sm-3">
                <?php echo $menus; ?>   
            </div>
         </div>
         <div class="row textcenter"><h6>Danh sách menu đa cấp</h6></div>   <!-- XỬ LÝ MENU ĐA CẤP -->
         <div class="row textcenter">
             <ul>
                 <?php foreach ($selectMenu as $key => $value): ?>          <!-- TẠO ĐƯỜNG DẪN THÂN THIỆN SEO -->
                     <li><a href="<?= base_url() ?>menu/<?= $value['link'] ?>-<?= $value['id'] ?>"><?= $value['title'] ?></a></li>
                 <?php endforeach ?>
             </ul>
         </div>
     </div>
     


    <!-- demo 6: search từ khóa: create start bootstrap -->
    <div class="bannerDemo6"> 
        <div class="container-fluid" style="margin: -85px 0 0 0;">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-xs-8 push-xs-1 col-sm-10 push-sm-0 text-center" style="transform: translateY(86px);z-index: 3;">
                <div class="container" style="overflow: hidden;">
                    <div class="row text-center">
                        <a href="#" class="col-3">
                            <img src="<?= base_url() ?>files/6.JPG" alt="" class="ml-1 mb-0">              
                        </a>
                        <div class="col-1"></div>
                        <a class="col-4 btn-danger" href="#">Velocity</a>
                    </div>
                </div>
            </div>
        <div class="col-2" style="opacity: 0; visibility: hidden;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-inverse col-12"> <!--navbar -> tab-->
            <!--tips: to change the nav placement use .fixed-top,.fixed-bottom,.sticky-top-->
            <!--col-12: nút điều hướng ☰ full màn hình ngang nằm bên phải (xem float-sm-right ở button)-->
            <!--<a class="navbar-brand" href="#">
                <img src="..." class="d-inline-block align-top" width="30" height="30" alt="...">My Brand
            </a>-->
            <div class="container-fluid"> <!--add container, row và col-12 vào để khối menu này căn zữa-->
                <div class="row">
                    <div class="col-12">
                        <button class="navbar-toggler ml-auto float-sm-right" type="button" data-toggle="collapse" data-target="#navbarContentDemo6" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">  <!--ml-auto: khối menu dịch phải-->
                            &#9776;<!--float-sm-right: từ màn hình di động trở đi, nút điều hướng ☰ bên phải-->
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    
                        <div class="collapse navbar-collapse backgroundMenuDemo6 mt-1 row mt-3" id="navbarContentDemo6">
                            <div class="col-sm-4">
                                <a href="" class="navbar-brand">
                                    <div class="row">
                                        <!-- <div > -->
                                            <img src="<?= base_url() ?>files/6.JPG" style="padding: 0 0 0 0;" alt="" style="width: 100%;" class="col-sm-4 ml-1 mb-1">  
                                        <!-- </div> -->
                                        <div class="col-sm-8 btn btn-danger col-md-4 push-md-1">
                                            Velocity 
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-8 col-sm-8 text-center">
                                <ul class="nav navbar-nav float-sm-right text-center"> 
                                    <!--ml-auto: khối menu dịch phải, 
                                    float-sm-right: bình thường thì căn phải, còn màn hình di động k làm zì
                                    text-center text-sm-right: màn hình di động thì chữ trên menu sẽ căn zữa, còn lại thì căn phải-->
                                    <li class="nav-item active pr-2 ml-1" >
                                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                                    </li>
                        
                                    <li class="nav-item pr-2">
                                        <a class="nav-link" href="#">Link</a>
                                    </li>
                        
                                    <li class="nav-item pr-2 dropdown" >
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Dropdown
                                        </a>
                                        <div class="dropdown-menu ml-3" style="background: #000000d4; color: white;" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </li>
                        
                                    <li class="nav-item pr-2">
                                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                                    </li>
                                    <li class="nav-item pr-2">
                                        <a class="nav-link btn btn-outline-danger" href="#" >Sign up free</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  <!--end container-fluid-->
        </nav>  <!-- end navbar -->
        </div>  <!-- end row -->
        </div>  <!-- end container-fluid -->
        

        <div class="slideDemo6">
            <!-- Cần tạo file mới, sau đó gõ !CarouselTemplate -> tab
                cuối cùng chỉnh sửa lại caroulse vào file này, đây là carousel bs5-->
            <div id="myCarouselDemo6" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php 
                        $count = 0;
                        foreach ($selectJsonAttribute as $key => $value): 
                    ?>
                        <li data-target="#myCarouselDemo6" data-slide-to="<?php echo $count ?>" class="<?php if($count==0) echo 'active'; ?>"></li>
                    <?php
                            $count++;
                        endforeach 
                    ?> 
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php 
                        $count = 0;
                        foreach ($selectJsonAttribute as $key => $value): 
                            $count++;
                    ?>
                        
                        <div class="carousel-item <?php if($count==1) echo 'active'; ?>">
                            <img src="<?= $value['image'] ?>" style="width: 100%; height: auto;" alt=""><!--add thêm hình ảnh vào-->
                            <div class="container">
                                <div class="carousel-caption">
                                    <h3><?= $value["title"] ?></h3>
                                    <p><?= $value['description'] ?></p>
                                    <p><a class="btn btn-outline-secondary" href="<?= $value['linkBtn'] ?>" role="button"><?= $value['textBtn'] ?></a></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach ?> 
                </div>
                <a class="carousel-control-prev" href="#myCarouselDemo6" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarouselDemo6" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>  <!--slideDemo6-->
    </div>  <!-- end bannerDemo6 -->












    <!-- XỬ LÝ PHẦN DANH MỤC TIN TỨC -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-inverse col-12"> <!--navbar -> tab-->
                <!--tips: to change the nav placement use .fixed-top,.fixed-bottom,.sticky-top-->
                <!--col-12: nút điều hướng ☰ full màn hình ngang nằm bên phải (xem float-sm-right ở button)-->
                <!--<a class="navbar-brand" href="#">
                    <img src="..." class="d-inline-block align-top" width="30" height="30" alt="...">My Brand
                </a>-->
        <div class="container-fluid"> <!--add container, row và col-12 vào để khối menu này căn zữa-->
            <div class="row">
                <div class="col-12">
                    <div class="collapse navbar-collapse backgroundMenuDemo6 mt-0 row" id="navbarContentDemo6">
                        <div class="col-lg-12 col-sm-12 text-center">
                            <ul class="nav navbar-nav float-sm-right text-center allCategories">  <!-- đoạn ul này copy từ bootstrap Demo 6, 1 phần trong navbar-toggle -->
                                <!--ml-auto: khối menu dịch phải, 
                                float-sm-right: bình thường thì căn phải, còn màn hình di động k làm zì
                                text-center text-sm-right: màn hình di động thì chữ trên menu sẽ căn zữa, còn lại thì căn phải-->
                                <?php foreach ($selectNewsCategories as $value): ?>
                                    <li class="nav-item pr-2 dropdown" >
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <?= $value['nameNewsCat'] ?>    <!-- nameNewsCat: cột nameNewsCat trong database -->
                                        </a>
                                        <!-- Update theo cách php (thông thường) -->
                                        <a href="<?= base_url() ?>AttributeHomejson/updateNewsCategoryOpenning/<?= $value['idNewsCat'] ?>"  class="btn btn-warning" ><i class="fas fa-pencil-alt"></i></a>
                                        <!-- Delete theo cách php (thông thường) -->
                                        <a href="<?= base_url() ?>AttributeHomejson/deleteNewsCategory/<?= $value['idNewsCat'] ?>" class="btn btn-danger" ><i class="fas fa-trash"></i></a>

                                        <!-- Update theo jquery (ajax) -->
                                        <a data-href="<?= base_url() ?>AttributeHomejson/updateNewsCategoryOpenning/<?= $value['idNewsCat'] ?>"  class="btn btn-warning btnUpdateCategoryByAjaxOpenning" >
                                            <div>Ajax</div>
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <!-- Delete theo jquery (ajax) -->
                                        <a data-href="<?= $value['idNewsCat'] ?>" class="btn btn-danger btnDeleteCategoryByAjax">
                                            <div>Ajax</div>
                                            <i class="fas fa-trash"></i>
                                        </a>        <!-- hidden-xs-up: từ màn hình mobile trở lên thì 2 input này sẽ bị ẩn đi -->
                                        <div class="row hidden-xs-up"> 
                                            <!-- <form action="AttributeHomejson/insertNewsCategory" method="POST" enctype="multipart/form-data"> -->
                                                <div class="form-group row text-center">
                                                    <div class="col-sm-6 push-sm-1">
                                                        <input type="hidden" class="form-control " name="updateIdNewsCatAjax" id="updateIdNewsCatAjax" value="<?= $value['idNewsCat'] ?>">
                                                        <input type="text" class="form-control " name="updateNameNewsCatAjax" id="updateNameNewsCatAjax" placeholder="Update" value="<?= $value['nameNewsCat'] ?>">
                                                    </div>
                                                    <div class="col-sm-5" style="margin-left: 5px;">
                                                        <div href="" class="btn btn-primary btnUpdateCategoryByAjax" >Update</div>
                                                    </div>
                                                </div>
                                            <!-- </form> -->
                                        </div>

                                        

                                        <div class="dropdown-menu ml-3" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <hr>
    <!-- Thêm danh mục tin tức bằng phương pháp php -->
    <div class="container">
        <form action="AttributeHomejson/insertNewsCategory" method="POST" enctype="multipart/form-data">
            <div class="row text-center"><h4>Thêm danh mục tin tức bằng phương pháp php</h4></div>
            <div class="form-group row">
                <label for="inputNameNewsCat" class="col-sm-3 col-form-label">Tên danh mục</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="inputNameNewsCat" id="inputNameNewsCat" placeholder="Tên danh mục mới">
                </div>
                <div class="col-sm-3">
                    <input type="submit" class="btn btn-primary" value="Thêm mới danh mục">
                </div>
            </div>
        </form>
    </div>
    <!-- Thêm danh mục tin tức bằng phương pháp ajax -->
    <div class="container">
        <!-- <form action="AttributeHomejson/insertNewsCategoryAjax" method="POST" enctype="multipart/form-data"> -->
            <div class="row text-center"><h4>Thêm danh mục tin tức bằng phương pháp ajax</h4></div>
            <div class="form-group row">
                <label for="inputNameNewsCatAjax" class="col-sm-3 col-form-label">Tên danh mục</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nameNewsCatAjax" id="inputNameNewsCatAjax" placeholder="Tên danh mục mới">
                </div><!-- thông số quan trọng sử dụng: id="inputNameNewsCatAjax" name="nameNewsCatAjax" (name đc truyền đến controllers)-->
                <div class="col-sm-3">
                    <button type="button" class="btn btn-outline-success btnInsertNewsCategory">Thêm mới danh mục</button>
                </div>  <!-- button btnInsertNewsCategory sẽ đc xử lý trong ajax -->
            </div>
        <!-- </form> -->
    </div>

    


















    <!-- XỬ LÝ PHẦN TIN TỨC -->    
    <div class="container">
        <div class="row">
            <div class="col-sm-6">          <!-- XỬ LÝ PHẦN INSERT TIN TỨC -->
                <div class="jumbotron">
                    <h1 class="display-3">Jumbo heading</h1>
                    <p class="lead">Jumbo helper text</p>
                    <hr class="my-2">
                    <p>More info</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
                    </p>
                </div>



                <div class="container">
                    <form action="<?= base_url() ?>AttributeHomejson/insertNews" method="POST" enctype="multipart/form-data" >
                        <!-- form cho idNews -->
                        <div class="form-group row hidden-xs-up">
                            <label for="idNews" class="col-sm-4 col-form-label">News id</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="idNews" id="idNews" placeholder="News id">
                            </div>
                        </div>
                        <!-- form cho   newsTitle -->
                        <div class="form-group row">
                            <label for="newsTitle" class="col-sm-4 col-form-label">News title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="newsTitle" id="newsTitle" placeholder="News Title">
                            </div>
                        </div>
                        <!-- form cho idNewsCat -->
                        <div class="form-group row">
                            <label for="idNewsCat" class="col-sm-4 col-form-label">News Category</label>
                            <div class="col-sm-8">
                                <select name="idNewsCat" id="idNewsCat" class="form-control">
                                    <?php foreach ($selectNewsCategories as $value): ?>
                                        <option value="<?= $value['idNewsCat'] ?>">
                                            <?= $value['nameNewsCat'] ?>    <!-- idNewsCat và nameNewsCat: các cột trong bảng -->
                                        </option>   <!-- newscategories (đc lấy từ ) function selectNews trong controllers -->
                                    <?php endforeach ?> 
                                </select>
                            </div>
                        </div>
                        <!-- form cho   imageNews -->
                        <div class="form-group row">
                            <label for="imageNews" class="col-sm-4 col-form-label">News Image</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="imageNews" id="imageNews" placeholder="Image News">
                            </div>
                        </div>
                        <!-- form cho   summaryNews -->
                        <div class="form-group row">
                            <label for="summaryNews" class="col-sm-12 col-form-label">Summary News</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control summaryNews" name="summaryNews" id="summaryNews"  cols="30" rows="10" placeholder="Summary News"></textarea>
                            </div>
                        </div>
                        <!-- form cho   newsCon -->
                        <div class="form-group row">
                            <label for="newsCon" class="col-sm-12 col-form-label">News Content</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control newsCon" name="newsCon" id="newsCon"  cols="30" rows="20" placeholder="News Content"></textarea>
                            </div>
                        </div>
                        <!-- form cho newsDate -->
                        <div class="form-group row hidden-xs-up">
                            <label for="newsDate" class="col-sm-4 col-form-label">News Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="newsDate" id="newsDate" placeholder="News Date">
                            </div>
                        </div>
                        <!-- form cho   isDeleteNewsCont -->
                        <div class="form-group row hidden-xs-up">
                            <label for="isDeleteNewsCont" class="col-sm-4 col-form-label">is Delete News Content</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="isDeleteNewsCont" id="isDeleteNewsCont" placeholder="is Delete News Content">
                            </div>
                        </div>
                        <!-- btn submit -->
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary btnInsertNews">Insert News</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end col-sm-6-->








            <div class="col-sm-6">          <!-- XỬ LÝ PHẦN SELECT, UPDATE, DELETE TIN TỨC -->
                <div class="jumbotron">
                    <h1 class="display-3">Jumbo heading</h1>
                    <p class="lead">Jumbo helper text</p>
                    <hr class="my-2">
                    <p>More info</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
                    </p>
                </div>


                <div class="row">
                    <div class="card-group">
                        <?php foreach ($selectingNews as $value): ?>
                            <div class="col-sm-4">
                                <!--tips: replace .card-group by .card-deck to obtain cards that aren’t attached to one another-->
                                <!--Card1-->
                                <div class="card">
                                    <a href="<?= base_url() ?>AttributeHomejson/newsDetails/<?= $value['idNews'] ?>">
                                        <?php 
                                            if (empty($value['imageNews'])){    /*nếu dữ liệu ảnh trống thì in ra 1 hình trống 700x300*/
                                         ?>
                                                <img src="http://placehold.it/700x300" style="width: 100%" class="card-img-top img-fluid">
                                        <?php
                                            }
                                            else{   /*còn dữ liệu ảnh có thì in ra ảnh*/
                                         ?>  
                                                <img src="<?= $value['imageNews'] ?>" style="width: 100%" class="card-img-top img-fluid">
                                        <?php
                                            }
                                        ?>
                                    </a>
                                    <div class="card-body">

                                        <p class="hidden-xs-up"><?= $value['idNews'] ?></p>
                                        <p class="hidden-xs-up"><?= $value['idNewsCat'] ?></p>
                                        <p class="hidden-xs-up"><?= $value['isDeleteNewsCont'] ?></p>

                                        <h5 class="card-title"><?= $value['newsTitle'] ?></h5>
                                        <small class="card-subtitle mb-2 text-muted">Đăng vào lúc: <?= date('d/m/Y G:i A',$value['newsDate']) ?></small>
                                        <small class="card-text"><?= $value['summaryNews'] ?></small>
                                        <a href="<?= base_url() ?>AttributeHomejson/updateNewsOpening/<?= $value['idNews'] ?>" class="btn btn-outline-warning updateNews"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="<?= base_url() ?>AttributeHomejson/deleteNews/<?= $value['idNews'] ?>" class="btn btn-outline-danger deleteNews"><i class="fas fa-eraser"></i></a>
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end col-sm-4 -->
                        <?php endforeach ?>
                    </div>
                </div>  <!-- end row -->
            </div><!-- end col-sm-6 -->
        </div><!--end row-->
    </div><!--end container-->






    <!-- XỬ LÝ PHẦN SELECT, UPDATE, DELETE TIN TỨC -->
    <div class="container">
        <div class="row">
            <div class="card-group">
                <?php foreach ($selectingNews as $value): ?>
                    <div class="col-sm-4">
                        <!--tips: replace .card-group by .card-deck to obtain cards that aren’t attached to one another-->
                        <!--Card1-->
                        <div class="card">
                            <a href="<?= base_url() ?>AttributeHomejson/newsDetails/<?= $value['idNews'] ?>">
                                <?php 
                                    if (empty($value['imageNews'])){    /*nếu dữ liệu ảnh trống thì in ra 1 hình trống 700x300*/
                                 ?>
                                        <img src="http://placehold.it/700x300" style="width: 100%" class="card-img-top img-fluid">
                                <?php
                                    }
                                    else{   /*còn dữ liệu ảnh có thì in ra ảnh*/
                                 ?>  
                                        <img src="<?= $value['imageNews'] ?>" style="width: 100%" class="card-img-top img-fluid">
                                <?php
                                    }
                                ?>
                            </a>
                            <div class="card-body">

                                <p class="hidden-xs-up"><?= $value['idNews'] ?></p>
                                <p class="hidden-xs-up"><?= $value['idNewsCat'] ?></p>
                                <p class="hidden-xs-up"><?= $value['isDeleteNewsCont'] ?></p>

                                <h5 class="card-title"><?= $value['newsTitle'] ?></h5>
                                <small class="card-subtitle mb-2 text-muted">Đăng vào lúc: <?= date('d/m/Y G:i A',$value['newsDate']) ?></small>
                                <small class="card-text"><?= $value['summaryNews'] ?></small>
                                <a href="<?= base_url() ?>AttributeHomejson/updateNewsOpening/<?= $value['idNews'] ?>" class="btn btn-outline-warning updateNews"><i class="fas fa-pencil-alt"></i></a>
                                <a href="<?= base_url() ?>AttributeHomejson/deleteNews/<?= $value['idNews'] ?>" class="btn btn-outline-danger deleteNews"><i class="fas fa-eraser"></i></a>
                            </div>
                        </div><!-- end card -->
                    </div><!-- end col-sm-4 -->
                <?php endforeach ?>
            </div>
        </div>  <!-- end row -->
    </div>








    <!-- XỬ LÝ CÁC NÚT ĐIỀU HƯỚNG-->
    <div class="container">
        <div class="row text-center"><h6>PHÂN TRANG THEO CÁCH THÔNG THƯỜNG</h6></div>   
        <!-- ===== PHÂN TRANG THEO CÁCH THÔNG THƯỜNG  (Lỗi)======-->
        <div class="row text-center">
            <nav class="pages mb-3 wow fadeInUp">

                <div class="controlPages"><!--phần xử lý button cho slide page Demo 2-->
                    
                    <ul>
                        <!-- XỬ LÝ NÚT PREVIOUS -->
                        <li class="pre">
                            <?php 
                                $prePage ='';
                                if($lastUri>2)  
                                    $prePage = '/pages/'.($lastUri-1);
                                if ($lastUri != "AttributeHomejson")
                                    echo '<a href="'.base_url().'AttributeHomejson'.$prePage.'" aria-label="Previous">';
                            ?>
                                <span aria-hidden="true">&laquo; Previous</span>
                            <?php if ($lastUri != "AttributeHomejson") echo '</a>' ?>
                        </li>

                        <!-- XỬ LÝ NÚT HOME (PAGE 1) -->
                        <li class="home <?php if($lastUri=="AttributeHomejson") echo 'runningAcivePage' ?>"> <!--nếu lastUri bằng vs-->
                            <?php if($lastUri=="AttributeHomejson") echo 'Home';/*AttributeHomejson thì add thêm class runningAcivePage để*/
                                  else echo '<a href="'.base_url().'AttributeHomejson">Home</a>';/*đánh dấu page đc chọn, và bỏ thẻ a đi*/
                            ?>
                        </li>

                        <!-- XỬ LÝ CÁC PAGES -->
                        <?php 
                            for ($count = 1; $count < $numberOfPages; $count++) {
                        ?>
                            <li class="controlPage <?php if($lastUri == ($count+1)) echo 'runningAcivePage' ?>">
                                <?php if ($lastUri==($count+1))     echo ($count+1);
                                      else echo '<a href="'.base_url().'AttributeHomejson/pages/'.($count+1).'">'.($count+1).'</a>';
                                /*Nếu lastUri bằng vs ($count+1) thì add thêm class runningAcivePage để đánh dấu page đc chọn, và bỏ thẻ a*/
                                ?>
                            </li>
                        <?php        
                            }
                        ?>

                        <!-- XỬ LÝ NÚT NEXT -->
                        <li class="next">
                            <?php 
                                $nextPage = $lastUri;
                                if ($lastUri == "AttributeHomejson")    $nextPage = 2;  /*nếu là page đầu thì next page sẽ là page 2*/
                                else if ($lastUri < $numberOfPages)/*nếu k phải là page đầu và k nhỏ hơn tổng số lượng page thì nextPage+1*/
                                    $nextPage = ((int)$lastUri+1);

                                if ($lastUri != $numberOfPages)
                                    echo '<a href="'.base_url().'AttributeHomejson/pages/'.$nextPage.'" aria-label="Next">';
                            ?>
                                <span aria-hidden="true">Next &raquo;</span>
                            <?php if ($lastUri != $numberOfPages) echo '</a>' ?>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
        <div class="row text-center"><h6>PHÂN TRANG SỬ DỤNG PHÍM TẮT</h6></div>     <!-- ========= PHÂN TRANG SỬ DỤNG PHÍM TẮT =========== -->
        <div class="row text-center">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>







    <!-- CÁC TIN LIÊN QUAN (KHỐI NHÚNG) -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">Các tin liên quan</div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="card-deck">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="http://placehold.it/700x400" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Text</p>
                        </div>  <!-- end card-body -->
                    </div>  <!-- end card -->
                </div>  <!-- end card-deck -->
            </div>  <!-- end col-sm-4 -->
        </div>  <!-- end row -->
    </div>  <!-- end container -->












    <!-- XỬ LÝ PHẦN GET USER, XUẤT FILE CÁC USER RA EXCEL -->
    <div class="container">
        <div class="row">
            <table class="exportAllUser2excel text-center">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Password</th>
                        <th class="text-center">Date Create</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getAllUser as $user): ?>
                        <tr>
                            <td><?= $user['idLogin'] ?></td>
                            <td><?= $user['nameLogin'] ?></td>
                            <td><?= $user['emailLogin'] ?></td>
                            <td><?= $user['passwordLogin'] ?></td>
                            <td><?= date('d/m/o G:i A',$user['dateCreate']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-6 push-sm-3">
                <button class="btn btn-block btn-outline-success ExportData2Excel">Export data to excel</button>
            </div> <!--class ExportData2Excel đc xử lý tại script trên phần header-->
        </div>
    </div>
    

</body>
</html>
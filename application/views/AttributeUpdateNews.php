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




    <!-- sử dụng thư viện ngoài để hiển thị chức năng như microsoft office word -->
    <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
    <!-- sử dụng thư viện ngoài để hiển thị chức năng như microsoft office word (quản lý hình ảnh)-->
    <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckfinder/ckfinder.js"></script>



    <!-- my js, tương tự trên, add thêm < ?php echo base_url(); ?> -->
    <!-- <script type="text/javascript" src="< ?php echo base_url(); ?>Firstjs.js"></script> -->
</head>
<body>  
    <?php 
        include "AttributeHeaderView.php";
     ?>


    
    <!-- < ?php 
        foreach ($selectNewsCategories as $value):
            echo '<pre>';
            var_dump($value['idNewsCat']);
            var_dump($value['nameNewsCat']);
            echo '</pre>';
        endforeach;
        die();
     ?> -->


    <!-- XỬ LÝ PHẦN CHỈNH SỬA TIN TỨC -->
    
    <div class="container">
        <div class="jumbotron col-sm-6 push-sm-3 text-center">
            <h1 class="display-6">Jumbo heading</h1>
            <p class="lead">Jumbo helper text</p>
            <hr class="my-2">
            <!-- <p>More info</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
            </p> -->
        </div>
        <form action="<?= base_url() ?>AttributeHomejson/updateNews" method="POST" enctype="multipart/form-data" class="col-sm-10 push-sm-1">
            <div class="row text-center"><h4>Chỉnh sửa tin tức</h4></div>
            <?php foreach ($selectUpdateNews as $value): ?>
            <!-- form cho idNews -->
            <div class="form-group row hidden-xs-up">
                <label for="idNews" class="col-sm-4 col-form-label">News id</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="idNews" id="idNews" value="<?= $value['idNews'] ?>">
                </div>
            </div>
            <!-- form cho   newsTitle -->
            <div class="form-group row">
                <label for="newsTitle" class="col-sm-4 col-form-label">News title</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="newsTitle" id="newsTitle" value="<?= $value['newsTitle'] ?>">
                </div>
            </div>
            <!-- form cho idNewsCat -->
            <div class="form-group row">
                <label for="idNewsCat" class="col-sm-4 col-form-label">News Category</label>
                <div class="col-sm-8">
                    <select name="idNewsCat" id="idNewsCat" class="form-control">
            <?php 
                $idNews = $value['idNewsCat'];  /*lưu lại $value['idNewsCat'] để thực hiện trong option hiển thị idNewsCat nào đc chọn*/
                endforeach 
            ?>
                        <?php foreach ($selectNewsCategories as $value): ?>
                            <option value="<?= $value['idNewsCat'] ?>" <?php if($value['idNewsCat']==$idNews) echo "selected" ?>>
                                <?= $value['nameNewsCat'] ?>    <!-- idNewsCat và nameNewsCat: các cột trong bảng -->
                            </option>   <!-- newscategories (đc lấy từ ) function selectNews trong controllers -->
                        <?php endforeach ?> 
            <?php foreach ($selectUpdateNews as $value): ?>
                    </select>
                </div>
            </div>
            <!-- form cho   imageNews (Ở ĐÂY CÓ XỬ LÝ CROP IMAGE)-->
            <div class="form-group row">
                <label for="imageNews" class="col-sm-4 col-form-label">News image</label>
                <div class="col-sm-8">
                    <img src="<?= $value['imageNews'] ?>" name="imageNews" id="imageNews" style="width: 50%" class='img-fluid'>
                </div>
                <div class="col-sm-8 push-sm-4">
                    <input type="file" class="form-control" name="imageNews" id="imageNews" placeholder="Image News">
                </div>
                <input type="hidden" class="form-control" name="imageNewsOld" id="imageNewsOld" value="<?= $value['imageNews'] ?>">
            </div>
            <!-- form cho   summaryNews -->
            <div class="form-group row">
                <label for="summaryNews" class="col-sm-12 col-form-label">Summary News</label>
                <div class="col-sm-12">
                    <textarea type="text" class="form-control summaryNews" name="summaryNews" id="summaryNews"  cols="30" rows="10" placeholder="Summary News"><?= $value['summaryNews'] ?></textarea>
                </div>
            </div>
            <!-- form cho   newsCon -->
            <div class="form-group row">
                <label for="newsCon" class="col-sm-12 col-form-label">News Content</label>
                <div class="col-sm-12">
                    <textarea type="text" class="form-control newsCon" name="newsCon" id="newsCon"  cols="30" rows="20" placeholder="News Content"><?= $value['newsCon'] ?></textarea>
                </div>
            </div>
            <!-- form cho newsDate -->
            <div class="form-group row hidden-xs-up">
                <label for="newsDate" class="col-sm-4 col-form-label">News Date</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="newsDate" id="newsDate" placeholder="News Date" value="<?= $value['newsDate'] ?>">
                </div>
            </div>
            <!-- form cho   isDeleteNewsCont -->
            <div class="form-group row hidden-xs-up">
                <label for="isDeleteNewsCont" class="col-sm-4 col-form-label">is Delete News Content</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="isDeleteNewsCont" id="isDeleteNewsCont" placeholder="is Delete News Content" value="<?= $value['isDeleteNewsCont'] ?>">
                </div>
            </div>
            <?php endforeach ?>
            <!-- btn submit -->
            <div class="form-group row text-center">
                <div class="col-sm-6 text-right">
                    <button type="submit" class="btn btn-primary btnUpdateNews">Update News</button>
                </div>
                <div class="col-sm-6 text-left">
                    <?php foreach ($selectUpdateNews as $value): ?> <!-- muốn có id thì đưa foreach này vào -->
                    <a  class="btn btn-danger btnDeleteNews" href="<?= base_url() ?>AttributeHomejson/deleteNews/<?= $value['idNews'] ?> ">Delete News</a>
                    <?php endforeach ?>
                </div>
            </div>

        </form>
    </div>
    



    <script type="text/javascript">
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
    </script>


</body>
</html>
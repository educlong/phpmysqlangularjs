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
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script> -->
    <!-- sử dụng thư viện ngoài để hiển thị chức năng như microsoft office word (quản lý hình ảnh)-->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>ckeditor/ckfinder/ckfinder.js"></script> -->

    <!-- my js, tương tự trên, add thêm < ?php echo base_url(); ?> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>Firstjs.js"></script> -->
</head>
<body>
    

    <?php 
        include "AttributeHeaderView.php";
     ?>

    <div class="container">
        <form action="<?= base_url() ?>AttributeHomejson/indexUser" method='POST' enctype='multipart/form-data'>
            <div class="row">
                <div class="col-sm-8 push-sm-2">
                    
                </div>
            </div>
        </form>
    </div>


    <div class="container">
        <form action="<?= base_url() ?>AttributeHomejson/addUser" method='POST' enctype='multipart/form-data'>
            <div class="row">
                <div class="col-sm-6 push-sm-3">
                    <div class="form-group">
                        <div class="row">
                            <label for="usernameLogin" class="col-sm-4 col-form-label">Username:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="usernameLogin" id="usernameLogin" placeholder="Username">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="emailLogin" class="col-sm-4 col-form-label">Email:</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="emailLogin" id="emailLogin" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="adminLogin" class="col-sm-4 col-form-label">Admin:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="adminLogin" id="adminLogin">
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="passwordLogin" class="col-sm-4 col-form-label">Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="passwordLogin" id="passwordLogin" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label  class="col-sm-4 col-form-label">Password Again:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" placeholder="Rewrite Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 text-right">
                            <input name="" type="submit" class="btn btn-primary" value="Create an account">
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</body>
</html>
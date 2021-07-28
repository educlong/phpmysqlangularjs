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

    <!-- my js, tương tự trên, add thêm < ?php echo base_url(); ?> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>Firstjs.js"></script>
</head>
<body>
    
    <div class="container">
        <div class="row" style="margin-top: 50px;">                           
            <form   method="post" enctype="multipart/form-data" 
                    action="<?= base_url() ?>index.php/MainEmployees/updateEmployee">
                <?php foreach ($updateEmployeeDetail as $value): ?>
                <div class="form-group form-row"><!--để gửi file đc cần đổi kiểu enctype sang multipart-->
                    
                    <div class="col-md-8">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="inputNameEmp">Name Employee</label>
                                <input type="text" class="form-control" id="inputNameEmp" name="nameEmployee" value="<?= $value['nameEmp'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAgeEmp">Age Employee</label>
                                <input type="number" class="form-control" id="inputAgeEmp" name="ageEmployee" value="<?= $value['ageEmp'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="form-group col-md-4">
                                <label for="inputPhoneEmp">Phone Employee</label>
                                <input type="text" class="form-control" id="inputPhoneEmp" name="phoneEmployee" value="<?= $value['phoneEmp'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputOrdersEmp">Number of orders</label>
                                <input type="number" class="form-control" id="inputOrdersEmp" placeholder="2" name="ordersEmployee" value="<?= $value['ordersEmp'] ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputAvatarEmp" class="form-control-label">Upload avatar</label>
                                <input type="file" class="form-control" id="inputAvatarEmp" name="avatarEmployee">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="inputLinkfbEmp">Link Facebook</label>
                                <input type="text" class="form-control" id="inputLinkfbEmp" placeholder="http://www.facebook.com/long.hx" name="linkfbEmployee" value="<?= $value['linkfbEmp'] ?>">
                            </div>
                            <div class="col-sm-4" style=" display: flex; align-items: center; justify-content: center;">
                                <button type="submit" class="btn btn-outline-warning btn-xs">
                                    <a href=""> Save <i class="fal fa-pencil"></i><i class="fa fa-chevron-right"></i></a>
                                </button>
                                <button type="reset" class="btn btn-outline-danger btn-xs">
                                    <a href="<?= base_url() ?>index.php/MainEmployees/deleteEmployeeModel/<?= $value['idEmp'] ?>" class="card-link linkfbEmp"> Back <i class="fas fa-trash"></i><i class="fa fa-chevron-right"></i></a>
                                </button>
                            </div>
                        </div>
                    </div>  <!-- end form-group col-md-8 -->
                    
                    <div class="col-md-4">
                        <img src="<?= $value['avartarEmp'] ?>" alt="" class="img-fluid" style="width: 40%;">
                        <br>
                        <input style="width: 40%;" type="hidden" name="idEmployee" id="" value="<?= $value['idEmp'] ?>">
                        <input style="width: 40%;" type="hidden" name="avatarEmployeeNotChange" id="" value="<?= $value['avartarEmp'] ?>">
                    </div>

                </div>  <!-- end form-row -->
                <?php endforeach ?>
            </form>     <!-- end form  -->
        </div>      <!-- end row -->
    </div>  <!-- end container -->
</body>
</html>
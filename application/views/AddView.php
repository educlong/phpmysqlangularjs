<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Page Title</title>
		

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
	<h3 style="text-align: center;">Hello, world!</h3>



	<!-- Demo 0 -->
	<ul>
		<?php foreach ($danhSachArr as $keyArr): ?> <!-- duyệt mảng, mỗi phần tử là 1 keyArr-->
			<li><?php echo $keyArr; ?></li>
		<?php endforeach ?>
	</ul>










	<?php require("HeaderView.php") ?>	<!-- lấy header chung từ file HeaderView.php -->










	<!-- Demo 1 -->
	<div class="container">
		<div class="row">
			<div class="col-sm-8 push-sm-2">
				<div class="container">	<!--gõ b4-form-grid -> tab --> <!--định nghĩa cho form này đc xử lý tại hàm insertTaiSanController trong controller-->
					<form action="FirstController/insertTaiSanController" method="post" enctype="multidata/form-data"><!--với phương thức post và mã hóa (enctype) multidata-->	
						<div class="card">	<!--add thêm card và card-block vào-->
							<div class="card-block">
								<div class="form-group row">
									<label for="inputName" class="col-sm-4 col-form-label">Mã Tài Sản</label>	<!--thay đổi col-sm-1-12 thành col-sm-4-->
									<div class="col-sm-8">	<!--thay đổi col-sm-1-12 thành col-sm-4-->	<!--chú ý đặt tên trường: name="inputCodeTs" -->
										<input type="text" class="form-control" name="inputCodeTs" id="inputName" placeholder="VD: TS01">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputName" class="col-sm-4 col-form-label">Tên Tài Sản</label>	<!--thay đổi col-sm-1-12 thành col-sm-4-->
									<div class="col-sm-8">	<!--thay đổi col-sm-1-12 thành col-sm-4-->	<!--chú ý đặt tên trường: name="inputNameTs" -->
										<input type="text" class="form-control" name="inputNameTs" id="inputName" placeholder="VD: Máy khoan">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputName" class="col-sm-4 col-form-label">Ngày nhập kho</label>	<!--thay đổi col-sm-1-12 thành col-sm-4-->
									<div class="col-sm-8">	<!--thay đổi col-sm-1-12 thành col-sm-4-->	<!--chú ý đặt tên trường: name="inputDateImport" -->
										<input type="text" class="form-control" name="inputDateImport" id="inputName" placeholder="VD: 30-11-2021">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputName" class="col-sm-4 col-form-label">Năm khấu hao</label>	<!--thay đổi col-sm-1-12 thành col-sm-4-->
									<div class="col-sm-8">	<!--thay đổi col-sm-1-12 thành col-sm-4-->	<!--chú ý đặt tên trường: name="inputYearKhauHao" -->
										<input type="text" class="form-control" name="inputYearKhauHao" id="inputName" placeholder="VD: 3">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputName" class="col-sm-4 col-form-label">Zá trị</label>	<!--thay đổi col-sm-1-12 thành col-sm-4-->
									<div class="col-sm-8">	<!--thay đổi col-sm-1-12 thành col-sm-4-->	<!--chú ý đặt tên trường: name="inputPriceTs" -->
										<input type="text" class="form-control" name="inputPriceTs" id="inputName" placeholder="VD: 10">
									</div>
								</div>
								<fieldset class="form-group row">
									<legend class="col-form-legend col-sm-1-12">Group name</legend>
									<div class="col-sm-1-12">
										
									</div>
								</fieldset>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-4">	<!--click vào input thì nội dung nhập sẽ đc truyền vào controller, sau đó đưa vào-->
										<input type="submit" class="btn btn-success btn-block" value="Nhập vào csdl mysql">	<!--database thông qua model-->
									</div>
									<!-- <div class="offset-sm-1 col-sm-4">
										<a href="" class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i></a>
									</div> -->
								</div> 	<!--end form-group row-->
							</div> 		<!--end card-block-->
						</div>			<!--end card-->
					</form>				<!--end form action="FirstController/insertTaiSanController" method="post" enctype="multidata/form-data-->
				</div>					<!--end container-->
			</div>						<!--end col-sm-8 push-sm-2-->
		</div>							<!--end row-->
	</div>								<!--end container-->






	
</body>
</html>
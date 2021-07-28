<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Load thành công</title>
	
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

	

	<?php require("HeaderView.php") ?>	<!-- lấy header chung từ file HeaderView.php -->





	<h5 class="text-center">Insert success</h5>
	<a href="<?php echo base_url() ?>index.php/FirstController" class="btn btn-info btn-lg">Back Home <i class="fa fa-chevron-left"></i></a>
	<div class="container">
		<div class="row">
			<h4 class="text-center">Danh sách tài sản</h4>
			<hr>
		</div>
		<div class="row">	<!-- duyệt mảng dataController lấy ra hết data -->
			<?php foreach ($dataController as $key => $value): ?>
			<div class="col-sm-4">
				<div class="card card-block">
					<div class="card-body">
						<h4 class="card-title"><?= $value["CodeTS"] ?>: <?= $value["NameTS"] ?></h4>
						<div class="card-text">
							<p>Ngày nhập: <?= $value["DateImport"] ?></p>
							<p>Năm khấu hao: <?= $value["YearKhauHao"] ?></p>
							<p>Zá trị: <?= $value["ValueTS"] ?></p>
						</div>
						<div class="container">
							<div class="row">
								<div class="offset-sm-1 col-sm-4">
									<a href="SecondController/deleteTaiSanController/<?= $value['CodeTS'] ?>" class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i></a>
								</div>
								<div class="offset-sm-1 col-sm-4">
									<a href="SecondController/updateTaiSanController/<?= $value['CodeTS'] ?>" class="btn btn-warning btn-block"><i class="fas fa-pen-alt"></i></a>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</body>
</html>
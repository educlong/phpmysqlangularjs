<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Tạo thư mục files để lưu file upload lên (ko sử dụng thư mục images như trước nữa)*/
/*Đầu tiên, để page upload đc file => copy file UploadHandler.php trong jqueryuploadfile/server/php/UploadHandler.php vào application/controllers. Sau đó include file UploadHandler.php vào*/
include 'UploadHandler.php';	/*include cho phép upload file*/

class mainAjax extends CI_Controller {	/*Link truy cập để text: http://127.0.0.1:8888/phpBasic4/index.php/mainAjax*/

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->selectEmployees();	/*ban đầu load data từ database lên view*/
	}

	public function selectEmployees()
	{
		$this->load->model('mainModel');/*sau khi load model thì truyền kq qua mainModel*/
		$this->load->view('mainViewAjax', 
			array("arrSelectAllEmployees" => $this->mainModel->selectEmployeesModel()));
	}

	public function insertEmployeeProcessingInAjax()	/*xử lý insert employee trong ajax (button btnInsertEmp)*/
	{	/*xử lý zống y chang insertEmployee, nhưng k xử lý file hình ảnh avatar đc*/
		$this->load->model('mainModel');
		// if ($this->mainModel->checkNameEmployeeModel($this->input->post('nameEmployee'))) {/*nếu name tồn tại*/
		// 	$this->updateEmployee(); /*thì chỉ cần update*/
		// }
		// else{	/*còn chưa tồn tại thì insert*/
			if ($this->mainModel->insertEmployeeModel($this->input->post('nameEmployee'),
												 $this->input->post('ageEmployee'),
												 $this->input->post('phoneEmployee'),
												 $this->input->post('avatarEmployee'),
												 $this->input->post('ordersEmployee'),
												 $this->input->post('linkfbEmployee')))
				 echo 'insert success';
			else echo 'insert fail';
		// }
	}

	public function updateEmployeeOpening($idEmployee)
	{
		$this->load->model('mainModel');
		$this->load->view('mainViewAjax', array("updateEmployeeDetail"=> $this->mainModel->checkEmployeeModel($idEmployee)),FALSE);
	}

	public function updateEmployee()
	{
		$imgAvatarEmp = $this->uploadImageAvatar();

		if ($imgAvatarEmp)  /*xử lý hình ảnh avatar, nếu có upload hình ảnh mới*/
			$imgAvatarEmp = base_url()."files/".$this->uploadImageAvatar();
		else 				/*nếu k có thì zữ nguyên*/
			$imgAvatarEmp = $this->input->post('avatarEmployeeNotChange');
		$this->load->model('mainModel');
		if ($this->mainModel->updateEmployeeModel($this->input->post('idEmployee'),
											  $this->input->post('nameEmployee'),
											  $this->input->post('ageEmployee'),
											  $this->input->post('phoneEmployee'),
											  $imgAvatarEmp,
											  $this->input->post('ordersEmployee'),
											  $this->input->post('linkfbEmployee')))
		{
			$this->load->view('insertupdatedeleteView');
		}
		else echo 'update fail';

	}

	public function deleteEmployee($idEmployee)
	{
		$this->load->model('mainModel');
		if ($this->mainModel->deleteEmployeeModel($idEmployee)){
			$this->load->view('insertupdatedeleteView');
		}
		else echo 'delete fail';
	}




	public function uploadImageAvatar()
	{
		/*phần xử lý upload file*/
		$target_dir = "files/";	/*đường dẫn file*/
		$target_file = $target_dir . basename($_FILES["avatarEmployee"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($_FILES["avatarEmployee"]["tmp_name"]);
		  if($check !== false) {
		    // echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    // echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($target_file)) {
		  // echo "Sorry, file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($_FILES["avatarEmployee"]["size"] > 5000000) {
		  // echo "Sorry, your file is too large.";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		  // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  // echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} 
		else {
		  if (move_uploaded_file($_FILES["avatarEmployee"]["tmp_name"], $target_file)) {
		    // echo "The file ". htmlspecialchars( basename( $_FILES["avatarEmployee"]["name"])). " has been uploaded.";
		  } else {
		    // echo "Sorry, there was an error uploading your file.";
		  }
		}
		return basename($_FILES["avatarEmployee"]["name"]);
	}


	/*xử lý phần upload hình ảnh bằng ajax*/
	public function uploadImageAvatarAjax()
	{	
		$uploadFile = new UploadHandler();
	}
}

/* End of file mainAjax.php */
/* Location: ./application/controllers/mainAjax.php */
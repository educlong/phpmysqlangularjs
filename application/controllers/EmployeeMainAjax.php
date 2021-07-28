<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Đầu tiên, để page upload đc file => copy file UploadHandler.php trong jqueryuploadfile/server/php/UploadHandler.php vào application/controllers. Sau đó include file UploadHandler.php vào*/
include 'UploadHandler.php';	/*include cho phép upload file*/

/*Config project
	Bước 1: kích hoạt url trong file autoload.php
	Bước 2: kích hoạt base_url trong file config.php
	Bước 3: thêm đường dẫn css, js bằng cách < ? php echo base_url(); ?>
	Bước 4: kết nối database trong file config/database.php (username, pass, databasename,etc.)
	Bước 5: chỉnh routes trong file application/config/routes.php link đế controller này để tối zản đường link
	Bước 6: add thêm file .htaccess (file này cùng cấp vs application) để bỏ luôn index.php trong đường link server
	Bước 7: tạo thư mục files (hoặc images) để lưu trữ hình ảnh
	Bước 8: copy thư viện (thư mục jqueryuploadfile) ngoài để upload file (xử lý tại project controllers EmployeeMainAjax, import vào EmployeeMainViewAjax)
*/
class EmployeeMainAjax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	private $model = 'EmployeeMainModel';
	private $viewHome = 'EmployeeMainViewAjax';
	private $viewUpdate = 'EmployeeUpdateView';
	private $viewSuccess ="EmployeeInsertupdatedeleteView";
	private $viewHomeTransferData = 'arrSelectAllEmployees';
	private $viewUpdateTransferData = 'updateEmployeeDetail';

	private $fieldsFromHomeView = array("nameEmployee","ageEmployee","phoneEmployee","avatarEmployee","ordersEmployee","linkfbEmployee");
	private $fieldsFromUpdateView = array("idEmployee", "nameEmployee","ageEmployee","phoneEmployee","avatarEmployee","ordersEmployee","linkfbEmployee", "avatarEmployeeNotChange");



	public function index()
	{
		$this->selectEmployees();	/*ban đầu load data từ database lên view*/
	}

	public function selectEmployees()
	{
		$this->load->model($this->model);/*sau khi load model thì truyền kq qua EmployeeMainModel*/
		$this->load->view($this->viewHome, 
			array($this->viewHomeTransferData => $this->EmployeeMainModel->selectEmployeesModel()));
	}

	public function insertEmployeeProcessingInAjax()	/*xử lý insert employee trong ajax (button btnInsertEmp)*/
	{	/*xử lý zống y chang insertEmployee, nhưng k xử lý file hình ảnh avatar đc*/
		$this->load->model($this->model);
		// if ($this->EmployeeMainModel->checkNameEmployeeModel($this->input->post('nameEmployee'))) {/*nếu name tồn tại*/
		// 	$this->updateEmployee(); /*thì chỉ cần update*/
		// }
		// else{	/*còn chưa tồn tại thì insert*/
			if ($this->EmployeeMainModel->insertEmployeeModel($this->input->post($this->fieldsFromHomeView[0]),
												 $this->input->post($this->fieldsFromHomeView[1]),
												 $this->input->post($this->fieldsFromHomeView[2]),
												 $this->input->post($this->fieldsFromHomeView[3]),
												 $this->input->post($this->fieldsFromHomeView[4]),
												 $this->input->post($this->fieldsFromHomeView[5])))
				 echo 'insert success';
			else echo 'insert fail';
		// }
	}

	public function updateEmployeeOpening($idEmployee)
	{
		$this->load->model($this->model);
		$this->load->view($this->viewUpdate, 
			array($this->viewUpdateTransferData => $this->EmployeeMainModel->checkEmployeeModel($idEmployee)),FALSE);
	}

	public function updateEmployee()
	{
		$imgAvatarEmp = $this->uploadImageAvatar();

		if ($imgAvatarEmp)  /*xử lý hình ảnh avatar, nếu có upload hình ảnh mới*/
			$imgAvatarEmp = base_url()."files/".$this->uploadImageAvatar();
		else 				/*nếu k có thì zữ nguyên*/
			$imgAvatarEmp = $this->input->post($this->fieldsFromUpdateView[7]);
		$this->load->model($this->model);
		if ($this->EmployeeMainModel->updateEmployeeModel($this->input->post($this->fieldsFromUpdateView[0]),
											  $this->input->post($this->fieldsFromUpdateView[1]),
											  $this->input->post($this->fieldsFromUpdateView[2]),
											  $this->input->post($this->fieldsFromUpdateView[3]),
											  $imgAvatarEmp,
											  $this->input->post($this->fieldsFromUpdateView[5]),
											  $this->input->post($this->fieldsFromUpdateView[6])))
		{
			$this->load->view($this->viewSuccess);
		}
		else echo 'update fail';

	}

	public function deleteEmployee($idEmployee)
	{
		$this->load->model($this->model);
		if ($this->EmployeeMainModel->deleteEmployeeModel($idEmployee)){
			$this->load->view($this->viewSuccess);
		}
		else echo 'delete fail';
	}




	public function uploadImageAvatar()
	{
		/*phần xử lý upload file*/
		$target_dir = "files/";	/*đường dẫn file*/
		$target_file = $target_dir . basename($_FILES[$this->fieldsFromUpdateView[4]]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($_FILES[$this->fieldsFromUpdateView[4]]["tmp_name"]);
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
		if ($_FILES[$this->fieldsFromUpdateView[4]]["size"] > 5000000) {
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
		  if (move_uploaded_file($_FILES[$this->fieldsFromUpdateView[4]]["tmp_name"], $target_file)) {
		    // echo "The file ". htmlspecialchars( basename( $_FILES[$this->fieldsFromUpdateView[4]]["name"])). " has been uploaded.";
		  } else {
		    // echo "Sorry, there was an error uploading your file.";
		  }
		}
		return basename($_FILES[$this->fieldsFromUpdateView[4]]["name"]);
	}


	/*xử lý phần upload hình ảnh bằng ajax*/
	public function uploadImageAvatarAjax()
	{	
		$uploadFile = new UploadHandler();
	}
}

/* End of file mainAjax.php */
/* Location: ./application/controllers/mainAjax.php */
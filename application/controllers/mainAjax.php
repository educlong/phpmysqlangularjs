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

	public function deleteEmployee($idEmployee)
	{
		$this->load->model('mainModel');
		if ($this->mainModel->deleteEmployeeModel($idEmployee)){
			$this->load->view('insertupdatedeleteView');
		}
		else echo 'delete fail';
	}




	/*xử lý phần upload hình ảnh bằng ajax*/
	public function uploadImageAvatarAjax()
	{	
		$uploadFile = new UploadHandler();
	}
}

/* End of file mainAjax.php */
/* Location: ./application/controllers/mainAjax.php */
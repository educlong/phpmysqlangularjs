<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AngularDemo1 extends CI_Controller {

	private $model = 'AngularDemo1Model';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->model);
	}
	private $angularHome = "AngularHome";
	public function index()
	{
		$this->load->view($this->angularHome);
	}

	/*DATABASE BẰNG CHUỖI JSON*/
	private $isDelete = ['0','1'];


		/*DEMO2: SỬ DỤNG TEMPLATE ADMIN ĐỂ LÀM BACKEND -> search từ khóa: milestones template admin download themelock, tải template về
		Bước 1: Tạo thêm folder phpBasic4/angularJsDemo2 để lưu trữ template và zao diện cần thiết
		Bước 2: Chỉnh sửa lại file demo phpBasic4/angularJsDemo2/milestone-120/html/app/index.html
		*/
	/*code tự xổ ra, gõ crud -> tab*/
			
	private $columnIdLogin = "idLogin";
	private $columnNameLogin = "nameLogin";			/*Paul*/
	private $columnEmailLogin = "emailLogin";		/*Paul*/
	private $columnPasswordLogin = "passwordLogin";	/*Paul*/
	private $columnAdminLogin = "adminLogin";		/*Paul*/
	private $columnIsDeleteLogin = "isDeleteLogin";


	private $fieldFromViewCreateAccount = array("idLogin", "usernameLogin", "emailLogin", "passwordLogin", "adminLogin", "isDeleteLogin");
	// private $viewHomeTransferDataUser = "getAllUser";

	public function getAll()	/*lấy hết cả user và admin*/
	{
		echo json_encode($this->AngularDemo1Model->getUser(NULL, NULL));
	}
	public function indexUser( $offset = 0 )	/*$offset = 0 là vị trí, zả sử muốn list ra tất cả người dùng ==> $offset = 0*/
	{	/*muốn list ra từ người dùng thứ 2, bỏ qua 2 người dùng ban đầu (thứ 0 và thứ 1) ==> $offset = 2*/
		return $this->AngularDemo1Model->getUser(NULL, false);	/*false: lấy hết user (ko lấy admin)*/
	}
	public function indexAdmin( $offset = 0 )	/*$offset = 0 là vị trí, zả sử muốn list ra tất cả người dùng ==> $offset = 0*/
	{	/*muốn list ra từ người dùng thứ 2, bỏ qua 2 người dùng ban đầu (thứ 0 và thứ 1) ==> $offset = 2*/
		return $this->AngularDemo1Model->getUser(NULL, true);	/*true: lấy hết admin (ko lấy user)*/
	}


	// Add a new item
	public function addUserOrAdmin()
	{	/*tạo 1 account mới từ view nhập vào*/	
		$newAccount = array($this->columnNameLogin => $this->input->post($this->fieldFromViewCreateAccount[1]),	/*trường username*/
			$this->columnEmailLogin 	=> $this->input->post($this->fieldFromViewCreateAccount[2]),	 /*trường email*/
			$this->columnPasswordLogin 	=> md5($this->input->post($this->fieldFromViewCreateAccount[3])),/*trường pass. md5: mã hóa password*/
			$this->columnAdminLogin 	=> (int)$this->input->post($this->fieldFromViewCreateAccount[4]), 
			$this->columnIsDeleteLogin 	=> $this->isDelete[0]);	/*trường admin = 0 (ko phải là admin), =1 (là admin). và trường isDelete =1*/

		if ($this->AngularDemo1Model->insertUser($newAccount))	/*insert account này vào database*/
			echo 'success';
		else echo 'fail';
	}

	//Update one item
	public function updateUserOrAdmin( $id = NULL )	/*nhận id cần chỉnh sửa*/
	{	/*đây chỉ là ví dụ, làm thực tế cần có 1 form để update và ở đây hứng data từ view*/
		$where = array($this->columnIdLogin => $this->input->post($this->fieldFromViewCreateAccount[0]));		/*zả sử update user có id=3*/
		$updateAccount = array($this->columnNameLogin 	=> $this->input->post($this->fieldFromViewCreateAccount[1]),	/*trường username*/
						$this->columnEmailLogin 		=> $this->input->post($this->fieldFromViewCreateAccount[2]),	/*trường email*/
						// $this->columnPasswordLogin 	=> md5($this->input->post($this->fieldFromViewCreateAccount[3])),	/*trường pass*/
						$this->columnAdminLogin 	=> $this->input->post($this->fieldFromViewCreateAccount[4]),		/*trường admin*/
						$this->columnIsDeleteLogin 	=> $this->input->post($this->fieldFromViewCreateAccount[5]));		/*trường isdelete*/

		if ($this->AngularDemo1Model->updateUser($updateAccount, $where))	/*update account này vào database*/
			echo 'success';
		else echo 'fail';
	}

	//Delete one item
	public function deleteUserOrAdmin( $id = NULL )	/*nhận id để xóa*/
	{	/*đây chỉ là ví dụ, làm thực tế cần có 1 form để delete và ở đây hứng data từ view*/
		$where = array($this->columnIdLogin => 3);					/*zả sử delete user có id=3*/
		$deleteAccount = array($this->columnIsDeleteLogin => 1); 		/*trường	idLogin = 1*/

		if ($this->AngularDemo1Model->updateUser($deleteAccount, $where))	/*update account này vào database*/
			echo 'success';
		else echo 'fail';
	}
	
	/* End of file AttributeHomejson.php */
	/* Location: ./application/controllers/AttributeHomejson.php */






	/*XỬ LÝ LOGIN*/
	public function checkLogin()	/*check xem email và pass user nhập vào có trùng vs database hay ko, nếu trùng trả về true*/
	{
		$where=array($this->columnEmailLogin 	=> $this->input->post($this->fieldFromViewCreateAccount[2]),
					 $this->columnPasswordLogin	=> md5($this->input->post($this->fieldFromViewCreateAccount[3])));
		$infoUser = $this->AngularDemo1Model->getUser($where, NULL);	/*lấy ra thông tin user trùng vs email và password nhập vào*/

		if ($infoUser) 	/*đặt data cho session này chính là data của mảng tìm đc (đặt vào trong data bộ nhớ của chrome để check login)*/
			 $this->session->set_userdata('infoUser',json_encode($infoUser));	/*đưa về 1 chuỗi json và đưa vào session*/
		else $this->session->set_userdata('infoUser','');	/*nếu đăng nhập sai thì đưa vào session là 1 chuỗi rỗng*/	
		echo $this->session->userdata('infoUser');			/*in ra check session, in ra là 1 chuỗi json, check chuỗi này trong file js*/
	}	/*Nếu session đc đưa vào là rỗng, thì đăng nhập k thành công=>fail. Ngược lại ok*/

}

/* End of file AngularDemo1.php */
/* Location: ./application/controllers/AngularDemo1.php */
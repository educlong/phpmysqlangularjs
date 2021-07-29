<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*	Config project
	Bước 1: kích hoạt url trong file autoload.php
	Bước 2: kích hoạt base_url trong file config.php
	Bước 3: thêm đường dẫn css, js bằng cách < ? php echo base_url(); ?>
	Bước 4: kết nối database trong file config/database.php (username, pass, databasename,etc.)
	Bước 5: chỉnh routes trong file application/config/routes.php link đế controller này để tối zản đường link
	Bước 6: add thêm file .htaccess (file này cùng cấp vs application) để bỏ luôn index.php trong đường link server
	Bước 7: tạo thư mục files (hoặc images) để lưu trữ hình ảnh
	Bước 8: copy thư viện (thư mục jqueryuploadfile) ngoài để upload file (xử lý tại project controllers EmployeeMainAjax, import vào EmployeeMainViewAjax)
	Bước 9: copy thư viện ckeditor ngoài vào để hiển thị chức năng như microsoft office word (import vào view AttributeHome)
	Bước 10: config tại file autoload.php để áp dụng session (chức năng đăng nhập)
	Bước 11: Để xuất data từ bảng table database ra excel, add thêm file exportTable2excelUsingJQuery vào cùng cấp vs application và link thư viện trong AttributeHome.php
	Bước 12: Tùy biến đường dẫn thân thiện trong file config/routers.php
		(VD: thay vì gõ 	http://127.0.0.1:8888/phpBasic4/AttributeHomejson/detailsMenu/10/hoc081098
			 thì chỉ cần gõ	http://127.0.0.1:8888/phpBasic4/hoc081098)
*/


class AttributeHomejson extends CI_Controller {
	private $model = 'AttributejsonModel';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->model);
	}


	private $attributeHome = "AttributeHome";


	public function index()
	{
		$this->load->view($this->attributeHome);
	}


	/*DATABASE BẰNG CHUỖI JSON*/
	private $nameAttribute = array("topBannerSlide", "infoBookingTable", "menuDacap", "userAngular");
	private $isDelete = ['0','1'];


	/*<!-- ============================== ANGULAR JS ================================ -->*/



	/*XỬ LÝ USER ANGULAR JS (xử lý bằng chuỗi json, dữ liệu cũng bằng chuỗi json)*/
	/*zá trị đầu tiên của trường nameAttribute trong db là userAngular $nameAttribute[3]*/
	private $fieldsUserAngInValueAttribute=array("id","name","dob","fb","phone","isDelete");/*các trường trong valueAttribute(user)*/

	// private $viewInsertMenu = 'AttrInsertMenuView';
	// private $fieldsFromSelectUserAngular = "selectUserAngular";		/*đống gói thành mảng và đưa vào view*/

	public function selectAttributeUserAngular()	/*trả về 1 chuỗi json chứ k phải trả về 1 mảng như thông thường, để xử lý cho angular js*/
	{
		echo $this->AttributejsonModel->selectAttributeModelNoDelete($this->nameAttribute[3], $this->fieldsUserAngInValueAttribute);
		// return $this->AttributejsonModel->selectAttributeModelNoDelete($this->nameAttribute[3], $this->fieldsUserAngInValueAttribute);
	}


	/*Những trường này đc lấy từ file js (phần xử lý cho angular js) ===> XỬ LÝ JSON (UPDATE PHẦN TỬ ĐƯỢC CHỌN TRONG JSON)*/
	private $fieldsFromUpdateUserAng = array("idUserAngular","nameUserAngular","dobUserAngular","fbUserAngular","phoneUserAngular");
	public function updateAttributeUserAngular()	/*thực ra lầ update lại zá trị của cột nameAttribute (update bất kỳ thuộc tính nào)*/
	{	/*Đầu tiên, lấy hết data trong cột valueAttribute, dòng userAngular ra, decode ra thành 1 mảng và lưu vào $selectAllDataUser*/
		$selectAllDataUser = json_decode($this->AttributejsonModel->selectAttributeModel($this->nameAttribute[3]),true);
		$allUserAngular = array();	/*tạo 1 mảng để sau khi update, đưa toàn bộ mảng này vào cột valueAttribute, dòng userAngular*/
		for ($count = 0; $count < count($selectAllDataUser) ; $count++) {	/*Nếu trường id bằng vs zá trị đưa vào thì*/
			if ($selectAllDataUser[$count][$this->fieldsUserAngInValueAttribute[0]] ==$this->input->post($this->fieldsFromUpdateUserAng[0])){
				$selectAllDataUser[$count][$this->fieldsUserAngInValueAttribute[1]] = $this->input->post($this->fieldsFromUpdateUserAng[1]);
				$selectAllDataUser[$count][$this->fieldsUserAngInValueAttribute[2]] = $this->input->post($this->fieldsFromUpdateUserAng[2]);
				$selectAllDataUser[$count][$this->fieldsUserAngInValueAttribute[3]] = $this->input->post($this->fieldsFromUpdateUserAng[3]);
				$selectAllDataUser[$count][$this->fieldsUserAngInValueAttribute[4]] = $this->input->post($this->fieldsFromUpdateUserAng[4]);
				$selectAllDataUser[$count][$this->fieldsUserAngInValueAttribute[5]] = $this->isDelete[0];
			}	/*thì update tất cả thuộc tính của các trường còn lại (name, dob, fb, phone) của 1 phần tử trong mảng $selectAllDataUser*/
			array_push($allUserAngular, $selectAllDataUser[$count]);	/*đưa phần tử đó vào $allUserAngular*/
		}
		if ($this->AttributejsonModel->updateAttributeModel($this->nameAttribute[3], json_encode($allUserAngular)))	/*sau đó gọi update*/
			echo 'success';
		else
			echo 'fail';
	}
}

/* End of file mainjson.php */
/* Location: ./application/controllers/mainjson.php */
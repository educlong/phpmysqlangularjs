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

	PHẦN XỬ LÝ GỬI MAIL (cần require load đến library -> xem tại line 12): search library "phpmailer github" => download 4 file bao gồm: 
		1. class phpmailer
		2. class pop3
		3. class smtp
		4. phpmailerautoload
	Copy 4 file này vào controllers/mail
*/

/*PHẦN XỬ LÝ SEND EMAIL và ĐẶT BÀN NHÀ HÀNG */
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;




class AttributeHomejson extends CI_Controller {
	private $model = 'AttributejsonModel';

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->model);
	}


	private $attributeHome = "AttributeHome";
	private $viewHomeTransferData = 'selectJsonAttribute';
	private $viewHomeTransferDataNewsCategory = "selectNewsCategories";
	private $viewHomeTransferDataNews = "selectingNews";

	public function index($offset = 0)		/*offset=1 -> page1, offset=2->page2*/
	{
		/*PHẦN XỬ LÝ SESSION*/
		$login = array(
			'username' => 'educlonghx',
			'password' => '1001',
			'checkLogin' => true
		);
		$this->session->set_userdata($login);
		$this->session->set_userdata("item1","educlong");/*lưu 1 session, educlong là zátrị, item1 là tên của zá trị này trong kho session*/
		

		// $this->session->unset_userdata('username');	/*để xóa 1 session, unset item nào thì gọi item đó ra*/

		/*PHẦN XỬ LÝ PAGE*/
		$this->pages($offset);
	}




	/*PHẦN PHÂN TRANG*/
	private $viewHomeNumberOfPages = "numberOfPages";
	private $transferUri = "lastUri";
	private $newsPerPage = 1;										/*số tin trong 1 trang*/

	public function pages($offset)
	{	/*$_SERVER['REQUEST_URI'] ===> kq: /phpBasic4/AttributeHomejson/pages/... ===> lấy đường dẫn ra*/
		$uri = explode("/", $_SERVER['REQUEST_URI']);/*explode trả về 1 mảng: xử lý chuỗi, tách chuỗi ra theo dấu /, chuỗi ở đây là 1 uri*/
		$lastUri = end($uri);	/*lấy ra phần tử cuối cùng của mảng uri, phần tử cuối cùng này là vị trí tại trang hiện tại của page*/

		// $offset = ($page) * $this->newsPerPage;	/*vị trí bắt đầu lấy tin = (trang hiện tại -1) * số lượng tin trên 1 trang*/
		
		$viewTransferDataToHome = array(
			$this->viewHomeTransferData => $this->selectAttributeSlide(),			/*selectJsonAttribute => (xử lý phần slide)*/
			$this->viewHomeTransferDataNewsCategory => $this->selectNewsCategory(),	/*selectNewsCategories => (xử lý phần news category)*/
			$this->viewHomeTransferDataNews => $this->selectNews($this->newsPerPage, $offset),	/*số lượng tin đc lấy, vị trí lấy*/
			$this->viewHomeTransferDataUser => $this->indexUser(),					/*lấy hết user ra (xử lý phần login, xuất ra file excel)*/
			$this->fieldsFromSelectMenu => $this->selectAttributeMenu(),	/*đưa data menu đa cấp vào view*/
			$this->viewHomeTransferDataMenu => $this->menu(),				/*đưa chuỗi html xuất ra menu đa cấp vào view*/

			/*2 line code này nếu sử dụng phân trang theo cách thông thường thì truyền vào, nếu sử dụng bằng phím tắt thì k cần*/
			$this->viewHomeNumberOfPages => $this->AttributejsonModel->numberOfPages($this->newsPerPage), /*số trang, mỗi trang lấy 2 tin*/
			$this->transferUri => $lastUri,	/*truyền phần tử cuối cùng chính là trang hiện tại qua view để xử lý tại mục phân trang*/
		);

		/*PHÂN TRANG BẰNG PHÍM TẮT*/
		/*gõ pagination -> tab ==> các thông số cơ sở dùng để phân trang*/
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'AttributeHomejson/index';			/*đường dẫn,sau index chính là vị trí bắt đầu lấy tin. VD index/2*/
		$config['total_rows'] = $this->AttributejsonModel->totalOfNews();	/*tổng số tin tức trong database*/
		$config['per_page'] = $this->newsPerPage;							/*số tin trong 1 trang*/
		$config['uri_segment'] = 0;											/*lấy từ tin số bao nhiêu, lấy từ tin đầu tiên*/
		$config['num_links'] = $this->AttributejsonModel->numberOfPages($this->newsPerPage);	/*số link hiển thị trên 1 trang = số trang*/

		/*bootstrap cho zao diện phân trang*/
		$config['full_tag_open']  = '<nav aria-label="Page navigation example">
										<ul class="pagination">';
		$config['first_tag_open'] = '		<li class="page-item">
												<div class="page-link">';	/*thẻ First*/
		$config['first_link'] 	  = 				'First';
		$config['first_tag_close']= '			</div>
											</li>';
		$config['prev_tag_open']  = '		<li class="page-item">
												<div class="page-link">';	/*Thẻ previous*/
		$config['prev_link'] 	  = 				'&lt; Previous';
		$config['prev_tag_close'] = 			'</div>
											</li>';
		$config['num_tag_open']   = '		<li class="page-item">
												<div class="page-link">';	/*Thẻ số các page ko đc chọn*/
		$config['num_tag_close']  = '			</div>
											</li>';

		$config['cur_tag_open']   = '		<li class="page-item active">
												<div class="page-link">';	/*Thẻ page đc chọn (page hiện tại), chứa class active*/
		$config['cur_tag_close']  = '				<span class="sr-only">(current)</span>
												</div>
											</li>';
		$config['next_tag_open']  = '		<li class="page-item">
												<div class="page-link">';	/*Thẻ next*/
		$config['next_link'] 	  = 				'Next &gt;';
		$config['next_tag_close'] = '			</div>
											</li>';
		$config['last_tag_open']  = '		<li class="page-item">
												<div class="page-link">';	/*Thẻ Last*/
		$config['last_link'] 	  = 				'Last';
		$config['last_tag_close'] = '			</div>
											</li>';
		$config['full_tag_close'] = '	</ul>
									</nav>';
		
		$this->pagination->initialize($config);
		// echo $this->pagination->create_links();		/*Line code này đưa vào view*/

		$this->load->view($this->attributeHome, $viewTransferDataToHome);	/*sau khi xử lý phân trang xong thì truyền vào view*/
	}









	/*DATABASE BẰNG CHUỖI JSON*/
	private $nameAttribute = array("topBannerSlide", "infoBookingTable", "menuDacap", "userAngular");
	private $isDelete = ['0','1'];










	/*XỬ LÝ MENU ĐA CẤP VÀ TẠO ĐƯỜNG DẪN THÂN THIỆN SEO*/
	private $viewHomeTransferDataMenu = "menus";
	/*zá trị đầu tiên của trường nameAttribute trong db là menuDacap $nameAttribute[3]*/
	private $fieldsMenuInValueAttribute=array("id","title","link","idParent","isDelete"); /*các trường trong valueAttribute (menu đa cấp)*/

	private $viewInsertMenu = 'AttrInsertMenuView';
	/*name của các trường lấy từ view AttributeInsertView ra, bao gồm*/
	private $fieldsFromInsertMenuView = array("idMenu", "titleMenu", "linkMenu", "idParent");
	private $fieldsFromSelectMenu = "selectMenu";

	public function selectAttributeMenu()
	{	/*lấy data ra, cần zải mã ra, sau khi decode thì tạo ra 1 mảng gồm 2 phần tử, từng phần tử là 1 mảng chứa nhiều phần tử*/
		return json_decode(
			$this->AttributejsonModel->selectAttributeModelNoDelete($this->nameAttribute[2], $this->fieldsMenuInValueAttribute),true);
	}

	public function insertAttributeMenuOpenning()
	{	
		$this->load->view($this->viewInsertMenu);
	}
	public function insertAttributeMenu()	/*thực ra lầ update lại zá trị của cột nameAttribute (thêm vào)*/
	{
		$selectAllDataMenu = json_decode($this->AttributejsonModel->selectAttributeModel($this->nameAttribute[2]),true);
		if ($selectAllDataMenu==null)
			$selectAllDataMenu = array();	/*nếu k có data thì khởi tạo mảng mới*/
		$idMenu = $this->input->post($this->fieldsFromInsertMenuView[0]);
		$dataMenuElement = array(
			$this->fieldsMenuInValueAttribute[0] => $idMenu,
			$this->fieldsMenuInValueAttribute[1] => $this->input->post($this->fieldsFromInsertMenuView[1]),
			$this->fieldsMenuInValueAttribute[2] => $this->input->post($this->fieldsFromInsertMenuView[2]),
			$this->fieldsMenuInValueAttribute[3] => $this->input->post($this->fieldsFromInsertMenuView[3]),
			$this->fieldsMenuInValueAttribute[4] => $this->isDelete[0]
		);
		array_push($selectAllDataMenu, $dataMenuElement);
		if ($this->AttributejsonModel->checkingIdModel($this->nameAttribute[2], $this->fieldsMenuInValueAttribute, $idMenu)) {
			if ($this->AttributejsonModel->updateAttributeModel($this->nameAttribute[2], json_encode($selectAllDataMenu))){
				echo 'success';
				echo '<pre>';
				var_dump($selectAllDataMenu);
				echo '</pre>';
			}
			else echo 'fail';
		}
		else {
			echo 'id đã tồn tại';
		}
		
	}


	/*ĐỆ QUY MENU ĐA CẤP*/
	public function getAllMenu($idParent=0)	/*lấy ra mảng những menu con từ $idParent đc truyền vào*/
	{
		$selectAllDataMenuNoDelete = json_decode(	/*lấy hết những dữ liệu ko bị xóa trong json ra => đưa về mảng*/
			$this->AttributejsonModel->selectAttributeModelNoDelete($this->nameAttribute[2], $this->fieldsMenuInValueAttribute),true);
		$menuChild = array();
		foreach ($selectAllDataMenuNoDelete as $key => $value) {
			if ($value[$this->fieldsMenuInValueAttribute[3]] == $idParent) {/*nếu $value['idParent'] của từng dữ liệu = $idParent truyền vào*/
				array_push($menuChild, $value);		/*lấy ra những menu con có idParent trùng vs $idParent đc nhập từ ngoài vào*/
			}
		}
		$cssMenu = '';
		if ($menuChild) {	/*Nếu menu con tồn tại => in ra kết quả*/
			$cssMenu = $cssMenu.'<ul>';
			foreach ($menuChild as $key => $value) {										/*in ra "link" vào thẻ a và "title" vào thẻ li*/
				$cssMenu = $cssMenu.'<li> <a href="'.base_url().'menu/'
											.$value[$this->fieldsMenuInValueAttribute[2]].'-'.$value[$this->fieldsMenuInValueAttribute[0]].'">'
											.$value[$this->fieldsMenuInValueAttribute[1]].'</a>';
				$cssMenu = $cssMenu.$this->getAllMenu(
								$idParent=$value[$this->fieldsMenuInValueAttribute[0]]);	/*gọi lại đệ quy để in ra các menu con nhỏ hơn*/
				$cssMenu = $cssMenu.'</li>';
			}
			$cssMenu = $cssMenu.'</ul>';
		}
		return $cssMenu;
	}
	public function menu()
	{
		return '<div class="menuLevels">'.$this->getAllMenu().'</div>';
	}






	/*TẠO ĐƯỜNG DẪN THÂN THIỆN SEO*/
	public function detailsMenu($idMenu = "", $linkMenu)	
	{	/*lấy chi tiết 1 menu (chi tiết 1 mảng trong tập các mảng selectAttributeMenu) theo idMenu và linkMenu*/
		foreach ($this->selectAttributeMenu() as $key => $value) {
			if ($value['id'] == $idMenu) {
				echo '<pre>';
				var_dump($value);
				echo '</pre>';
				return $value;
			}
		}
	}















	




	/*SLIDE BANNER*/
	/*zá trị đầu tiên của trường nameAttribute trong db là topBannerSlide $nameAttribute[0]*/
	private $fieldsInValueAttribute=array("title","description","linkBtn","textBtn","image","isDelete"); /*các trường trong valueAttribute*/

	private $viewInsert = 'AttributeInsertView';
	private $viewUpdate = 'AttributeUpdateView';
	
	private $viewUpdateTransferData = 'selectJsonSlidesUpdateView';

	/*name của các trường lấy từ view AttributeInsertView ra, bao gồm*/
	private $fieldsFromInsertView = array("titleSlide", "descriptionSlide", "linkBtnSlide", "textBtnSlide", "imageSlide");

	/*name của các mảng các trường lấy từ view AttributeUpdateView ra, bao gồm*/
	private $fieldsFromUpdateView = array("titleSlide[]", "descriptionSlide[]", "linkBtnSlide[]", "textBtnSlide[]", "imageSlide" , "imageSlideOld[]", "isDeleteSlide[]");

	

	public function selectAttributeSlide()
	{/*lấy data ra, cần zải mã ra, sau khi decode thì tạo ra 1 mảng gồm 2 phần tử, từng phần tử là 1 mảng chứa nhiều phần tử*/
		return json_decode($this->AttributejsonModel->selectAttributeModelNoDelete($this->nameAttribute[0], $this->fieldsInValueAttribute),true);
	}
	/*PHẦN INSERT: MỞ MÀN HÌNH InsertOpenning và Insert*/
	public function insertAttributeSlideOpenning()
	{	
		$this->load->view($this->viewInsert);
	}
	public function insertAttributeSlide()	/*thực ra lầ update lại zá trị của cột nameAttribute (thêm vào)*/
	{
		$selectAllDataSlide = json_decode($this->AttributejsonModel->selectAttributeModel($this->nameAttribute[0]),true);
		if ($selectAllDataSlide==null)
			$selectAllDataSlide = array();	/*nếu k có data thì khởi tạo mảng mới*/
		$dataSlideElement = array(
			$this->fieldsInValueAttribute[0] => $this->input->post($this->fieldsFromInsertView[0]),
			$this->fieldsInValueAttribute[1] => $this->input->post($this->fieldsFromInsertView[1]),
			$this->fieldsInValueAttribute[2] => $this->input->post($this->fieldsFromInsertView[2]),
			$this->fieldsInValueAttribute[3] => $this->input->post($this->fieldsFromInsertView[3]),
			$this->fieldsInValueAttribute[4] => base_url()."files/".$this->uploadImage($this->fieldsFromInsertView[4]),
			$this->fieldsInValueAttribute[5] => $this->isDelete[0]
		);
		array_push($selectAllDataSlide, $dataSlideElement);
		if ($this->AttributejsonModel->updateAttributeModel($this->nameAttribute[0], json_encode($selectAllDataSlide)))
			echo 'success';
		else echo 'fail';
	}

	/*PHẦN UPDATE: MỞ MÀN HÌNH UpdateOpenning và Update*/
	public function updateAttributeSlideOpenning()
	{	/*lấy hết data ra và truyền vào view jsonUpdateView*/
		$this->load->view($this->viewUpdate, array($this->viewUpdateTransferData => 
				json_decode($this->AttributejsonModel->selectAttributeModel($this->nameAttribute[0]),true), FALSE));
	}
	public function updateAttributeSlide()	/*thực ra lầ update lại zá trị của cột nameAttribute (update bất kỳ thuộc tính nào)*/
	{
		// echo '<pre>'; updateImagesToPageJson()); echo '</pre>';
		$allSlidesOnTopBanner = array();	/*tạo 1 mảng $allSlidesOnTopBanner chứa tất cả các slide, ban đầu mảng này rỗng*/
		for ($count=0; $count < count($this->input->post($this->fieldsFromUpdateView[0])); $count++){/*titleSlide[] là thuộc tính từ view*/
			$allSlidesOnTopBannerElement=array( /*mảng allSlidesOnTopBanner chứa các allSlidesOnTopBannerElement, allSlidesOnTopBannerElement là 1 mảng chứa $fieldsInValueAttribute*/	/*(đã định nghĩa trong jsonupdateView)*/
			    $this->fieldsInValueAttribute[0] => $this->input->post($this->fieldsFromUpdateView[0])[$count],
			    $this->fieldsInValueAttribute[1] => $this->input->post($this->fieldsFromUpdateView[1])[$count],
			    $this->fieldsInValueAttribute[2] => $this->input->post($this->fieldsFromUpdateView[2])[$count],
			    $this->fieldsInValueAttribute[3] => $this->input->post($this->fieldsFromUpdateView[3])[$count],
			    $this->fieldsInValueAttribute[4] => $this->updateImagesToPageJson($this->fieldsFromUpdateView[4],
			    															  $this->fieldsFromUpdateView[5])[$count],
			    $this->fieldsInValueAttribute[5] => $this->input->post($this->fieldsFromUpdateView[6])[$count]
			);
			array_push($allSlidesOnTopBanner, $allSlidesOnTopBannerElement);
		}	/*sau khi hết for, $allSlidesOnTopBanner có đầy đủ data*/
		echo '<pre>';
		var_dump($allSlidesOnTopBanner);
		echo '</pre>';
		if ($this->AttributejsonModel->updateAttributeModel($this->nameAttribute[0], json_encode($allSlidesOnTopBanner)));
			echo 'success';
	}












	/*ĐẶT BÀN NHÀ HÀNG*/

	/*PHẦN XỬ LÝ GỬI MAIL (cần require load đến library -> xem tại line 12): search library "phpmailer github" => download 4 file bao gồm: 
		1. class phpmailer
		2. class pop3
		3. class smtp
		4. phpmailerautoload
	Copy 4 file này vào controllers/mail
	*/

	// thông tin từ view
	private $fieldsFromHomeViewBookingTable=array("nameBooking","emailBooking","phoneBooking","dateBooking","timeBooking","numberBooking");
	// các trường trong cột valueAttribute của database
	private $fieldsInValueBookingTable = array("name", "email", "phone", "date", "time", "number");
	

	function sendingEmail()	/*copy từ github phpmailer*/
	{
		/*trước khi config cho gửi mail => cần xác minh 2 bước cho tài khoản gmail gửi đi (educlong@gmail.com)
		 search từ khóa: security gmail
		 Sau khi xác minh 2 bước, gmail sẽ gửi zề 1 password -> điền pass vào $mail->Password*/

		//Instantiation and passing `true` enables exceptions
		
	    $mail = new PHPMailer(true);
	    $mail->CharSet = "utf-8";

		try {
		    //Server settings
		    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		    $mail->isSMTP();                                            //Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';				/*Host của gmail*/
		    $mail->SMTPAuth   = true;                           //Enable SMTP authentication
		    $mail->Username   = 'educlong@gmail.com';           //SMTP username (gửi từ) -> user k nhìn thấy email này
		    $mail->Password   = 'dyeycmeisxlmnyan';                               //SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    //Recipients
		    $mail->setFrom('founder@elongcenter.com', 'Trung tâm đào tạo elong');			  /*gửi từ (user nhìn thấy email này*/
		    $mail->addAddress("lloonnggg@gmail.com",$this->input->post($this->fieldsFromHomeViewBookingTable[0]));/*đến*/
		    // $mail->addAddress('ellen@example.com');               //Name is optional
		    // $mail->addReplyTo('info@example.com', 'Information');
		    // $mail->addCC('cc@example.com');
		    // $mail->addBCC('bcc@example.com');

		    //Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = "Thông báo booking table ".$this->input->post($this->fieldsFromHomeViewBookingTable[4]).
		    									   ", ".$this->input->post($this->fieldsFromHomeViewBookingTable[3]).
		    							 ". Số lượng: ".$this->input->post($this->fieldsFromHomeViewBookingTable[5]);	/*tiêu đề mail*/
		    $mail->Body    = "Thông tin đặt bàn: ".
		    	"\n 1. Tên khách hàng: ".$this->input->post($this->fieldsFromHomeViewBookingTable[0]).
		    	"\n 2. Email: ".$this->input->post($this->fieldsFromHomeViewBookingTable[1]).
		    	"\n 3. Phone: ".$this->input->post($this->fieldsFromHomeViewBookingTable[2]).
		    	"\n 4. Ngày zờ: ".$this->input->post($this->fieldsFromHomeViewBookingTable[4]).", "
		    					.$this->input->post($this->fieldsFromHomeViewBookingTable[3]).
		    	"\n 5. Số lượng: ".$this->input->post($this->fieldsFromHomeViewBookingTable[5]);							/*body mail*/
		    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		    
		    if ($mail->send()){
		    	echo 'Message has been sent';
		    }
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}


	public function insertBookingTable()	/*insert vào db sau đó send email*/
	{
		// echo($this->fieldsFromHomeViewBookingTable[1]);
		$selectAllDataBooking = json_decode($this->AttributejsonModel->selectAttributeModel($this->nameAttribute[1]),true);
		if ($selectAllDataBooking==null)
			$selectAllDataBooking = array();	/*nếu k có data thì khởi tạo mảng mới*/
		$dataBookingElement = array(
			$this->fieldsInValueBookingTable[0] => $this->input->post($this->fieldsFromHomeViewBookingTable[0]),
			$this->fieldsInValueBookingTable[1] => $this->input->post($this->fieldsFromHomeViewBookingTable[1]),
			$this->fieldsInValueBookingTable[2] => $this->input->post($this->fieldsFromHomeViewBookingTable[2]),
			$this->fieldsInValueBookingTable[3] => $this->input->post($this->fieldsFromHomeViewBookingTable[3]),
			$this->fieldsInValueBookingTable[4] => $this->input->post($this->fieldsFromHomeViewBookingTable[4]),
			$this->fieldsInValueBookingTable[5] => $this->input->post($this->fieldsFromHomeViewBookingTable[5])
		);
		array_push($selectAllDataBooking, $dataBookingElement);
		if ($this->AttributejsonModel->updateAttributeModel($this->nameAttribute[1], json_encode($selectAllDataBooking))){
			$this->sendingEmail();	
		}
		else echo 'fail';
	}










	/*XỬ LÝ PHẦN DANH MỤC TIN TỨC*/
	private $fieldsFromHomeViewNewsCategories = "inputNameNewsCat";
	private $fieldsFromHomeViewNewsCategoriesAjax = "nameNewsCatAjax";
	private $fieldsFromUpdateCategoryView = array("idCategory", "inputNameCategory");
	private $fieldsFromHomeViewUpdateCategoryAjax = array('updateIdNewsCatAjax', 'updateNameNewsCatAjax');

	private $viewHomeNewCategory = "AttributeCategory";
	private $viewUpdateCategory = "AttributeUpdateCategory";

	
	private $viewTransferDateUpdateCategory = "selectUpdateCategories";
	
	public function selectNewsCategory()
	{
		return $this->AttributejsonModel->selectNewsCategoryModel();
	}
	
	public function insertNewsCategory()		/*Thêm danh mục tin tức bằng phương pháp php*/
	{
		if ($this->AttributejsonModel->insertNewsCategoryModel($this->input->post($this->fieldsFromHomeViewNewsCategories)))
			 echo "success";
		else echo "fail";
	}
	public function insertNewsCategoryAjax()	/*Thêm danh mục tin tức bằng phương pháp ajax*/
	{
		if($this->AttributejsonModel->insertNewsCategoryModel($this->input->post($this->fieldsFromHomeViewNewsCategoriesAjax)))
			echo json_encode($this->db->insert_id());	/*lấy idNewsCat phục vụ cho ajax*/
		else echo "fail";
	}
	public function updateNewsCategoryOpenning($idCategory)
	{	/*lấy hết data ra và truyền vào view AttributeUpdateCategory*/
		$this->load->view($this->viewUpdateCategory, /*"AttributeUpdateCategory", "selectUpdateCategories"*/
			array($this->viewTransferDateUpdateCategory => $this->AttributejsonModel->checkNewsCategoryModel($idCategory)),FALSE);
	}

	public function updateNewsCategory()
	{
		if ($this->AttributejsonModel->updateNewsCategoryModel ($this->input->post($this->fieldsFromUpdateCategoryView[0]),	/*idCategory*/
														 $this->input->post($this->fieldsFromUpdateCategoryView[1])))/*inputNameCategory*/
		 echo "success";
		else echo 'update fail';

	}

	public function updateNewsCategoryAjax()
	{
		if ($this->AttributejsonModel->updateNewsCategoryModel ($this->input->post($this->fieldsFromHomeViewUpdateCategoryAjax[0]),/*id*/
														 $this->input->post($this->fieldsFromHomeViewUpdateCategoryAjax[1])))	/*Name*/
		 echo "success";
		else echo 'update fail';

	}

	public function deleteNewsCategory($idCategory)
	{
		if ($this->AttributejsonModel->deleteNewsCategoryModel ($idCategory))
			echo "success";
		else echo 'update fail';

	}










	/*XỬ LÝ PHẦN TIN TỨC*/
	// private $fieldsFromHomeViewNews = "inputNameNews";
	// private $fieldsFromHomeViewNewsAjax = "nameNewsAjax";
	// private $fieldsFromUpdateView = array("idNews", "inputNameCategory");
	// private $fieldsFromHomeViewUpdateAjax = array('updateIdNewsCatAjax', 'updateNameNewsCatAjax');
	private $fieldFromViewNews = array( "idNews", "newsTitle", "idNewsCat", "imageNews", 
										"summaryNews", "newsCon", "newsDate", "isDeleteNewsCont", "imageNewsOld");

	private $viewNews = "AttributeNewsView";
	private $viewIdCategories = "AttributeIdCategories";
	private $viewUpdateNews = "AttributeUpdateNews";

	
	private $viewTransferDateUpdateNews = "selectUpdateNews";
	public function selectNews($numberOfNewsPerPage, $startNews)
	{	
		return $this->AttributejsonModel->selectNewsModel($numberOfNewsPerPage, $startNews);
	}
	public function insertNews()
	{
		if ($this->AttributejsonModel->insertNewsModel(	$this->input->post($this->fieldFromViewNews[1]),
														$this->input->post($this->fieldFromViewNews[2]),
														base_url()."files/".$this->uploadImage($this->fieldFromViewNews[3]),
														$this->input->post($this->fieldFromViewNews[4]),
														$this->input->post($this->fieldFromViewNews[5]),
														$this->input->post($this->fieldFromViewNews[6])))
			echo json_encode($this->db->insert_id());
		else echo 'fail';
	}
	public function updateNewsOpening($idNews)
	{	/*Đưa dữ liệu của bảng newscategories qua view AttributeUpdateNews (dữ liệu danh mục tin tức qua view tin tức)
		  Đồng thời đưa dữ liệu của bảng newscontent qua view AttributeUpdateNews (dữ liệu tin tức qua view tin tức)
		  Do đó, ở đây, cần ghép 2 mảng danhSáchDanhMụcTinTức và danhSáchTinTức lại vs nhau, sau đó tranfer qua AttributeUpdateNews.
		  Tại AttributeUpdateNews thì nhả ra dựa theo key và value*/
		// echo '<pre>';
		// var_dump($this->AttributejsonModel->selectCategoryFromIdNewsModel($idNews));
		// echo '</pre>';
		// die();
		$viewTransferUpdateNews = array(
		    $this->viewHomeTransferDataNewsCategory => $this->AttributejsonModel->selectNewsCategoryModel(), /*tên và mã danh mục*/
		    $this->viewTransferDateUpdateNews=>$this->AttributejsonModel->checkIdNewsModel($idNews)/*mảng values của bảng news tại $idNews*/
		);
		$this->load->view($this->viewUpdateNews, $viewTransferUpdateNews,FALSE);		
	}
	public function updateNews()
	{
		if ($this->AttributejsonModel->updateNewsModel(	$this->input->post($this->fieldFromViewNews[0]),		/*idNews*/
														$this->input->post($this->fieldFromViewNews[1]),		/*newsTitle*/
														$this->input->post($this->fieldFromViewNews[2]),		/*idNewsCat*/
														$this->updateImagesToPage($this->fieldFromViewNews[3],	/*imageNews*/
																				  $this->fieldFromViewNews[8]),	/*imageNewsOld*/
														$this->input->post($this->fieldFromViewNews[4]),		/*summaryNews*/
														$this->input->post($this->fieldFromViewNews[5]),		/*newsCon*/
														$this->input->post($this->fieldFromViewNews[6])))		/*newsDate*/
			echo "success";
		else echo "fail";
	}

	
	public function deleteNews($idNews)
	{
		if ($this->AttributejsonModel->deleteNewsModel($idNews))
			echo "success";
		else echo "fail";
	}



	public function newsDetails($idNews)	
	{
		// echo $idNews;
		echo '<pre>';
		var_dump($this->AttributejsonModel->selectCategoryFromIdNewsModel($idNews)[0]['summaryNews']);
		var_dump($this->AttributejsonModel->selectCategoryFromIdNewsModel($idNews)[0]['idNewsCat']);	/*lấy ra id danh mục từ id tin*/
		echo '</pre>';

		$idCategr = $this->AttributejsonModel->selectCategoryFromIdNewsModel($idNews)[0]['idNewsCat'];
		echo($idCategr);
		echo '<pre>';
		// var_dump($this->AttributejsonModel->selectNewsFromIdCategoryModel($idCategr));
		echo '</pre>'; 

		$newsInThisIdCat = $this->AttributejsonModel->selectNewsFromIdCategoryModel($idCategr);		/*lấy ra những tin trong danh mục này*/

		
		
		/*(load thêm những tin liên quan đến tin này, những tin có cùng danh mục nhưng k hiển thị tin hiện tại) đoạn này nhác làm view mới*/

		echo 
		'<div class="container">
	        <div class="row">
	            <div class="col-sm-12 text-center">Các tin liên quan</div>
	        </div>
	        <div class="row">';
	        foreach ($newsInThisIdCat as $value) {
	        	if ($value['idNews']==$idNews) {	/*nếu 1 tin trong danh mục này có idNews bằng vs idNews truyền vào thì bỏ đi*/
	        		continue;						/*chỉ lấy những tin nào có cùng idNewsCat, nhưng k phải tin hiện tại (tin liên quan)*/
	        	}
	            echo '<div class="col-sm-4">
	                <div class="card-deck">
	                    <div class="card">
	                        <img class="card-img-top img-fluid" src="'.$value['imageNews'].'" alt="">
	                        <div class="card-body">
	                            <h4 class="card-title">'.$value['newsTitle'].'</h4>
	                            <p class="card-text">'.$value['summaryNews'].'</p>
	                        </div>  <!-- end card-body -->
	                    </div>  <!-- end card -->
	                </div>  <!-- end card-deck -->
	            </div>  <!-- end col-sm-4 -->';
			}
	        echo '</div>  <!-- end row -->
	    </div>  <!-- end container -->';
	}

















	/*UPLOAD IMAGE THEO JSON*/
	public function updateImagesToPageJson($fieldsFromUpdateView, $fieldsFromUpdateView_Old)		
	{	/*CHỈ XỬ LÝ UPDATE Image, nếu đc update -> lấy link image mới, còn k thì zữ link cũ*/
		$allSlides = array();/*đầu tiên tạo 1 biến slides để lưu trữ toàn bộ data. Duyệt hết các phần tử trong $slides đó*/
		$allImages=$_FILES[$fieldsFromUpdateView]['name'];/*mảng các file image đc upload lên (chỉ lấy đc image, chưa upload lên)*/
		$allImagesLink=$_FILES[$fieldsFromUpdateView]['tmp_name'];/*tmp_name là lấy linkC:\CodDevProgConfig\xamppserver\tmp\..tmp*/
		$allImagesSlide = array();	/*duyệt mảng để lấy tên từng file image đc đưa vào*/
		for ($count = 0; $count < count($allImages) ; $count++) {
			// echo '<pre>'; var_dump($allImages[$count]); var_dump($allImagesLink[$count]); echo '</pre>';
			if (empty($allImages[$count])) {	/*nếu có 1 phần tử bị trống  thì k làm zì cả, zữ nguyên file cũ (lấy từ view ra)*/
				$allImagesSlide[$count] = $this->input->post($fieldsFromUpdateView_Old)[$count];
			}	/*$this->input->post($fieldsFromUpdateView_Old)[$count]: ghi zá trị file cũ tại count vào mảng mới*/
			else {	/*nếu có 1 phần tử ko bị trống move từ C:\CodDevProgConfig\xamppserver\tmp\php8622.tmp */
				move_uploaded_file($allImagesLink[$count], "files/".$allImages[$count]);	/*vào folder files*/
				$allImagesSlide[$count] = base_url()."files/".$allImages[$count];	/*đưa các hình ảnh lấy đc vào mảng $allImagesSlide*/
			}
		}	/*hết vòng lặp này we có đc mảng các file đc upload*/
		return $allImagesSlide;
	}



	/*UPLOAD IMAGE THEO THÔNG THƯỜNG*/
	public function updateImagesToPage($fieldsFromUpdateView, $fieldsFromUpdateView_Old)			
	{	

		/*CÁCH 1: UPLOAD SỬ DỤNG $_FILES*/

		/*CHỈ XỬ LÝ UPDATE Image, nếu đc update -> lấy link image mới, còn k thì zữ link cũ. 	Nếu ko có image đc up lên (bị trống) thì*/
		
		// $allImagesNews = $this->input->post($fieldsFromUpdateView_Old);				/* k làm zì cả, zữ nguyên file cũ (lấy từ view ra)*/
		// $allImages=$_FILES[$fieldsFromUpdateView]['name'];/*mảng các file image đc upload lên (chỉ lấy đc image, chưa upload lên)*/
		// $allImagesLink=$_FILES[$fieldsFromUpdateView]['tmp_name'];/*tmp_name là lấy linkC:\CodDevProgConfig\xamppserver\tmp\..tmp*/	
		// if (!empty($allImages)) {	/*nếu có có image đc up lên (ko bị trống) move từ C:\CodDevProgConfig\xamppserver\tmp\php8622.tmp */
			// move_uploaded_file($allImagesLink, "files/".$allImages);	/*vào folder files*/
			// $allImagesNews = base_url()."files/".$allImages;	/*đưa các hình ảnh lấy đc vào mảng $allImagesNews*/
		// }
		// return $allImagesNews;


		/*CÁCH 2: UPLOAD IMAGE THEO PHÍM TẮT (CÁCH UPLOAD NÀY CÓ SẴN CỦA FRAMEWORK CODEIGNITER) -> K cần phải lo về việc trùng tên file*/

		/*Code này copy từ trang chủ của codeigniter -> https://codeigniter.com/userguide3/libraries/file_uploading.html 
		  hoặc gõ: upload -> tab*/
		$config['upload_path'] = './files/';				/*đường dẫn chứa file đc upload lên, ở đây là thư mục phpBasic4/files */
		$config['allowed_types'] = 'gif|jpg|png|zip|rar';	/*loại file đc upload lên*/
		$config['max_size']     = '10000000';				/*dung lượng maximum file đc up lên*/
		// $config['max_width'] = '1024';					/*độ rộng của hình ảnh*/
		// $config['max_height'] = '768';					/*độ cao của hình ảnh*/

		$this->load->library('upload', $config);			/*dùng để load thư viện upload*/

		// Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
		$this->upload->initialize($config);					/*kích hoạt thư viện upload trên*/

		/*sau khi config xong thì sử dụng hàm upload*/
		$dataPicture = $this->input->post($fieldsFromUpdateView_Old);	/*ban đầu nếu k upload thì lấy hình ảnh cũ*/
		if ( ! $this->upload->do_upload($this->fieldFromViewNews[3])){	/*lấy trường trong view ra, nếu upload k thành công thì báo lỗi*/
			$error = array('error' => $this->upload->display_errors());
		}
		else{/*upload thành công thì lưu vào data, array('upload_data' => $this->upload->data()) =>trả về 1 mảng các phầntử file đc upload*/
			$data = array('upload_data' => $this->upload->data());
			$dataPicture = base_url().'files/'.$data['upload_data']['file_name'];
		}	/*['upload_data'] => lấy phần tử data đc upload ra, đây là 1 mảng các thuộc tính của file đc upload*/
			/*['file_name'] => lấy thuộc tính file_name ra và nối vs đường dẫn base_url().'files/'*/


		/*cắt ảnh trước rồi resize ảnh sau*/
		// $imgCrop = $this->cropImage($dataPicture, 2000, 2000, TRUE, 'auto');	/*cắt ảnh zữ nguyên tỷ lệ (TRUE)*/
		// $imgResize = $this->resizeImage($imgCrop, 500,500,TRUE,'auto');		/*resize ảnh nhỏ lại zữ nguyên tỷ lệ (TRUE)*/
		// die();

		/*resize ảnh nhỏ lại trước (TRUE: zữ nguyên tỷ lệ) rồi cắt ảnh thành hình vuông sau (FALSE: Ko zữ tỷ lệ, ảnh có kích thước 200x200)*/
		/*resize ảnh nhỏ, cỡ 400x400 (TRUE: ratio), ảnh đã resize trong file phpBasic4/files*/
		$imgResize = $this->resizeImage($dataPicture, 500, 500, TRUE, 'width');
		/*sau khi resize thì crop ảnh (FALSE: ko ratio), (crop lấy chiều 'width' làm chuẩn), và lưu vào phpBasic4/files*/
		$imgCrop = $this->cropImage($imgResize, 500, 500, FALSE, 'width');
		/*xử lý watermark, gán logo vào hình ảnh*/
		$this->watermarkImage($imgCrop);

		// die();
		return $imgCrop;
	}









	/*DÙNG ĐỂ RESIZE OR CROP HÌNH ẢNH (THAY ĐỔI KÍCH CỠ HOẶC CẮT HÌNH ẢNH)*/
	public function resizeAndCropImage($dataPicture, $width, $height, $ratio, $master_dim)
	{	/*search từ khóa: resize image class codeigniter, và copy code từ https://codeigniter.com/userguide3/libraries/image_lib.html*/
		$imageName = explode("/", $dataPicture)[count(explode("/", $dataPicture))-1];	/*explode("/" ... ==> zải thích tại pages($page)*/
		$imgName = explode('.', $imageName)[0];
		$imgExtent = explode('.', $imageName)[1];
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'files/'.$imageName;	/*đường dẫn để đưa hình ảnh này vào*/
		$config['new_image']    = 'files/'.$imageName;
		$config['create_thumb'] = TRUE;		/*tạo ra 1 image đc resize bên cạnh ảnh gốc, tên ảnh sẽ là tênCũ_thumb*/
		$config['maintain_ratio'] = $ratio;	/*có cần zữ nguyên tỷ lệ ko? Có -> TRUE; Ko -> FALSE*/
		$config['width']         = $width;	/*resize/crop cỡ bao nhiêu, 100x100. Như zậy cỡ tối đa của nó là 100, 1 cạnh có thể nhỏ hơn 100*/
		$config['height']       = $height;
		$config['master_dim'] = $master_dim;
		$config['x_axis']        = 0;		/*dịch chuyển ảnh theo chiều x*/
		$config['y_axis']        = 0;		/*dịch chuyển ảnh theo chiều y*/



		$this->load->library('image_lib', $config);	/*sau khi resize xong thì load lại thư viện lần nữa*/
		$this->image_lib->initialize($config);			/*gọi lại thư viện 1 lần nữa để nó lưu lại những thông số mà we đã config*/

		return $imageName;
	}


	/*DÙNG ĐỂ RESIZE HÌNH ẢNH (THAY ĐỔI KÍCH CỠ HÌNH ẢNH)*/
	public function resizeImage($dataResize, $width, $height, $ratio, $master_dim)	
	{	/*resizeImage trả về 1 chuỗi là đường link của ảnh đã resize*/
		$imageName = $this->resizeAndCropImage($dataResize, $width, $height, $ratio, $master_dim);
		$this->image_lib->resize();
		/*sau khi resize thì trả về tên hình ảnh (ko bao gồm đường dẫn), chỉ có tên hình ảnh và phần extent (.jpg, .png,...) */
		return explode('.', $imageName)[0]	/*tách chuỗi lấy phần tử đầu chính là tên image (ko bao gồm đuôi .jpg)*/
					.'_thumb.'.explode('.', $imageName)[1];	/*+vs phần extent là _thumb và + thêm phần đuôi jpg là phần sau của chuỗi đc tách*/
	}


	/*DÙNG ĐỂ CROP HÌNH ẢNH (Cắt HÌNH ẢNH)*/
	public function cropImage($dataCrop, $width, $height, $ratio, $master_dim)	
	{	/*cropImage trả về 1 chuỗi là đường link của ảnh đã resize*/
		$imageName = $this->resizeAndCropImage($dataCrop, $width, $height, $ratio, $master_dim);
		$this->image_lib->crop();
		/*sau khi crop thì trả về tên hình ảnh (ko bao gồm đường dẫn), chỉ có tên hình ảnh và phần extent (.jpg, .png,...) */
		return base_url().'files/'.explode('.', $imageName)[0]	/*tách chuỗi lấy phần tử đầu chính là tên image (ko bao gồm đuôi .jpg)*/
					.'_thumb.'.explode('.', $imageName)[1];	/*+vs phần extent là _thumb và + thêm phần đuôi jpg là phần sau của chuỗi đc tách*/	
	}



	/*THÊM LOGO VÀO HÌNH ẢNH ĐÁNH DẤU BẢN QUYỀN (WATERMARK)*/
	public function watermarkImage($dataWatermark)	
	{
		$config['source_image'] = 'files/'.explode("/", $dataWatermark)[count(explode("/", $dataWatermark))-1];		/*hình ảnh đc upload lên*/
		$config['wm_type'] = 'overlay';						/*kiểu watermark đc đè lên trên, có thể gán text hoặc image đè lên trên*/
		/*CÁCH 1: GÁN IMAGE ĐÈ LÊN TREN*/
		$config['wm_overlay_path'] = 'files/bkdn.png';		/*đường dẫn đến logo cần watermark*/
		/*CÁCH 2: GÁN TEXT LÊN HÌNH ẢNH ĐC UPLOAD LÊN*/
		// $config['wm_text'] = 'Copyright Paul 2021';
		// $config['wm_type'] = 'text';
		// $config['wm_font_path'] = './system/fonts/texb.ttf';
		// $config['wm_font_size'] = '16';
		// $config['wm_font_color'] = 'ffffff';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'center';
		// $config['wm_padding'] = '-50';

		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		$this->image_lib->watermark();
	}










	/*để hỗ trợ upload file, cần vào config/autoload.php, chỉnh sửa $autoload['helper'] thành array("url","file") để cho phép upload file.*/
	public function uploadImage($fieldsFromInsertView)	/*code lấy từ w3school (Search: w3school upload file php)*/
	{
		$target_dir = "files/";
		$target_file = $target_dir . basename($_FILES[$fieldsFromInsertView]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($_FILES[$fieldsFromInsertView]["tmp_name"]);
		  if($check !== false) {
		    echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($target_file)) {
		  echo "Sorry, file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($_FILES[$fieldsFromInsertView]["size"] > 5000000) {
		  echo "Sorry, your file is too large.";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		  if (move_uploaded_file($_FILES[$fieldsFromInsertView]["tmp_name"], $target_file)) {
		    echo "The file ". htmlspecialchars( basename( $_FILES[$fieldsFromInsertView]["name"])). " has been uploaded.";
		  } else {
		    echo "Sorry, there was an error uploading your file.";
		  }
		}
		return basename($_FILES[$fieldsFromInsertView]["name"]);
	}


















	



	/*XỬ LÝ PHẦN LOGIN  ==> XỬ LÝ BẰNG PHÍM TẮT*/
	/*code tự xổ ra, gõ crud -> tab*/
			
	private $columnIdLogin = "idLogin";
	private $columnNameLogin = "nameLogin";			/*Paul*/
	private $columnEmailLogin = "emailLogin";		/*Paul*/
	private $columnPasswordLogin = "passwordLogin";	/*Paul*/
	private $columnAdminLogin = "adminLogin";		/*Paul*/
	private $columnIsDeleteLogin = "isDeleteLogin";

	private $viewCreateAnAccount = "CreateAccount";

	private $fieldFromViewCreateAccount = array("usernameLogin", "emailLogin", "passwordLogin", "adminLogin");
	private $viewHomeTransferDataUser = "getAllUser";

	public function indexUser( $offset = 0 )	/*$offset = 0 là vị trí, zả sử muốn list ra tất cả người dùng ==> $offset = 0*/
	{	/*muốn list ra từ người dùng thứ 2, bỏ qua 2 người dùng ban đầu (thứ 0 và thứ 1) ==> $offset = 2*/
		return $this->AttributejsonModel->getUser();
	}

	// Add a new item
	public function addUser()
	{	/*tạo 1 account mới từ view nhập vào*/	
		$newAccount = array($this->columnNameLogin => $this->input->post($this->fieldFromViewCreateAccount[0]),	/*trường username*/
			$this->columnEmailLogin => $this->input->post($this->fieldFromViewCreateAccount[1]),	/*trường email*/
			$this->columnPasswordLogin => md5($this->input->post($this->fieldFromViewCreateAccount[2])), /*trường pass. md5: mã hóa password*/
			$this->columnAdminLogin => (int)$this->input->post($this->fieldFromViewCreateAccount[3]), 
			$this->columnIsDeleteLogin => 0);		/*trường admin = 0 (ko phải là admin), =1 (là admin). và trường isDelete =1*/

		if ($this->AttributejsonModel->insertUser($newAccount))	/*insert account này vào database*/
			echo 'success';
		else echo 'fail';
	}

	//Update one item
	public function updateUser( $id = NULL )	/*nhận id cần chỉnh sửa*/
	{	/*đây chỉ là ví dụ, làm thực tế cần có 1 form để update và ở đây hứng data từ view*/
		$where = array($this->columnIdLogin => 3);		/*zả sử update user có id=3*/
		$updateAccount = array($this->columnNameLogin 	=> "Duc Long",	/*trường username*/
						$this->columnEmailLogin 	=> "educlong",	/*trường email*/
						$this->columnPasswordLogin 	=> md5("bc")); 		/*trường pass. md5: mã hóa password*/

		if ($this->AttributejsonModel->updateUser($updateAccount, $where))	/*update account này vào database*/
			echo 'success';
		else echo 'fail';
	}

	//Delete one item
	public function deleteUser( $id = NULL )	/*nhận id để xóa*/
	{	/*đây chỉ là ví dụ, làm thực tế cần có 1 form để delete và ở đây hứng data từ view*/
		$where = array($this->columnIdLogin => 3);					/*zả sử delete user có id=3*/
		$deleteAccount = array($this->columnIsDeleteLogin => 1); 		/*trường	idLogin = 1*/

		if ($this->AttributejsonModel->updateUser($deleteAccount, $where))	/*update account này vào database*/
			echo 'success';
		else echo 'fail';
	}
	
	/* End of file AttributeHomejson.php */
	/* Location: ./application/controllers/AttributeHomejson.php */


	public function createAccount()
	{
		$this->load->view($this->viewCreateAnAccount);
	}
























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
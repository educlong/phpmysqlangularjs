<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*	Bước 1: kích hoạt url trong file autoload.php
	Bước 2: kích hoạt base_url trong file config.php
	Bước 3: thêm đường dẫn css, js bằng cách < ? php echo base_url(); ?> trong view
	Bước 4: kết nối database trong file config/database.php (username, pass, databasename,etc.)
	Bước 5: Để truy cập, gõ: http://localhost:8888/phpBasic/index.php/FirstController*/

class FirstController extends CI_Controller {/*gõ cicontroller -> tab -> đặt tên zống tên file*/

	public function __construct()
	{
		parent::__construct();
	}

	public function index()	/*function này đc load_view vs 1 view để chạy đầu tiên*/
	{
		echo 'Hello, world';

		/*Demo 0: Array*/	

		/*danhSachArr: có kiểu data là kiểu mảng*/
		/*C1: duyệt mảng theo key-value, phone04:key, 09...:value, cách 1 ko truyền qua view đc*/
		$firstArr = array("phone01"=>"09111111", "phone02"=>"09222222",	
						  "phone03"=>"0933333", "phone04"=>"0944444"); 
		foreach ($firstArr as $key => $value)			 /*foreach để duyệt mảng. dấu . để nối*/
			echo "Key: ".$key.", value: ".$value."<br>"; /*chuỗi, tương tự dấu + trong java*/


		/*C2: duyệt mảng theo key-value, đặt key trong tên mảng*/
		$firstArr["danhSachArr"] = array("09111111","09222222","0933333","0944444");
		$this->load->view('AddView',$firstArr);	/*tạo view: loadview -> tab*/

		/*VD Mảng nhiều chiều*/
		$thucDonMenu = array(			/*mảng thucDonMenu, chưa mảng breakfast, lunch, dinner*/
			"breakfast" => array(		/*mảng breakfast chứa các mảng: khaiVi, monChinh, etc*/
					"khaiVi" => array("kv1"=>"sup","kv2"=>"vodka"),
					"monChinh"=> array("com"=>"com rang", "pho"=>"pho bo"),
					"trangMieng"=> array("kem" => "vani", "nuoc" => "cafe")
				)
			// ,"lunch" => "com"
			// ,"dinner" => "bun"
		);
		/*duyệt mảng nhiều chiều*/
		foreach ($thucDonMenu as $key => $value) {				/*duyệt thucDonMenu*/
			echo 'key: '.$key.", value: <br><ul>";				/*in thucDonMenu*/
			foreach ($value as $key2 => $value2) {				/*duyệt breakfast*/
				echo '<li> key: '.$key2.", value: <br><ul>";	/*in breakfast*/
				foreach ($value2 as $key3 => $value3) {			/*duyệt khaiVi*/
					echo '<li> key: '.$key3.", value: ".$value3."</li>";
				}
				echo '</ul></li>';
			}
			echo '</ul>';
		}
	}
	public function otherFunction()
	{
		echo 'other function';
	}








	/*Demo 1: Select and Add data*/
	public function insertTaiSanController()
	{	/*lấy data từ view gửi về (gõ: _post -> tab*/
		$codeTs=$this->input->post('inputCodeTs');	/*lấy từng trường một về, lấy trường CodeTs*/
		$nameTS=$this->input->post('inputNameTs');	/*lấy trường NameTs, lưu vào biến nameTs*/
		$dateImport=$this->input->post('inputDateImport');	/*lấy trường Ngày nhập và lưu*/
		$year=$this->input->post('inputYearKhauHao');		/*lấy trường Năm khấu hao và lưu*/
		$priceTS=$this->input->post('inputPriceTs');		/*lấy trường Zá trị Ts và lưu*/

		/*lấy thông tin xong rồi thì controller sẽ truyền data vào model*/
		$this->load->model('FirstModel');	/*gọi hàm insertTaiSanModel trong model ra*/
/*insert*/if($this->FirstModel->insertTaiSanModel($codeTs, 
												$nameTS, $dateImport, $year, $priceTS)!=null){
			echo 'update thành công';
		}
		else{
			echo 'update thất bại';
		}

		/*sau khi truyền vào model, update data trong database => hiển thị data lên view*/
		/*gọi hàm selectTaiSanModel trong model ra để lấy dữ liệu, truyền vào biến selectData*/
/*select*/$selectData = $this->FirstModel->selectTaiSanModel();	
		$selectData=array("dataController"=>$selectData);/*để load data lên view PHẢI đưa về mảng*/
		/*với key là dataController. Sau đó, loadview ->tab (truyền data lấy đc ra view)*/
		// echo '<pre>';			/*Đoạn mã check lỗi*/
		// var_dump($selectData);
		$this->load->view('SelectView', $selectData, FALSE);	/*vào view xử lý*/
	}




}

/* End of file FirstController.php */
/* Location: ./application/controllers/FirstController.php */
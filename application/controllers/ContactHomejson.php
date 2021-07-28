<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Muốn bỏ text index.php trên đường link => tạo 1 file .htaccess tại: phpBasic4/.htaccess và paste đoạn code tìm đc vào
 Link server lúc này sẽ là: http://127.0.0.1:8888/phpBasic4/ContactHomejson*/
class ContactHomejson extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->model);	/*tự động load model*/
	}
	public function index()
	{
		$contact1 = [
		    'name' =>"long",
		    "phone"=>"09999999" 
		];	/*1 mảng*/
		$contacts = array();	/*nhiều mảng*/
		array_push($contacts, $contact1);	/*đưa mảng con vào mảng cha*/
		
		$contact2 = array(
		    'name' => "duc",
		    "phone"=>'0888888' 
		);
		array_push($contacts, $contact2);	/*đưa mảng con vào mảng cha*/

		/*mã hóa mảng contacts thành json bằng hàm tên là json_encode()*/

		echo '<h5>json encode</h5><pre>';
		var_dump(json_encode($contacts));
		echo '</pre>';

		/*để lấy nội dung ra thì zải mã bằng json_decode()*/
		echo '<h5>json decode</h5><pre>';
		var_dump(json_decode(json_encode($contacts)));
		echo '</pre>';

		// echo $this->ContactjsonModel->insertContactModel($this->columnNameContactFirstRow,json_encode($contacts));	
		/*đưa data json vào db với nameCont="liên hệ 1", và contact=json_encode($contacts) */

		$this->selectContact();
		/*lấy data ra, cần zải mã ra, sau khi decode thì tạo ra 1 mảng gồm 2 phần tử, từng phần tử là 1 mảng chứa 2 trường phone và name*/

		// echo '<pre>';
		// var_dump(json_decode($this->ContactjsonModel->selectContactModel()));	/*lấy data ra, cần zải mã ra*/
		// echo '</pre>';
	}

	private $columnNameContactFirstRow = "liên hệ 1";	/*zá trị đầu tiên của trường selectJsonContact trong db là "liên hệ 1"*/

	private $fieldsInValueContact=array("name","phone");/*các trường trong cột contact*/

	private $model = 'ContactjsonModel';
	private $viewHome = 'ContactHomejson';
	private $viewUpdate = 'ContactUpdateView';
	private $viewHomeTransferData = 'selectJsonContact';
	private $viewUpdateTransferData = 'selectJsonContactUpdateView';

	/*name của các trường lấy từ view ra (bao gồm chung cho cả homeview và updateview), bao gồm*/
	private $fieldsFromView = array("nameContact", "phoneContact");



	public function selectContact()
	{
		$this->load->view($this->viewHome, array($this->viewHomeTransferData => json_decode(
							$this->ContactjsonModel->selectContactModel($this->columnNameContactFirstRow),true),FALSE));
	}

	public function insertContact()
	{/*đầu tiên lấy hết data ra, rồi zải mã thành 1 mảng (phải đưa zề mảng để add data vào),sau đó đưa $contactElement vô mảng này thêm zá*/
		$selectAllData=json_decode($this->ContactjsonModel->selectContactModel($this->columnNameContactFirstRow),true);/*trị true ở đây*/
		$contactElement = array(	/*thì $selectAllData sẽ biến thành 1 dạng mảng, còn k có true thì mặc định biến thành object*/
		    $this->fieldsInValueContact[0] => $this->input->post($this->fieldsFromView[0]),
		    $this->fieldsInValueContact[1] => $this->input->post($this->fieldsFromView[1])
		);
		array_push($selectAllData, $contactElement);	/*sau đó mã hóa ngược lại thành chuỗi json và update vào*/
		if ($this->ContactjsonModel->updateContactModel($this->columnNameContactFirstRow,json_encode($selectAllData)))
			echo 'success';
		// echo '<pre>';
		// var_dump($selectAllData);
		// echo '</pre>';
	}
	public function updateContactOpening()
	{	/*lấy hết data ra và truyền vào view viewUpdate*/
		$this->load->view($this->viewUpdate, array($this->viewUpdateTransferData => json_decode(
			$this->ContactjsonModel->selectContactModel($this->columnNameContactFirstRow),true), FALSE));
	}

	public function updateContact()
	{
		$contacts = array();/*đầu tiên tạo 1 biến contacts để lưu trữ toàn bộ data. Duyệt hết các phần tử nameContact trong jsonupdateView*/
		for ($count = 0; $count < count($this->input->post($this->fieldsFromView[0])) ; $count++) { /*nameContact là thuộc tính từ view*/
			$contact=array( /*mảng contacts chứa các contact, contact là 1 mảng chứa name+phone*/	/*(đã định nghĩa trong jsonupdateView)*/
			    $this->fieldsInValueContact[0] => $this->input->post($this->fieldsFromView[0])[$count],
			    $this->fieldsInValueContact[1] => $this->input->post($this->fieldsFromView[1])[$count]
			);
			array_push($contacts, $contact);
		}	/*sau khi hết for, $contacts có đầy đủ data*/
		// echo '<pre>';
		// var_dump($contacts);
		// echo '</pre>';
		if ($this->ContactjsonModel->updateContactModel($this->columnNameContactFirstRow, json_encode($contacts)))
			echo 'success';
	}


	public function deleteContact($phone)
	{	/*đầu tiên lấy hết data ra, rồi zải mã thành 1 mảng (thực ra zải mã thành kiểu object, chỉ search k add nên đưa về object cũng ok)*/
		$selectAllData = json_decode($this->ContactjsonModel->selectContactModel($this->columnNameContactFirstRow));/*sau đó duyệt mảng, */
		foreach ($selectAllData as $key => $value) {	/*kiểm tra từng phần tử vs phone. Ở đây, $selectAllData đã đc decode (Zải mã)*/
			if ($value->phone == $phone) {				/*nếu value của phone trùng vs param $phone thì unset (xóa)*/
				unset($selectAllData[$key]);
			}
		}
		if ($this->ContactjsonModel->updateContactModel($this->columnNameContactFirstRow, json_encode($selectAllData)))
			echo 'success';
	}
}

/* End of file mainjson.php */
/* Location: ./application/controllers/mainjson.php */
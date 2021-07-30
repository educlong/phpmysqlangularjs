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
	private $nameAttribute = array("topBannerSlide", "infoBookingTable", "menuDacap", "userAngular", "angularJsDemo1");
	private $isDelete = ['0','1'];


	/*XỬ LÝ ANGULAR JS (xử lý bằng chuỗi json, dữ liệu cũng bằng chuỗi json)*/
	/*zá trị đầu tiên của trường nameAttribute trong db là angularJsDemo1 $nameAttribute[4] với mảng dưới là các trường trong valueAttribute*/
	private $fieldsAngDemo1InValueAttribute=array("id","page","title","subtitle","content","image","author","date","isDelete");

	public function selectAngularDemo1()	/*trả về 1 chuỗi json chứ k phải trả về 1 mảng như thông thường, để xử lý cho angular js*/
	{
		echo $this->AngularDemo1Model->selectAttributeModelNoDelete($this->nameAttribute[4], $this->fieldsAngDemo1InValueAttribute);
	}

	

	public function selectAngularDemo1ById($id)	/*trả về 1 chuỗi json theo id*/
	{
		$getAllData = json_decode(
				$this->AngularDemo1Model->selectAttributeModelNoDelete($this->nameAttribute[4], $this->fieldsAngDemo1InValueAttribute), true);
		foreach ($getAllData as $key => $value) {
			if ($value[$this->fieldsAngDemo1InValueAttribute[0]]==$id) {
				echo json_encode(array($value));
			}
		}
	}

	/*Những trường này đc lấy từ file js (phần xử lý cho angular js) ===> XỬ LÝ JSON (UPDATE PHẦN TỬ ĐƯỢC CHỌN TRONG JSON)*/
	private $fieldsFromUpdateAngDemo1 = array("idAngDemo1","pageAngDemo1","titleAngDemo1","subtitleAngDemo1","contentAngDemo1","imageAngDemo1", "authorAngDemo1", "dateAngDemo1");
	public function updateAngularDemo1()	/*thực ra lầ update lại zá trị của cột nameAttribute (update bất kỳ thuộc tính nào)*/
	{	/*Đầu tiên, lấy hết data trong cột valueAttribute, dòng angularJsDemo1 ra, decode ra thành 1 mảng và lưu vào $selectAllData*/
		$selectAllData = json_decode($this->AngularDemo1Model->selectAttributeModel($this->nameAttribute[4]),true);
		$allAllData = array();	/*tạo 1 mảng để sau khi update, đưa toàn bộ mảng này vào cột valueAttribute, dòng userAngular*/
		for ($count = 0; $count < count($selectAllData) ; $count++) {	/*Nếu trường id bằng vs zá trị đưa vào thì*/
			if ($selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[0]] ==$this->input->post($this->fieldsFromUpdateAngDemo1[0])){
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[1]] = $this->input->post($this->fieldsFromUpdateAngDemo1[1]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[2]] = $this->input->post($this->fieldsFromUpdateAngDemo1[2]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[3]] = $this->input->post($this->fieldsFromUpdateAngDemo1[3]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[4]] = $this->input->post($this->fieldsFromUpdateAngDemo1[4]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[5]] = $this->input->post($this->fieldsFromUpdateAngDemo1[5]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[6]] = $this->input->post($this->fieldsFromUpdateAngDemo1[6]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[7]] = $this->input->post($this->fieldsFromUpdateAngDemo1[7]);
				$selectAllData[$count][$this->fieldsAngDemo1InValueAttribute[8]] = $this->isDelete[0];
			}	/*thì update tất cả thuộc tính của các trường còn lại (name, dob, fb, phone) của 1 phần tử trong mảng $selectAllData*/
			array_push($allAllData, $selectAllData[$count]);	/*đưa phần tử đó vào $allAllData*/
		}
		if ($this->AngularDemo1Model->updateAttributeModel($this->nameAttribute[4], json_encode($allAllData)))	/*sau đó gọi update*/
			echo 'success';
		else
			echo 'fail';
	}








	/*XỬ LÝ ANGULAR UI SELECT*/
	private $fieldsMenuInValueAttribute=array("id","title","link","idParent","isDelete"); /*các trường trong valueAttribute (menu đa cấp)*/

	public function selectAngularUiSelect()	/*trả về 1 chuỗi json chứ k phải trả về 1 mảng như thông thường, để xử lý cho angular js*/
	{
		echo $this->AngularDemo1Model->selectAttributeModelNoDelete($this->nameAttribute[2], $this->fieldsMenuInValueAttribute);
	}





}

/* End of file AngularDemo1.php */
/* Location: ./application/controllers/AngularDemo1.php */
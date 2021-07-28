<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*	Bước 1: kích hoạt url trong file autoload.php
	Bước 2: kích hoạt base_url trong file config.php
	Bước 3: thêm đường dẫn css, js bằng cách < ? php echo base_url(); ?> trong view
	Bước 4: kết nối database trong file config/database.php (username, pass, databasename,etc.)
	Bước 5: Để truy cập, gõ: http://localhost:8888/phpBasic/index.php/FirstController
	*/
class FirstModel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}



	/*Demo 1: Select and Add data*/
	/*đầu tiên, kết nối data trong file config/database.php (xem xử lý trong database.php)*/
	public function insertTaiSanModel($codeTs, $nameTs, $dateImport, $yearKhauHao, $priceTS)
	{	/*CodeTS, NameTS, DateImport, YearKhauHao, ValueTS lấy đúng tên cột trong database*/
		$arrTaiSan = array("CodeTS"=>$codeTs, "NameTS"=>$nameTs, "DateImport"=>$dateImport,
							"YearKhauHao"=>$yearKhauHao, "ValueTS"=>$priceTS);

		$this->db->insert('taisan', $arrTaiSan);  /*gõ: db_insert -> tab để insert data vào*/
		$this->db->where('CodeTS', $codeTs);	/*khi truyền vào đc rồi thì nó sẽ trả về 1 id*/
		return $this->db->get("taisan")->result_array();
		
	}	/*chú ý chỗ này cần kích hoạt thêm $autoload['libraries'] = array(); trong autoload*/



	/*update*/
	public function updateTaiSanModel($codeTs)	/*gọi đến view EditView để update data*/
	{
		$this->db->select('*');				/*select hết toàn bảng, search codeTs hết toàn bảng*/
		$this->db->where('CodeTS', $codeTs);/*search taisan có mã codeTs ra*/
		return $this->db->get('taisan')->result_array();	/*trả về tài sản có mã đó*/

		// echo '<pre>';/*đoạn code để text lỗi (debug)*/
		//var_dump($this->db->get('taisan')->result_array());/*result_array: covert sang array*/
	}

	/*xử lý sau khi update*/
	public function updateTaiSanModelFinal($codeTs, $nameTS, $dateImport, $year, $priceTS)
	{	/*xử lý sau khi update data xong. Đầu tiên tại 1 đối tượng để update*/
		$dataUpdateTaiSan = array("CodeTS"=> $codeTs, "NameTS"=> $nameTS,
						"DateImport"=>$dateImport, "YearKhauHao"=>$year, "ValueTS"=> $priceTS);
		$this->db->where('CodeTS', $codeTs);/*nếu CodeTS trong bảng = $codeTs nhận vào thì gọi*/
		return $this->db->update('taisan', $dataUpdateTaiSan);/*update đối tượng dataUpdateTaiSan*/
	}



	/*select*/
	public function selectTaiSanModel()
	{
		$this->db->select('*');		/*gõ db_select -> tab (*) tức là lấy hết tất cả các trường*/
		$selectTaiSan = $this->db->get('taisan');/*lấy data từ bảng nào, lưu vào mảng selectTaiSan*/
		return $selectTaiSan->result_array();	 /*đưa kq về 1 mảng dữ liệu*/
		// echo '<pre>';
		// var_dump($selectTaiSan);	/*var_dump: check lỗi*/
	}





	/*Demo 2: Delete data*/
	public function deleteTaiSanModelByCodeTS($codeTs)
	{	/*đầu tiên cần check data, nếu trường CodeTS (trong mysql) trùng vs $codeTs đc nhận về*/
		$this->db->where('CodeTS', $codeTs);	/*db_where -> tab ==> check CodeTS*/
		return $this->db->delete('taisan');		/*db_delete -> tab (xóa CodeTS trong bảng taisan)*/
	}





}

/* End of file FirstModel.php */
/* Location: ./application/models/FirstModel.php */
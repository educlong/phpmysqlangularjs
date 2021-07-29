<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AttributejsonModel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	/*CÓ THỂ SỬ DỤNG PHÍM TẮT ĐỂ XỔ RA CODE TƯƠNG TÁC VS DATABASE (SELECT, INSERT, UPDATE, DELETE)

	Gõ ci2me -> tab (hoặc ctrl+space)	*/









	/*XỬ LÝ VỚI BẢNG DỮ LIỆU JSON*/
	public $tableDatabase = "webpageattribute";					/*tên bảng dữ liệu*/

	public $columnIdAttribute ="idAttribute";					/*cột idAttribute trong mysql*/
	public $columnNameAttribute ="nameAttribute";				/*cột nameAttribute trong mysql*/
	public $columnValueAttribute ="valueAttribute";				/*cột valueAttribute trong mysql*/
	public $columnValueAttributeFieldId = "id";					/*trường id trong cột valueAttribute trong mysql*/


	
	public $isDelete = ['0','1'];



	public function selectAttributeModel($infoInColumnNameAttribute)
	{
		$this->db->select('*');
		$this->db->order_by($this->columnIdAttribute, 'asc');						/*sắp xếp id theo chiều tăng dần (asc)*/
		$this->db->where($this->columnNameAttribute, $infoInColumnNameAttribute);	/*lấy cột có nameAttribute là "topBannerSlide"*/

		/*duyệt tất cả bảng dữ liệu*/
		foreach ($this->db->get($this->tableDatabase)->result_array() as $value)	/*lấy ra đc dòng có nameAttribute ="topBannerSlide"*/
		{	/*$this->db->get($this->tableDatabase)->result_array() trong foreach sẽ trả về 1 mảng chứa các phần tử là 1 dòng trên db*/
			$result = $value[$this->columnValueAttribute]; /*các phần tử trên 1 dòng db cũng là 1 mảng (mảng 2), trong mảng 2 này chứa*/
		}	/*nội dung của từng cột -> chỉ lấy ra cột valueAttribute ($this->columnValueAttribute)*/

		return $result;	/*result trả về là 1 chuỗi dữ liệu json: */
	}

	public function selectAttributeModelNoDelete($infoInColumnNameAttribute, Array $fieldsInValueAttribute)
	{

		$nameAtri = json_decode($this->selectAttributeModel($infoInColumnNameAttribute),true);

		$selectAttributeNoDelete = array();
		foreach ($nameAtri as $key => $value) {
			if ($value[$fieldsInValueAttribute[count($fieldsInValueAttribute)-1]] == $this->isDelete[0] ) {
				$selectAttributeNoDeleteElement = array();	/*tạo 1 mảng chứa 1 phần tử trong chuỗi json (phần tử này có key và value)*/
				$selectAttributeNoDeleteElement = array_fill_keys($fieldsInValueAttribute, "");	/*tạo key cho từng phần tử trong mảng này*/
				for ($count = 0; $count <count($selectAttributeNoDeleteElement) ; $count++) {	/*gán value cho từng phần tử trong mảng này*/
					$selectAttributeNoDeleteElement[$fieldsInValueAttribute[$count]] = $value[$fieldsInValueAttribute[$count]];
				}
				array_push($selectAttributeNoDelete, $selectAttributeNoDeleteElement);	/*đưa mảng vừa tạo vào mảng lớn tất cả dữ liệu*/
			}
		}
		return json_encode($selectAttributeNoDelete);
	}
	
	public function insertAttributeModel($nameAttribute, $valueAttribute)		/*$attribute này đã đc mã hóa (json_encode)*/
	{	/*insert $nameAttribute vào cột nameAttribute ($this->$columnNameAttribute) */
		$this->db->insert($this->tableDatabase, 	/*và $valueAttribute vào cột valueAttribute ($this->columnValueAttribute)*/
			array($this->columnNameAttribute => $nameAttribute, $this->columnValueAttribute => $valueAttribute));
		return $this->db->insert_id();				/*nếu insert_id=0: false, =1: true*/
	}


	public function updateAttributeModel($infoInColumnNameAttribute, $saveData)
	{	/*nếu cột nameAttribute trong bảng = $infoInColumnNameAttribute nhận vào thì gọi*/
		$this->db->where($this->columnNameAttribute, $infoInColumnNameAttribute);
		return $this->db->update($this->tableDatabase, 
			array($this->columnNameAttribute=>$infoInColumnNameAttribute, $this->columnValueAttribute=>$saveData));
	} /*tạo mảng để update data update cả mảng, vs nameAttribute="topBannerSlide", và valueAttribute=...(là 1 chuỗi dữ liệu json)*/





	
	        
}

/* End of file mainjsonModel.php */
/* Location: ./application/models/mainjsonModel.php */
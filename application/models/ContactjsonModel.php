<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContactjsonModel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public $tableDatabase = "contacts";				/*tên bảng dữ liệu*/

	public $columnIdCont ="idCont";					/*cột idCont trong mysql*/
	public $columnNameCont ="nameCont";				/*cột nameCont trong mysql*/
	public $columnCont ="contact";					/*cột contact trong mysql*/
	public $columnIsDeleteCont = "isDeleteCont";	/*cột isDeleteCont trong mysql*/



	public function selectContactModel($infoInColumnNameCont)
	{
		$this->db->select('*');
		$this->db->order_by($this->columnIdCont, 'asc');	/*sắp xếp id theo chiều tăng dần (asc)*/
		$this->db->where($this->columnIsDeleteCont, false);	/*lấy dữ liệu có cột isDeleteCont = 0 ra (tức là những data nào k bị xóa)*/
		$this->db->where($this->columnNameCont, $infoInColumnNameCont);	/*lấy cột có nameCont là "liên hệ 1"*/

		/*duyệt tất cả bảng dữ liệu*/
		foreach ($this->db->get($this->tableDatabase)->result_array() as $value)	/*lấy ra đc dòng có nameCont ="liên hệ 1"*/
		{	/*$this->db->get($this->tableDatabase)->result_array() trong foreach sẽ trả về 1 mảng chứa các phần tử là 1 dòng trên db*/
			$result = $value[$this->columnCont]; 	/*các phần tử trên 1 dòng db cũng là 1 mảng (gọi là mảng 2), trong mảng 2 này chứa*/
		}	/*nội dung của từng cột -> chỉ lấy ra cột contact ($this->columnCont)*/
		return $result;	/*result trả về là 1 chuỗi dữ liệu json: [{"name":"long","phone":"09999999"},{"name":"duc","phone":"0888888"}]*/
	}

	public function insertContactModel($nameCont, $contact)		/*$contact này đã đc mã hóa (json_encode)*/
	{	/*insert $nameCont vào cột nameCont ($this->$columnNameCont) và $contact vào cột contact ($this->columnCont)*/
		$this->db->insert($this->tableDatabase, 
			array($this->columnNameCont => $nameCont, $this->columnCont => $contact, $this->columnIsDeleteCont => false));
		return $this->db->insert_id();/*nếu insert_id=0: false, =1: true*/
	}


	public function updateContactModel($infoInColumnNameCont, $saveData)
	{
		$this->db->where($this->columnIsDeleteCont, false);
		$this->db->where($this->columnNameCont, $infoInColumnNameCont);	/*nếu nameCont trong bảng = $infoInColumnNameCont nhận vào thì gọi*/
		return $this->db->update($this->tableDatabase, array($this->columnNameCont=>$infoInColumnNameCont, $this->columnCont=>$saveData));
	} /*tạo mảng để update data update cả mảng, vs nameCont="liên hệ 1", và contact="[{"name":"long","phone":"09999999"}]" (đã xóa 1ptử)*/

}

/* End of file mainjsonModel.php */
/* Location: ./application/models/mainjsonModel.php */
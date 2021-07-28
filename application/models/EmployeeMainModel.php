<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EmployeeMainModel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}


	public $tableDatabase = "employee";				/*tên bảng dữ liệu*/

	public $columnIdEmp ="idEmp";					/*cột idEmp trong mysql*/
	public $columnNameEmp ="nameEmp";				/*cột nameEmp trong mysql*/
	public $columnAgeEmp ="ageEmp";					/*cột ageEmp trong mysql*/
	public $columnPhoneEmp ="phoneEmp";				/*cột phoneEmp trong mysql*/
	public $columnAvartarEmp ="avartarEmp";			/*cột avartarEmp trong mysql*/
	public $columnLinkfbEmp ="linkfbEmp";			/*cột linkfbEmp trong mysql*/
	public $columnOrdersEmp = "ordersEmp";			/*cột ordersEmp trong mysql*/
	public $columnIsdeleteEmp = "isdeleteEmp";		/*cột isdeleteEmp trong mysql*/

	public function selectEmployeesModel()	/*lọc hết nhân viên (isdeleteEmp=false)*/
	{
		$this->db->select('*');
		$this->db->order_by($this->columnIdEmp, 'asc');	/*sắp xếp id theo chiều tăng dần (asc)*/
		$this->db->where($this->columnIsdeleteEmp, false);
		return $this->db->get($this->tableDatabase)->result_array();
	}

	public function insertEmployeeModel($nameEmp, $ageEmp, $phoneEmp, $avatar, $orders, $linkfb)
	{
		$this->db->insert($this->tableDatabase, array($this->columnNameEmp=>$nameEmp, $this->columnAgeEmp=>$ageEmp, 
											$this->columnPhoneEmp=>$phoneEmp, $this->columnAvartarEmp=>$avatar, 
											$this->columnLinkfbEmp=>$linkfb, $this->columnOrdersEmp=>$orders,
											$this->columnIsdeleteEmp=>false));
		return $this->db->insert_id();/*nếu insert_id=0: false, =1: true*/
	}

	public function checkEmployeeModel($idEmployee)
	{
		$this->db->select('*');
		$this->db->where($this->columnIdEmp, $idEmployee);
		return $this->db->get($this->tableDatabase)->result_array();
	}

	public function checkNameEmployeeModel($nameEmployee)
	{
		$this->db->select('*');
		$this->db->where($this->columnNameEmp, $nameEmployee);
		return $this->db->get($this->tableDatabase)->result_array();
	}

	public function updateEmployeeModel($id,$nameEmp,$ageEmp,$phoneEmp,$avatar,$orders,$linkfb)
	{
		$this->db->where($this->columnIdEmp, $id);/*nếu CodeTS trong bảng = $codeTs nhận vào thì gọi*/
		return $this->db->update($this->tableDatabase, array($this->columnNameEmp=>$nameEmp, $this->columnAgeEmp=>$ageEmp, $this->columnPhoneEmp=>$phoneEmp, $this->columnAvartarEmp=>$avatar,$this->columnLinkfbEmp=>$linkfb, $this->columnOrdersEmp=>$orders));
	}

	public function deleteEmployeeModel($idEmployee)
	{
		$this->db->where($this->columnIdEmp, $idEmployee);
		return $this->db->update($this->tableDatabase, array($this->columnIsdeleteEmp=>true));;
	}

}

/* End of file mainModel.php */
/* Location: ./application/models/mainModel.php */
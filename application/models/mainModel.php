<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mainModel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function selectEmployeesModel()	/*lọc hết nhân viên (isdeleteEmp=false)*/
	{
		$this->db->select('*');
		$this->db->order_by('idEmp', 'asc');	/*sắp xếp id theo chiều tăng dần (asc)*/
		$this->db->where('isdeleteEmp', false);
		return $this->db->get('employee')->result_array();
	}

	public function insertEmployeeModel($nameEmp, $ageEmp, $phoneEmp, $avatar, $orders, $linkfb)
	{
		$this->db->insert('employee', array("nameEmp"=>$nameEmp, "ageEmp"=>$ageEmp, 
											"phoneEmp"=>$phoneEmp, "avartarEmp"=>$avatar, 
											"linkfbEmp"=>$linkfb, "ordersEmp"=>$orders,
											"isdeleteEmp"=>false));
		return $this->db->insert_id();/*nếu insert_id=0: false, =1: true*/
	}

	public function checkEmployeeModel($idEmployee)
	{
		$this->db->select('*');
		$this->db->where('idEmp', $idEmployee);
		return $this->db->get('employee')->result_array();
	}

	public function checkNameEmployeeModel($nameEmployee)
	{
		$this->db->select('*');
		$this->db->where('nameEmp', $nameEmployee);
		return $this->db->get('employee')->result_array();
	}

	public function updateEmployeeModel($id,$nameEmp,$ageEmp,$phoneEmp,$avatar,$orders,$linkfb)
	{
		$this->db->where('idEmp', $id);/*nếu CodeTS trong bảng = $codeTs nhận vào thì gọi*/
		return $this->db->update('employee', array("nameEmp"=>$nameEmp, "ageEmp"=>$ageEmp, 
		 "phoneEmp"=>$phoneEmp, "avartarEmp"=>$avatar,"linkfbEmp"=>$linkfb, "ordersEmp"=>$orders));
	}

	public function deleteEmployeeModel($idEmployee)
	{
		$this->db->where('idEmp', $idEmployee);
		return $this->db->update('employee', array("isdeleteEmp"=>true));;
	}

}

/* End of file mainModel.php */
/* Location: ./application/models/mainModel.php */
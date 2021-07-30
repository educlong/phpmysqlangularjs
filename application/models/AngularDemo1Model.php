<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AngularDemo1Model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	/*DEMO2: SỬ DỤNG TEMPLATE ADMIN ĐỂ LÀM BACKEND -> search từ khóa: milestones template admin download themelock, tải template về
	Bước 1: Tạo thêm folder phpBasic4/angularJsDemo2 để lưu trữ template và zao diện cần thiết
	Bước 2: Chỉnh sửa lại file demo phpBasic4/angularJsDemo2/milestone-120/html/app/index.html
		*/
	/**
     * @name string TABLE_NAME Holds the name of the table in use by this model
     */
    const TABLE_NAME = 'login';



	private $columnAdminLogin = "adminLogin";		/*Paul*/
	private $columnIsDeleteLogin = "isDeleteLogin";	/*Paul*/
	private $columnDateCreate = "dateCreate";		/*Paul*/

    /**
     * @name string PRI_INDEX Holds the name of the tables' primary index used in this model
     */
    const PRI_INDEX = 'idLogin';

    /**
     * Retrieves record(s) from the database
     *
     * @param mixed $where Optional. Retrieves only the records matching given criteria, or all records if not given.
     *                      If associative array is given, it should fit field_name=>value pattern.
     *                      If string, value will be used to match against PRI_INDEX
     * @return mixed Single record if ID is given, or array of results
     */
    public function getUser($where=NULL,$getAdmin=NULL){/*Nếu getAdmin=NULL -> lấy hết data; getAdmin=true -> lấy admin, =false -> lấy user*/
        $this->db->select('*');
        $this->db->from(self::TABLE_NAME);
        $this->db->where($this->columnIsDeleteLogin, false);		/*Paul*//*Chỉ lấy những user nào ko bị xóa, tức là cột isDeleteLogin = 0*/
        if ($getAdmin!=NULL) {
			$this->db->where($this->columnAdminLogin, $getAdmin);	/*Paul*//*Chỉ lấy những user nào là user, tức là cột adminLogin = 0*/
        }
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where(self::PRI_INDEX, $where);
            }
        }
        $preResult = $this->db->get()->result_array();				/*Paul*/



        $result = array();	/*Sử dụng 1 mảng result để convert zá trị dateCreate qua format ngày tháng*/	/*Paul*/
		foreach ($preResult as $auser) {			/*Paul*/
			$auser[$this->columnDateCreate] = date('d/m/Y', $auser[$this->columnDateCreate]);	/*Paul*/
			array_push($result, $auser);			/*Paul*/
		}											/*Paul*/




        if ($result) {
            if ($where !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    /**
     * Inserts new data into database
     *
     * @param Array $data Associative array with field_name=>value pattern to be inserted into database
     * @return mixed Inserted row ID, or false if error occured
     */
    public function insertUser(Array $data) {
        if ($this->db->insert(self::TABLE_NAME, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Updates selected record in the database
     *
     * @param Array $data Associative array field_name=>value to be updated
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of affected rows by the update query
     */
    public function updateUser(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array(self::PRI_INDEX => $where);
            }
        $this->db->update(self::TABLE_NAME, $data, $where);
        return $this->db->affected_rows();
    }

    /**
     * Deletes specified record from the database
     *
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of rows affected by the delete query
     */
    public function deleteUser($where = array()) {
        if (!is_array()) {
            $where = array(self::PRI_INDEX => $where);
        }
        $this->db->delete(self::TABLE_NAME, $where);
        return $this->db->affected_rows();
    }

}
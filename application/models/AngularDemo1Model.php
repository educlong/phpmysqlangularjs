<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AngularDemo1Model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}






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
	public function increaseIdAttributeModel($infoInColumnNameAttribute)	/*trường id trong valueAttribute tự động tăng*/
	{
		$id=1;
		foreach (json_decode($this->selectAttributeModel($infoInColumnNameAttribute), true) as $key => $value) {
			if ($value[$this->columnValueAttributeFieldId] >= $id) {
				$id++;
			}
		}
		return $id;
	}

	public function checkingIdModel($infoInColumnNameAttribute, Array $fieldsInValueAttribute, $idAttribute)
	{
		$nameAtri = json_decode($this->selectAttributeModel($infoInColumnNameAttribute),true);
		foreach ($nameAtri as $key => $value) {
			if ($idAttribute == $value[$fieldsInValueAttribute[0]]) {	/*Nếu trùng id => return false, ko trùng id => return true*/
				return false;
			}
		}
		return true;
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
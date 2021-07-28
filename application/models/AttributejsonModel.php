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





	












	/*XỬ LÝ PHẦN DANH MỤC TIN TỨC*/
	private $tableDatabaseNewsCategory = "newscategories";					/*tên bảng dữ liệu*/
	private $columnIdNewsCat  = "idNewsCat";
	private $columnNameNewsCat = "nameNewsCat";
	private $columnIsDeleteNewsCat = "isDeleteNewsCat";
	public function insertNewsCategoryModel($newNameCategory)
	{
		$this->db->insert($this->tableDatabaseNewsCategory, 
			array($this->columnNameNewsCat => $newNameCategory, $this->columnIsDeleteNewsCat => false));
		return $this->db->insert_id();
	}

	public function selectNewsCategoryModel()	
	{
		$this->db->select('*');
		$this->db->where($this->columnIsDeleteNewsCat, false);
		return $this->db->get($this->tableDatabaseNewsCategory)->result_array();
	}
	public function checkNewsCategoryModel($idCategory)
	{
		$this->db->select('*');
		$this->db->where($this->columnIdNewsCat, $idCategory);
		return $this->db->get($this->tableDatabaseNewsCategory)->result_array();
	}
	public function updateNewsCategoryModel($idCategory, $newNameCategory)
	{
		$this->db->where($this->columnIdNewsCat, $idCategory);	/*nếu CodeTS trong bảng = $codeTs nhận vào thì gọi*/
		return $this->db->update($this->tableDatabaseNewsCategory, array($this->columnNameNewsCat=>$newNameCategory));
	}

	public function deleteNewsCategoryModel($idCategory)
	{
		$this->db->where($this->columnIdNewsCat, $idCategory);
		return $this->db->update($this->tableDatabaseNewsCategory, array($this->columnIsDeleteNewsCat=>true));
	}













	/*XỬ LÝ PHẦN TIN TỨC*/
	private $tableDatabaseNews = "newscontent";
	private $columnIdNews = "idNews";
	private $columnNewsTitle = "newsTitle";
	private $columnImageNews = "imageNews";
	private $columnSummaryNews = "summaryNews";
	private $columnNewsCon = "newsCon";
	private $columnNewsDate = "newsDate";
	private $columnIsDeleteNewsCont = "	isDeleteNewsCont";
	public function insertNewsModel($newsTitle, $idNewsCat, $imageNews, $summaryNews, $newsCon, $newsDate)
	{
		$this->db->insert($this->tableDatabaseNews, array($this->columnNewsTitle => $newsTitle, $this->columnIdNewsCat => $idNewsCat, 
														  $this->columnImageNews => $imageNews, $this->columnSummaryNews => $summaryNews,
														  $this->columnNewsCon => $newsCon, $this->columnNewsDate => $newsDate,
														  $this->columnIsDeleteNewsCont => false));
		return $this->db->insert_id();
	}

	public function totalOfNews()							/*ĐẾM XEM CÓ TẤT CẢ BAO NHIÊU TIN KO BỊ XÓA ==> XỬ LÝ PHẦN PHÂN TRANG*/
	{
		$this->db->select('*');
		$this->db->where($this->columnIsDeleteNewsCont, false);
		return count($this->db->get($this->tableDatabaseNews)->result_array());
	}

	public function numberOfPages($numberOfNewsPerPage)		/*ĐẾM XEM CÓ TẤT CẢ BAO NHIÊU TRANG ==> XỬ LÝ PHẦN PHÂN TRANG*/
	{
		$this->db->select('*');
		$this->db->where($this->columnIsDeleteNewsCont, false);
		$numberOfNews = count($this->db->get($this->tableDatabaseNews)->result_array());	/*tổng có bao nhiêu tin (number of news)*/
		if ($numberOfNewsPerPage== null || $numberOfNewsPerPage== 0)  return 1;
		return ceil($numberOfNews/$numberOfNewsPerPage); 	/*số trang bằng số lượng tin chia cho số tin trên 1 trang, ceil: làm tròn*/
	}
	public function selectNewsModel($numberOfNewsPerPage, $startNews) 
	{	/*$numberOfNewsPerPage: số tin lấy ra (số lượng tin trên 1 trang), $startNews: lấy ra bắt đầu từ tin nào*/
		$this->db->select('*');
		$this->db->where($this->columnIsDeleteNewsCont, false);
		if ($numberOfNewsPerPage==null && $startNews==null) {						/*nếu 2 đối số = null thì lấy hết tất cả các tin*/
			return $this->db->get($this->tableDatabaseNews)->result_array();
		}
		return $this->db->get($this->tableDatabaseNews, $numberOfNewsPerPage, $startNews)->result_array();
	}
	public function selectNewsFromIdCategoryModel($idCat)	/*lấy tất cả news theo 1 danh mục (category)*/
	{
		$this->db->select('*');
		$this->db->where($this->columnIsDeleteNewsCont, false);
		$this->db->where($this->columnIdNewsCat, $idCat);
		return $this->db->get($this->tableDatabaseNews)->result_array();		
	}
	public function checkIdNewsModel($idNews)
	{
		$this->db->select('*');
		$this->db->where($this->columnIdNews, $idNews);
		return $this->db->get($this->tableDatabaseNews)->result_array();
	}

	public function selectCategoryFromIdNewsModel($idNews)	/*lấy danh mục (bảng newscategories) từ idNews (bảng newscontent)*/
	{/*select*->lấy hết, from-> bảng newsCategory, join->nếu cột idNewsCat của bảng news bằng cột idNewsCat của bảng newsCategory*/
		$this->db->select('*');
		$this->db->from($this->tableDatabaseNewsCategory);	/*lấy từ bảng newsCategory*/
		$this->db->join($this->tableDatabaseNews, 	/*join: kết nối 2 bảng news và newsCategory lại vs nhau rồi kiểm tra 2 cột nếu = nhau*/
					$this->tableDatabaseNews.'.'.$this->columnIdNewsCat.' = '.$this->tableDatabaseNewsCategory.'.'.$this->columnIdNewsCat,
					'left');
		$this->db->where($this->tableDatabaseNews.'.'.$this->columnIdNews, $idNews);	/*và khi mà idNews bằng id nhận vào*/
		// $getNameCat = array();
		// foreach ($this->db->get()->result_array() as $key => $value) {
		// 	array_push($getNameCat, array($this->columnIdNewsCat => $value[$this->columnIdNewsCat],
		// 								  $this->columnNameNewsCat => $value[$this->columnNameNewsCat]));
		// }
		// return $getNameCat;
		return $this->db->get()->result_array()/*[0]['nameNewsCat']*/;	/*nếu thỏa hết điều kiện trên thì lấy ra*/
	}	/*mảng này trả về 1 kq => lấy tại vị trí [0], trong vị trí [0] lại là 1 mảng vs các key của cả 2 bảng => lấy key nameNewsCat*/

	public function updateNewsModel($idNews, $newsTitle, $idNewsCat, $imageNews, $summaryNews, $newsCon, $newsDate)
	{
		$this->db->where($this->columnIdNews, $idNews);
		return $this->db->update($this->tableDatabaseNews, array($this->columnNewsTitle => $newsTitle, $this->columnIdNewsCat => $idNewsCat,
															$this->columnImageNews => $imageNews, $this->columnSummaryNews => $summaryNews, 
															$this->columnNewsCon => $newsCon, $this->columnNewsDate => $newsDate));
	}
	public function deleteNewsModel($idNews)
	{
		$this->db->where($this->columnIdNews, $idNews);
		return $this->db->update($this->tableDatabaseNews, array($this->columnIsDeleteNewsCont=>true));
	}

















	/*XỬ LÝ PHẦN LOGIN ==> XỬ LÝ BẰNG PHÍM TẮT*/

	/*code tự xổ ra, gõ ci2me -> tab*/
	
    /**
     * @name string TABLE_NAME Holds the name of the table in use by this model
     */
    const TABLE_NAME = 'login';		/*tên bảng dữ liệu*/

	// private $columnIdLogin = "idLogin";				/*tất cả đều do code tự gen ra, những chỗ commen 'Paul' là tự viết*/
	// private $columnNameLogin = "nameLogin";			/*Paul*/
	// private $columnEmailLogin = "emailLogin";		/*Paul*/
	// private $columnPasswordLogin = "passwordLogin";	/*Paul*/
	// private $columnDateCreate = "dateCreate";		/*Paul*/
	private $columnAdminLogin = "adminLogin";		/*Paul*/
	private $columnIsDeleteLogin = "isDeleteLogin";	/*Paul*/


    /**
     * @name string PRI_INDEX Holds the name of the tables' primary index used in this model
     */
    const PRI_INDEX = 'idLogin';	/*primary key của bảng login*/

    /**
     * Retrieves record(s) from the database
     *
     * @param mixed $where Optional. Retrieves only the records matching given criteria, or all records if not given.
     *                      If associative array is given, it should fit field_name=>value pattern.
     *                      If string, value will be used to match against PRI_INDEX
     * @return mixed Single record if ID is given, or array of results
     */

    public function getUser($where = NULL) {	/*truyền vào là điều kiện để lấy ra theo điều kiện đó*/
        $this->db->select('*');
        $this->db->from(self::TABLE_NAME);		/*self:: => lấy hằng số*/
		$this->db->where($this->columnIsDeleteLogin, false);	/*Paul*/	/*Chỉ lấy những user nào ko bị xóa, tức là cột isDeleteLogin = 0*/
		$this->db->where($this->columnAdminLogin, false);		/*Paul*/	/*Chỉ lấy những user nào là user, tức là cột adminLogin = 0*/
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where(self::PRI_INDEX, $where);
            }
        }
        $result = $this->db->get()->result_array();				/*Paul*/	/*result_array để trả về 1 mảng*/
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
    public function insertUser(Array $data) {				/*truyền vào là 1 mảng dữ liệu theo cột như trong database*/
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
    public function updateUser(Array $data, $where = array()) {	/*nhận vào 1 mảng data và 1 câu lệnh điều kiện (thường là id)*/
            if (!is_array($where)) {
                $where = array(self::PRI_INDEX => $where);
            }
        $this->db->update(self::TABLE_NAME, $data, $where);
        return $this->db->affected_rows();						/*nếu có số lượng hàng bị ảnh hưởng thì trả về >0, nếu k thì k thành công*/
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

/* End of file mainjsonModel.php */
/* Location: ./application/models/mainjsonModel.php */
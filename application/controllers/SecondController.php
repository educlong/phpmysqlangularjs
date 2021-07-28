<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SecondController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()	/*function này đc load_view vs 1 view để chạy đầu tiên (SelectView)*/
	{
		$this->load->model('FirstModel');	
/*select*/$selectData = $this->FirstModel->selectTaiSanModel();	
		$selectData=array("dataController"=>$selectData);
		$this->load->view('SelectView', $selectData, FALSE);
	}





	/*Demo 2: Delete data*/
	public function deleteTaiSanController($codeTs)
	{
		$this->load->model('FirstModel');
/*delete*/if ($this->FirstModel->deleteTaiSanModelByCodeTS($codeTs)) {
			echo "Xóa thành công";
		}
		else{
			echo "Lỗi";
		}
		$this->load->view('DeleteSuccess');
	}




	public function updateTaiSanController($codeTs)	/*gọi đến view EditView để update data*/
	{/*tại controller sẽ nhận đc $this->db->get('taisan')->result_array() lấy đc trong model*/
		$this->load->model('FirstModel');
/*update*/$updateTaiSan = $this->FirstModel->updateTaiSanModel($codeTs);
		$updateTaiSan = array("editTaiSan" => $updateTaiSan); /*đưa về 1 mảng mới xử lý đc*/
		$this->load->view('EditView', $updateTaiSan, FALSE);
	}	/*truyền updateTaiSan cho view để sửa dữ liệu*/



	public function updateTaiSanControllerFinal()
	{	/*xử lý sau khi update data xong, lấy data từ view về*/
		$codeTs=$this->input->post('inputCodeTs');	/*lấy từng trường một về, lấy trường CodeTs*/
		$nameTS=$this->input->post('inputNameTs');	/*lấy trường NameTs, lưu vào biến nameTs*/
		$dateImport=$this->input->post('inputDateImport');	/*lấy trường Ngày nhập và lưu*/
		$year=$this->input->post('inputYearKhauHao');		/*lấy trường Năm khấu hao và lưu*/
		$priceTS=$this->input->post('inputPriceTs');		/*lấy trường Zá trị Ts và lưu*/

		/*check xem lấy đc thông tin chưa:*/
		echo $codeTs.',name:'.$nameTS.',date:'.$dateImport.',year:'.$year.',price:'.$priceTS;

		/*lấy thông tin xong rồi thì controller sẽ truyền data vào model*/
		$this->load->model('FirstModel');	/*gọi hàm insertTaiSanModel trong model ra*/
/*insert*/if($this->FirstModel->updateTaiSanModelFinal($codeTs, 
												$nameTS, $dateImport, $year, $priceTS)){
			echo 'update thành công <br> <a href='.base_url().'index.php/SecondController>Back home</a>';
		}
		else{
			echo '<br> update thất bại';
		}

		/*sau khi truyền vào model, update data trong database => hiển thị data lên view*/
		/*gọi hàm selectTaiSanModel trong model ra để lấy dữ liệu*/
// /*select*/$selectData=array("dataController"=>$this->FirstModel->selectTaiSanModel());
		/*để load data lên view PHẢI đưa về mảng với key là dataController.*/
		// echo '<pre>';			/*Đoạn mã check lỗi*/
		// var_dump($selectData);
		// $this->load->view('SelectView', $selectData, FALSE);	/*truyền data lấy đc ra view*/
	}
}

/* End of file SecondController.php */
/* Location: ./application/controllers/SecondController.php */
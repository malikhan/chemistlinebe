<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Json extends CI_Controller {
	public function session($email){
		  header('Access-Control-Allow-Origin: *');
		  header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		  header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		  $data=json_decode(file_get_contents('php://input'), true);
          $this->session->sess_expiration         = 0;
          $this->session->sess_cookie_name        = 'ci_sessions';
          $this->session->sess_expire_on_close    = FALSE;
          $this->session->sess_encrypt_cookie     = FALSE;
          $this->session->sess_use_database       = TRUE;
          $this->session->sess_table_name         = 'ci_sessions';
          $this->session->sess_match_ip           = FALSE;
          $this->session->sess_match_useragent    = TRUE;
          $this->session->sess_time_to_update     = 86400;
          // $this->session->userdata('item');
          // $session_id = $this->session->userdata('session_id');
          //echo $session_id;
          $data = array(
          				'email' =>$email ,
          				 'logged_in'=>true );
          $this->session->set_userdata( array('hasSession' => true, 'email' => $data) );
          print_r($this->session->all_userdata());
	}
	
public function upload_file(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		// $data=json_decode(file_get_contents('php://input'), true);
		// $productId=$data['product_id'];
		$meta = $_POST;
  		$productId = $meta['product_id'];
		$flag=0;
		date_default_timezone_set("Asia/Karachi");
		$createTime = date("g:i a");
		$name_array=array();
		$name_array=$_FILES['file']['name'];
		$tmp_name_array=$_FILES['file']['tmp_name'];
		for($i=0;$i<count($tmp_name_array);$i++){
			if(move_uploaded_file($tmp_name_array[$i], "./uploads/".$name_array[$i])){
				echo $name_array[$i]."upload is complete <br>";
			}
			else{
				echo $name_array[$i]."has some errors in uploading </br>";
			}
		}

		
			$this->restapi_model->upload($productId,$name_array,$createTime,$flag);
		


	}
	public function delete_file(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$deletedFiles=$data['deleted_files'];
		date_default_timezone_set("Asia/Karachi");
		$deleteTime = date("g:i a");
		if(empty($data)){
			$response=array();
			$data['message']=array('status'=>false,'message'=>'invalid Request.','response'=>$response);
		}
		else{
			$data['message']=$this->restapi_model->delete_file($deletedFiles,$deleteTime);
		}
		$this->load->view('json', $data);
	}
	
	/***Login Function **/
	public function login(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$email=$data['email'];
		$password=$data['password'];
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->login($email,$password);
			// if($this->db->affected_rows()==1){
			// 	echo "hello";
			// 	$this->session($email);
			// }
			// else{
			// 	echo "sorry";
			// }
			
		}
		$this->load->view('json', $data);
	}
	public function signup(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$email=$data['email'];
		$password=$data['password'];
		$name=$data['name'];
		$phone=$data['phone'];
		$address=$data['address'];
		$userType="User";
		date_default_timezone_set("Asia/Karachi");
		$createTime = date("g:i a");
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->register($email,$password,$name,$phone,$address,$userType,$createTime);
			
			
		}
		$this->load->view('json', $data);
	}
	public function logout(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$this->load->view('json', $data);
	}
	/*** Add Products function**/
	public function add_products(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$brandId=$data['brand_id'];
		$qualityMax=$data['product_quantity'];
		$percentageOff=$data['percentage_off'];
		$productName=$data['product_name'];
		$productPrice=$data['product_price'];
		$productDescription=$data['product_description'];
		$warnings=$data['warning'];
		$ingredients=$data['ingredients'];
		$directions=$data['direction'];
		$medicalId=$data['medical_id'];
		$sideEffects=$data['side_effects'];
		// $productDetails=$data['product_details'];
		$preferences=$data['preferences'];
		date_default_timezone_set("Asia/Karachi");
		$createTime = date("g:i a");
		$flag=0;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
		}else{
			
				
				$data['message']=$this->restapi_model->add_products($medicalId,$brandId,$productName,$productPrice,$productDescription,$percentageOff,$qualityMax,$createTime,$flag,$preferences,$warnings,$ingredients,$directions,$sideEffects);
				
		}
		$this->load->view('json', $data);
	}
	/*** Edit Products function**/
	public function edit_products(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$brandId=$data['brand_id'];
		$medicalId=$data['medical_id'];
		$productId=$data['product_id'];
		// $productId = (int)$product_id;
		// echo $productId;
		$productName=$data['product_name'];
		$productPrice=$data['product_price'];
		$productDescription=$data['product_description'];
		$percentageOff=$data['percentage_off'];
		
		$qualityMax=$data['quality_max'];
		$warnings=$data['warning'];
		$ingredients=$data['ingredients'];
		$directions=$data['direction'];
		$sideEffects=$data['side_effects'];
		
		$preferences=$data['preferences'];
		date_default_timezone_set("Asia/Karachi");
		$updateTime = date("g:i a");
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
		}else{
				$data['message']=$this->restapi_model->edit_products($preferences,$productId,$brandId,$medicalId,$productName,$productPrice,$productDescription,$percentageOff,$qualityMax,$updateTime,$warnings,$ingredients,$directions,$sideEffects);
			}
		$this->load->view('json', $data);
	}
	/*** Delete Products function**/
	public function delete_products(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS,PUT");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$productId=$data['product_id'];
		date_default_timezone_set("Asia/Karachi");
		$deleteTime = date("g:i a");
		$flag=1;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->delete_products($productId,$flag,$deleteTime);
		}
		$this->load->view('json', $data);
	}
	/*** Add Brand function**/
	public function add_brand(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
	
		$brandName=$data['brand_name'];
		date_default_timezone_set("Asia/Karachi");
		$createTime = date("g:i a");
		$flag=0;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->add_brand($brandName,$flag,$createTime);
		}
		$this->load->view('json', $data);

	}
	/***Edit Brand Function **/
	public function edit_brand(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$brandId=$data['brand_id'];
		$brandName=$data['brand_name'];
		date_default_timezone_set("Asia/Karachi");
		$updateTime = date("g:i a");
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->edit_brand($brandId,$brandName,$updateTime);
		}
		$this->load->view('json', $data);
	}
	/*** Delete Brand function**/
	public function delete_brand(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS,PUT");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$brandId=$data['brand_id'];
		date_default_timezone_set("Asia/Karachi");
		$deleteTime = date("g:i a");
		$flag=1;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->delete_brand($brandId,$flag,$deleteTime);
		}
		$this->load->view('json', $data);
	}
	/***Add Medical Condition function**/
	public function add_medical_condition(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$condition=$data['condition'];
		date_default_timezone_set("Asia/Karachi");
		$createTime = date("g:i a");
		$flag=0;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->add_medical_condition($condition,$flag,$createTime);
		}
		$this->load->view('json', $data);

	}
	/***Edit Medical Condition Function **/
	public function edit_medical_condition(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$medicalId=$data['medical_id'];
		$condition=$data['condition'];
		date_default_timezone_set("Asia/Karachi");
		$updateTime = date("g:i a");
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->edit_medical_condition($medicalId,$condition,$updateTime);
		}
		$this->load->view('json', $data);
	}
	/*** Delete Medical Condition function**/
	public function delete_medical_condition(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS,PUT");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$medicalId=$data['medical_id'];
		date_default_timezone_set("Asia/Karachi");
		$deleteTime = date("g:i a");
		$flag=1;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->delete_medical_condition($medicalId,$flag,$deleteTime);
		}
		$this->load->view('json', $data);
	}
	/***Add Preference function**/
	public function add_preference(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$quantity=$data['quantity'];
		$subTasks=$data['sub_tasks'];
		date_default_timezone_set("Asia/Karachi");
		$createTime = date("g:i a");
		$flag=0;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->add_preference($quantity,$subTasks,$flag,$createTime);
		}
		$this->load->view('json', $data);
	}
	/***Edit Preference Function **/
	public function edit_preference(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		
		$preferenceId=$data['preference_id'];
		$quantity=$data['quantity'];
		$subTasks=$data['sub_tasks'];
		date_default_timezone_set("Asia/Karachi");
		$updateTime = date("g:i a");
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->edit_preference($preferenceId,$quantity,$subTasks,$updateTime);
		}
		$this->load->view('json', $data);
	}
	/*** Delete Preference Function**/
	public function delete_preference(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$preferenceId=$data['preference_id'];
		date_default_timezone_set("Asia/Karachi");
		$deleteTime = date("g:i a");
		$flag=1;
		if(empty($data)){
			$response = array();
			$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

		}else{
			$data['message']=$this->restapi_model->delete_preference($preferenceId,$flag,$deleteTime);
		}
		$this->load->view('json', $data);
	}
	/*** Getting all brands details**/
	public function brands_detail(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$data['message']=$this->restapi_model->brands_detail();
		$this->load->view('json', $data);
	}
	/*** Getting medical condition detail **/
	public function medical_condition_details(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$data['message']=$this->restapi_model->medical_condition_details();
		$this->load->view('json', $data);
	}
	/*** Getting preference details **/
	public function preference_details(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$data['message']=$this->restapi_model->preference_details();
		$this->load->view('json', $data);
	}
	/***Getting catagories **/
	public function get_catagories(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$data['message']=$this->restapi_model->get_catagories();
		$this->load->view('json', $data);
	}
	/***All products list**/
	public function get_product_list(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		$data=json_decode(file_get_contents('php://input'), true);
		$data['message']=$this->restapi_model->get_product_list();
		$this->load->view('json', $data);
	}
	public function __construct() {
        	parent::__construct();
        	$this->load->library('session');
        	
        	}
    }
?>
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
			$user=$data['user'];
			$email=$user['email'];
			$password=$user['password'];
			if(empty($user['name'])){
				$name="";
			}
			else{
				$name=$user['name'];
			}
			if(empty($user['phone'])){
				$phone="";
			}
			else{
				$phone=$user['phone'];
			}
			if(empty($user['address'])){
				$address="";
			}
			else{
				$address=$user['address'];
			}
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
		public function UserSignUp(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$firstName1=$data['first_name1'];
			$lastName1=$data['last_name1'];
			$email=$data['email'];
			$postCode1=$data['post_code1'];
			$addressOne=$data['address_one'];
			$addressTwo=$data['address_two'];
			$password=$data['password'];
			$phoneNumber1=$data['phone_number1'];
			date_default_timezone_set("Asia/Karachi");
			$createTime = date("g:i a");
			$flag=0;
			$user_type=$data['user_type'];
			if($user_type=="user"){
				$userType="user";
				$category=$data['category'];
				$day=$data['day'];
				$month=$data['month'];
				$year=$data['year'];
				$gender=$data['gender'];
				$contactMethod=$data['con_method'];
				$city=$data['city'];
			}
			if($user_type=="guest_user"){
				$userType="guest user";
				$addressThree=$data['address_three'];
				$addressFour=$data['address_four'];
				$postCode2=$data['post_code2'];
				$firstName2=$data['first_name2'];
				$lastName2=$data['last_name2'];
				$phoneNumber2=$data['phone_number2'];
				$postCode3=$data['post_code3'];
				$addressFive=$data['address_five'];
				$addressSix=$data['address_six'];
				$addressSeven=$data['address_seven'];
				$addressEight=$data['address_eight'];
				$postCode4=$data['post_code4'];
				$manualBillingAddressOne=$data['manual_billing_address_one'];
				$manualBillingAddressTwo=$data['manual_billing_address_two'];
				$manualBillingAddressThree=$data['manual_billing_address_three'];
				$manualBillingTown=$data['manual_billing_town'];
				$manualBillingPostCode=$data['manual_billing_post_code'];
				$manualDeliveryAddressOne=$data['manual_delivery_address_one'];
				$manualDeliveryAddressTwo=$data['manual_delivery_address_two'];
				$manualDeliveryAddressThree=$data['manual_delivery_address_three'];
				$manualDeliveryTown=$data['manual_delivery_town'];
				$manualDeliveryPostCode=$data['manual_delivery_post_code'];
			}
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

			}else{
				if($user_type=="user"){
					$data['message']=$this->restapi_model->registerUser($userType,$firstName1,$lastName1,$category,$day,$month,$year,$gender,$postCode1,$addressOne,$addressTwo,$city,$phoneNumber1,$email,$password,$createTime,$contactMethod);
				}
				if($user_type=="guest_user"){
					$data['message']=$this->restapi_model->registerGuestUser($firstName1,$lastName1,$email,$postCode1,$addressOne,$addressTwo,$phoneNumber1,$password,$createTime,$flag,$userType,$addressThree,$addressFour,$postCode2,$firstName2,$lastName2,$phoneNumber2,$postCode3,$addressFive,$addressSix,$addressSeven,$addressEight,$postCode4,$manualBillingAddressOne,$manualBillingAddressTwo,$manualBillingAddressThree,$manualBillingTown,$manualBillingPostCode,$manualDeliveryAddressOne,$manualDeliveryAddressTwo,$manualDeliveryAddressThree,$manualDeliveryTown,$manualDeliveryPostCode);
				}
			}
			$this->load->view('json', $data);
		}
		public function editUser(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$userId=$data['user_id'];
			$firstName1=$data['first_name1'];
			$lastName1=$data['last_name1'];
			$email=$data['email'];
			$postCode1=$data['post_code1'];
			$addressOne=$data['address_one'];
			$addressTwo=$data['address_two'];
			$password=$data['password'];
			$phoneNumber1=$data['phone_number1'];
			date_default_timezone_set("Asia/Karachi");
			$updateTime = date("g:i a");
			$user_type=$data['user_type'];
			if($user_type=="user"){
				$userType="user";
				$category=$data['category'];
				$day=$data['day'];
				$month=$data['month'];
				$year=$data['year'];
				$gender=$data['gender'];
				$city=$data['city'];
				$contactMethod=$data['con_method'];
			}
			if($user_type=="guest_user"){
				$userType="guest user";
				$addressThree=$data['address_three'];
				$addressFour=$data['address_four'];
				$postCode2=$data['post_code2'];
				$firstName2=$data['first_name2'];
				$lastName2=$data['last_name2'];
				$phoneNumber2=$data['phone_number2'];
				$postCode3=$data['post_code3'];
				$addressFive=$data['address_five'];
				$addressSix=$data['address_six'];
				$addressSeven=$data['address_seven'];
				$addressEight=$data['address_eight'];
				$postCode4=$data['post_code4'];
				$manualBillingAddressOne=$data['manual_billing_address_one'];
				$manualBillingAddressTwo=$data['manual_billing_address_two'];
				$manualBillingAddressThree=$data['manual_billing_address_three'];
				$manualBillingTown=$data['manual_billing_address_town'];
				$manualBillingPostCode=$data['manual_billing_address_post_code'];
				$manualDeliveryAddressOne=$data['manual_delivery_address_one'];
				$manualDeliveryAddressTwo=$data['manual_delivery_address_two'];
				$manualDeliveryAddressThree=$data['manual_delivery_address_three'];
				$manualDeliveryTown=$data['manual_delivery_address_town'];
				$manualDeliveryPostCode=$data['manual_delivery_address_post_code'];
			}
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				if($user_type=="user"){
					$data['message']=$this->restapi_model->editUser($userId,$userType,$firstName1,$lastName1,$category,$day,$month,$year,$gender,$postCode1,$addressOne,$addressTwo,$city,$phoneNumber1,$email,$password,$updateTime,$contactMethod);
				}
				if($user_type=="guest_user"){
					$data['message']=$this->restapi_model->editGuestUser($userId,$firstName1,$lastName1,$email,$postCode1,$addressOne,$addressTwo,$phoneNumber1,$password,$updateTime,$userType,$addressThree,$addressFour,$postCode2,$firstName2,$lastName2,$phoneNumber2,$postCode3,$addressFive,$addressSix,$addressSeven,$addressEight,$postCode4,$manualBillingAddressOne,$manualBillingAddressTwo,$manualBillingAddressThree,$manualBillingTown,$manualBillingPostCode,$manualDeliveryAddressOne,$manualDeliveryAddressTwo,$manualDeliveryAddressThree,$manualDeliveryTown,$manualDeliveryPostCode);
				}
			}
			$this->load->view('json', $data);
		}
		/*** Delete a user **/
		public function deleteUser(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$userId=$data['user_id'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
					$data['message']=$this->restapi_model->delete_user($userId);
					
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
			$medRackId=$data['med_rack_id'];
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
			$retailPrice=$data['rrp'];
			$similarProduct=$data['similar_products'];
			$restrictProduct=$data['restrict_products'];
			// $productDetails=$data['product_details'];
			$preferences=$data['preferences'];
			date_default_timezone_set("Asia/Karachi");
			$createTime = date("g:i a");
			$flag=0;
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
					$data['message']=$this->restapi_model->add_products($medicalId,$brandId,$medRackId,$productName,$productPrice,$productDescription,$percentageOff,$qualityMax,$createTime,$flag,$preferences,$warnings,$ingredients,$directions,$sideEffects,$retailPrice,$similarProduct,$restrictProduct);
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
			$medRackId=$data['med_rack_id'];
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
			$retailPrice=$data['rrp'];
			$preferences=$data['preferences'];
			$similarProduct=$data['similar_products'];
			date_default_timezone_set("Asia/Karachi");
			$updateTime = date("g:i a");
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
					$data['message']=$this->restapi_model->edit_products($preferences,$productId,$brandId,$medRackId,$medicalId,$productName,$productPrice,$productDescription,$percentageOff,$qualityMax,$updateTime,$warnings,$ingredients,$directions,$sideEffects,$retailPrice,$similarProduct);
				}
			$this->load->view('json', $data);
		}
		/*** Delete Products function**/
		public function delete_products(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS,PUT,DELETE");
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
			if(empty($data['brand_name'])){
				$brandName="";
			}
			else{
			$brandName=$data['brand_name'];
			}
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
		/*** Add Medical Rack**/
		public function add_med_rack(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			if(empty($data['med_rack_name'])){
				$medRackName="";
			}
			else{
			$medRackName=$data['med_rack_name'];
			}
			date_default_timezone_set("Asia/Karachi");
			$createTime = date("g:i a");
			$flag=0;
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

			}else{
				$data['message']=$this->restapi_model->add_med_rack($medRackName,$flag,$createTime);
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
		/***Edit Medical Rack Function **/
		public function edit_med_rack(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$medRackId=$data['med_rack_id'];
			$medRackName=$data['med_rack_name'];
			date_default_timezone_set("Asia/Karachi");
			$updateTime = date("g:i a");
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

			}else{
				$data['message']=$this->restapi_model->edit_med_rack($medRackId,$medRackName,$updateTime);
			}
			$this->load->view('json', $data);
		}
		/*** Delete Brand function**/
		public function delete_brand(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
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
		/*** Delete Medical rack function**/
		public function delete_med_rack(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS,PUT");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$medRackId=$data['med_rack_id'];
			date_default_timezone_set("Asia/Karachi");
			$deleteTime = date("g:i a");
			$flag=1;
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->delete_med_rack($medRackId,$flag,$deleteTime);
			}
			$this->load->view('json', $data);
		}
		/***Add Medical Condition function**/
		public function add_medical_condition(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			if(empty($data['condition'])){
				$condition="";
			}
			else{
			$condition=$data['condition'];
			}
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
		public function similar_products_list(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$productId=$data['product_id'];
			echo $productId;
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->similar_products_list($productId);
			}
			$this->load->view('json', $data);
		}
		public function add_order(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$userId=$data['user_id'];
			$orderJson = json_encode($data);
			date_default_timezone_set("Asia/Karachi");
			$createTime = date("g:i a");
			$createDate=date('m-d-Y');
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->add_order($userId,$orderJson,$createTime,$createDate);
			}
			$this->load->view('json', $data);
		}
		public function get_products_name(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$data['message']=$this->restapi_model->get_products_name();
			$this->load->view('json', $data);
		}
		public function add_question(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$userId=$data['user_id'];
			$productId=$data['product_id'];
			$medicineFlag=$data['medicine_flag'];
			$age=$data['age'];
			$symptoms=$data['symptom'];
			$healthConditionFlag=$data['health_condition_flag'];
			$healthCondition=$data['health_condition'];
			$medicationFlag=$data['medication_flag'];
			$medication=$data['medication'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->add_question($userId,$productId,$medicineFlag,$age,$symptoms,$healthConditionFlag,$healthCondition,$medicationFlag,$medication);
			}
			$this->load->view('json', $data);
		}
		public function edit_question(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$questionId=$data['question_id'];
			$medicineFlag=$data['medicine_flag'];
			$age=$data['age'];
			$symptoms=$data['symptom'];
			$healthConditionFlag=$data['health_condition_flag'];
			$healthCondition=$data['health_condition'];
			$medicationFlag=$data['medication_flag'];
			$medication=$data['medication'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);

			}else{
				$data['message']=$this->restapi_model->edit_question($questionId,$medicineFlag,$age,$symptoms,$healthConditionFlag,$healthCondition,$medicationFlag,$medication);
			}
			$this->load->view('json', $data);
		}
		public function get_orders_list(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$data['message']=$this->restapi_model->get_orders_list();
			$this->load->view('json', $data);
		}
		public function add_cargo_service(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$cargoTitle=$data['cargo_title'];
			$cargoCost=$data['cargo_cost'];
			$cargoDetails=$data['cargo_details'];
			$cargoPrefFlag=$data['cargo_pref_flag'];
			$cargoDefaultFlag=$data['cargo_default_flag'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->add_cargo_service($cargoTitle,$cargoCost,$cargoDetails,$cargoPrefFlag,$cargoDefaultFlag);
			}
			$this->load->view('json', $data);
		}
		public function edit_cargo_service(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$cargoId=$data['cargo_id'];
			$cargoTitle=$data['cargo_title'];
			$cargoCost=$data['cargo_cost'];
			$cargoDetails=$data['cargo_details'];
			$cargoPrefFlag=$data['cargo_pref_flag'];
			$cargoDefaultFlag=$data['cargo_default_flag'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->edit_cargo_service($cargoId,$cargoTitle,$cargoCost,$cargoDetails,$cargoPrefFlag,$cargoDefaultFlag);
			}
			$this->load->view('json', $data);
		}
		public function delete_cargo_service(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$cargoId=$data['cargo_id'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->delete_cargo_service($cargoId);
			}
			$this->load->view('json', $data);
		}
		public function get_cargo_items_list(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$data['message']=$this->restapi_model->get_cargo_items_list();
			$this->load->view('json',$data);
		}
		public function get_all_cargo_items(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$data['message']=$this->restapi_model->get_all_cargo_items();
			$this->load->view('json',$data);
		}
		/**Forgot Password ***/
		public function forgot_password(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$email=$data['email'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->forgot_password($email);
			}
			$this->load->view('json', $data);
		}
		/** Reset password  **/
		public function reset_password(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$resetPassword=$data['reset_pass'];
			$email=$data['email'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->reset_password($resetPassword,$email);
			}
			$this->load->view('json', $data);
		}
		public function forgot_password_admin(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$email=$data['email'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->forgot_password_admin($email);
			}
			$this->load->view('json', $data);
		}
		/*** check email if already exists  **/
		public function check_email(){
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
			header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
			$data=json_decode(file_get_contents('php://input'), true);
			$email=$data['email'];
			if(empty($data)){
				$response = array();
				$data['message']=array('status' => false ,'message' => 'invalid Request.','response' => $response);
			}else{
				$data['message']=$this->restapi_model->check_email($email);
			}
			$this->load->view('json', $data);
		}
		public function __construct(){
	        parent::__construct();
	        $this->load->library('session');

	    }
	}
?>
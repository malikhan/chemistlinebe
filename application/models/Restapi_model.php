<?php
	if (!defined('BASEPATH')) {
	    exit('No direct script access allowed');
	}
	class Restapi_model extends CI_Model{
		/***Login Function **/
		public function login($email,$password){
			$response = array();
			$query = $this->db->query('SELECT `user_id` FROM `asgn_user` WHERE `email`=('.$this->db->escape($email).')  AND `password`= ('.$this->db->escape($password).')');
			if($query->num_rows()>0){
				$user = $query->row();
	            $user = $user->user_id;
	            $response[0] = $this->db->query('SELECT * FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($user).')')->row();
				$data = array('status' => true ,'message' => 'Login Successfully','response' => $response);
	            return $data;
			}
			else{
				
				$data = array('status' => false ,'message' => 'credentials are wrong','response' => $response);
	            return $data;
			}
		}
		/*** Upload image **/
		public function upload($productId,$name_array,$createTime,$flag){
			foreach ($name_array as $files):
				$query=$this->db->query('INSERT INTO `asoc_pro_to_multimedia`(`product_id`,`files`,`create_time`,`delete_flag`) VALUES('.$this->db->escape($productId).','.$this->db->escape($files).','.$this->db->escape($createTime).','.$this->db->escape($flag).")");
			endforeach;
			$message="images are added successfully";
			return $message;	
		}
		public function delete_file($deletedFiles,$deleteTime){
			foreach ($deletedFiles as $file):
				$fileId=$file['file_id'];
				$fileName=$file['files'];
				$query=$this->db->query('DELETE  FROM `asoc_pro_to_multimedia` WHERE `file_id`=('.$this->db->escape($fileId).')');
				if($query){
				 	if($fileId!="" || $fileName!=""){
						// if(unlink("uploads/".$fileName)):
			 			echo 'File '.$fileName.' has been deleted';
			 			// endif;
			 		}
			 	}
			 	else{
			 		echo "Sorry ".$fileName."has not been deleted from database";
			 	}
			endforeach;
		}
		/*** Add User **/
		public function register($email,$password,$name,$phone,$address,$userType,$createTime){
			$response = array();
			$query=$this->db->query('SELECT * FROM `asgn_user` WHERE `email`=('.$this->db->escape($email).')');
			if($query->num_rows()>0){
				$data = array('status' => false ,'message' => 'email is already registerd','response' => $response);
	            return $data;
			}
		   else{
				$query=$this->db->query('INSERT INTO `asgn_user`(`email`,`password`,`name`,`phone_1`,`address_4`,`user_type`,`create_time`) VALUES('.$this->db->escape($email).','.$this->db->escape($password).','.$this->db->escape($name).','.$this->db->escape($phone).','.$this->db->escape($address).','.$this->db->escape($userType).','.$this->db->escape($createTime).")");
				$user_id=$this->db->insert_id();
				$response[0]=$this->db->query('SELECT * FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($user_id).')')->row();
				$data = array('status' => true ,'message' => 'Add user Successfully','response' => $response);
		        return $data;
	    	}
		}
		/*** Add user **/
		public function registerUser($userType,$firstName1,$lastName1,$category,$day,$month,$year,$gender,$postCode1,$addressOne,$addressTwo,$city,$phoneNumber1,$email,$password,$createTime,$contactMethod){
			$response = array();
			$checkEmail=$this->db->query('SELECT * FROM `asgn_user` WHERE `email`=('.$this->db->escape($email).')');
			if($checkEmail->num_rows()>0){
				$data = array('status' => false ,'message' => 'email is already registerd','response' => $response);
	            return $data;
			}
			else{
				$query=$this->db->query('INSERT INTO `asgn_user`(`user_type`,`email`,`password`,`phone_1`,`city`,`address_2`,`address_1`,`post_code1`,`gender`,`dob_year`,`dob_month`,`dob_day`,`last_name1`,`first_name1`,`category`,`create_time`,`con_method`) VALUES('.$this->db->escape($userType).','.$this->db->escape($email).','.$this->db->escape($password).','.$this->db->escape($phoneNumber1).','.$this->db->escape($city).','.$this->db->escape($addressTwo).','.$this->db->escape($addressOne).','.$this->db->escape($postCode1).','.$this->db->escape($gender).','.$this->db->escape($year).','.$this->db->escape($month).','.$this->db->escape($day).','.$this->db->escape($lastName1).','.$this->db->escape($firstName1).','.$this->db->escape($category).','.$this->db->escape($createTime).','.$this->db->escape($contactMethod).")");
				$user_id=$this->db->insert_id();
				$response[0]=$this->db->query('SELECT * FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($user_id).')')->row();
				$data = array('status' => true ,'message' => 'Add user Successfully','response' => $response);
			    return $data;
			}    
		}
		/*** Add guest user **/
		public function registerGuestUser($firstName1,$lastName1,$email,$postCode1,$addressOne,$addressTwo,$phoneNumber1,$password,$createTime,$flag,$userType,$addressThree,$addressFour,$postCode2,$firstName2,$lastName2,$phoneNumber2,$postCode3,$addressFive,$addressSix,$addressSeven,$addressEight,$postCode4,$manualBillingAddressOne,$manualBillingAddressTwo,$manualBillingAddressThree,$manualBillingTown,$manualBillingPostCode,$manualDeliveryAddressOne,$manualDeliveryAddressTwo,$manualDeliveryAddressThree,$manualDeliveryTown,$manualDeliveryPostCode){
			$response = array();
			$checkEmail=$this->db->query('SELECT * FROM `asgn_user` WHERE `email`=('.$this->db->escape($email).')');
			if($checkEmail->num_rows()>0){
				$data = array('status' => false ,'message' => 'email is already registerd','response' => $response);
	            return $data;
			}
			else{
				$query=$this->db->query('INSERT INTO `asgn_user`(`first_name1`,`last_name1`,`email`,`post_code1`,`address_1`,`address_2`,`phone_1`,`password`,`create_time`,`delete_flag`,`user_type`,`address_3`,`address_4`,`post_code2`,`first_name2`,`last_name2`,`phone_2`,`post_code3`,`address_5`,`address_6`,`address_7`,`address_8`,`post_code4`,`manual_billing_address_one`,`manual_billing_address_two`,`manual_billing_address_three`,`manual_billing_address_town`,`manual_billing_address_post_code`,`manual_delivery_address_one`,`manual_delivery_address_two`,`manual_delivery_address_three`,`manual_delivery_address_town`,`manual_delivery_address_post_code`) VALUES('.$this->db->escape($firstName1).','.$this->db->escape($lastName1).','.$this->db->escape($email).','.$this->db->escape($postCode1).','.$this->db->escape($addressOne).','.$this->db->escape($addressTwo).','.$this->db->escape($phoneNumber1).','.$this->db->escape($password).','.$this->db->escape($createTime).','.$this->db->escape($flag).','.$this->db->escape($userType).','.$this->db->escape($addressThree).','.$this->db->escape($addressFour).','.$this->db->escape($postCode2).','.$this->db->escape($firstName2).','.$this->db->escape($lastName2).','.$this->db->escape($phoneNumber2).','.$this->db->escape($postCode3).','.$this->db->escape($addressFive).','.$this->db->escape($addressSix).','.$this->db->escape($addressSeven).','.$this->db->escape($addressEight).','.$this->db->escape($postCode4).','.$this->db->escape($manualBillingAddressOne).','.$this->db->escape($manualBillingAddressTwo).','.$this->db->escape($manualBillingAddressThree).','.$this->db->escape($manualBillingTown).','.$this->db->escape($manualBillingPostCode).','.$this->db->escape($manualDeliveryAddressOne).','.$this->db->escape($manualDeliveryAddressTwo).','.$this->db->escape($manualDeliveryAddressThree).','.$this->db->escape($manualDeliveryTown).','.$this->db->escape($manualDeliveryPostCode).")");
				$user_id=$this->db->insert_id();
				$response[0]=$this->db->query('SELECT * FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($user_id).')')->row();
				$data = array('status' => true ,'message' => 'Add guest user Successfully','response' => $response);
			    return $data;
			}
		}
		/*** Edit user **/
		public function editUser($userId,$userType,$firstName1,$lastName1,$category,$day,$month,$year,$gender,$postCode1,$addressOne,$addressTwo,$city,$phoneNumber1,$email,$password,$updateTime,$contactMethod){
			$response = array();
			$query = $this->db->query('UPDATE `asgn_user` SET `user_type`=('.$this->db->escape($userType).'),`first_name1`=('.$this->db->escape($firstName1).'),`last_name1`=('.$this->db->escape($lastName1).'),`category`=('.$this->db->escape($category).'),`dob_day`=('.$this->db->escape($day).'),`dob_month`=('.$this->db->escape($month).'),`dob_year`=('.$this->db->escape($year).'),`gender`=('.$this->db->escape($gender).'),`post_code1`=('.$this->db->escape($postCode1).'),`address_1`=('.$this->db->escape($addressOne).') ,`address_2`=('.$this->db->escape($addressTwo).') , `city` =('.$this->db->escape($city).') ,`phone_1`=('.$this->db->escape($phoneNumber1).'),`email`=('.$this->db->escape($email).'),`con_method`=('.$this->db->escape($contactMethod).'),`password`=('.$this->db->escape($password).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `user_id`=('.$this->db->escape($userId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($userId).')')->row();
				$data = array('status' => true ,'message' => 'Update user Successfully','response' => $response);
			    return $data;
			}
		}
		/*** Edit guest user **/
		public function editGuestUser($userId,$firstName1,$lastName1,$email,$postCode1,$addressOne,$addressTwo,$phoneNumber1,$password,$updateTime,$userType,$addressThree,$addressFour,$postCode2,$firstName2,$lastName2,$phoneNumber2,$postCode3,$addressFive,$addressSix,$addressSeven,$addressEight,$postCode4,$manualBillingAddressOne,$manualBillingAddressTwo,$manualBillingAddressThree,$manualBillingTown,$manualBillingPostCode,$manualDeliveryAddressOne,$manualDeliveryAddressTwo,$manualDeliveryAddressThree,$manualDeliveryTown,$manualDeliveryPostCode){
			$response = array();
			$query = $this->db->query('UPDATE `asgn_user` SET `user_type`=('.$this->db->escape($userType).'),`first_name1`=('.$this->db->escape($firstName1).'),`last_name1`=('.$this->db->escape($lastName1).'),`email`=('.$this->db->escape($email).'),`post_code1`=('.$this->db->escape($postCode1).'),`address_1`=('.$this->db->escape($addressOne).'),`address_2`=('.$this->db->escape($addressTwo).'),`phone_1`=('.$this->db->escape($phoneNumber1).'),`password`=('.$this->db->escape($password).') ,`update_time`=('.$this->db->escape($updateTime).') , `address_3` =('.$this->db->escape($addressThree).') ,`address_4`=('.$this->db->escape($addressFour).'),`post_code2`=('.$this->db->escape($postCode2).'),`first_name2`=('.$this->db->escape($firstName2).'),`last_name2`=('.$this->db->escape($lastName2).'),`phone_2`=('.$this->db->escape($phoneNumber2).'),`post_code3`=('.$this->db->escape($postCode3).'),`address_5`=('.$this->db->escape($addressFive).'),`address_6`=('.$this->db->escape($addressSix).'),`address_7`=('.$this->db->escape($addressSeven).'),`address_8`=('.$this->db->escape($addressEight).'),`post_code4`=('.$this->db->escape($postCode4).'),`manual_billing_address_one`=('.$this->db->escape($manualBillingAddressOne).'),`manual_billing_address_two`=('.$this->db->escape($manualBillingAddressTwo).'),`manual_billing_address_three`=('.$this->db->escape($manualBillingAddressThree).'),`manual_billing_address_town`=('.$this->db->escape($manualBillingTown).'),`manual_billing_address_post_code`=('.$this->db->escape($manualBillingPostCode).'),`manual_delivery_address_one`=('.$this->db->escape($manualDeliveryAddressOne).'),`manual_delivery_address_two`=('.$this->db->escape($manualDeliveryAddressTwo).'),`manual_delivery_address_three`=('.$this->db->escape($manualDeliveryAddressThree).'),`manual_delivery_address_town`=('.$this->db->escape($manualDeliveryTown).'),`manual_delivery_address_post_code`=('.$this->db->escape($manualDeliveryPostCode).')WHERE `user_id`=('.$this->db->escape($userId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($userId).')')->row();
				$data = array('status' => true ,'message' => 'Update guest user Successfully','response' => $response);
			    return $data;
			}
		}
		/** Delete a user **/
		public function delete_user($userId){
			$response=array();
			$deleteQuery=$this->db->query('DELETE FROM `asgn_user` WHERE `user_id`=('.$this->db->escape($userId).')');
			if($deleteQuery){
				$data=array('status'=> true, 'message'=> 'Delete a user successfully', 'response'=> $response);
				return $data;
			}
		}
		/*** Add Products **/
		public function add_products($medicalId,$brandId,$medRackId,$productName,$productPrice,$productDescription,$percentageOff,$qualityMax,$createTime,$flag,$preferences,$warnings,$ingredients,$directions,$sideEffects,$retailPrice,$similarProduct,$restrictProduct){
			$response = array();
			$query=$this->db->query('INSERT INTO `asgn_product`(`name`,`price`,`description`,`percentage_off`,`quality_max`,`warning`,`ingredients`,`direction`,`side_effects`,`rrp`,`create_time`,`delete_flag`) VALUES('.$this->db->escape($productName).','.$this->db->escape($productPrice).','.$this->db->escape($productDescription).','.$this->db->escape($percentageOff).','.$this->db->escape($qualityMax).','.$this->db->escape($warnings).','.$this->db->escape($ingredients).','.$this->db->escape($directions).','.$this->db->escape($sideEffects).','.$this->db->escape($retailPrice).','.$this->db->escape($createTime).','.$this->db->escape($flag).")");
			$product_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `asgn_product` WHERE `product_id`=('.$this->db->escape($product_id).')')->row();
			if($medicalId!=null):
				foreach ($medicalId as $condition):
					$medical_id=$condition['medical_id'];
					$query1=$this->db->query('INSERT INTO `asoc_pro_to_medical_condition`(`medical_id`,`product_id`,`create_time`,`delete_flag`) VALUES('.$this->db->escape($medical_id).','.$this->db->escape($product_id).','.$this->db->escape($createTime).','.$this->db->escape($flag).")");
				endforeach;
			endif;
			if($brandId!=null):
				$query2=$this->db->query('INSERT INTO `asoc_pro_to_brand`(`brand_id`,`product_id`,`create_time`,`delete_flag`) VALUES('.$this->db->escape($brandId).','.$this->db->escape($product_id).','.$this->db->escape($createTime).','.$this->db->escape($flag).")");
			endif;
			if($medRackId!=null):
				$query4=$this->db->query('INSERT INTO `asoc_pro_to_med_rack`(`med_rack_id`,`product_id`,`create_time`,`delete_flag`) VALUES('.$this->db->escape($medRackId).','.$this->db->escape($product_id).','.$this->db->escape($createTime).','.$this->db->escape($flag).")");
			endif;
			$prefId = null;
			$prefeFlag = null;
			foreach ($preferences as $pref):
				$prefId = $pref['preference_id'];
				$prefeFlag = $pref['preference'];
				if($prefId!=null):
					$query3=$this->db->query('INSERT INTO `asoc_pro_to_pref`(`product_id`,`preference_id`,`flag`,`create_time`,`delete_flag`) VALUES('.$this->db->escape($product_id).','.$this->db->escape($prefId).','.$this->db->escape($prefeFlag).','.$this->db->escape($createTime).','.$this->db->escape($flag).")");
				endif;
			endforeach;
			if($similarProduct!=null):
				foreach ($similarProduct as $similarPro):
					$similar_pro=$similarPro['similar_product'];
					$query1=$this->db->query('INSERT INTO `asoc_pro_to_similarPro`(`product_id`,`similar_pro_id`,`delete_flag`) VALUES('.$this->db->escape($product_id).','.$this->db->escape($similar_pro).','.$this->db->escape($flag).")");
				endforeach;
			endif;
			if($restrictProduct!=null):
				foreach ($restrictProduct as $restrictPro):
					$restrict_pro=$restrictPro['restrict_product'];
					$query1=$this->db->query('INSERT INTO `asoc_pro_to_restrict_pro`(`product_id`,`restrict_pro_id`,`delete_flag`) VALUES('.$this->db->escape($product_id).','.$this->db->escape($restrict_pro).','.$this->db->escape($flag).")");
				endforeach;
			endif;
			$data = array('status' => true ,'message' => 'Add product Successfully','response' => $response);
	        return $data;
		}
		/*** Edit Products **/
		public function edit_products($preferences,$productId,$brandId,$medRackId,$medicalId,$productName,$productPrice,$productDescription,$percentageOff,$qualityMax,$updateTime,$warnings,$ingredients,$directions,$sideEffects,$retailPrice,$similarProduct){
			$response = array();
			$query = $this->db->query('UPDATE `asgn_product` SET `name`=('.$this->db->escape($productName).'),`price`=('.$this->db->escape($productPrice).'),`description`=('.$this->db->escape($productDescription).'),`percentage_off`=('.$this->db->escape($percentageOff).'),`quality_max`=('.$this->db->escape($qualityMax).'),`side_effects`=('.$this->db->escape($sideEffects).'),`warning`=('.$this->db->escape($warnings).'),`ingredients`=('.$this->db->escape($ingredients).'),`direction`=('.$this->db->escape($directions).'),`update_time`=('.$this->db->escape($updateTime).') ,`rrp`=('.$this->db->escape($retailPrice).') WHERE `product_id`=('.$this->db->escape($productId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `asgn_product` WHERE `product_id`=('.$this->db->escape($productId).')')->row();
				$deleteQuery=$this->db->query('DELETE FROM `asoc_pro_to_medical_condition` WHERE `product_id`=('.$this->db->escape($productId).')');
				if($medicalId!=null):
					foreach ($medicalId as $condition):
						$medical_id=$condition['medical_id'];
						if($medical_id!=null):
							$insertQuery=$this->db->query('INSERT INTO `asoc_pro_to_medical_condition`(`medical_id`,`product_id`,`create_time`) VALUES('.$this->db->escape($medical_id).','.$this->db->escape($productId).','.$this->db->escape($updateTime).")");
						endif;
					endforeach;
				endif;
				if($brandId!=null):
					$query2=$this->db->query('UPDATE `asoc_pro_to_brand` SET `brand_id`=('.$this->db->escape($brandId).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `product_id`=('.$this->db->escape($productId).')');
				endif;
				if($medRackId!=null):
					$query4=$this->db->query('UPDATE `asoc_pro_to_med_rack` SET `med_rack_id`=('.$this->db->escape($medRackId).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `product_id`=('.$this->db->escape($productId).')');
				endif;
				$prefId = null;
				$prefeFlag = null;
				foreach ($preferences as $pref):
					$prefId = $pref['preference_id'];
					$prefeFlag = $pref['preference'];
					if($prefId!=null):
						$query3=$this->db->query('UPDATE `asoc_pro_to_pref` SET `flag`=('.$this->db->escape($prefeFlag).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `product_id`=('.$this->db->escape($productId).') AND `preference_id`=('.$this->db->escape($prefId).')  ' );
					endif;
				endforeach;
				$deleteQuery1=$this->db->query('DELETE FROM `asoc_pro_to_similarPro` WHERE `product_id`=('.$this->db->escape($productId).')');
				if($similarProduct!=null):
					$flag=0;
					foreach ($similarProduct as $similarPro):
						$similar_pro=$similarPro['similar_product'];
						if($similar_pro!=null):
							$insertQuery1=$this->db->query('INSERT INTO `asoc_pro_to_similarPro`(`product_id`,`similar_pro_id`,`delete_flag`) VALUES('.$this->db->escape($productId).','.$this->db->escape($similar_pro).','.$this->db->escape($flag).")");
						endif;
					endforeach;
				endif;
				$data = array('status' => true ,'message' => 'Product updated Successfully','response' => $response);
	            return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in updating product','response' => $response);
	            return $data;
			}	
		}
		/*** Delete Products function**/
		public function delete_products($productId,$flag,$deleteTime){
			$response = array();
			$query=$this->db->query('UPDATE `asgn_product` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `product_id`=('.$this->db->escape($productId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `asgn_product` WHERE `product_id`=('.$this->db->escape($productId).')')->row();
				$data = array('status' => true ,'message' => 'Delete Product Successfully','response' => $response);
	        	$query1=$this->db->query('UPDATE `asoc_pro_to_medical_condition` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `product_id`=('.$this->db->escape($productId).')');
	        	$query2=$this->db->query('UPDATE `asoc_pro_to_brand` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `product_id`=('.$this->db->escape($productId).')');
	        	$query4=$this->db->query('UPDATE `asoc_pro_to_med_rack` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `product_id`=('.$this->db->escape($productId).')');
	        	$query3=$this->db->query('UPDATE `asoc_pro_to_similarPro` SET `delete_flag`=('.$this->db->escape($flag).')');
	        	return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in Delete Product ','response' => $response);
	        	return $data;
			}
		}
		/*** Add Brand function**/
		public function add_brand($brandName,$flag,$createTime){
			$response = array();
			$query=$this->db->query('INSERT INTO `lkup_brand`(`brand_name`,`delete_flag`,`create_time`) VALUES('.$this->db->escape($brandName).','.$this->db->escape($flag).','.$this->db->escape($createTime).")");
			$brand_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `lkup_brand` WHERE `brand_id`=('.$this->db->escape($brand_id).')')->row();
			$data = array('status' => true ,'message' => 'Add brand Successfully','response' => $response);
	        return $data;
		}
		/*** Add Medical Rack function**/
		public function add_med_rack($medRackName,$flag,$createTime){
			$response = array();
			$query=$this->db->query('INSERT INTO `lkup_medicine_rack`(`med_rack_name`,`delete_flag`,`create_time`) VALUES('.$this->db->escape($medRackName).','.$this->db->escape($flag).','.$this->db->escape($createTime).")");
			$med_rack_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `lkup_medicine_rack` WHERE `med_rack_id`=('.$this->db->escape($med_rack_id).')')->row();
			$data = array('status' => true ,'message' => 'Add Medical Rack Successfully','response' => $response);
	        return $data;
		}
		/***Edit Brand Function **/
		public function edit_brand($brandId,$brandName,$updateTime){
			$response = array();
			$query = $this->db->query('UPDATE `lkup_brand` SET `brand_name`=('.$this->db->escape($brandName).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `brand_id`=('.$this->db->escape($brandId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `lkup_brand` WHERE `brand_id`=('.$this->db->escape($brandId).')')->row();
				$data = array('status' => true ,'message' => 'Brand updated Successfully','response' => $response);
	            return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in updating brand','response' => $response);
	            return $data;
			}	
		}
		/***Edit Medical Rack Function **/
		public function edit_med_rack($medRackId,$medRackName,$updateTime){
			$response = array();
			$query = $this->db->query('UPDATE `lkup_medicine_rack` SET `med_rack_name`=('.$this->db->escape($medRackName).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `med_rack_id`=('.$this->db->escape($medRackId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `lkup_medicine_rack` WHERE `med_rack_id`=('.$this->db->escape($medRackId).')')->row();
				$data = array('status' => true ,'message' => 'Medical rack updated Successfully','response' => $response);
	            return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in updating rack','response' => $response);
	            return $data;
			}	
		}
		/*** Delete Brand function**/
		public function delete_brand($brandId,$flag,$deleteTime){
			$query2=$this->db->query('SELECT `brand_id` FROM `asoc_pro_to_brand` WHERE `brand_id`=('.$this->db->escape($brandId).')');
			if($query2->num_rows()!=0){
				echo "Sorry the brand can not be deleted because it is associated to product";
			}
			else{
				$response = array();
				$query=$this->db->query('UPDATE `lkup_brand` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `brand_id`=('.$this->db->escape($brandId).')');
				if($query){
					$response[0]=$this->db->query('SELECT * FROM `lkup_brand` WHERE `brand_id`=('.$this->db->escape($brandId).')')->row();
					$data = array('status' => true ,'message' => 'Delete brand Successfully','response' => $response);
		        	return $data;
				}
				else{
					$data = array('status' => false ,'message' => 'Error in Delete brand ','response' => $response);
		        	return $data;
				}
			}
		}
		/*** Delete Medical rack function**/
		public function delete_med_rack($medRackId,$flag,$deleteTime){
			$query2=$this->db->query('SELECT `med_rack_id` FROM `asoc_pro_to_med_rack` WHERE `med_rack_id`=('.$this->db->escape($medRackId).')');
			if($query2->num_rows()!=0){
				echo "Sorry the medical cart can not be deleted because it is associated to product";
			}
			else{
				$response = array();
				$query=$this->db->query('UPDATE `lkup_medicine_rack` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `med_rack_id`=('.$this->db->escape($medRackId).')');
				if($query){
					$response[0]=$this->db->query('SELECT * FROM `lkup_medicine_rack` WHERE `med_rack_id`=('.$this->db->escape($medRackId).')')->row();
					$data = array('status' => true ,'message' => 'Delete medical rack Successfully','response' => $response);
		        	return $data;
				}
				else{
					$data = array('status' => false ,'message' => 'Error in Delete rack ','response' => $response);
		        	return $data;
				}
			}
		}
		/***Add Medical Condition function**/
		public function add_medical_condition($condition,$flag,$createTime){
			$response = array();
			$query=$this->db->query('INSERT INTO `lkup_medical_condition`(`condition`,`delete_flag`,`create_time`) VALUES('.$this->db->escape($condition).','.$this->db->escape($flag).','.$this->db->escape($createTime).")");
			$medical_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `lkup_medical_condition` WHERE `medical_id`=('.$this->db->escape($medical_id).')')->row();
			$data = array('status' => true ,'message' => 'Add condition Successfully','response' => $response);
	        return $data;
		}
		/***Edit Medical Condition Function **/
		public function edit_medical_condition($medicalId,$condition,$updateTime){
			$response = array();
			$query = $this->db->query('UPDATE `lkup_medical_condition` SET `condition`=('.$this->db->escape($condition).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `medical_id`=('.$this->db->escape($medicalId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `lkup_medical_condition` WHERE `medical_id`=('.$this->db->escape($medicalId).')')->row();
				$data = array('status' => true ,'message' => 'Medical Condition is updated Successfully','response' => $response);
	            return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in updating medical condition','response' => $response);
	            return $data;
			}	
		}
		/*** Delete Medical Condition function**/
		public function delete_medical_condition($medicalId,$flag,$deleteTime){
			$query2=$this->db->query('SELECT `medical_id` FROM `asoc_pro_to_medical_condition` WHERE `medical_id`=('.$this->db->escape($medicalId).')');
			if($query2->num_rows()!=0){
				echo "Sorry the medical condition can not be deleted because it is associated to product";
			}
			else{
				$response = array();
				$query=$this->db->query('UPDATE `lkup_medical_condition` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `medical_id`=('.$this->db->escape($medicalId).')');
				if($query){
					$response[0]=$this->db->query('SELECT * FROM `lkup_medical_condition` WHERE `medical_id`=('.$this->db->escape($medicalId).')')->row();
					$data = array('status' => true ,'message' => 'Delete condition Successfully','response' => $response);
		        	return $data;
				}
				else{
					$data = array('status' => false ,'message' => 'Error in Delete condition ','response' => $response);
		        	return $data;
				}
			}
		}
		/***Add Preference function**/
		public function add_preference($quantity,$subTasks,$flag,$createTime){
			$response = array();
			$query=$this->db->query('INSERT INTO `lkup_preference`(`quantity`,`sub_tasks`,`delete_flag`,`create_time`) VALUES('.$this->db->escape($quantity).','.$this->db->escape($subTasks).','.$this->db->escape($flag).','.$this->db->escape($createTime).")");
			$preference_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `lkup_preference` WHERE `preference_id`=('.$this->db->escape($preference_id).')')->row();
			$data = array('status' => true ,'message' => 'Add preference Successfully','response' => $response);
	        return $data;
		}
		/***Edit preference Function **/
		public function edit_preference($preferenceId,$quantity,$subTasks,$updateTime){
			$response = array();
			$query = $this->db->query('UPDATE `lkup_preference` SET `quantity`=('.$this->db->escape($quantity).'),`sub_tasks`=('.$this->db->escape($subTasks).'),`update_time`=('.$this->db->escape($updateTime).') WHERE `preference_id`=('.$this->db->escape($preferenceId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `lkup_preference` WHERE `preference_id`=('.$this->db->escape($preferenceId).')')->row();
				$data = array('status' => true ,'message' => 'Preference is updated Successfully','response' => $response);
	            return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in updating preference','response' => $response);
	            return $data;
			}	
		}
		/*** Delete preference function**/
		public function delete_preference($preferenceId,$flag,$deleteTime){
			$response = array();
			$query=$this->db->query('UPDATE `lkup_preference` SET `delete_flag`=('.$this->db->escape($flag).'),`delete_time`=('.$this->db->escape($deleteTime).') WHERE `preference_id`=('.$this->db->escape($preferenceId).')');
			if($query){
				$response[0]=$this->db->query('SELECT * FROM `lkup_preference` WHERE `preference_id`=('.$this->db->escape($preferenceId).')')->row();
				$data = array('status' => true ,'message' => 'Delete Preference Successfully','response' => $response);
	        	return $data;
			}
			else{
				$data = array('status' => false ,'message' => 'Error in Delete Preference','response' => $response);
	        	return $data;
			}
		}
		/*** Getting all brands details**/
		public function brands_detail(){
			$q = $this->db->query('SELECT DISTINCT b.brand_id,b.brand_name,b.create_time FROM `lkup_brand` AS b INNER JOIN `asoc_pro_to_brand` AS pb ON b.brand_id=pb.brand_id');
			$response = array();
			foreach ($q->result() as $b):
			   $bp = $this->db->get_where('asoc_pro_to_brand',array('brand_id'=>$b->brand_id));
			   $b->products = $bp->result();
			   $response[] = $b;
			endforeach;
			$data = array('status' => true ,'message' => 'Brands detail','response' => $response);
	        return $data;
		}
		/*** Getting medical condition detail **/
		public function medical_condition_details(){
			$q=$this->db->query('SELECT DISTINCT m.medical_id,m.condition,m.create_time,m.update_time,m.delete_time FROM `lkup_medical_condition` AS m INNER JOIN `asoc_pro_to_medical_condition` AS pm ON m.medical_id=pm.medical_id');
			$response=array();
			foreach ($q->result() as $m):
				$cp=$this->db->get_where('asoc_pro_to_medical_condition',array('medical_id'=>$m->medical_id));
				$m->products=$cp->result();
				$response[]=$m;
			endforeach;
			$data = array('status' => true ,'message' => 'Medical condition detail','response' => $response);
	        return $data;
		}
		/*** Getting preference details **/
		public function preference_details(){
			$q=$this->db->query('SELECT p.preference_id,p.quantity,p.sub_tasks,p.create_time,p.update_time,p.delete_time,pp.product_id FROM `lkup_preference` AS p INNER JOIN `asoc_pro_to_pref` AS pp ON p.preference_id=pp.preference_id');
			$response=array();
			foreach ($q->result() as $p):
				$pp=$this->db->get_where('asgn_product',array('product_id'=>$p->product_id));
				$p->products=$pp->result();
				$response[]=$p;
			endforeach;
			$data = array('status' => true ,'message' => 'Preference details','response' => $response);
	        return $data;
		}
		/***Getting catagories **/
		public function get_catagories(){
			$response=array();
			$response[0]=$this->db->query('SELECT * FROM `lkup_brand` WHERE `delete_flag`=0')->result();
			$response[1]=$this->db->query('SELECT * FROM `lkup_medicine_rack` WHERE `delete_flag`=0')->result();
			$response[2]=$this->db->query('SELECT * FROM `lkup_medical_condition` WHERE `delete_flag`=0')->result();
			$data = array('status' => true ,'message' => 'All catagories list','response' => array('Brands'=>$response[0],'Racks'=>$response[1],'Condition'=>$response[2]));
	        return $data;
		}
		public function get_product_list(){
			$q=$this->db->query('SELECT DISTINCT p.product_id,p.name,p.price,p.description,p.percentage_off,p.quality_max,p.create_time,p.update_time,p.delete_time,p.warning,p.ingredients,p.direction,p.side_effects,p.product_details,p.size,p.delete_flag,p.rrp FROM `asgn_product` AS p WHERE p.delete_flag=0');
			$response=array();
			foreach ($q->result() as $p):
				$pp=$this->db->get_where('asoc_pro_to_pref',array('product_id'=>$p->product_id));
				$p->preferences=$pp->result();
				foreach($p->preferences as $prefArr):
					if($prefArr->preference_id == "8007"){
						if($prefArr->flag == '0'){
							$p->questionnaireFlag= false;	
						}else{
							$p->questionnaireFlag=true;
						}
						// $p->questionnaireFlag=$prefArr->flag;
					}
				endforeach;
				$mp=$this->db->get_where('asoc_pro_to_multimedia',array('product_id'=>$p->product_id));
				$p->Files=$mp->result();
				$bp=$this->db->get_where('asoc_pro_to_brand',array('product_id'=>$p->product_id));
				$p->Brands=$bp->result();
				$mr=$this->db->get_where('asoc_pro_to_med_rack',array('product_id'=>$p->product_id));
				$p->Racks=$mr->result();
				$cp=$this->db->get_where('asoc_pro_to_medical_condition',array('product_id'=>$p->product_id));
				$p->Condition=$cp->result();
				$sp=$this->db->get_where('asoc_pro_to_similarPro',array('product_id'=>$p->product_id));
				$p->similarProducts=$sp->result();
				$rp=$this->db->get_where('asoc_pro_to_restrict_pro',array('product_id'=>$p->product_id));
				$p->restrictProducts=$rp->result();
				$response[]=$p;
				foreach($p->similarProducts as $products):
					$pd=$this->db->get_where('asgn_product',array('product_id'=>$products->similar_pro_id));
					$products->productsDetail=$pd->result();
						foreach($products->productsDetail as $image):
							$spi=$this->db->get_where('asoc_pro_to_multimedia',array('product_id'=>$image->product_id));
							$image->productImage=$spi->result();
						endforeach;
				endforeach;
			endforeach;
			$data = array('status' => true ,'message' => 'All products list','response' => $response);
	        return $data;
		}
		public function similar_products_list($productId){
			$response=array();
			$response[0]=$this->db->query('SELECT * FROM asgn_product WHERE product_id NOT IN (SELECT product_id FROM asgn_product   WHERE  product_id=('.$this->db->escape($productId).'))')->result();
			$data = array('status' => true ,'message' => 'All products list','response' => $response);
	        return $data;
		}	
		public function add_order($userId,$orderJson,$createTime,$createDate){
			$response=array();
			$insertOrder=$this->db->query('INSERT INTO `asgn_order`(`user_id`,`order_json`,`create_time`,`create_date`) VALUES('.$this->db->escape($userId).','.$this->db->escape($orderJson).','.$this->db->escape($createTime).','.$this->db->escape($createDate).")");
			$order_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `asgn_order` WHERE `user_id`=('.$this->db->escape($userId).')')->result();
			$data = array('status' => true ,'message' => 'Order is addedd successfully','response' => $response);
	        return $data;
		}
		public function get_products_name(){
			$response=array();
			$response[0]=$this->db->query('SELECT name FROM asgn_product WHERE delete_flag=0')->result();
			$data = array('status' => true ,'message' => 'All products name','response' => $response);
	        return $data;
		}
		public function add_question($userId,$productId,$medicineFlag,$age,$symptoms,$healthConditionFlag,$healthCondition,$medicationFlag,$medication){
			$response=array();
			$insertQuery=$this->db->query('INSERT INTO `asgn_question`(`medicine_take_flag`,`age`,`symptoms`,`health_condition_flag`,`health_condition`,`medication_flag`,`medication`) VALUES('.$this->db->escape($medicineFlag).','.$this->db->escape($age).','.$this->db->escape($symptoms).','.$this->db->escape($healthConditionFlag).','.$this->db->escape($healthCondition).','.$this->db->escape($medicationFlag).','.$this->db->escape($medication).")");
			$question_id=$this->db->insert_id();
			$insertQueryForUser=$this->db->query('INSERT INTO `asoc_user_to_question`(`user_id`,`question_id`) VALUES('.$this->db->escape($userId).','.$this->db->escape($question_id).")");
			$insertQueryForProduct=$this->db->query('INSERT INTO `asoc_pro_to_question`(`product_id`,`question_id`) VALUES('.$this->db->escape($productId).','.$this->db->escape($question_id).")");
			$response[0]=$this->db->query('SELECT * FROM `asgn_question` WHERE `question_id`=('.$this->db->escape($question_id).')')->row();
			$data = array('status' => true ,'message' => 'Question is addedd successfully','response' => $response);
	        return $data;
		}
		public function edit_question($questionId,$medicineFlag,$age,$symptoms,$healthConditionFlag,$healthCondition,$medicationFlag,$medication){
			$response=array();
			$updateQuery = $this->db->query('UPDATE `asgn_question` SET `medicine_take_flag`=('.$this->db->escape($medicineFlag).'),`age`=('.$this->db->escape($age).'),`symptoms`=('.$this->db->escape($symptoms).'),`health_condition_flag`=('.$this->db->escape($healthConditionFlag).'),`health_condition`=('.$this->db->escape($healthCondition).'),`medication_flag`=('.$this->db->escape($medicationFlag).'),`medication`=('.$this->db->escape($medication).') WHERE `question_id`=('.$this->db->escape($questionId).')');
			$response[0]=$this->db->query('SELECT * FROM `asgn_question` WHERE `question_id`=('.$this->db->escape($questionId).')')->row();
			$data = array('status' => true ,'message' => 'Question is updated successfully','response' => $response);
	        return $data;
		}
		public function get_orders_list(){
			$selectOrders=array();
			$response=$this->db->query('SELECT DISTINCT * FROM `asgn_order`')->result();
			foreach($response as $selectOrder):
				$ud=$this->db->get_where('asgn_user',array('user_id'=>$selectOrder->user_id));
				$selectOrder->UserDetails=$ud->result();
			endforeach;
			$data=array('status' => true ,'message' => 'All orders list' , 'order' => $response);
			return $data;
		}
		public function add_cargo_service($cargoTitle,$cargoCost,$cargoDetails,$cargoPrefFlag,$cargoDefaultFlag){
			$response=array();
			$insertCargo=$this->db->query('INSERT INTO `asgn_cargo_services`(`cargo_title`,`cargo_cost`,`cargo_details`,`cargo_pref_flag`,`cargo_default_flag`) VALUES('.$this->db->escape($cargoTitle).','.$this->db->escape($cargoCost).','.$this->db->escape($cargoDetails).','.$this->db->escape($cargoPrefFlag).','.$this->db->escape($cargoDefaultFlag).")");
			$cargo_id=$this->db->insert_id();
			$response[0]=$this->db->query('SELECT * FROM `asgn_cargo_services` WHERE `cargo_id`=('.$this->db->escape($cargo_id).')')->row();
			$data = array('status' => true ,'message' => 'Cargo service is addedd successfully','response' => $response);
	        return $data;
		}
		public function edit_cargo_service($cargoId,$cargoTitle,$cargoCost,$cargoDetails,$cargoPrefFlag,$cargoDefaultFlag){
			$response=array();
			$updateCargo = $this->db->query('UPDATE `asgn_cargo_services` SET `cargo_title`=('.$this->db->escape($cargoTitle).'),`cargo_cost`=('.$this->db->escape($cargoCost).'),`cargo_details`=('.$this->db->escape($cargoDetails).'),`cargo_pref_flag`=('.$this->db->escape($cargoPrefFlag).'),`cargo_default_flag`=('.$this->db->escape($cargoDefaultFlag).') WHERE `cargo_id`=('.$this->db->escape($cargoId).')');
			$response[0]=$this->db->query('SELECT * FROM `asgn_cargo_services` WHERE `cargo_id`=('.$this->db->escape($cargoId).')')->row();
			$data = array('status' => true ,'message' => 'Cargo is updated successfully','response' => $response);
	        return $data;
		}
		public function delete_cargo_service($cargoId){
			$deleteCargo=$this->db->query('DELETE FROM `asgn_cargo_services` WHERE `cargo_id`=('.$this->db->escape($cargoId).')');
			if($deleteCargo){
				$data=array('status'=> true, 'message'=> 'Delete cargo successfully');
				return $data;
			}
		}
		public function get_cargo_items_list(){
			$response=array();
			$response[]=$this->db->query('SELECT * FROM `asgn_cargo_services` WHERE cargo_pref_flag = 1')->result();
			$data = array('status' => true ,'message' => 'All Cargo Items','response' => $response);
	        return $data;
		}
		public function get_all_cargo_items(){
			$response=array();
			$response[]=$this->db->query('SELECT * FROM `asgn_cargo_services`')->result();
			$data = array('status' => true ,'message' => 'All Cargo Items','response' => $response);
	        return $data;
		}
		public function forgot_password($email){
			$this->db->select('email');
			$this->db->where('email',$email);
			$q=$this->db->get('asgn_user');
			// $selectEmail=$q->result_array();
			$count=$q->num_rows();
			if($count>0){
				$config = Array(
			        'protocol' => 'sendmail',
		            'smtp_host' => 'your domain SMTP host',
		            'smtp_port' => 25,
		            'smtp_user' => 'SMTP Username',
		            'smtp_pass' => 'SMTP Password',
		            'smtp_timeout' => '4',
		            'mailtype'  => 'html', 
		            'charset'   => 'iso-8859-1'
			    );
			    $data = array(
             		'userName'=> 'Zeeshan'
                 );
			    $this->load->library('email',$config);
				$this->email->from('zeeshan@mdsoltech.com', 'Zeeshan Arshad');
				$this->email->to($email);
 				$this->email->subject('Forgot Password');
 				$message=$this->load->view('email.php',$data,true);
				$this->email->message($message);
				if($this->email->send()){
					$data = array('status' => true ,'message' => 'Email is send successfully');
	        		return $data;
				}
				else{
					$data = array('status' => true ,'message' => 'sorry the email is not send please try again');
	        		return $data;
				}
			}
			else{
				$data = array('status' => true ,'message' => 'Email is does not exists');
	        		return $data;
			}

		}
		public function reset_password($resetPassword,$email){
			$response=array();
			$data=array('password'=>$resetPassword);
			$this->db->where('email',$email);
			$this->db->update('asgn_user',$data);
			$response[0] = $this->db->query('SELECT * FROM `asgn_user` WHERE `email`=('.$this->db->escape($email).')')->row();
			$data = array('status' => true ,'message' => 'Password is reset successfully','response' => $response);
	        return $data;
		}
		public function forgot_password_admin($email){
			$this->db->select('email');
			$this->db->where('email',$email);
			$q=$this->db->get('asgn_user');
			// $selectEmail=$q->result_array();
			$count=$q->num_rows();
			if($count>0){
				$config = Array(
			        'protocol' => 'sendmail',
		            'smtp_host' => 'your domain SMTP host',
		            'smtp_port' => 25,
		            'smtp_user' => 'SMTP Username',
		            'smtp_pass' => 'SMTP Password',
		            'smtp_timeout' => '4',
		            'mailtype'  => 'html', 
		            'charset'   => 'iso-8859-1'
			    );
			    $data = array(
             		'userName'=> 'Zeeshan'
                 );
			    $this->load->library('email',$config);
				$this->email->from('zeeshan@mdsoltech.com', 'Zeeshan Arshad');
				$this->email->to($email);
 				$this->email->subject('Forgot Password');
 				$message=$this->load->view('email_admin.php',$data,true);
				$this->email->message($message);
				if($this->email->send()){
					$data = array('status' => true ,'message' => 'Email is send successfully');
	        		return $data;
				}
				else{
					$data = array('status' => true ,'message' => 'sorry the email is not send please try again');
	        		return $data;
				}
			}
			else{
				$data = array('status' => true ,'message' => 'Email is does not exists');
	        		return $data;
			}

		}
		/***  check email if already exists **/
		public function check_email($email){
			$response = array();
			$checkEmail=$this->db->query('SELECT * FROM `asgn_user` WHERE `email`=('.$this->db->escape($email).')');
			if($checkEmail->num_rows()>0){
				$data = array('status' => false ,'message' => 'email is already registerd','response' => $response);
	            return $data;
			}
			  
		}
	}
?>
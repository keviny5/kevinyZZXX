<?php 

require_once('twilio/twilio-php/Services/Twilio.php');
import("@.ORG.CacheMemcache");

class AccountAction extends Action {

	public function register(){
                //Free Account
		//$AccountSid= 'AC98d039a613a264e4f8efa57b04ea0158'; 
		//$AuthToken = 'b144e9a4d1fab0341819cbbc9015581e'; 
		//$from = '2482913884';

                //Paid Account
		$AccountSid= 'AC7514f8dc7b5c98ccfd731e01dc3e0226'; 
		$AuthToken = '3a7888c672472d471b52400903b04b86'; 
		$from = '7542272682';

		$to = $_POST['register'];

		$data['status'] = 0;
		$data['mesg'] = '';

                $user_profile_table= M("user_register_profile");
                $condition['user_phone_number'] = $to;
                $exist_id = $user_profile_table->where($condition)->getField('user_id');
		if(!empty($exist_id)){
		    $data['mesg'] = 'Already registered';
		    $data['status'] = 2;
		    $this->ajaxReturn($data,'JSON');
		}
		else{
			$client = new Services_Twilio($AccountSid, $AuthToken);
			try {
				$verify_key= intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
                                S($to,$verify_key,300);
				//echo 'Registering '.$to.'     '.$verify_key;
				$reply="Welcome to WayneCircle! Your verfication code: ".$verify_key;
				$message = $client->account->messages->sendMessage($from,$to,$reply);
				$data['status'] = 1;
				$this->ajaxReturn($data,'JSON');

			} catch (Services_Twilio_RestException $e) {
				//echo $e->getMessage();
				$data['mesg'] = $e->getMessage();
				$this->ajaxReturn($data,'JSON');
			}
		}

	}

	public function verify(){

		$client = $_POST['register'];
		$code= $_POST['verify'];
		$nickname= $_POST['nickname'];
                $uid = '';

		$data['status'] = 0;
		$data['uid'] =$uid;
      
                $key= S($client);
		if($code == $key){
		     $uid= intval( rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
		     $data['status'] = 1;
		     $data['uid'] = $uid;
                     //Database Operation Save phone number, unique uid
                     //Local Database
                     $profile['user_id'] = $uid;
                     $profile['user_phone_number'] = $client;
                     $profile['nickname'] = $nickname;
                     $profile['avatar'] =''; 
                     $user_profile_table= M("user_register_profile");
                     $user_profile_table->add($profile);

                     //IM Database
                     $improfile['username'] = $nickname;
                     $improfile['cell'] = $client;
                     $improfile['id'] = $uid;
		     $now= time();
                     $improfile['date'] = $now;
                     $improfile['authenticationTime'] = $now;
                     $imuser_profile_table= new UsersModel(); //The new Messages model is defined in /var/www/App/Lib/Model/MessagesModel.class.php
                     $imuser_profile_table->add($improfile);

		     $this->ajaxReturn($data,'JSON');

                }
		else {
		     $this->ajaxReturn($data,'JSON');
                }
	}


         
	public function deactivate(){
		$client = $_POST['register'];
                $user_profile_table= M("user_register_profile");
                $condition['user_phone_number'] = $client;
                $user_profile_table->where($condition)->delete();
		$data['status'] = 1;
                $exist_id = $user_profile_table->where($condition)->getField('user_id');
		if(!empty($exist_id)){
		  $data['status'] = 0;
                }
		$this->ajaxReturn($data,'JSON');

        }

	public function editnickname(){
		$uid= $_POST['uid'];
		$nickname = $_POST['nickname'];
                $user_profile_table= M("user_register_profile");
                $condition['uid'] = $uid;
		$data['status'] = 1;
                $user_profile_table->where($condition)->setField('nickname',$nickname);
                $newname= $user_profile_table->where($condition)->getField('nickname');
		if($newname != $nickname){
		  $data['status'] = 0;
                }

                //Update IM Database 
                $condition['uid'] = $uid;
                $imuser_profile_table= new UsersModel(); //The new Messages model is defined in /var/www/App/Lib/Model/MessagesModel.class.php
                $imuser_profile_table->where($condition)->setField('username',$nickname);

		$this->ajaxReturn($data,'JSON');

        }

	public function editavatar(){
		$uid= $_POST['uid'];
		$avatar= $_POST['avatar'];
                $user_profile_table= M("user_register_profile");
                $condition['uid'] = $uid;
		$data['status'] = 1;
                $user_profile_table->where($condition)->setField('avatar',$avatar);
		$this->ajaxReturn($data,'JSON');

        }

}
?> 

<?php

class PostAction extends Action {
	//Delete Post
	public function delete(){
		$pid= $_POST['pid'];
		$post_table= M("posts");
		$condition['pid'] = $pid;
		$data['status'] = 0;
		$data['pid'] = $pid;

		$exist_id_1 = $post_table->where($condition)->getField('pid');//verify if the deleting post message exists. If not exists, then just status = 0 means fail deleted.
		$user_id = $post_table->where('pid='.$pid)->getField('uid');
		$current_time = $post_table->where('pid='.$pid)->getField('uploaded_green_time'); 
		//delete the file which this item includes.
		for($j=1;$j<=10;$j++){//delete the file, if one attribute in the database is empty then ignore, else delete that attribute file name's file.
			$fname_loop = $post_table->where('pid='.$pid)->getField('fname_'.$j);
			if(!empty($fname_loop)){  
				$fname = $post_table->where('pid='.$pid)->getField('fname_'.$j); 
				$target_path = $user_id."_".$current_time."_".$fname;   
				$data['status'] = $this->delete_file($target_path);     
			}
		}

		//delete the thumbnail file.
		$thn_fname = $post_table->where('pid='.$pid)->getField('thn_fname');
		$target_path = $user_id."_".$current_time."_".$thn_fname;
		$data['status'] = $this->delete_file($target_path); 

		$post_table->where($condition)->delete();
		$exist_id = $post_table->where($condition)->getField('pid');

		if((!empty($exist_id))||(empty($exist_id_1))){
			$data['status'] = 0;
		}else{
			$data['status'] = 1;
		}

		//Instante and connect to the instant_message database to modify the postid of messages table. 
		//$message_table = M("messages","mysql://root:cic2014@localhost:3306/instant_message");
		// Model->db(2,"mysql://root:cic2014@localhost:3306/instant_message");
		//delete all the all the communication messages which has the corresponding pid in instant_message database.
		$message_table = new MessagesModel();//The new Messages model is defined in /var/www/App/Lib/Model/MessagesModel.class.php
		$message_table->where('postid='.$pid)->delete();
		//$message_table->where('postid='.$pid)->setField('postid','');

		$this->ajaxReturn($data,'JSON');
	}


	public function delete_file($target_path){
		$status = 0;
		$base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
		$imagepath = $base."image/";
		$videopath = $base."video/";
		$audiopath = $base."audio/";
		$miscpath = $base."misc/";
		$file_path_1 = $imagepath.$target_path;
		$file_path_2 = $audiopath.$target_path;
		$file_path_3 = $videopath.$target_path;
		$file_path_4 = $miscpath.$target_path;

		if (!unlink($file_path_1)){ //unlink is deleting file operation. if !unlink is true, it means the delete failed,so choose another path to try.

			if (!unlink($file_path_2)){

				if (!unlink($file_path_3)){

					if (!unlink($file_path_4)){
						echo ("Deleted Error");
						$status = 0;
					}else{echo ("Deleted $target_path"."\n");
						$status = 1;}

				}else{
					echo ("Deleted $target_path"."\n");
					$status = 1;
				}

			}else{
				echo ("Deleted $target_path"."\n");
				$status = 1;
			}        

		}else{
			echo ("Deleted $target_path"."\n");
			$status = 1;
		}

		return $status;

	}



	//Read one Post with static dummy data
	public function readonestatic(){
		$pid= $_POST['pid'];
		$uid= $_POST['uid'];

		$data['uid'] = $uid;
		$data['price'] = '79';
		$data['uid'] = '28381847';
		$data['stamp'] = '05/05/2014';
		$data['lat'] = '42.331';
		$data['lng'] = '83.046';

		$data['desc'] = "I'm selling an IPhone 4 through Att. It has 8gb and works perfectly fine. No issues no nothing. Only reason I'm selling it is because I'm switching phone companies. The phone works great no scratches and was in the Otter Box maybe twice since I got it";
		$data['category'] = 'Electronics';
		$data['title'] = 'Selling my Iphone 4';

		$data['server_file_name'] = '12345678_1400631941_008.png'; //for the update function.     

		$file="/tmp/thumbnail.png";


		$fp=fopen($file,"r");
		if($fp){
			$type=getimagesize($file);
			$file_content=chunk_split(base64_encode(fread($fp,filesize($file))));
			$order   = array("\r\n", "\n", "\r");
			$replace = '';
			$imgdata= str_replace($order, $replace, $file_content);
			switch($type[2]){
				case 1:$img_type="gif";break;  
				case 2:$img_type="jpg";break;  
				case 3:$img_type="png";break;  
			}  
			$img='data:image/'.$img_type.';base64,'.$imgdata;
			$data['thumbnail'] = $img;
			fclose($fp);  
		}
		else
			$data['thumbnail'] = '';

		$file="/var/www/Wayne_Trading_Data/user_uploaded_image_file/image/12345678_1400631482_008.png";
		$fp=fopen($file,"r");
		if($fp){
			$type=getimagesize($file);
			$file_content=chunk_split(base64_encode(fread($fp,filesize($file))));
			$order   = array("\r\n", "\n", "\r");
			$replace = '';
			$imgdata= str_replace($order, $replace, $file_content);
			switch($type[2]){
				case 1:$img_type="gif";break;  
				case 2:$img_type="jpg";break;  
				case 3:$img_type="png";break;  
			}  
			$img='data:image/'.$img_type.';base64,'.$imgdata;
			$data['pic0'] = $img;
			$data['pic1'] = $img;
			$data['pic2'] = $img;
			$data['pic3'] = $img;
			fclose($fp);  
		}
		else{
			$data['pic0'] = '';
			$data['pic1'] = '';
			$data['pic2'] = '';
			$data['pic3'] = '';
                }

		$reply['pid'] = 238428;
		$reply['data'] = $data;
		$this->ajaxReturn($reply,'JSON');
	}

	//Read a few Post with static dummy data
	public function readstatic(){

		$objArray=array();
		for ($x=0; $x<=5; $x++) {
			$data['price'] = '79';
			$data['lat'] = '42.331';
			$data['uid'] = '28381847';
			$data['stamp'] = '05/05/2014';
			$data['lng'] = '83.046';
			$data['desc'] = "I'm selling an IPhone 4 through Att. It has 8gb and works perfectly fine. No issues no nothing. Only reason I'm selling it is because I'm switching phone companies. The phone works great no scratches and was in the Otter Box maybe twice since I got it";
			$data['category'] = 'Electronics';
			$data['title'] = 'Selling my Iphone 4';

			$data['server_file_name'] = '12345678_1400631941_008.png'; //for the update function.

			$file="/tmp/thumbnail.png";
			$fp=fopen($file,"r");
			if($fp){
				$type=getimagesize($file);
				$file_content=chunk_split(base64_encode(fread($fp,filesize($file))));
				$order   = array("\r\n", "\n", "\r");
				$replace = '';
				$imgdata= str_replace($order, $replace, $file_content);
				switch($type[2]){
					case 1:$img_type="gif";break;  
					case 2:$img_type="jpg";break;  
					case 3:$img_type="png";break;  
				}  
				$img='data:image/'.$img_type.';base64,'.$imgdata;
				$data['thumbnail'] = $img;
				fclose($fp);  
			}
			else
				$data['thumbnail'] = '';

			$reply['pid'] = 238428+$x;
			$reply['data'] = $data;
			array_push($objArray,$reply);
		} 
		//$this->ajaxReturn(json_encode($objArray),'JSON');
		$this->ajaxReturn($objArray,'JSON');
	}

	//update a Post
	public function update(){
	}


	//Create Post
	public function create(){
		foreach($_POST as $key=>$val)
		{
                        //Debug Only
			//echo "Post message: "."\n";
			//echo "Key: ".$key."  "."Value: ".$val."\n";

			//identify the $data array is a global array.
			global $data;

			//store the metadata into $data[] array which would be stored in the database
			switch($key){
				case "uid":
					$data['uid'] = $val;
					break;

				case "category":
					$data['category'] = $val;
					break;

				case "price":
					$data['price'] = $val;
					break;

				case "lat":
					$data['lat'] = $val;
					break;

				case "lng":
					$data['lng'] = $val;
					break;

				case "desc":
					$data['desc'] = $val;
					break;

				case "title":
					$data['title'] = $val;
					break;
			} 

		}

		//Compose the file name.
		$user_id = $data['uid'];
		$current_time = time();
		$data['uploaded_green_time'] = $current_time;
		//use the server time region to make a synchronization.
		//Achieve the server time function. Eastern time region. 
		date_default_timezone_set('America/New_York');
		$showtime = date("Y-m-d H:i:s");
		$data['stamp'] = $showtime;
		$data['pid'] = $data['uid'].$data['uploaded_green_time'];

		$return_data['status'] = 0;
		//call the receiveFile function to receive the file.
		$return_data['status'] = $this->receiveFile($user_id,$current_time);

		//Store the temperate $data[] array into database.
		$database_operation = M("posts");
		$database_operation->add($data);

		//verify if the current inserted pid exists in the database.
		$condition['pid'] = $data['pid'];
		$exist_id = $database_operation->where($condition)->getField('pid');
		$return_data['pid'] = $exist_id;//if failed, the $exist_id is empty, so the return pid json data is also empty.

		if(empty($exist_id)){
			$return_data['status'] = 0;
		}else{
			$return_data['status'] = 1;
		}
		$this->ajaxReturn($return_data,'JSON');
	}



	public function receiveFile($user_id,$current_time){

		$base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
		$imagepath = $base."image/";
		$videopath = $base."video/";
		$audiopath = $base."audio/";
		$miscpath = $base."misc/";
		$status = 0;
		// !empty( $_FILES ) is an extra safety precaution
		// in case the form's enctype="multipart/form-data" attribute is missing
		// or in case your form doesn't have any file field elements
		if(strtolower($_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty( $_FILES ))
		{

			global $data;
			$data['thn_fname'] = $_FILES['thumbnail']['name'];
			$data['thn_ftype'] = $_FILES['thumbnail']['type'];
			$data['thn_fsize'] = $_FILES['thumbnail']['size'];
			$target_path = $imagepath.$user_id."_".$current_time."_".$_FILES["thumbnail"]["name"];
			if(move_uploaded_file($_FILES[ 'thumbnail' ][ 'tmp_name' ],$target_path)){
				//echo $_FILES["thumbnail"]["name"]." has been uploaded"."\n";  
			}else{  
				//echo "There was an error uploading the file, please try again!".$name."\n";  
			} 

			$j = 1;//identify which number the current file is.
			foreach( $_FILES[ 'file' ][ 'tmp_name' ] as $index => $tmpName )
			{
				if (!empty($_FILES['file']['error'][$index])){

					// some error occured with the file in index $index
					// yield an error here
					return false;  //return false also immediately perhaps??

				}else if(!empty($tmpName)&&is_uploaded_file($tmpName)){  // check whether it's not empty, and whether it indeed is an uploaded file
					$name = $_FILES['file']['name'][$index];
					$size = $_FILES['file']['size'][$index];
					$type = $_FILES['file']['type'][$index];


					//identify the $data array is a global array.
					global $data;

					//store the metadata into $data[] array which would be stored in the database
					$data['fname_'.$j] = $name;
					$data['ftype_'.$j] = $type;
					$data['fsize_'.$j] = $size;

					//identify the directory of the target storage path.
					if(($type == "image/gif")||($type == "image/jpeg")||($type == "image/pjpeg")||($type == "image/png")||($type == "image/jpg")||($type == "image/fax")||($type == "image/x-icon")||($type == "image/pnetvue")||($type == "image/tiff")||($type == "image/vnd.wap.wbmp")){

						//The directory of the received picture file.
						$target_path = $imagepath.$user_id."_".$current_time."_".$_FILES["file"]["name"][$index];

					}else if(($type == "audio/mp1")||($type == "audio/mpeg")||($type == "audio/aiff")||($type == "audio/basic")||($type == "audio/x-liquid-secure")||($type == "audio/x-la-lms")||($type == "audio/mid")||($type == "audio/wav")||($type == "audio/x-ms-wma")||($type == "audio/amr")||($type == "audio/aiff")||($type == "audio/mid")||($type == "audio/mp3")||($type == "audio/mp2")||($type == "audio/scpls")||($type == "audio/x-pn-realaudio")||($type == "audio/x-pn-realaudio-plugin")||($type == "audio/x-ms-wax")){

						//The directory of the received voice file.
						$target_path = $audiopath.$user_id."_".$current_time."_".$_FILES["file"]["name"][$index];

					}else if(($type == "video/x-mpeg")||($type == "video/mpeg4")||($type == "video/mpeg")||($type == "video/mpg")||($type == "video/x-ms-wmv")||($type == "video/avi")||($type == "video/mpg")||($type == "video/x-ms-wm")||($type == "video/x-ms-wmx")||($type == "video/3gp")||($type == "video/x-ms-wvx")){

						//The directory of the received voice file.
						$target_path = $videopath.$user_id."_".$current_time."_".$_FILES["file"]["name"][$index];

					}else{//other files.

						//The directory of the received other files.
						$target_path = $miscpath.$user_id."_".$current_time."_".$_FILES["file"]["name"][$index];

					} 

					//storage the data.

					if(move_uploaded_file($tmpName,$target_path)){
						//echo $name." has been uploaded"."\n";  
						$status = 1;
					}else{  
						echo "There was an error uploading the file, please try again!".$name."\n";  
						$status = 0;
					}  
				}
				$j++;
			}

		}

		return $status;

	}



	//Read one Post with pid
	public function readone(){
		//the path of all the files.
		$status = 0;
		$base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
		$imagepath = $base."image/";
		$videopath = $base."video/";
		$audiopath = $base."audio/";
		$miscpath = $base."misc/";

		$pid= $_POST['pid'];
		$post_table= M("posts");
		$condition['pid'] = $pid;

		$data['uid'] = $post_table->where('pid='.$pid)->getField('uid');

		if(empty($data['uid'])){  
			$reply['pid'] = $pid;
			$reply['data'] = '';
			$this->ajaxReturn($reply,'JSON');
		}
		else{
			$data['price'] = $post_table->where('pid='.$pid)->getField('price');
			$data['lat'] = $post_table->where('pid='.$pid)->getField('lat');
			$data['lng'] = $post_table->where('pid='.$pid)->getField('lng');
			$data['desc'] = $post_table->where('pid='.$pid)->getField('desc');
			$data['stamp'] = $post_table->where('pid='.$pid)->getField('stamp');
			$data['category'] = $post_table->where('pid='.$pid)->getField('category');
			$data['title'] = $post_table->where('pid='.$pid)->getField('title');
			$uploaded_green_time_new = $post_table->where('pid='.$pid)->getField('uploaded_green_time');
			//echo $data['price']." ".$data['lat']." ".$data['lng']." ".$data['desc']." ".$data['category']." ".$data['title']." "."\r\n";

			$fname_loop = $post_table->where('pid='.$pid)->getField('thn_fname');
			$file = $imagepath.$data['uid']."_".$uploaded_green_time_new."_".$fname_loop;  //The thumbnail is no doubt image.
			//echo $file."\r\n";

			$fp=fopen($file,"r");
			if($fp){
			        $type=getimagesize($file);
				$file_content=chunk_split(base64_encode(fread($fp,filesize($file))));
				$order   = array("\r\n", "\n", "\r");
				$replace = '';
				$imgdata= str_replace($order, $replace, $file_content);
				switch($type[2]){
					case 1:$img_type="gif";break;  
					case 2:$img_type="jpg";break;  
					case 3:$img_type="png";break;  
				}  
				$img='data:image/'.$img_type.';base64,'.$imgdata;
				$data['thumbnail'] = $img;
				fclose($fp);  
			}
			else
				$data['thumbnail'] = '';

			for($j=1;$j<=10;$j++){
				$fname_loop = $post_table->where('pid='.$pid)->getField('fname_'.$j);
				if(!empty($fname_loop)){  
					$fname = $post_table->where('pid='.$pid)->getField('fname_'.$j); 
					$file = $data['uid']."_".$uploaded_green_time_new."_".$fname;   
					//echo $file."_".$j."\r\n";
					$file_path_1 = $imagepath.$file;
					$file_path_2 = $audiopath.$file;
					$file_path_3 = $videopath.$file;
					$file_path_4 = $miscpath.$file;
					$file_path = null;
					$fp = null;
					if (!($fp=fopen($file_path_1,"r"))){ //Try to traversal all the file directories to find that file. When fopen fails, it would return false.

						if (!($fp=fopen($file_path_2,"r"))){

							if (!($fp=fopen($file_path_3,"r"))){

								if (!($fp=fopen($file_path_4,"r"))){
									//echo ("/r/n"."read Error");
									$status = 0;
								}else{
									$status = 1;
									$file_path = $file_path_4;
								}

							}else{
								$status = 1;
								$file_path = $file_path_3;
							}

						}else{
							$status = 1;
							$file_path = $file_path_2;
						}        

					}else{
						$status = 1;
						$file_path = $file_path_1;
					}


					if($status == 1){
						//echo $file_path."_".$j."\r\n";
						$type=getimagesize($file_path);
						$file_content=chunk_split(base64_encode(fread($fp,filesize($file_path))));

						switch($type[2]){
							case 1:$img_type="gif";break;  
							case 2:$img_type="jpg";break;  
							case 3:$img_type="png";break;  
						}  
						$img='data:image/'.$img_type.';base64,'.$file_content;
						fclose($fp);  
						$data['fname'.$j] = $file; //the return file name is only the 12345678_1400631941_008.png, not included the directory.
						$data['file'.$j] = $img;
						//$data['fname'.$j] = '12345678_1400631941_008.png'; //for the update function.     
					}else if($status == 0){//the file doesn't exist.
						$data['fname'.$j] = ''; //the return file name is only the 12345678_1400631941_008.png, not included the directory.
						$data['file'.$j] = '';
					}

				}
			}

			$reply['pid'] = $pid;
			$reply['data'] = $data;
			$this->ajaxReturn($reply,'JSON');
		}
	}




        //Pull down to load newer post
	public function readnewer(){
                $base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
		$imagepath = $base."image/";

		$uid= $_POST['uid'];
		$starttime = $_POST['starttime'];

                $post_table= M("posts");
		$timeStampArray = $post_table->getField('stamp',true);//get all the stamp value in the stamp colume list in the table.
                $pidArray = $post_table->getField('pid',true);
 
                $objArray=array();
                $resultArray;
                $resultPidArray;
                $n = 0;

                 if($starttime == 0){//it means it is the first time for user to read all the list. Then return the newest 10 or less than 10 messages.

                 $resultPidArray = $post_table->order('uploaded_green_time desc')->limit(10)->getField('pid',true);//desc indicates it is inverted sequence. If it is asce,it is the sequence.
                    


                 }else{  
                  //to calculate the most recent 10 items in the database after the starttime. It would travel through all the elements for the stamp colume.
                  for($i = 0;$i < count($timeStampArray);$i++){
                   
                      if((strtotime($timeStampArray[$i]) > strtotime($starttime))&&($n < 10)){//if the element is less than 10, then just directly add it if the current timestamp is eariler than the endtime.
                        $resultArray[$n] = strtotime($timeStampArray[$i]);
                        $resultPidArray[$n] = $pidArray[$i];//to record the final result 10 pid array which maintains the most recent 10 timestamp messages.
                        $n++;         
                       }else if((strtotime($timeStampArray[$i]) > strtotime($starttime))&&($n >= 10)){//if the element is more than 10(when n == 10),then just replace the latest timestamp, to keep the result array always maintain 10 elements.
                          $latest_timestamp = 0;//infinite large.
                          $latest_timestamp_tag = 0;
                          for($j = 0;$j < 10;$j++){//to find the earliest timestamp in the timeStampArray ten elements,and then replace it.
                               if($resultArray[$j] > $latest_timestamp){//to find the largest timestamp, it means to find the one which is farest from the current time.
                                      $latest_timestamp = $resultArray[$j]; 
                                      $latest_timestamp_tag = $j;         
                               }                        
                          }
                          //echo $earliest_timestamp_tag."\r\n";
                          //echo $earliest_timestamp."\r\n";
                          if(strtotime($timeStampArray[$i]) < $resultArray[$latest_timestamp_tag]){//find the earliest timestamp,and if the current on is later than this timestamp,relace it.
                                     $resultArray[$latest_timestamp_tag] = strtotime($timeStampArray[$i]);
                                     $resultPidArray[$latest_timestamp_tag] = $pidArray[$i];//to record the final result 10 pid array which maintains the most recent 10 timestamp messages.
                          }                       


                      }

                }

            }

                //$resultPidArray owns the final 10 most recent messages' after the start_time pid, and if the most recent messages from the end_time is less than 10 messages, the $resultPidArray would only has less than 10 messages.  
                for($i = 0;$i < count($resultPidArray);$i++){
                   
                     $data['uid'] = $post_table->where('pid='.$resultPidArray[$i])->getField('uid');
                     $data['stamp'] =  $post_table->where('pid='.$resultPidArray[$i])->getField('stamp');                  
                     $data['lat'] = $post_table->where('pid='.$resultPidArray[$i])->getField('lat');
                     $data['lng'] = $post_table->where('pid='.$resultPidArray[$i])->getField('lng');                  
                     $data['category'] = $post_table->where('pid='.$resultPidArray[$i])->getField('category');
                     $data['price'] = $post_table->where('pid='.$resultPidArray[$i])->getField('price');
                     $data['title'] = $post_table->where('pid='.$resultPidArray[$i])->getField('title');
                     $data['desc'] = $post_table->where('pid='.$resultPidArray[$i])->getField('desc');
                     //output the thumbnail
                     $thn_fname = $post_table->where('pid='.$resultPidArray[$i])->getField('thn_fname');
                     $uploaded_green_time_new = $post_table->where('pid='.$resultPidArray[$i])->getField('uploaded_green_time');
		     $file = $imagepath.$data['uid']."_".$uploaded_green_time_new."_".$thn_fname;  //The thumbnail is no doubt image.
		     //echo $file;

		     $fp=fopen($file,"r");
		     if($fp){
			     $type=getimagesize($file);
			     $file_content=chunk_split(base64_encode(fread($fp,filesize($file))));
			     $order   = array("\r\n", "\n", "\r");
			     $replace = '';
			     $imgdata= str_replace($order, $replace, $file_content);
			     switch($type[2]){
				     case 1:$img_type="gif";break;  
				     case 2:$img_type="jpg";break;  
				     case 3:$img_type="png";break;  
			     }  
			     $img='data:image/'.$img_type.';base64,'.$imgdata;
			     $data['thumbnail'] = $img;
			     fclose($fp);  
		     }
		     else
			     $data['thumbnail'] = '';


		     $reply['pid'] = $resultPidArray[$i];
		      $reply['data'] = $data;
		      array_push($objArray,$reply);

                      }


                      //$this->ajaxReturn(json_encode($objArray),'JSON');
                      $this->ajaxReturn($objArray,'JSON');



        }



        //Pull up to load older post
	public function readolder(){

                $base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
		$imagepath = $base."image/";

		$uid = $_POST['uid'];
		$endtime = $_POST['endtime']; //if the client invoke the readolder function, it means the client must have already read newer.
		$post_table= M("posts");
		//$condition['stamp'] = array('lt',$endtime);
		$timeStampArray = $post_table->getField('stamp',true);//get all the stamp value in the stamp colume list in the table.
                $pidArray = $post_table->getField('pid',true);

                $objArray=array();
                $resultArray;
                $resultPidArray;
                $n = 0;
                 //to calculate the most recent 10 items in the database since the endtime. It would travel through all the elements for the stamp colume.
                 for($i = 0;$i < count($timeStampArray);$i++){
                   
                      if((strtotime($timeStampArray[$i]) < strtotime($endtime))&&($n < 10)){//if the element is less than 10, then just directly add it if the current timestamp is eariler than the endtime.
                       //  echo 11111;
                        $resultArray[$n] = strtotime($timeStampArray[$i]);
                        $resultPidArray[$n] = $pidArray[$i];//to record the final result 10 pid array which maintains the most recent 10 timestamp messages.
                        $n++;         
                       }else if((strtotime($timeStampArray[$i]) < strtotime($endtime))&&($n >= 10)){//if the element is more than 10(when n == 10),then just replace the earilest timestamp, to keep the result array always maintain 10 elements.
                          $earliest_timestamp = 111111111111111111111111111111111111111111111111111111111;//infinite large.
                          $earliest_timestamp_tag = 0;
                          for($j = 0;$j < 10;$j++){//to find the earliest timestamp in the timeStampArray ten elements,and then replace it.
                               if($resultArray[$j] < $earliest_timestamp){
                                      $earliest_timestamp = $resultArray[$j]; 
                                      $earliest_timestamp_tag = $j;         
                               }                        
                          }
                          //echo $earliest_timestamp_tag."\r\n";
                          //echo $earliest_timestamp."\r\n";
                          if(strtotime($timeStampArray[$i]) > $resultArray[$earliest_timestamp_tag]){//find the earliest timestamp,and if the current on is later than this timestamp,relace it.
                                     $resultArray[$earliest_timestamp_tag] = strtotime($timeStampArray[$i]);
                                     $resultPidArray[$earliest_timestamp_tag] = $pidArray[$i];//to record the final result 10 pid array which maintains the most recent 10 timestamp messages.
                          }                       


                      }

                }

               /*
               for($j = 0;$j < 10;$j++){
                              echo $resultPidArray[$j]."\r\n";                 
                          }*/


                //$resultPidArray owns the final 10 most recent messages' from the end_time pid, and if the most recent messages from the end_time is less than 10 messages, the $resultPidArray would only has less than 10 messages.  
                for($i = 0;$i < count($resultPidArray);$i++){
                   
                     $data['uid'] = $post_table->where('pid='.$resultPidArray[$i])->getField('uid');
                     $data['stamp'] =  $post_table->where('pid='.$resultPidArray[$i])->getField('stamp');                  
                     $data['lat'] = $post_table->where('pid='.$resultPidArray[$i])->getField('lat');
                     $data['lng'] = $post_table->where('pid='.$resultPidArray[$i])->getField('lng');                  
                     $data['category'] = $post_table->where('pid='.$resultPidArray[$i])->getField('category');
                     $data['price'] = $post_table->where('pid='.$resultPidArray[$i])->getField('price');
                     $data['title'] = $post_table->where('pid='.$resultPidArray[$i])->getField('title');
                     $data['desc'] = $post_table->where('pid='.$resultPidArray[$i])->getField('desc');
                     //output the thumbnail
                     $thn_fname = $post_table->where('pid='.$resultPidArray[$i])->getField('thn_fname');
                     $uploaded_green_time_new = $post_table->where('pid='.$resultPidArray[$i])->getField('uploaded_green_time');
                     $file = $imagepath.$data['uid']."_".$uploaded_green_time_new."_".$thn_fname;  //The thumbnail is no doubt image.
                     //echo $file;


		     $fp=fopen($file,"r");
		     if($fp){
			     $type=getimagesize($file);
			     $file_content=chunk_split(base64_encode(fread($fp,filesize($file))));
			     $order   = array("\r\n", "\n", "\r");
			     $replace = '';
			     $imgdata= str_replace($order, $replace, $file_content);
			     switch($type[2]){
				     case 1:$img_type="gif";break;  
				     case 2:$img_type="jpg";break;  
				     case 3:$img_type="png";break;  
			     }  
			     $img='data:image/'.$img_type.';base64,'.$imgdata;
			     $data['thumbnail'] = $img;
			     fclose($fp);  
		     }
		     else
			     $data['thumbnail'] = '';

                      $reply['pid'] = $resultPidArray[$i];
		      $reply['data'] = $data;
		      array_push($objArray,$reply);

                      }

		$this->ajaxReturn(json_encode($objArray),'JSON');
	}

}
?>

<?php

class UpdateAction extends Action {

    public function update(){

       global $database_operation;
     //Store the temperate $data[] array into database.
       $database_operation = M("posts");
     
     //get the metadata information of this post such as user_id,phone_number,coordinate of the location.
     foreach($_POST as $key=>$val)
     {
      echo "Post message: "."\n";
      echo "Key: ".$key."  "."Value: ".$val."\n";

       //identify the $data array is a global array.
       global $data;
       global $condition;
       $return_data['status'] = 1; //the initial value of status is 1 because most of the update text information would be correct, the problem mostly happens when update or delete files.
       //store the metadata into $data[] array which would be stored in the database
        switch($key){

           case "pid": // !required!

             $condition['pid'] = $val;  //use uid+uploaded_green_time to identify the each unique item in the database.
             break;

             
           case "lat": //update lat

             $data['lat'] = $val;
             break;

           case "lng": //update lng

              $data['lng'] = $val;
              break;

           case "category": //update category

             $data['category'] = $val;
             break;

           case "price": //update price

             $data['price'] = $val;
             break;

           case "desc": //update desc

              $data['desc'] = $val;
              break;

           case "title": //update title

              $data['title'] = $val;
              break;

          //If the post key is delete_file, then the value $val should be that corresponding file's full name.(uid_uploadedGreenTime_fileName)
          //for example:    key : delete_file, value : 12345678_1400453930_009.png

           case "delete_file_0": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_1": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_2": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;
 
           case "delete_file_3": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_4": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_5": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_6": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_7": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_8": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

           case "delete_file_9": //it is still the text post.

              $return_data['status'] = $this->deleteFile($val);
            
              break;

                 }
           }


     $return_data['status'] = $this->updateThumbnail($condition['pid']);
     $return_data['status'] = $this->addFile($condition['pid']);

     $database_operation->where($condition)->save($data);

     $return_data['pid'] = $condition['pid'];
     $this->ajaxReturn($return_data,'JSON');
 }



public function deleteFile($val){

       global $database_operation;
       global $condition; 

       list($user_id,$uploaded_green_time,$file_name) = split("_",$val);
        //   echo $val."\n";
       //    echo $user_id."\n";
      //     echo $file_name."\n";
     //      echo $uploaded_green_time."\n";
    
             if($database_operation->where('pid='.$condition['pid'])->getField('fname_1') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_1','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_1','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_1','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_2') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_2','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_2','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_2','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_3') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_3','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_3','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_3','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_4') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_4','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_4','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_4','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_5') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_5','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_5','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_5','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_6') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_6','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_6','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_6','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_7') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_7','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_7','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_7','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_8') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_8','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_8','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_8','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_9') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_9','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_9','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_9','');

             }else if($database_operation->where('pid='.$condition['pid'])->getField('fname_10') == $file_name){

                    $database_operation->where('pid='.$condition['pid'])->setField('fname_10','');
                    $database_operation->where('pid='.$condition['pid'])->setField('ftype_10','');
                    $database_operation->where('pid='.$condition['pid'])->setField('fsize_10','');

             }
            $status = 0;
            $base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
            $imagepath = $base."image/";
            $videopath = $base."video/";
            $audiopath = $base."audio/";
            $miscpath = $base."misc/";
            $file_path_1 = $imagepath.$val;
            $file_path_2 = $audiopath.$val;
            $file_path_3 = $videopath.$val;
            $file_path_4 = $miscpath.$val;
                if (!unlink($file_path_1)){ //unlink is deleting file operation. if !unlink is true, it means the delete failed,so choose another path to try.
                       
                      if (!unlink($file_path_2)){

                           if (!unlink($file_path_3)){

                                 if (!unlink($file_path_4)){
                                         echo ("Deleted Error");
                                          $status = 0;
                                   }else{echo ("Deleted $file_name"."\n");
                                         $status = 1;}

                             }else{
                                echo ("Deleted $file_name"."\n");
                                $status = 1;
                             }

                        }else{
                          echo ("Deleted $file_name"."\n");
                          $status = 1;
                        }        
       
                 }else{
                  echo ("Deleted $file_name"."\n");
                   $status = 1;
                 }

            return $status;

       }




  public function updateThumbnail($pid){

            $base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
            $imagepath = $base."image/";
            $status = 0;
	    // !empty( $_FILES['thumbnail'] ) it means if the thumbnail is null, the user doesn't update thumbnail, then exit this function. 
	    // in case the form's enctype="multipart/form-data" attribute is missing
	    // or in case your form doesn't have any file field elements
	    if(strtolower($_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty( $_FILES['thumbnail'] ))
	    {
                    $database_operation_updateThumbnail = M("posts");
                    $original_thn_fname = $database_operation_updateThumbnail->where('pid='.$pid)->getField('thn_fname');
                    $user_id = $database_operation_updateThumbnail->where('pid='.$pid)->getField('uid');
                    $current_time = $database_operation_updateThumbnail->where('pid='.$pid)->getField('uploaded_green_time');
		    global $data;
		    //The file name doesn't change,just override. 
		    $data['thn_ftype'] = $_FILES['thumbnail']['type'];
		    $data['thn_fsize'] = $_FILES['thumbnail']['size'];
		    $target_path = $imagepath.$user_id."_".$current_time."_".$original_thn_fname;
		    if(move_uploaded_file($_FILES[ 'thumbnail' ][ 'tmp_name' ],$target_path)){ //move_uploaded_file could override the original file.
			    echo "Thumbnail ".$_FILES["thumbnail"]["name"]." has been updated"."\n";  
                            $status = 1;
		    }else{  
			    echo "There was an error updating the file, please try again!".$name."\n";  
                            $status = 0;
		    }  

             }
             
             return $status;

       }

 public function addFile($pid){

            $base="/var/www/Wayne_Trading_Data/user_uploaded_image_file/";
            $imagepath = $base."image/";
            $videopath = $base."video/";
            $audiopath = $base."audio/";
            $miscpath = $base."misc/";
            $status = 0;
            // !empty( $_FILES['file'] ) it means if the file is null, the user doesn't want to add the file. 
	    // in case the form's enctype="multipart/form-data" attribute is missing
	    // or in case your form doesn't have any file field elements
	    if(strtolower($_SERVER[ 'REQUEST_METHOD' ] ) == 'post' && !empty( $_FILES))
	    {
              
              $database_operation_addFile = M("posts");
              $user_id = $database_operation_addFile->where('pid='.$pid)->getField('uid');
              $current_time = $database_operation_addFile->where('pid='.$pid)->getField('uploaded_green_time');

              $j = 1;//identify which number the current file is.
                 
                  
              
		    foreach( $_FILES[ 'file' ][ 'tmp_name' ] as $index => $tmpName )
		    {
                       //$j means the first empty fname of each loop in the database posts table in the pid item. 
                            $fname_loop = $database_operation_addFile->where('pid='.$pid)->getField('fname_'.$j);

                            while(!empty($fname_loop)){//insert,to find the first item slot which is empty.
                             $j++;
                             $fname_loop = $database_operation_addFile->where('pid='.$pid)->getField('fname_'.$j);
                            }
                   //         echo "\n".$j."\n";
           		    if (!empty($_FILES['file']['error'][$index])){

				    // some error occured with the file in index $index
				    // yield an error here
				    return false;  //return false also immediately perhaps??

			    }else if(!empty($tmpName)&&is_uploaded_file($tmpName)){  // check whether it's not empty, and whether it indeed is an uploaded file
				    $name = $_FILES['file']['name'][$index];
				    $size = $_FILES['file']['size'][$index];
				    $type = $_FILES['file']['type'][$index];
                                   
                         //             echo  "\n".$tmpName."\n";
				    //identify the $data array is a global array.
				    global $data;

				    //store the metadata into $data[] array which would be stored in the database
                                    //this $j comes from the above function and it indicates the current first empty file in this item.
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

                       //             echo  "\n".$target_path."\n";
				    //storage the data.
				    if(move_uploaded_file($tmpName,$target_path)){
					    echo "File: ".$name." has been updated"."\n";  
                                            //If upload and add the new file successfully, then immediately update the database's metadata information.
                                            //And if this uploaded failed, then next uploaded file would update the array $data[] and override the fname metadata,then we do not need to worry about that the failed uploading would still update our database's metadata.  
                                            global $data;
                                            $database_operation_addFile->where('pid='.$pid)->save($data);
                                            $status = 1;
				    }else{  
					    echo "There was an error updating the file, please try again!".$name."\n";  
                                            $status = 0;
				    }

                                    
			    }
			    
		    }
             }
             return $status;

       }


}
?>
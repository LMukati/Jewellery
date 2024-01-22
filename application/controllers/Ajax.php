<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax extends CC_Controller {
    
    public function __construct() {
      header('Access-Control-Allow-Origin: *');
      parent::__construct();
      $this->load->model('global_model', 'global_mdl');
	  $this->load->model('admin_models/products_model', 'product_mdl');
    }
    public function index() {
    }
	
	 
 
	 /*upload_image*/
	 public function upload_image() { 
	 
			if ( 0 < $_FILES['file']['error'] ) { 

			$output['msg']='<p class="error">Error: ' . $_FILES['file']['error'] . '.</p>';
			echo json_encode($output);
			die();
			}
			else {
				/*upload*/
				$type=$_REQUEST['type'];
				if($type){
				$target_dir = "assets/uploads/".$type."/";
				}else{
				$target_dir = "assets/uploads/";
				}
				
				$target_file = $target_dir . basename($_FILES["file"]["name"]);
				$output['success']='false';
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				$imageFileType = strtolower($imageFileType);

				/*  && $imageFileType != "pdf"   && $imageFileType != "txt"  && $imageFileType != "docx"  && $imageFileType != "doc" */

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" && $imageFileType != "webp"     ) {
						
					$output['msg']='<p class="error">Sorry, you can only upload JPG, JPEG, PNG and GIF files.</p>';
					echo json_encode($output);
					die();
				}
				list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']); 

				$_FILES['file']['name'] = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['file']['name']); 
				$imgname=$_FILES['file']['name']=time()."-".$_FILES['file']['name'];
				move_uploaded_file($_FILES['file']['tmp_name'], ''.$target_dir.'' . $_FILES['file']['name']); 
				
				
				
				/******rotate******/ 
				$allurl = base_url()."".$target_dir."".$imgname;	
				$exif = exif_read_data($allurl); 
				
				switch ($exif['Orientation']) {
					case 3:
					$degrees = 180;
					break;
					case 6:
					$degrees = -90;
					break;
					case 8:
					$degrees = 90;
					break;
					default:
					$degrees = 0;
				} 	 
				if($degrees!=0){	
						$fileName = $allurl;
						if($imageFileType == 'jpg' || $imageFileType == 'jpeg'){
							
							$source = imagecreatefromjpeg(''.$target_dir.''.$imgname.'');
							$rotate = imagerotate($source, $degrees, 0); 
							imagejpeg($rotate,'assets/uploads/'.$imgname.''); 
							 
							
						}else if($imageFileType == 'png'){
							
							$source = imagecreatefrompng(''.$target_dir.''.$imgname.'');
							$bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
							$rotate = imagerotate($source, $degrees, $bgColor);
							imagesavealpha($rotate, true);
							imagepng($rotate,''.$target_dir.''.$imgname.'');
						}
						
						
						imagedestroy($source);
						imagedestroy($rotate); 
				}
				
				/*****rotate*****/  
				
				
				/*quality*/
				if($imageFileType == 'jpg' || $imageFileType == 'jpeg'){
	
					$source_file=''.$target_dir.''.$imgname.'';
					$image_info = getimagesize($source_file);
					
					$nwidth = $image_info[0];
					$nheight = $image_info[1];
					
					if($nwidth>650000){
						
						$targetWidth = 650; 						
						$ratio = $nwidth / $nheight;
						$targetHeight = $targetWidth / $ratio;

						$nwidth = $targetWidth;
						$nheight = $targetHeight;  
					
					}
					
					if($quality == '' || $quality < 0 || $quality > 100){ $quality = 100; }
					
					
					
					$image = imagecreatefromjpeg($source_file);
					$thumb = imagecreatetruecolor($nwidth, $nheight);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
					$target_file = "".$target_dir."" . $imgname; 
					$success = imagejpeg($thumb, $target_file, $quality); 
				}
				
				
				
				if($imageFileType == 'png' ){
					
					$source_file=''.$target_dir.''.$imgname.'';
					$image_info = getimagesize($source_file);
			
					$nwidth = $image_info[0];
					$nheight = $image_info[1];
					
					if($nwidth>650){
						$targetWidth = 650; 						
						$ratio = $nwidth / $nheight;
						$targetHeight = $targetWidth / $ratio;
						$nwidth = $targetWidth;
						$nheight = $targetHeight;  
					}					
					
					if($quality == '' || $quality < 0 || $quality > 100){ $quality = 100; }
					
					$image = imagecreatefrompng($source_file);
					$thumb = imagecreatetruecolor($nwidth, $nheight);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
					$target_file = "".$target_dir."" . $imgname; 
					/* $success = imagejpeg($thumb, $target_file, $quality);  */
				}
				
				
				if($imageFileType == 'webp' ){
					
					$source_file=''.$target_dir.''.$imgname.'';
					$image_info = getimagesize($source_file);
			
					$nwidth = $image_info[0];
					$nheight = $image_info[1];
					
					if($nwidth>6500){
						$targetWidth = 650; 						
						$ratio = $nwidth / $nheight;
						$targetHeight = $targetWidth / $ratio;
						$nwidth = $targetWidth;
						$nheight = $targetHeight;  
					}					
					
					if($quality == '' || $quality < 0 || $quality > 100){ $quality = 80; }
					
					$image = imagecreatefromwebp($source_file);
					$thumb = imagecreatetruecolor($nwidth, $nheight);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
					
					$target_file = "".$target_dir."" . $imgname; 	 
					$success = imagewebp($thumb, $target_file, $quality); 
					
					/*change webp to jpg*/ 
					$imgname = str_replace(array("webp","WEBP"),"jpg",$imgname);
					$target_file2 = "".$target_dir."" . str_replace(array("webp","WEBP"),"png",$imgname);
					$target_file3 = "".$target_dir."" . str_replace(array("webp","WEBP"),"jpg",$imgname);
					
					$image=  imagecreatefromwebp($target_file); 
					ob_start();
					imagejpeg($image,NULL,100);
					
					
					$cont=  ob_get_contents();
					ob_end_clean();
					imagedestroy($image);
					$content =  imagecreatefromstring($cont);
					
					unlink($target_file);
					imagewebp($content,$target_file2);
					/* imagewebp($content,$target_file3); */
					imagedestroy($content);	
					/*change webp to jpg*/
					
					
				}
				
				/*quality*/
				
				$fieldname = $_REQUEST['fieldname'];
				$singleImg = $_REQUEST['singleImg'];
				
				if($singleImg=='true'){
					
					$output['list'] = '<div class="ajaximg"> <img src="'.base_url().''.$target_dir.''.$imgname.'"><a href="javascript:;" class="delete delete-img "  data-img="'.$imgname.'" ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="'.$imgname.'" name="'.$fieldname.'" > </div>';	
					
				}else{
				
					$output['list'] = '<div class="ajaximg"> <img src="'.base_url().''.$target_dir.''.$imgname.'"><a href="javascript:;" class="delete delete-img "  data-img="'.$imgname.'" ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="'.$imgname.'" name="'.$fieldname.'[]" > </div>';
				
				}
				
				$output['imgname']= ''.$imgname;
				$output['imgurl']= base_url().''.$target_dir.''.$imgname;
				$output['success']='true';
				echo json_encode($output);				
				
				/*upload*/
			}
	 
	 }
	 /*upload*/ 
	
	
	 /*product image upload*/
	 public function upload_product_image() { 
	 
			if ( 0 < $_FILES['file']['error'] ) { 

			$output['msg']='<p class="error">Error: ' . $_FILES['file']['error'] . '.</p>';
			echo json_encode($output);
			die();
			}
			else {
				/*upload*/
				$type=$_REQUEST['type'];
				if($type){
				$target_dir = "assets/uploads/".$type."/";
				}else{
				$target_dir = "assets/uploads/";
				}
				
				$target_file = $target_dir . basename($_FILES["file"]["name"]);
				$output['success']='false';
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				$imageFileType = strtolower($imageFileType);

				/*  && $imageFileType != "pdf"   && $imageFileType != "txt"  && $imageFileType != "docx"  && $imageFileType != "doc" */

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" && $imageFileType != "webp"     ) {
						
					$output['msg']='<p class="error">Sorry, you can only upload JPG, JPEG, PNG and GIF files.</p>';
					echo json_encode($output);
					die();
				}
				list($width, $height, $type, $attr) = getimagesize($_FILES['file']['tmp_name']); 

				$_FILES['file']['name'] = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['file']['name']); 
				$imgname=$_FILES['file']['name']=time()."-".$_FILES['file']['name'];
				move_uploaded_file($_FILES['file']['tmp_name'], ''.$target_dir.'' . $_FILES['file']['name']); 
				
				
				
				/******rotate******/ 
				$allurl = base_url()."".$target_dir."".$imgname;	
				$exif = exif_read_data($allurl); 
				
				switch ($exif['Orientation']) {
					case 3:
					$degrees = 180;
					break;
					case 6:
					$degrees = -90;
					break;
					case 8:
					$degrees = 90;
					break;
					default:
					$degrees = 0;
				} 	 
				if($degrees!=0){	
						$fileName = $allurl;
						if($imageFileType == 'jpg' || $imageFileType == 'jpeg'){
							
							$source = imagecreatefromjpeg(''.$target_dir.''.$imgname.'');
							$rotate = imagerotate($source, $degrees, 0); 
							imagejpeg($rotate,'assets/uploads/'.$imgname.''); 
							 
							
						}else if($imageFileType == 'png'){
							
							$source = imagecreatefrompng(''.$target_dir.''.$imgname.'');
							$bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
							$rotate = imagerotate($source, $degrees, $bgColor);
							imagesavealpha($rotate, true);
							imagepng($rotate,''.$target_dir.''.$imgname.'');
						}
						
						
						imagedestroy($source);
						imagedestroy($rotate); 
				}
				
				/*****rotate*****/  
				
				
				/*quality*/
				if($imageFileType == 'jpg' || $imageFileType == 'jpeg'){
	
					$source_file=''.$target_dir.''.$imgname.'';
					$image_info = getimagesize($source_file);
					
					$nwidth = $image_info[0];
					$nheight = $image_info[1];
					
					if($nwidth>650){
						
						$targetWidth = 650; 						
						$ratio = $nwidth / $nheight;
						$targetHeight = $targetWidth / $ratio;

						$nwidth = $targetWidth;
						$nheight = $targetHeight;  
					
					}
					
					if($quality == '' || $quality < 0 || $quality > 100){ $quality = 100; }
					
					
					
					$image = imagecreatefromjpeg($source_file);
					$thumb = imagecreatetruecolor($nwidth, $nheight);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
					$target_file = "".$target_dir."" . $imgname; 
					$success = imagejpeg($thumb, $target_file, $quality); 
				}
				
				
				
				if($imageFileType == 'png' ){
					
					$source_file=''.$target_dir.''.$imgname.'';
					$image_info = getimagesize($source_file);
			
					$nwidth = $image_info[0];
					$nheight = $image_info[1];
					
					if($nwidth>650){
						$targetWidth = 650; 						
						$ratio = $nwidth / $nheight;
						$targetHeight = $targetWidth / $ratio;
						$nwidth = $targetWidth;
						$nheight = $targetHeight;  
					}					
					
					if($quality == '' || $quality < 0 || $quality > 100){ $quality = 100; }
					
					$image = imagecreatefrompng($source_file);
					$thumb = imagecreatetruecolor($nwidth, $nheight);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
					$target_file = "".$target_dir."" . $imgname; 
					/* $success = imagejpeg($thumb, $target_file, $quality);  */
				}
				
				
				if($imageFileType == 'webp' ){
					
					$source_file=''.$target_dir.''.$imgname.'';
					$image_info = getimagesize($source_file);
			
					$nwidth = $image_info[0];
					$nheight = $image_info[1];
					
					if($nwidth>650){
						$targetWidth = 650; 						
						$ratio = $nwidth / $nheight;
						$targetHeight = $targetWidth / $ratio;
						$nwidth = $targetWidth;
						$nheight = $targetHeight;  
					}					
					
					if($quality == '' || $quality < 0 || $quality > 100){ $quality = 80; }
					
					$image = imagecreatefromwebp($source_file);
					$thumb = imagecreatetruecolor($nwidth, $nheight);
					imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
					
					$target_file = "".$target_dir."" . $imgname; 	 
					$success = imagewebp($thumb, $target_file, $quality); 
					
					/*change webp to jpg*/ 
					$imgname = str_replace(array("webp","WEBP"),"jpg",$imgname);
					$target_file2 = "".$target_dir."" . str_replace(array("webp","WEBP"),"png",$imgname);
					$target_file3 = "".$target_dir."" . str_replace(array("webp","WEBP"),"jpg",$imgname);
					
					$image=  imagecreatefromwebp($target_file); 
					ob_start();
					imagejpeg($image,NULL,100);
					
					
					$cont=  ob_get_contents();
					ob_end_clean();
					imagedestroy($image);
					$content =  imagecreatefromstring($cont);
					
					unlink($target_file);
					imagewebp($content,$target_file2);
					/* imagewebp($content,$target_file3); */
					imagedestroy($content);	
					/*change webp to jpg*/
					
					
				}
				
				/*quality*/
				
				$fieldname = $_REQUEST['fieldname'];
				$singleImg = $_REQUEST['singleImg'];
				
				 
				
				$output['list'] = '<div class="ajaximg"> <img src="'.base_url().''.$target_dir.''.$imgname.'"><a href="javascript:;" class="delete delete-img "  data-img="'.$imgname.'" ><i class="fa fa-times-circle" aria-hidden="true"></i></a> <input type="hidden" value="'.$imgname.'" name="'.$fieldname.'[]" > 
				 <span class="mark-featured"> <input  type="checkbox" name="gallery_featured"  class="col-is-featured" value="'.$imgname.'" > Mark as featured</span>
				</div>';
				
				 
				
				$output['imgname']= ''.$imgname;
				$output['imgurl']= base_url().''.$target_dir.''.$imgname;
				$output['success']='true';
				echo json_encode($output);				
				
				/*upload*/
			}
	 
	 }
	 /*product image upload*/ 
    } 
	
	
	
	
?>
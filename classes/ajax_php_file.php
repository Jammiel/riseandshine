
<?php
error_reporting(0);
$result = "";
for($i = 1;$i <= 3;$i++){
	if(isset($_FILES["file".$i]["type"])){
		$imgFile = $_FILES['file'.$i]['name'];   
		$tmp_dir = $_FILES['file'.$i]['tmp_name'];  
		$imgSize = $_FILES['file'.$i]['size'];
		
		$user_pic =(($_POST['userpic'.$i])?$_POST['userpic'.$i]:"");
			$userpic = "";
			if($imgFile){
				$upload_dir = 'upload/'; // upload directory
				$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
				$valid_extensions = array("jpeg", "jpg", "png","PNG","JPEG","JPG","GIF","gif"); // valid extensions
				$userpic = rand(1000,1000000).".".$imgExt;
				if(in_array($imgExt, $valid_extensions)){
					if($imgSize < 1000000000){ 
						if(!empty($_POST['userpic'.$i])){
							if (file_exists("upload/" . $_POST['userpic'.$i])) {
								unlink($upload_dir.$user_pic); 
							} 
						}
						move_uploaded_file($tmp_dir,$upload_dir.$userpic);
					}else{
							$errMSG = "Sorry, your file is too large it should be less then 5MB";
					}
				}else{
					$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				}
			}else{
				$userpic = $user_pic;
			}
			$result .=",". $userpic;
	}
}
	$length = strlen($result);
	$output[0] = substr($result, 0, 1);
	$output[1] = substr($result, 1, $length);
	$data = $output;
	echo $data[1];
?>
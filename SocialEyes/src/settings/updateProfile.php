<?php
session_start();
include_once '../postgres/query.php';
$o=new query();
echo print_r($_FILES);
if(isset($_FILES["image"])){
	$target_dir = "../uploads/";
	$target_file = $target_dir . basename ( $_FILES ["image"] ["name"] );
	$uploadOk = 1;
	$imageFileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
	// Check if image file is a actual image or fake image
	echo "tar ".$target_file;
	if (isset ( $_POST ["submit"] )) {
		$check = getimagesize ( $_FILES ["image"] ["tmp_name"] );
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			echo "<script>alert('File is not an image.');window.location='../../web/settings.php';</script>";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists ( $target_file )) {
		echo "<script>alert('Sorry, file already exists.');window.location='../../web/settings.php';</script>";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
		echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');window.location='../../web/settings.php';</script>";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "<script>alert('Sorry, your file was not uploaded.');window.location='../../web/settings.php';</script>";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file ( $_FILES ["image"] ["tmp_name"], $target_file )) {
			//echo "The file " . basename ( $_FILES ["image"] ["name"] ) . " has been uploaded.";
			$id=strtotime ( "now" );
			rename ( $target_file, $target_dir . $id . "." . $imageFileType );
			$target_file=$target_dir . $id . "." . $imageFileType;
			$o->putImageToGallery($id, $_SESSION['user']['id'],$target_file);
			$o->updatePropic($_SESSION['user']['id'], $id);
			echo "<script>alert('Profile Picture Updated.');window.location='../../web/settings.php';</script>";
		} else {
			echo "<script>alert('Sorry, there was an error uploading your file.');window.location='../../web/settings.php';</script>";
		}
	}
}
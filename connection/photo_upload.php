<?php 
require_once(__DIR__ .'/../includes/autoload.php');

$data = $user;

// Check if this upload is ajax
if (isset($_POST['ajax_photo'])) {
  $ajax_image_ = explode(';',$_POST['ajax_photo']);
  $ajax_image_ = isset($ajax_image_[1]) ? $ajax_image_[1] : null;
}

if (!empty($ajax_image_)) {
  $image = $_POST['ajax_photo'];
  list($type, $image) = explode(';',$image);
  list(, $image) = explode(',',$image);
  $image = base64_decode($image);

  $new_image = mt_rand().'_'.mt_rand().'_'.mt_rand().'_n.png';
 
  $imgexist = $_GET["pid"];

  // Save the new image to the upload directory  
  file_put_contents('../uploads/img/'.$new_image, $image);  

  // delete the old image if not gallery
  if ($imgexist != '') {
    deleteFile(0, $imgexist);
  }

  // Link image to DB 
  $msg = savePhoto($new_image, $data['id']);
  $class = 1;
} elseif (empty($ajax_image_)) {
  $msg = 'Please choose a valid image file';
  $class = 3;
} 
echo messageNotice($msg, $class);

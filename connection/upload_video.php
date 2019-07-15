<?php 
require_once(__DIR__ .'/../includes/autoload.php');

// $data = array('something' => '$main_content', 'loader' => '$loader', 'navigation' => '$navigation');
// echo json_encode($data, JSON_UNESCAPED_SLASHES); 


//   $cd = getcwd();  
//   echo $target_path = $cd.'/uploads/videos/'.$cd;
// //upload.php

// A list of permitted file extensions
$allowed = array('mp4');
$source = isset($_FILES['videoSource']) ? $_FILES['videoSource'] : null;
$mid = $framework->db_prepare_input($_POST['module_id']);

if(isset($_FILES['videoSource']) && $source['error'] == 0){

    $extension = pathinfo($source['name'], PATHINFO_EXTENSION);

    if(!in_array(strtolower($extension), $allowed)){
        echo '{"status":"error", "msg":"You may only upload MP4 video files", "rslt":"empty"}';
        exit;
    }
    $new_vid = mt_rand().'_'.mt_rand().'_v.'.$extension;
  	$cd = getcwd(); 
  	$target_path = '../uploads/videos/';
    if(move_uploaded_file($source['tmp_name'], $target_path.$new_vid)){
        $x = getModules(2, $mid)[0];
        deleteFile(1, $x['video']);
        $sql = sprintf("UPDATE " . TABLE_MODULES . " SET `video` = '%s' WHERE id = '%s'", $new_vid, $mid);
        $results = $framework->dbProcessor($sql, 0, 1);
        if ($results == 1) {
            echo '{"status":"success", "msg":"Upload Complete", "rslt":"'.$new_vid.'"}';
        } else {
            echo '{"status":"error", "msg":"DB Error: '.$results.'", "rslt":"empty"}';
        }
        exit;
    }
}

echo '{"status":"error", "msg":"You may not upload an empty file", "rslt":"empty"}';
exit;

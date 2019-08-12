<?php 
require_once(__DIR__ .'/../includes/autoload.php');

$preview = '';
$msg = '';
if (isset($_POST['youtube_url'])) {

    $post_url = $framework->db_prepare_input($_POST['youtube_url']);
    $mid = $framework->db_prepare_input($_POST['moduleid']);
 
    if ($_POST['youtube_url'] == '') {
        $msg = messageNotice('Youtube Embed URL cannot be empty');
    } elseif (!filter_var($post_url, FILTER_VALIDATE_URL)) {
        $msg = messageNotice('You have provided an invalid URL');
    } elseif (strpos($post_url, "youtube.com") == false) {
        $msg = messageNotice('Only Youtube URLs are allowed');
    } elseif (strpos($post_url, "/embed/") == false) {
        $msg = messageNotice('This is not a valid embed URL, a valid one would look like: https://www.youtube.com/embed/AbcD3Fgh1Jk');
    } else {
        $x = getModules(2, $mid)[0];
        deleteFile(1, $x['video']);
        $sql = sprintf("UPDATE " . TABLE_MODULES . " SET `video` = '%s' WHERE id = '%s'", $post_url, $mid);
        $results = $framework->dbProcessor($sql, 0, 1);
        if ($results == 1) {
            $msg = messageNotice('Video uploaded successfully', 1);
            $x = getModules(2, $mid)[0];
            $preview = ' 
                <iframe 
                    width="280" 
                    height="210" 
                    style="border:none; background:gray;
                    src="' . getVideo($x['video']) . '">
                </iframe>';
        } else {
            $msg = messageNotice($results, 3);
        }
    }
    $data = array('msg' => $msg, 'preview' => $preview);
    echo json_encode($data, JSON_UNESCAPED_SLASHES);  
} else {
                
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
        $target_path = $SETT['working_dir'].'/uploads/videos/';
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
}

<?php 
require_once(__DIR__ .'/../includes/autoload.php');
$id = $_POST['type'] == 2 ? $_POST['country_id'] : $_POST['state_id'];

// get locale
$locale = getLocale($_POST['type'], $id);
$all_locale = '';

if ($locale) {
	foreach ($locale as $list) {
		if (isset($user)) {
			if ($_POST['type'] == 1) {
				if ($user['state'] == $list['name']) {
					$sel = ' selected = "selected"';
				} else {
					$sel = '';
				}
			} elseif ($_POST['type'] == 2) {
				if ($user['city'] == $list['name']) {
					$sel = ' selected = "selected"';
				} else {
					$sel = '';
				}
			} else {
				if ($user['country'] == $list['name']) {
					$sel = ' selected = "selected"';
				} else {
					$sel = '';
				}
			}
		} else {
			$sel = '';
		}
		$all_locale .= '<option'.$sel.' value="'.$list['name'].'" id="'.$list['id'].'">'.$list['name'].'</option>';
	}
} else {
	$stmt = $_POST['type'] == 1 ? 'cities for this state' : 'states for this country';
	$all_locale .= '<option selected="selected" disabled="disabled">No '.$stmt.'</option>'; 
}

$data = $all_locale;

echo $data;
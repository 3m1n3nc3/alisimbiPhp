<?php

function mainContent() {
	global $PTMPL, $LANG, $SETT; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = $LANG['welcome'];	 
	
	$PTMPL['site_url'] = $SETT['url'];

	$PTMPL['name'] = $LANG['name']; 
	$PTMPL['intro'] = $LANG['intro']; 
	$PTMPL['goal'] = 'This is my goal';

	// Dont touch anything below this line
	$theme = new themer('homepage/content');
	return $theme->make();
}
?>
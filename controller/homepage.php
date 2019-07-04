<?php

function mainContent() {
	global $PTMPL, $LANG, $SETT; 

	$PTMPL['page_title'] = $LANG['welcome'];	 
	
	$PTMPL['site_url'] = $SETT['url'];

	$PTMPL['name'] = $LANG['name']; 
	$PTMPL['intro'] = $LANG['intro']; 
	$PTMPL['goal'] = 'This is my goal';

	// Set the active landing page_title 
	$theme = new themer('homepage/content');
	return $theme->make();
}
?>
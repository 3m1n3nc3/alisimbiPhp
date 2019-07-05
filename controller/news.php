<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);	 
	$PTMPL['site_url'] = $SETT['url'];

	if (isset($_GET['read'])) {
		$read = getNews($_GET['read'])[0];
		echo $PTMPL['news_title'] = $read['title'];
	}


	// Change themer('hompage/content') to themer('yourhtmldirectory/yourfile')
	$theme = new themer('news/content');
	return $theme->make();
}
?>	

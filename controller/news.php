<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);	 
	$PTMPL['site_url'] = $SETT['url'];

	if (isset($_GET['read'])) {
		$read = getNews($_GET['read'])[0];
		$PTMPL['news_title'] = $read['title'];
		$PTMPL['news_photo'] = '<p><img src="'.getImage($read['image'], 1).'" class="image_class"></p>';
		$PTMPL['news_content'] = $read['content'];
		$PTMPL['news_date'] = $marxTime->timeAgo(strtotime($read['date']), 1);
	}

	// Change themer('hompage/content') to themer('yourhtmldirectory/yourfile')
	$theme = new themer('news/content');
	return $theme->make();
}
?>	

<?php

function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework;
	// Dont touch anything above this line

	$PTMPL['page_title'] = getHome('1')[0]['title'];

	$PTMPL['site_url'] = $SETT['url'];

	$PTMPL['future_agribiz'] = getHome('1')[0]['intro'];
	$PTMPL['description'] = getHome('1')[0]['description'];
	$PTMPL['learn_relevant'] = $LANG['learn_relevent'];

	$PTMPL['news'] = 'Recent Agric News & Opportunities';
	$PTMPL['vlog'] = 'Alisimbi Agribusiness Trainings (FARM 101)';
	$PTMPL['testimony'] = 'Testimonials';
	$PTMPL['sponsors'] = 'Sponsors';

	// Fetch and Show the news content
	$newser = getNews();
	$news_list = '';
	foreach ($newser as $content) {
		$image = getImage($content['image'], 1);
		$news_content = $framework->myTruncate($content['content'], 150);
		$link = cleanUrls($SETT['url'].'/?page=news&read='.$content['link'].'&id='.$content['id']);
		$news_list .= '
			<div class="border-blue padding-5 inline-blk margin-5 news-slider">'
				 . '<span class="bolden">'.$content['title'].'</span>'
				 . '<p><img src="'.$image.'" class="image_class"></p>'
				 . '<div class="details">'.$news_content.' <a href="'.$link.'">Read More</a></div>' .
			'</div>';
	}
	$PTMPL['new_lisiting'] = $news_list;

	// Fetch and Show the vlog content 
	$vloger = getVlog();
	$vlog_list = '';
	foreach ($vloger as $content) {
		$video = getVideo($content['video']);
		$image = getImage($content['image'], 1);
		$vlog_content = $framework->myTruncate($content['content'], 150);
		$link = cleanUrls($SETT['url'].'/?page=training&view='.$content['link'].'&id='.$content['id']);
		$vlog_list .= '
			<div class=" news-slider">'
				 . '<span class="bolden">'.$content['title'].'</span>'
				 . '<p><img src="'.$image.'" class="image_class"></p>'
				 . '<div class="details">'.$vlog_content.' <a href="'.$link.'">Read More</a></div>' .
			'</div>';
	}
	$PTMPL['vloger'] = $vlog_list;

	// Fetch and Show the vlog content
	$testimonial = getTestimonials();
	$testimonial_list = '';
	foreach ($testimonial as $content) {
		$image = getImage($content['image'], 1);
		$testimonial_content = $framework->myTruncate($content['content'], 150);
		$testimonial_list .= '
			<div class="border-blue padding-5 inline-blk margin-5 news-slider">'
				 . '<p><img src="'.$image.'" class="avatar"></p>'
				 . '<span class="bolden">'.$content['name'].'</span><br>'
				 . '<span class="italicit">'.$content['organisation'].'</span>'
				 . '<div class="details">'.$testimonial_content.'</div>' .
			'</div>';
	}
	$PTMPL['testimonial'] = $testimonial_list;

	// Fetch and Show the vlog content
	$sponsors =  getSponsors();
	$sponsors_list = '';
	if ($sponsors) {
		foreach ($sponsors as $content) {
			$image = getImage($content['image'], 1);
			$sponsors_desc = $framework->myTruncate($content['description'], 150);
			$sponsors_list .= '
				<div class="border-blue padding-5 inline-blk margin-5 news-slider">'
					 . '<p><img src="'.$image.'" class="avatar"></p>'
					 . '<span class="bolden">'.$content['name'].'</span><br>'
					 . '<span class="italicit">'.$content['company'].'</span>'
					 . '<div class="details">'.$sponsors_desc.'</div>' .
				'</div>';
		}
		$PTMPL['sponsors_list'] = $sponsors_list;
	}


	// Set social values
	$contact = getContactInfo()[0];
	$facebook = $twitter = $instagram = $youtube = '';

	if (isset($contact['facebook'])) {
    	$facebook = '
        	<li><a href="http://facebook.com/'.$contact['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
	}
	if (isset($contact['twitter'])) {
    	$twitter = '
        	<li><a href="http://twitter.com/'.$contact['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
	}
	if (isset($contact['instagram'])) {
    	$instagram = '
       		<li><a href="http://instagram.com/'.$contact['instagram'].'"><i class="fa fa-instagram"></i></a></li>';
	}
	if (isset($contact['youtube'])) {
    	$youtube = '
        	<li><a href="http://youtube.com/'.$contact['youtube'].'"><i class="fa fa-youtube"></i></a></li>';

	}

    $PTMPL['social'] = $facebook.$twitter.$instagram.$youtube;
    $PTMPL['copyright'] = $LANG['copyright'].' &copy; '. date('Y').' '.$contact['c_line'];
    $PTMPL['address'] = $contact['address'];
    $PTMPL['email'] = $contact['email'];
    $PTMPL['phone'] = $contact['phone'];
    $PTMPL['login_slider'] = accountAccess();


		// get countries
		$countries = getLocale();
		$all_countries = '';
		foreach ($countries as $list) {
				$all_countries .= '<option value="'.$list['name'].'" id="'.$list['id'].'">'.$list['name'].'</option>';
		}
		$PTMPL['countries'] = $all_countries;
		
	// Dont touch anything below this line
	$theme = new themer('homepage/content');
	return $theme->make();
}
?>

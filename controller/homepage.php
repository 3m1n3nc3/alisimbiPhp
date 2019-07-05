<?php

function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = getHome('1')[0]['title'];	 
	
	$PTMPL['site_url'] = $SETT['url'];

	$PTMPL['future_agribiz'] = getHome('1')[0]['intro']; 
	$PTMPL['description'] = getHome('1')[0]['description'];

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
		$link = cleanUrls($SETT['url'].'/index.php?page=news&read='.$content['link'].'&id='.$content['id']);
		$news_list .= '
			<div class="border-blue padding-5 inline-blk margin-5 news-slider">'
				 . '<span class="bolden">'.$content['title'].'</span>' 
				 . '<p><img src="'.$image.'" class="image_class"></p>'
				 . '<div class="details">'.$news_content.' <a href="'.$link.'">Read More</a></div>' .
			'</div>'; 
	}
	$PTMPL['newser'] = $news_list;

	// Fetch and Show the vlog content
	$vloger = getVlog(); 
	$vlog_list = '';
	foreach ($vloger as $content) {
		$video = getVideo($content['video']);
		$image = getImage($content['image'], 1);
		$vlog_content = $framework->myTruncate($content['content'], 150);
		$link = cleanUrls($SETT['url'].'/index.php?page=trainings&view='.$content['link'].'&id='.$content['id']);
		$vlog_list .= '
			<div class="border-blue padding-5 inline-blk margin-5 news-slider">'
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

	$contact = getContactInfo()[0];
	$PTMPL['copyright'] = '&copy; '. date('Y').' '.$contact['c_line'];
	$PTMPL['address'] = $contact['address'];

	//Email Address
	$PTMPL['email_var'] = $contact['email'];
	$PTMPL['email'] = '<a href="mailto:'.$contact['email'].'" id="contact_email">'.$contact['email'].'</a>';

	//Phone number
	$PTMPL['phone_var'] = $contact['phone'];
	$PTMPL['phone'] = '
		<a href="tel:'.$contact['phone'].'" id="contact_phone">'.$contact['phone'].'</a>';

	//Facebook
	$PTMPL['facebook_var'] = $contact['facebook'];
	$PTMPL['facebook'] = '
		<a href="http://facebook.com/'.$contact['facebook'].'" id="contact_facebook">http://facebook.com/'.$contact['facebook'].'</a>';

	//Twitter
	$PTMPL['twitter_var'] = $contact['twitter'];
	$PTMPL['twitter'] = '
		<a href="http://twitter.com/'.$contact['twitter'].'" id="contact_twitter">http://twitter.com/'.$contact['twitter'].'</a>';

	//Instagram
	$PTMPL['instagram_var'] = $contact['instagram'];
	$PTMPL['instagram'] = '
		<a href="http://instagram.com/'.$contact['instagram'].'" id="contact_instagram">http://instagram.com/'.$contact['instagram'].'</a>';
	
	//Youtube
	$PTMPL['youtube_var'] = $contact['youtube'];
	$PTMPL['youtube'] = '
		<a href="http://youtube.com/'.$contact['youtube'].'" id="contact_youtube">http://youtube.com/'.$contact['youtube'].'</a>';
	
	//Signup links
	if (!isset($user)) {
		$PTMPL['learn_signup'] = '<a href="#" id="learn_signup">Signup to Learn</a>';
		$PTMPL['teach_signup'] = '<a href="#" id="teach_signup">Signup to Teach</a>';
	}

	$PTMPL['support_alisimbi'] = $LANG['support_alisimbi'].' '.$LANG['or'].' '.$LANG['make_donation'];
	$PTMPL['donate_btn'] = '<a href="#" class="pass-btn" id="donate_btn">'.$LANG['donate'].'</a>';

	// Dont touch anything below this line
	$theme = new themer('homepage/content');
	return $theme->make();
}
?>
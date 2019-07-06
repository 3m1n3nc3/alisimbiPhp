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
		$link = cleanUrls($SETT['url'].'/index.php?page=training&view='.$content['link'].'&id='.$content['id']);
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

	// Dont touch anything below this line
	$theme = new themer('homepage/content');
	return $theme->make();
}
?>
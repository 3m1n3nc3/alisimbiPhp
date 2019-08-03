<?php

function mainContent() {
    global $PTMPL, $LANG, $SETT, $configuration, $framework, $user, $user_role;
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

    if ($user && $user_role < 3) {
        $framework->redirect('account&profile=home');
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
        $all_countries .= '<option value="' . $list['name'] . '" id="' . $list['id'] . '">' . $list['name'] . '</option>';
    }
    $PTMPL['countries'] = $all_countries;
		
	// Dont touch anything below this line
	$theme = new themer('homepage/content');
	return $theme->make();
}


<?php 
function errorMessage($str) {
    $string = "
            <div style='text-align: center; padding: 0.35rem 1.01rem;' class='notice danger-notice'>
                <strong>".$str."</strong>  
            </div>
        ";
    return $string;
}

function successMessage($str) {
    $string = "
            <div style='text-align: center; padding: 0.35rem 1.01rem;' class='notice success-notice'>
                <strong>".$str."</strong> 
            </div>
        ";
    return $string;
}

function warningMessage($str) {
    $string = "
            <div style='text-align: center; padding: 0.35rem 1.01rem;' class='notice warning-notice'>
                <strong>".$str."</strong>
            </div>
        ";
    return $string;
}

function infoMessage($str) {
    $string = "
            <div style='text-align: center; padding: 0.35rem 1.01rem;' class='notice info-notice'>
                <strong>".$str."</strong>
            </div>
        ";
    return $string;
}

function getImage($image, $type = null) {
    global $SETT;
    if (!$image) {
        $dir = $SETT['url'].'/uploads/img/';
        $image = 'default.png';
        return $dir.$image;
    }
    if ($type == null) {
        // Site specific images
       $dir = $SETT['url'].'/'.$SETT['template_url'].'/img/';
    } else {
        // Deletable images
        $dir = $SETT['url'].'/uploads/img/';
    }
    return $dir.$image;
}

function getVideo($video) {
    global $SETT, $framework;
    $link = $framework->determineLink($video);

    if ($link) {
        $video = $link;
    } else {
        $video = $SETT['url'].'/uploads/videos/'.$video;
    }
    return $video;
}

function getHome($content) {
    global $framework;
    $content = $framework->db_prepare_input($content);
    $sql = sprintf("SELECT * FROM " . TABLE_HOME . " WHERE title = '%s' OR id = '%s'", $content, $content);
    return $framework->dbProcessor($sql, 1);
}

function getTestimonials() {
    global $framework;
    $sql = sprintf("SELECT * FROM " . TABLE_TESTIMONIAL);
    return $framework->dbProcessor($sql, 1);
}

function getSponsors() {
    global $framework;
    $sql = sprintf("SELECT * FROM " . TABLE_SPONSORS);
    return $framework->dbProcessor($sql, 1);
}

function getNews($link = null) {
    global $framework;
    $link = $framework->db_prepare_input($link);
    if ($link) {
        $sql = sprintf("SELECT * FROM " . TABLE_NEWS . " WHERE link = '%s' OR id = '%s' AND state = '1'", $link, $link);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_NEWS . " WHERE state = '1'");
    }
    return $framework->dbProcessor($sql, 1);
}

function getVlog($link = null) {
    global $framework;
    $link = $framework->db_prepare_input($link);
    if ($link) {
        $sql = sprintf("SELECT * FROM " . TABLE_TRAINING . " WHERE link = '%s' OR id = '%s'", $link, $link);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_TRAINING . " WHERE state = '1'");
    }
    return $framework->dbProcessor($sql, 1);
}

function getContactInfo($id = null) {
    global $framework;
    $id = $framework->db_prepare_input($id);
    if ($id) {
        $id = $id;
    } else {
        $id = '1';
    }
    $sql = sprintf("SELECT * FROM " . TABLE_CONTACT . " WHERE id = '%s'", $id);
    return $framework->dbProcessor($sql, 1);
}
    
/**
/* This function will convert your urls into cleaner urls
**/
function cleanUrls($url) {
    global $configuration; //$configuration['cleanurl'] = 1;
    if ($configuration['cleanurl']) {
        $pager['homepage']      =   'index.php?page=homepage';
        $pager['news']          =   'index.php?page=news';
        $pager['trainings']     =   'index.php?page=trainings';

        if(strpos($url, $pager['homepage'])) {
            $url = str_replace(array($pager['homepage'], '&user=', '&read='), array('homepage', '/', '/'), $url);
        } elseif(strpos($url, $pager['news'])) {
            $url = str_replace(array($pager['news'], '&read=', '&id'), array('news', '/', '/'), $url);
        } elseif(strpos($url, $pager['trainings'])) {
            $url = str_replace(array($pager['trainings'], '&view=', '&id'), array('trainings', '/', '/'), $url);
        }
    }
    return $url;
}

// Side navigation contest management dropdown menu
function contactInformation() {
    global $LANG, $PTMPL, $SETT, $settings;

    $theme = new themer('container/footer'); $footer = '';
    $OLD_THEME = $PTMPL; $PTMPL = array(); 

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

    $footer = $theme->make(); 
    $PTMPL = $OLD_THEME; unset($OLD_THEME);
    return $footer;
} 
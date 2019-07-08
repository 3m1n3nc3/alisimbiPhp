<?php 
function errorMessage($str) {
    $string = "
            <span style='text-align: center; padding: 0.35rem 1.01rem;' class='alert alert-danger'>
                <strong>".$str."</strong>  
            </span>
        ";
    return $string;
}

function successMessage($str) {
    $string = "
            <span style='text-align: center; padding: 0.35rem 1.01rem;' class='alert alert-success'>
                <strong>".$str."</strong> 
            </div>
        ";
    return $string;
}

function warningMessage($str) {
    $string = "
            <span style='text-align: center; padding: 0.35rem 1.01rem;' class='alert alert-warning'>
                <strong>".$str."</strong>
            </div>
        ";
    return $string;
}

function infoMessage($str) {
    $string = "
            <span style='text-align: center; padding: 0.35rem 1.01rem;' class='alert alert-info'>
                <strong>".$str."</strong>
            </div>
        ";
    return $string;
}

function seo_plugin($image, $twitter, $facebook, $desc, $title) {
    global $SETT, $PTMPL, $configuration, $site_image;

    $twitter = ($twitter) ? $twitter : $configuration['site_name'];
    $facebook = ($facebook) ? $facebook : $configuration['site_name'];
    $title = ($title) ? $title.' ' : '';
    $titles = $title.'On '.$configuration['site_name'];
    $image = ($image) ? $image : $site_image;
    $alt = ($title) ? $title : $titles;
    $desc = rip_tags(strip_tags(stripslashes($desc)));
    $desc = strip_tags(myTruncate($desc, 350));
    $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    $plugin = '
    <meta name="description" content="'.$desc.'"/>
    <link rel="canonical" href="'.$url.'" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="'.$titles.'" />
    <meta property="og:url" content="'.$url.'"/>
    <meta property="og:description" content="'.$desc.'" />
    <meta property="og:site_name" content="'.$configuration['site_name'].'" />
    <meta property="article:publisher" content="https://www.facebook.com/'.$configuration['site_name'].'" />
    <meta property="article:author" content="https://www.facebook.com/'.$facebook.'" />
    <meta property="og:image" content="'.$image.'" />
    <meta property="og:image:secure_url" content="'.$image.'" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta property="og:image:alt" content="'.$alt.'" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="'.$desc.'" />
    <meta name="twitter:title" content="'.$titles.'" />
    <meta name="twitter:site" content="@'.$configuration['site_name'].'" />
    <meta name="twitter:image" content="'.$image.'" />
    <meta name="twitter:creator" content="@'.$twitter.'" />';
    return $plugin;
}

function getLocale($type = null, $id = null) {
    global $framework;
    if ($type == 1) {
        $sql = sprintf("SELECT * FROM " . TABLE_CITIES . " WHERE state_id = '%s'", $id);
    } elseif ($type == 2) {
        $sql = sprintf("SELECT * FROM " . TABLE_STATES . " WHERE country_id = '%s'", $id);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_COUNTRIES);
    }
    if ($type == 3) {
        $list = getLocale();
        $listed = '';
        foreach($list as $name) {
            if($id == $name['name']) {
                $selected = ' selected="selected"';
            } else {
                $selected = '';
            }
            $listed .= '<option id="'.$name['id'].'" value="'.$name['name'].'"'.$selected.'>'.$name['name'].'</option>';
        }
        return $listed;
    } else {
        return $framework->dbProcessor($sql, 1);
    }
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

function getCourses($type = null) {
    global $framework;
    if ($type) {
        # code...
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSES);
    }
    return $framework->dbProcessor($sql, 1);
}

function getNews($link = null) {
    global $framework;
    if ($link) {
        $sql = sprintf("SELECT * FROM " . TABLE_NEWS . " WHERE link = '%s' OR id = '%s' AND state = '1'", $link, $link);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_NEWS . " WHERE state = '1'");
    }
    return $framework->dbProcessor($sql, 1);
}

function getVlog($link = null) {
    global $framework;
    if ($link) {
        $sql = sprintf("SELECT * FROM " . TABLE_TRAINING . " WHERE link = '%s' OR id = '%s'", $link, $link);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_TRAINING . " WHERE state = '1'");
    }
    return $framework->dbProcessor($sql, 1);
}

function getContactInfo($id = null) {
    global $framework;
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
function contactInformation($type = null) {
    global $LANG, $PTMPL, $SETT, $settings;

    $contact = getContactInfo()[0];
    if ($type) {
        $PTMPL['address'] = $contact['address'];
    } else {
        
    }
    $theme = new themer('container/footer'); $footer = '';
    $OLD_THEME = $PTMPL; $PTMPL = array(); 

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
 
function accountAccess($type = null) {
    global $LANG, $PTMPL, $SETT, $settings;
    if ($type == 0) {
        $theme = new themer('homepage/signup'); $footer = '';
    } else {
        $theme = new themer('homepage/login'); $footer = '';
    }
    
    $OLD_THEME = $PTMPL; $PTMPL = array(); 
    
    $PTMPL['register_link'] = cleanUrls($SETT['url'].'/index.php?page=account&register=true');


    $footer = $theme->make(); 
    $PTMPL = $OLD_THEME; unset($OLD_THEME);
    return $footer;
}

// course and modules boxes HTML
function courseModuleCard($image, $title, $intro, $duration, $view, $edit) {
    $card = '
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <img src="'.$image.'" class="card-img-top">
            <div class="card-body">
                <h4 class="card-title">'.$title.'</h4>
                <p class="card-text"> '.$intro.' </p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="'.$view.'" class="btn btn-sm btn-outline-secondary">View</a>
                        <a href="'.$edit.'" class="btn btn-sm btn-outline-secondary">Edit</a> 
                    </div>
                    <small class="text-muted">'.$duration.'</small>
                </div>
            </div>
        </div>
    </div>
    ';
    return $card;
}
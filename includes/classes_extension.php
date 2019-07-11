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
    // $framework->
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
    }
    if ($type == null) {
        // Site specific images
       $dir = $SETT['url'].'/'.$SETT['template_url'].'/img/';
    } elseif ($type == 2) {
        // More Site specific images
       $dir = $SETT['url'].'/'.$SETT['template_url'].'/images/';
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

function getCourses($type = null, $course = null) {
    global $framework;
    if ($type) {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSES . " WHERE id = '%s' AND status = '1'", $course);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSES);
    }
    return $framework->dbProcessor($sql, 1);
}

function getModules($type = null, $course = null) {
    global $framework;
    if ($type) {
        $sql = sprintf("SELECT * FROM " . TABLE_MODULES . " AS modules LEFT JOIN " . TABLE_COURSE_MODULES . " AS course_modules ON `modules`.`id` = `course_modules`.`module_id`"
                . " WHERE course_id = '%s'", $course);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_MODULES);
    }
    return $framework->dbProcessor($sql, 1);
}

function getInstructors($course) {
    global $framework;
    $sql = sprintf("SELECT * FROM " . TABLE_USERS . " AS users LEFT JOIN " . TABLE_INSTRUCTORS . " AS instructors ON `users`.`id` = `instructors`.`user_id`"
            . " WHERE course_id = '%s'", $course);
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
function courseModuleCard($contentArr, $type = null, $text = 1) {
    global $user_role, $framework, $SETT;
    $col = '4';
    $duration = ' ';
    if ($type) {
        // This controls the modules
        $col = '3';
        $intro = $framework->myTruncate($contentArr['intro'], 150);
        $photo = getImage($contentArr['cover'], 1);
        $edlink = cleanUrls($SETT['url'].'/index.php?page=training&module=edit&moduleid='.$contentArr['id']);
        $view = cleanUrls($SETT['url'].'/index.php?page=training&course=study&courseid='.$contentArr['course_id'].'&moduleid='.$contentArr['id']);
        $edit = $user_role >= 3 ? '<a href="'.$edlink.'" class="btn btn-sm btn-outline-secondary">Edit</a>' : '';
        $vb = $text == 1 ? '<a href="'.$view.'" class="btn btn-sm btn-outline-secondary">Start</a>' : '';
    } else {
        // This controls the courses
        $intro = $framework->myTruncate($contentArr['intro'], 200);
        $photo = getImage($contentArr['cover'], 1);
        $edlink = cleanUrls($SETT['url'].'/index.php?page=training&course=edit&courseid='.$contentArr['id']);
        $view = cleanUrls($SETT['url'].'/index.php?page=training&course=view&courseid='.$contentArr['id']);
        $edit = $user_role >= 3 ? '<a href="'.$edlink.'" class="btn btn-sm btn-outline-secondary">Edit</a>' : '';
        $vb = $text == 1 ? '<a href="'.$view.'" class="btn btn-sm btn-outline-secondary">View Details</a>' : '';
    }

    // if $text = 0 don't show the $intro
   $intro = $text ? $intro : ''; 

    $card = '
    <div class="accordion" id="module_accordion">
        <div class="module-tile module-tile-wide">
            <div class="module-header">
                <div class="data-icon">
                    <img class="" src="'.$photo.'" title="'.$contentArr['title'].' thumbnail" alt="'.$contentArr['title'].' thumbnail">
                </div>
                <div class="data-info">
                    <div class="title">
                        <a href="#module_'.$contentArr['id'].'" class="collapsed" data-toggle="collapse" data-target="#module_'.$contentArr['id'].'" aria-expanded="false" aria-controls="module_'.$contentArr['id'].'">
                            '.$contentArr['title'].'
                        </a>
                    </div>
                </div>
                <span class="data-toggle">
                    <a href="#module_'.$contentArr['id'].'" class="collapsed" data-toggle="collapse" data-target="#module_'.$contentArr['id'].'" aria-expanded="false" aria-controls="module_'.$contentArr['id'].'">
                        <i class="fa fa-angle-down"></i>
                    </a>
                </span>
            </div>
            <div id="module_'.$contentArr['id'].'" class="collapse data-content" aria-labelledby="module_heading_'.$contentArr['id'].'" data-parent="#module_accordion">
                <div class="">
                    '.$intro.'<p>'.$vb.$edit.'</p>
                </div>
            </div>
        </div>
    </div>
    ';

    return $card;
}

// course and modules boxes HTML
function userCourseModuleCard($contentArr, $type = null, $text = 1) {
    global $user_role, $framework, $SETT;
    $col = '4';
    $duration = ' ';
    if ($type) {
        // This controls the modules
        $col = '3';
        $intro = $framework->myTruncate($contentArr['intro'], 150);
        $photo = getImage($contentArr['cover'], 1);
        $edlink = cleanUrls($SETT['url'].'/index.php?page=training&module=edit&moduleid='.$contentArr['id']);
        $view = cleanUrls($SETT['url'].'/index.php?page=training&course=view&courseid='.$contentArr['course_id'].'&moduleid='.$contentArr['id']);
        $edit = $user_role >= 3 ? '<a href="'.$edlink.'" class="btn btn-sm btn-outline-secondary">Edit</a>' : '';
        $vb = $text == 1 ? '<a href="'.$view.'" class="btn btn-sm btn-outline-secondary">Start</a>' : '';
    } else {
        // This controls the courses
        $intro = $framework->myTruncate($contentArr['intro'], 200);
        $photo = getImage($contentArr['cover'], 1);
        $edlink = cleanUrls($SETT['url'].'/index.php?page=training&course=edit&courseid='.$contentArr['id']);
        $view = cleanUrls($SETT['url'].'/index.php?page=training&course=view&courseid='.$contentArr['id']);
        $edit = $user_role >= 3 ? '<a href="'.$edlink.'" class="btn btn-sm btn-outline-secondary">Edit</a>' : '';
        $vb = $text == 1 ? '<a href="'.$view.'" class="btn btn-sm btn-outline-secondary">View Details</a>' : '';
    }

    // if $text = 0 don't show the $intro
   $intro = $text ? '<p class="card-text"> '.$intro.' </p>' : '';
    // This is the course and module HTML card
    $card = '
    <div class="col-md-'.$col.'">
        <div class="card mb-4 shadow-sm">
            <img src="'.$photo.'" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">'.$contentArr['title'].'</h5>
                <span style="font-size:15px;">'.$intro.'</span>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        '.$vb.'
                        '.$edit.'
                    </div>
                    <small class="text-muted">'.$duration.'</small>
                </div>
            </div>
        </div>
    </div>
    '; 

    return $card;
}

function userRating($rating) {
    $cs = '<i class="fa fa-star"></i>';
    $os = '<i class="fa fa-star-o"></i>';

    if ($rating == 5) {
        $rate = $cs.$cs.$cs.$cs.$cs;
    } elseif ($rating == 4) {
        $rate = $cs.$cs.$cs.$cs.$os;
    } elseif ($rating == 3) {
        $rate = $cs.$cs.$cs.$os.$os;
    } elseif ($rating == 2) {
        $rate = $cs.$cs.$os.$os.$os;
    } elseif ($rating == 1) {
        $rate = $cs.$os.$os.$os.$os;
    } elseif ($rating == 0) {
        $rate = $os.$os.$os.$os.$os;
    }
    return $rate;
}

function instructorCard($ins) {
    $inst_fullname = $ins['f_name'].' '.$ins['l_name'];
    $inst_about = $ins['about'] ? $ins['about'] : 'Instructor has not written about themselves';
    $inst_photo = getImage($ins['photo'], 1);
    $inst_rating = userRating($ins['rating']);

    $social = '';
    $social .= $ins['facebook'] ? '<span class="media"><a href="'.$ins['facebook'].'"><i class="fa fa-mobile"></i></a></span>' : '';
    $social .= $ins['twitter'] ? '<span class="media"><a href="'.$ins['twitter'].'"><i class="fa fa-mobile"></i></a></span>' : '';
    $social .= $ins['instagram'] ? '<span class="media"><a href="'.$ins['instagram'].'"><i class="fa fa-mobile"></i></a></span>' : '';

    $card = '
    <div class="instructor">
      <div class="row">
        <div class="col-md-5">
          <div class="i-profile-img">
              <img src="'.$inst_photo.'"
            class="img-responsive" alt="">
          </div>
          <div class="pt-3">
            <p class="i-name">'.$inst_fullname.'</p>
            <div class="i-rating">'.$inst_rating.'</div>
            <div class="i-social">
              '.$social.'
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="i-bio">
            <p >
              '.$inst_about.'
            </p>
          </div>
        </div>

      </div>
    </div>';
    return $card;
}

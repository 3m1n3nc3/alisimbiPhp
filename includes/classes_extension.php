<?php
function errorMessage($str) {
    $string = "
  <span style='padding: 0.35rem 1.01rem;' class='alert alert-danger'>
  <strong>" . $str . "</strong>
  </span>";
    return $string;
}

function successMessage($str) {
    $string = "
  <span style='padding: 0.35rem 1.01rem;' class='alert alert-success'>
  <strong>" . $str . "</strong>
  </div>";
    return $string;
}

function warningMessage($str) {
    $string = "
  <span style='padding: 0.35rem 1.01rem;' class='alert alert-warning'>
  <strong>" . $str . "</strong>
  </div>";
    return $string;
}

function infoMessage($str) {
    $string = "
  <span style='padding: 0.35rem 1.01rem;' class='alert alert-info'>
  <strong>" . $str . "</strong>
  </div>";
    return $string;
}

function messageNotice($str, $type = null) {
    switch ($type) {
        case 1:
            $alert = 'success';
            break;

        case 2:
            $alert = 'warning';
            break;

        case 3:
            $alert = 'danger';
            break;

        default:
            $alert = 'info';
            break;
    }
    $string = "
    <div style='padding: 2px;' class='alert alert-" . $alert . "'> " . $str . " </div>";
    return $string;
}

function seo_plugin($image, $twitter, $facebook, $desc, $title) {
    global $SETT, $PTMPL, $configuration, $site_image;

    $twitter = ($twitter) ? $twitter : $configuration['site_name'];
    $facebook = ($facebook) ? $facebook : $configuration['site_name'];
    $title = ($title) ? $title . ' ' : '';
    $titles = $title . 'On ' . $configuration['site_name'];
    $image = ($image) ? $image : $site_image;
    $alt = ($title) ? $title : $titles;
    $desc = rip_tags(strip_tags(stripslashes($desc)));
    $desc = strip_tags(myTruncate($desc, 350));
    $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $plugin = '
    <meta name="description" content="' . $desc . '"/>
    <link rel="canonical" href="' . $url . '" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="' . $titles . '" />
    <meta property="og:url" content="' . $url . '"/>
    <meta property="og:description" content="' . $desc . '" />
    <meta property="og:site_name" content="' . $configuration['site_name'] . '" />
    <meta property="article:publisher" content="https://www.facebook.com/' . $configuration['site_name'] . '" />
    <meta property="article:author" content="https://www.facebook.com/' . $facebook . '" />
    <meta property="og:image" content="' . $image . '" />
    <meta property="og:image:secure_url" content="' . $image . '" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />
    <meta property="og:image:alt" content="' . $alt . '" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="' . $desc . '" />
    <meta name="twitter:title" content="' . $titles . '" />
    <meta name="twitter:site" content="@' . $configuration['site_name'] . '" />
    <meta name="twitter:image" content="' . $image . '" />
    <meta name="twitter:creator" content="@' . $twitter . '" />';
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
        foreach ($list as $name) {
            if ($id == $name['name']) {
                $selected = ' selected="selected"';
            } else {
                $selected = '';
            }
            $listed .= '<option id="' . $name['id'] . '" value="' . $name['name'] . '"' . $selected . '>' . $name['name'] . '</option>';
        }
        return $listed;
    } else {
        return $framework->dbProcessor($sql, 1);
    }
}

function getImage($image, $type = null, $x = null) {
    global $SETT;
    if (!$image) {
      $dir = $SETT['url'] . '/uploads/img/';
      $image = 'default.png';
    }

    $y = null;
    if ($type == 1) {
      // Deletable images
      $dir = $SETT['url'] . '/uploads/img/';
      $_dir = 'uploads/img/';
      $y = 1;
    } elseif ($type == 2) {
      // More Site specific images
      $dir = $SETT['url'] . '/' . $SETT['template_url'] . '/images/';
      $_dir = $SETT['template_url'] . '/images/';
    } else {
      // Site specific images
      $dir = $SETT['url'] . '/' . $SETT['template_url'] . '/img/';
      $_dir = $SETT['template_url'] . '/img/';
    } 

    // Get the directory
    $cd = $y ? ($x ? getcwd() : '') : ($x ? getcwd() : '');
    $cd_image = $cd . $_dir . $image;

    // Show the image
    if (file_exists($cd_image)) {
      $image = $cd_image;
    } else {
      $image = $SETT['url'] . '/uploads/img/default.png';
    }
    return $image;
}

function getVideo($source) {
    global $SETT, $framework;
    $link = $framework->determineLink($source);

    if (!$source) {
        $source = 'defaultvid.png';
        return $source = $SETT['url'] . '/uploads/videos/' . $source;
    }
    if ($link) {
        $source = $link;
    } else {
        $source = $SETT['url'] . '/uploads/videos/' . $source;
    }
    return $source;
}

function savePhoto($photo, $id) {
    global $SETT, $framework;
    $sql = sprintf("UPDATE " . TABLE_USERS . " SET `photo` = '%s' WHERE id = '%s'", $photo, $id);
    $update = $framework->dbProcessor($sql, 0, 1);
    if ($update == 1) {
      $msg = 'Your photo was uploaded successfully, you may want to refresh your page!';
    } else {
      $msg = $update;
    }
    return $msg;
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

function getCourses($type = null, $course = null, $x = null) {
    global $framework;
    if ($type == 1) {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSES . " WHERE id = '%s'", $course);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSES . "%s", $x ? $x : '');
    }
    return $framework->dbProcessor($sql, 1);
}

function getModules($type = null, $id = null, $x = null) {
    global $framework;

    if ($type == 1) {
        $sql = sprintf("SELECT * FROM " . TABLE_MODULES . " AS modules LEFT JOIN " . TABLE_COURSE_MODULES . " AS course_modules ON `modules`.`id` = `course_modules`.`module_id`"
            . " WHERE course_id = '%s'", $id);
    } elseif ($type == 2) {
        $sql = sprintf("SELECT * FROM " . TABLE_MODULES . " WHERE id = '%s'", $id);
    } elseif ($type == 3) {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSE_MODULES . "%s", $x ? $x : '');
    }  elseif ($type == 4) {
        $sql = sprintf("SELECT COUNT(id) AS count_modules FROM " . TABLE_COURSE_MODULES . " WHERE course_id = '%s'", $id);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_MODULES . "%s", $x ? $x : '');
    }
    return $framework->dbProcessor($sql, 1);
}

function linkModule($module_id, $course_id) {
    global $framework;
    $module_id = $framework->db_prepare_input($module_id);
    $course_id = $framework->db_prepare_input($course_id);
    $sql = sprintf("INSERT INTO " . TABLE_COURSE_MODULES . " (`course_id`, `module_id`) VALUES ('%s', '%s')",
        $course_id, $module_id);
    $x = sprintf(" WHERE course_id = '%s' AND module_id = '%s'", $course_id, $module_id);
    $ver = getModules(3, null, $x)[0];
    if ($ver['course_id'] == $course_id && $ver['module_id'] == $module_id) {
        return 'This module is already linked to this course';
    } else {
        $results = $framework->dbProcessor($sql, 0, 1);
        if ($results == 1) {
            $x = sprintf(" WHERE id = '%s'", $module_id);
            $r = getModules(null, null, $x)[0];
            $xy = sprintf(" WHERE course_id = '%s' AND user_id = '%s'", $course_id, $r['creator_id']);
            $y = getInstructors(null, 1, $xy)[0];
            if ($y['user_id'] != $r['creator_id'] && $y['course_id'] != $course_id) {
                $framework->addInstructor($r['creator_id'], $course_id);
            }
        }
        return $results;
    }
}

function doSum($id, $type = null) {
    global $framework;
    if ($type == 1) {
        // Count the course intructors
        $sql = sprintf("SELECT COUNT(user_id) AS count_intructors FROM " . TABLE_INSTRUCTORS . " WHERE course_id = '%s'", $id);
    } else {
        // Count the course duration
        $sql = sprintf("SELECT SUM(duration) AS course_duration FROM " . TABLE_MODULES . " AS modules LEFT JOIN " . TABLE_COURSE_MODULES . " AS course_modules ON `modules`.`id` = `course_modules`.`module_id` WHERE course_id = '%s'", $id);
    }
    $results = $framework->dbProcessor($sql, 1);
    return $results;
}

function getInstructors($course = null, $type = null, $x = null) {
    global $framework;
    if ($type == null) {
        $sql = sprintf("SELECT * FROM " . TABLE_INSTRUCTORS . " AS instructors LEFT JOIN " . TABLE_USERS . " AS users ON `instructors`.`user_id` = `users`.`id`"
            . " WHERE course_id = '%s'", $course);
    } elseif ($type == 1) {
        $sql = sprintf("SELECT * FROM " . TABLE_INSTRUCTORS . "%s", $x ? $x : '');
    }

    return $framework->dbProcessor($sql, 1);
}

function getQuestions($id, $type = null) {
    global $framework;
    if ($type == 1) {
        $sql = sprintf("SELECT * FROM " . TABLE_QUESTION . " WHERE 1 AND module_id = '%s'", $id);
    } elseif ($type == 2) {
        $sql = sprintf("SELECT modules.module_id, course_id, correct, questions.id AS question_id, question FROM " . TABLE_QUESTION . " AS questions LEFT JOIN " . TABLE_COURSE_MODULES . " AS modules ON `questions`.`module_id` = `modules`.`module_id` WHERE course_id = '%s'", $id);
    } else {
        $sql = sprintf("SELECT * FROM " . TABLE_QUESTION . " WHERE module_id = '%s' ORDER BY id DESC", $id);
    }
    return $framework->dbProcessor($sql, 1);
}

function getAnswers($id) {
    global $framework;
    $sql = sprintf("SELECT * FROM " . TABLE_ANSWER . " WHERE 1 AND question_id = '%s'", $id);
    return $framework->dbProcessor($sql, 1);
}

function completeCourse($course_id) {
  global $framework, $user;
  $sql = sprintf("INSERT INTO " . TABLE_COMPLETED . " (`user_id`, `course_id`) VALUES ('%s', '%s')", $user['id'], $framework->db_prepare_input($course_id));
  return $framework->dbProcessor($sql, 0, 1);
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

function getBenefits($x = null) {
    global $framework;
    $sql = sprintf("SELECT * FROM " . TABLE_BENEFITS . "%s", $x);
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
 * /* This function will convert your urls into cleaner urls
 **/
function cleanUrls($url) {
    global $configuration; //$configuration['cleanurl'] = 1;
    if ($configuration['cleanurl']) {
        $pager['homepage'] = 'index.php?page=homepage';
        $pager['news'] = 'index.php?page=news';
        $pager['trainings'] = 'index.php?page=trainings';

        if (strpos($url, $pager['homepage'])) {
            $url = str_replace(array($pager['homepage'], '&user=', '&read='), array('homepage', '/', '/'), $url);
        } elseif (strpos($url, $pager['news'])) {
            $url = str_replace(array($pager['news'], '&read=', '&id'), array('news', '/', '/'), $url);
        } elseif (strpos($url, $pager['trainings'])) {
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
    $theme = new themer('container/footer');
    $footer = '';
    $OLD_THEME = $PTMPL;
    $PTMPL = array();

    $PTMPL['copyright'] = '&copy; ' . date('Y') . ' ' . $contact['c_line'];
    $PTMPL['address'] = $contact['address'];

    //Email Address
    $PTMPL['email_var'] = $contact['email'];
    $PTMPL['email'] = '<a href="mailto:' . $contact['email'] . '" id="contact_email">' . $contact['email'] . '</a>';

    //Phone number
    $PTMPL['phone_var'] = $contact['phone'];
    $PTMPL['phone'] = '
  <a href="tel:' . $contact['phone'] . '" id="contact_phone">' . $contact['phone'] . '</a>';

    //Facebook
    $PTMPL['facebook_var'] = $contact['facebook'];
    $PTMPL['facebook'] = '
  <a href="http://facebook.com/' . $contact['facebook'] . '" id="contact_facebook">http://facebook.com/' . $contact['facebook'] . '</a>';

    //Twitter
    $PTMPL['twitter_var'] = $contact['twitter'];
    $PTMPL['twitter'] = '
  <a href="http://twitter.com/' . $contact['twitter'] . '" id="contact_twitter">http://twitter.com/' . $contact['twitter'] . '</a>';

    //Instagram
    $PTMPL['instagram_var'] = $contact['instagram'];
    $PTMPL['instagram'] = '
  <a href="http://instagram.com/' . $contact['instagram'] . '" id="contact_instagram">http://instagram.com/' . $contact['instagram'] . '</a>';

    //Youtube
    $PTMPL['youtube_var'] = $contact['youtube'];
    $PTMPL['youtube'] = '
  <a href="http://youtube.com/' . $contact['youtube'] . '" id="contact_youtube">http://youtube.com/' . $contact['youtube'] . '</a>';

    //Signup links
    if (!isset($user)) {
        $PTMPL['learn_signup'] = '<a href="#" id="learn_signup">Signup to Learn</a>';
        $PTMPL['teach_signup'] = '<a href="#" id="teach_signup">Signup to Teach</a>';
    }

    $PTMPL['support_alisimbi'] = $LANG['support_alisimbi'] . ' ' . $LANG['or'] . ' ' . $LANG['make_donation'];
    $PTMPL['donate_btn'] = '<a href="#" class="pass-btn" id="donate_btn">' . $LANG['donate'] . '</a>';

    $footer = $theme->make();
    $PTMPL = $OLD_THEME;
    unset($OLD_THEME);
    return $footer;
}

function accountAccess($type = null) {
    global $LANG, $PTMPL, $SETT, $settings;
    if ($type == 0) {
        $theme = new themer('homepage/signup');
        $footer = '';
    } else {
        $theme = new themer('homepage/login');
        $footer = '';
    }

    $OLD_THEME = $PTMPL;
    $PTMPL = array();

    $PTMPL['register_link'] = cleanUrls($SETT['url'] . '/index.php?page=account&register=true');


    $footer = $theme->make();
    $PTMPL = $OLD_THEME;
    unset($OLD_THEME);
    return $footer;
}

function manageButtons($type = null, $cid = null, $mid = null) {
    global $user_role, $user, $framework, $SETT;
    $link = '';

    if ($type == 0) {
        // Edit Module
        $link = cleanUrls($SETT['url'] . '/index.php?page=training&module=edit&moduleid=' . $mid);
    } elseif ($type == 1) {
        // Edit Course
        $link = cleanUrls($SETT['url'] . '/index.php?page=training&course=edit&courseid=' . $cid);
    } elseif ($type == 2) {
        $link = cleanUrls($SETT['url'] . '/index.php?page=training&module=add');
    } elseif ($type == 3) {
        $link = cleanUrls($SETT['url'] . '/index.php?page=training&course=add');
    }
    return $link;
}

function secureButtons($class, $title, $type, $cid, $mid, $x = null) {
    global $user, $user_role;
    $link = manageButtons($type, $cid, $mid);
    $gcrs = getCourses(1, $cid)[0];
    $gmd = getModules(2, $mid)[0];

    $class = $class ? ' ' . $class : '';
    $btnClass = $x ? '' : 'btn';
    $_btn = '';
    $btn = '<a href="' . $link . '" class="' . $btnClass . $class . '">' . $title . '</a>';
    $allow = 0;

    if ($type == 0) {
        // Edit Module
        if ($gmd['creator_id'] == $user['id']) {
            $allow = 1;
        }
    } elseif ($type == 1) {
        // Edit Course
        if ($gcrs['creator_id'] == $user['id']) {
            $allow = 1;
        }
    }
    if ($allow == 1 && ($type == 0 || $type == 1)) {
        $btn = $btn;
    } elseif ($user_role >= 2 && ($type == 0 || $type == 1)) {
        $btn = $btn;
    } elseif ($user_role >= 1 && ($type == 2 || $type == 3)) {
        $btn = $btn;
    } else {
        $btn = $_btn;
    }

    return $btn;
}

function simpleButtons($class, $title, $link, $x = null) {
    global $user, $user_role;

    $class = $class ? ' ' . $class : '';
    $btnClass = $x ? '' : 'btn';
    $btn = '<a href="' . $link . '" class="' . $btnClass . $class . '">' . $title . '</a>';

    return $btn;
}

function twoRandomCourse() {
  global $SETT, $marxTime;
  $coursesArr = getCourses();
  shuffle($coursesArr);

  if ($coursesArr) {
    $i = 0;
    $courses = '                                        
      <div class="card-content">
        <div class="other_courses">';

    foreach ($coursesArr as $rslt) {
      $i++;
      if($i == 3) break;

      $c_duration = doSum($rslt['id'])[0]['course_duration'];
      $c_duration = $marxTime->minutesConverter($c_duration, '%02d Hrs %02d Mins');
      $count_ins = doSum($rslt['id'], 1)[0]['count_intructors'];
      $count_instructors = $count_ins >= 1 ? $count_ins : '0';
      $count_modules = getModules(4, $rslt['id'])[0]['count_modules'];
      $photo = getImage($rslt['cover'], 1);
      $view = cleanUrls($SETT['url'] . '/index.php?page=training&course=view&courseid=' . $rslt['id']);

      $courses .= '
          <div class="course-column ">
              <div class="course-icon">
                  <img alt="'.$rslt['title'].' course image" class="" src="'.$photo.'" title="">
              </div>
              <div class="course-content">
                  <div class="title"><a href="'.$view.'">'.$rslt['title'].'</a></div>
                  <small class="block hint">'.$c_duration.'</small>
                  <small class="block hint">Instructors ('.$count_instructors.')</small>
              </div>
          </div>';
    }
    $courses .= '
        </div>
      </div>';
    return $courses;
  }
}

// course and modules boxes HTML
function courseModuleCard($contentArr, $type = null, $text = 1) {
    global $user, $user_role, $framework, $marxTime, $SETT;
    $col = '4';
    $duration = $price = $count_modules = 0;
    $start_learning = $count_instructors = '';
    if ($type) {
        // This controls the modules
        $col = '3';
        $intro = $framework->myTruncate($contentArr['intro'], 150);
        $photo = getImage($contentArr['cover'], 1);
        $view = cleanUrls($SETT['url'] . '/index.php?page=training&course=view&courseid=' . $contentArr['course_id'] . '&moduleid=' . $contentArr['module_id']);
        $enlink = cleanUrls($SETT['url'] . '/index.php?page=training&course=get&process=payment&courseid=' . $contentArr['id']);
        $enroll = $text == 1 ? '<a href="' . $enlink . '">Enroll</a>' : '';
        $edit = secureButtons(null, 'Edit Module', 0, null, $contentArr['id'], 1);
        $vb = $text == 1 ? '<a href="' . $view . '">Start</a>' : '';
        $start_learning = cleanUrls($SETT['url'] . '/index.php?page=training&course=now_learning&courseid=' . $contentArr['course_id'] . '&moduleid=' . $contentArr['module_id']);
        $progress_val = $contentArr['duration'];

        $unlink = cleanUrls($SETT['url'] . '/index.php?page=training&course=edit&courseid=' . $contentArr['course_id'] . '&unlink_module=' . $contentArr['module_id']);
        $unlink_module = simpleButtons('font-weight-bold text-info', 'Unlink', $unlink, 1);
    } else {
        // This controls the courses
        $intro = $framework->myTruncate($contentArr['intro'], 200);
        $photo = getImage($contentArr['cover'], 1);
        $view = cleanUrls($SETT['url'] . '/index.php?page=training&course=view&courseid=' . $contentArr['id']);
        $enlink = cleanUrls($SETT['url'] . '/index.php?page=training&course=get&process=payment&courseid=' . $contentArr['id']);
        $enroll = $text == 1 ? '<a href="' . $enlink . '">Enroll/Start</a>' : '';
        $edit = secureButtons(null, 'Edit', 1, $contentArr['id'], null, 1);
        $vb = $text == 1 ? '<a href="' . $view . '">View</a>' : '';
        $progress_val = $user ? '<span class="progress-value">' . courseDuration($contentArr['id']) . '% complete</span>' : '';
        $price = $contentArr['price'] > 0 ? '<span class="currency"></span> ' . $contentArr['price'] : 'Free';
        $duration = doSum($contentArr['id'])[0]['course_duration'];
        $duration = $marxTime->minutesConverter($duration, '%02d Hrs %02d Mins');
        $count_instructors = doSum($contentArr['id'], 1)[0]['count_intructors'];
        $count_modules = getModules(4, $contentArr['id'])[0]['count_modules'];
        $paid = courseAccess(1, $contentArr['id']) ? '<i class="fa fa-check-circle text-white small"></i>' : '';
    }

    // if $text = 0 don't show the $intro
    $intro = $text ? '<p class="card-text"> ' . $intro . ' </p>' : '';
    // This is the course and module HTML card

    $course_card = !$type ? '
    <div class="col-md-6 col-sm-6">
      <div class="course-column ">
        <div class="course-icon">
          <img class="img-responsive" src="' . $photo . '" title="" alt="course image">
          <div class="course-price">
            ' . $price . '
            ' . $paid . '
          </div>

        </div>
        <div class="course-content">
          <div class="title">' . $contentArr['title'] . '</div>
          <div class="succinct">
            <span class="item "><i class="fa fa-user"></i> ' . $count_instructors . '</span>
            <span class="item "><i class="fa fa-clock-o"></i> ' . $duration . '</span>
            <span class="item "><i class="fa fa-book"></i> ' . $count_modules . '</span>
            
          </div>
          ' . $progress_val . '
        </div>
        <div class="swipe-in">
          <div class="readmore">
            ' . $edit . '
          </div>
          <div class="readmore">
            ' . $vb . '
          </div>
        </div>
      </div>
    </div>' : '';

    $start_now = $user ? 'Continue' : 'Start';
    $module_card = $type ? '
    <div class="module-tile module-tile-wide">
        <div class="module-icon"></div>
        <div class="module-info">
            <div class="title">
                <a href="' . $start_learning . '">
                    ' . $contentArr['title'] . '
                </a>
            </div>
            <span class="progress-value">' . $progress_val . ' Minutes</span>
            <div class="module-btn">
                <a href="' . $start_learning . '" class="btn">' . $start_now . '</a>
            </div>
        </div>
    </div>' : '';

    $module_edit_card = $type == 2 ? '
    <div class="module-tile module-tile-wide">
      <div class="module-icon"></div>
      <div class="module-info">
        <div class="title">
          <a href="' . $start_learning . '">' . $contentArr['title'] . '</a>
        </div>
        <div class="module-btn background_lightgrey">
          ' . $unlink_module . secureButtons(null, 'Edit', 0, null, $contentArr['module_id'], 1) . '
        </div>
      </div>
    </div>' : '';

    $set_card = $type == 2 ? $module_edit_card : ($type ? $module_card : $course_card);

    return $set_card;
}

function studyModules($course, $curr = null) {
    global $SETT, $framework;
    $module = getModules(1, $course);
    $list = $current_module_title = $current_module_link = '';

    if ($module) {
        foreach ($module as $key => $value) {
            $active = ($curr == $value['module_id']) ? true : false;
            $link = cleanUrls($SETT['url'] . '/index.php?page=training&course=now_learning&courseid=' . $course . '&moduleid=' . $value['module_id']);
            if ($active) {
                $current_module_title = $value['title'];
                $current_module_link = $link;
            }
            $list .= '<a href="' . $link . '"><li class="list-group-item p-3 ' . (($active) ? 'highlight' : '') . '">' . $value['title'] . '</li></a>';
        }
    }
    $card =
        '<div class="card-tile">
    <div class="card-head card-header-divider">
        <div class="card-title">
            <h4>Modules</h4>
        </div>
    </div>
    <div class="card-body p-0">
      <ul class="list-group list-group-flush">
        ' . $list . '
      </ul>
   </div>
</div>';
    return [$card, $current_module_title, $current_module_link];
}

function userRating($rating) {
    $cs = '<i class="fa fa-star"></i>';
    $os = '<i class="fa fa-star-o"></i>';

    if ($rating == 5) {
        $rate = $cs . $cs . $cs . $cs . $cs;
    } elseif ($rating == 4) {
        $rate = $cs . $cs . $cs . $cs . $os;
    } elseif ($rating == 3) {
        $rate = $cs . $cs . $cs . $os . $os;
    } elseif ($rating == 2) {
        $rate = $cs . $cs . $os . $os . $os;
    } elseif ($rating == 1) {
        $rate = $cs . $os . $os . $os . $os;
    } elseif ($rating == 0) {
        $rate = $os . $os . $os . $os . $os;
    }
    return $rate;
}

function instructorCard($ins, $type = null) {   global $SETT;
    $inst_fullname = $ins['f_name'] . ' ' . $ins['l_name'];
    $inst_about = $ins['about'];
    $inst_photo = getImage($ins['photo'], 1);
    $inst_rating = userRating($ins['rating']);

    $social = '';
    $social .= $ins['facebook'] ? '<span class="media"><a href="' . $ins['facebook'] . '"><i class="fa fa-facebook"></i></a></span>' : '';
    $social .= $ins['twitter'] ? '<span class="media"><a href="' . $ins['twitter'] . '"><i class="fa fa-twitter"></i></a></span>' : '';
    $social .= $ins['instagram'] ? '<span class="media"><a href="' . $ins['instagram'] . '"><i class="fa fa-instagram"></i></a></span>' : '';
    $profile_link = cleanUrls($SETT['url'] . '/index.php?page=profile&profile=view&username='.$ins['username']);

    $instructor_detail_card = '
    <div class="instructor justify-content-center ">
      <div class="i-misc">
        <div class="i-profile-img">
          <img src="' . $inst_photo . '" class="img-responsive" alt=""/>
        </div>
        <p class="i-name"><a href="'.$profile_link.'"><h4 class="i-name">' . $inst_fullname . '</h4></a></p>
        <div class="i-rating">' . $inst_rating . '</div>
      </div>
      <div class="i-bio">
        <p>
          ' . $inst_about . '
        </p>
        <div class="i-social">
          ' . $social . '
        </div>
      </div>
    </div>';

    $instructor_summary_card = '
    <div class="instructor justify-content-center">
      <div class="i-misc">
        <div class="i-profile-img">
          <img src="' . $inst_photo . '" class="img-responsive" alt=""/>
        </div>
        <div><a href="'.$profile_link.'"><h4 class="i-name">' . $inst_fullname . '</h4></a></div>
        <div><span class="i-rating">' . $inst_rating . '</span></div>
      </div>
    </div>';

    if ($type === 1) {
        return $instructor_summary_card;
    } else {
        return $instructor_detail_card;
    }
}

function deleteFile($type, $name, $x = null) {
    global $SETT, $framework;

    if ($type == 0) {
        $ext = 'png';
        $path = 'img';
    } elseif ($type == 1) {
        $ext = 'mp4';
        $path = 'videos';
    } 

    if ($name !== 'default.' . $ext) {
        if (file_exists($SETT['working_dir'] . '/uploads/' . $path . '/' . $name)) {
            unlink($SETT['working_dir'] . '/uploads/' . $path . '/' . $name);
            return 1;
        }
    }
    return null;
}

function fetchBenefits($course_id) {
    $x = sprintf(" WHERE id = '%s'", $course_id);
    $get = getCourses(null, null, $x)[0]['benefits'];

    $benefit = explode(',', $get);
    $list_benefits = '';
    if ($get) {
        foreach ($benefit as $key => $value) {
            $fetch = getBenefits(sprintf(" WHERE title = '%s'", $value))[0];
            $format = '
              <div class="col-xs-6 col-sm-6 service">
                <div class="icon">
                  <span class="fa fa-' . $fetch['icon'] . '"></span>
                </div>
                <h4>' . $fetch['title'] . '</h4>
                <p>' . $fetch['description'] . '</p>
              </div>';
            $list_benefits .= $format;
        }
    }
    return $list_benefits;
}

function notAvailable($item) {
    return
        '<div class="pad-section">
        <div class="">
            <div class="empty">
                <i class="fa fa-question icon"></i>
                <p class="small para">No ' . $item . '</p>
            </div>
        </div>
    </div>';
}

function courseDuration($course) {
    global $framework;

    $duration = 0;
    $access_log = courseAccess(1, $course)[0];

    $sql = sprintf("SELECT SUM(duration) AS duration FROM " . TABLE_MODULES . " AS modules LEFT JOIN " . TABLE_COURSE_MODULES . " AS course_modules ON `modules`.`id` = `course_modules`.`module_id` WHERE course_id = '%s'", $framework->db_prepare_input($course));
    $sum = $framework->dbProcessor($sql, 1)[0];

    if ($access_log['course_id'] == $course) {
        if ($access_log['time_spent'] > 1 && $sum['duration'] > 1) {
            $duration = ($access_log['time_spent'] * 100) / $sum['duration'];
            $duration = round($duration);
        }
    }

    return $duration;
}

function courseAccess($type, $course_id = null) {
    global $framework, $user;
    if ($type == 1) {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSE_ACCESS . " WHERE user_id = '%s' AND course_id = '%s'",
            $user['id'], $framework->db_prepare_input($course_id));
    } elseif ($type == 2) {
        $sql = sprintf("SELECT * FROM " . TABLE_COURSE_ACCESS . " AS access LEFT JOIN " . TABLE_COURSES . " AS courses ON `access`.`course_id` = `courses`.`id` WHERE user_id = '%s'",
            $user['id']);
    } else {
        // Approve users course purchase
        $var = courseAccess(1, $course_id)[0];
        $sql = sprintf("INSERT INTO " . TABLE_COURSE_ACCESS . " (`course_id`, `user_id`, `completed`) VALUES ('%s','%s', NULL)", $framework->db_prepare_input($course_id), $user['id']);
        if ($var) {
            return 1;
        } else {
            return $framework->dbProcessor($sql, 0, 1);
        }
    }
    $results = $framework->dbProcessor($sql, 1);
    return $results;
}

function moduleProgress($course_id = null, $module_id = null, $type) {
    global $framework, $user;
    $mod_id = $framework->db_prepare_input($module_id);
    $cou_id = $framework->db_prepare_input($course_id);
    if ($type == 1) {
        $gt_dur = getModules(2, $module_id)[0];
        $gt_acc = courseAccess(1, $course_id)[0];
        $complete = $gt_acc['completed'] == '' ? $mod_id : $gt_acc['completed'] . ',' . $mod_id;
        $var = $gt_acc['completed'] ? explode(',', $gt_acc['completed']) : array();
        $time = $gt_acc['time_spent'] == 0 ? $gt_dur['duration'] : $gt_acc['time_spent'] + $gt_dur['duration'];
        if (!in_array($module_id, $var)) {
            $sql = sprintf("UPDATE " . TABLE_COURSE_ACCESS . " SET `current_module` = '%s',"
                . " `time_spent` = '%s', `completed` = '%s' WHERE course_id = '%s'"
                . " AND user_id = '%s'", $mod_id, $time, $complete, $cou_id, $user['id']);
        }
    }
    return isset($sql) ? $framework->dbProcessor($sql, 0, 1) : 0;
}

function headerFooter($type) {
    global $LANG, $SETT, $PTMPL, $contact_, $configuration, $framework, $user, $user_role;
    if ($type) {
        $theme = new themer('container/header');
        $section = '';
    } else {
        $theme = new themer('container/footer');
        $section = '';
    }
    $login_link = cleanUrls($SETT['url'] . '/index.php?page=account&process=login');
    $PTMPL['dashboard_url'] = cleanUrls($SETT['url'] . '/index.php?page=homepage');
    $PTMPL['user_url'] = $user_url = cleanUrls($SETT['url'] . '/index.php?page=account&profile=home');
    $PTMPL['username_url'] = simpleButtons('logout', 'Account', $user_url, 1);
    $PTMPL['site_title_'] = ucfirst($configuration['site_name']);
    $PTMPL['copyright'] = '&copy; ' . ucfirst($LANG['copyright']) . ' ' . date('Y') . ' ' . $contact_['c_line'];
    $PTMPL['logout_url'] = cleanUrls($SETT['url'] . '/index.php?logout=true');

    if ($user_role >=3) {
      $management = cleanUrls($SETT['url'] . '/index.php?page=management');
      $PTMPL['management'] = simpleButtons("bordered background_green2", 'Manage Site <i class="fa fa-cog"></i>', $management);
    }

    $avatar_division = '
      <div class="top_avatar">
        <div class="user_avatar">
          <a data-toggle="collapse" href="#logout" title="edit profile">
            <img alt="' . ucfirst($user['username']) . ' avatar" src="' . getImage($user['photo'], 1) . '">
          </a>
        </div>
        <div class="user_name">
          ' . ucfirst($user['username']) . '
        </div>
      </div>';
    $login_division = '<div class="">' . simpleButtons("bordered background_green2", 'Login', $login_link) . ' </div > ';

    $PTMPL['action_btn_link_avatar'] = $user ? $avatar_division : $login_division;
    $section = $theme->make();
    return $section;
}

function deleteItems($type = null, $cid, $mid) {
    global $framework, $user, $user_role;
    $allow = 0;

    // Sort from module
    $module = getModules(2, $mid)[0];
    if ($module['creator_id'] == $user['id']) {
        $allow = 1;
    } elseif ($user_role >= 2) {
        $allow = 1;
    }

    if ($type == 1) {
        // unlink module
        $sql = sprintf("DELETE FROM " . TABLE_COURSE_MODULES . " WHERE course_id = ' % s' AND module_id = ' % s'", $cid, $mid);
    }
    $results = $framework->dbProcessor($sql, 0, 1);
    return $results;
}

/*
* Generate a modal menu
*/
function modal($modal, $content, $title = null, $size = null, $footer = null, $extra = null) {
    // Always call the extra variable starting with a space
    // Size 1: Small
    // Size 2: Large
    // Size 3: Fluid
 
    if ($size == 1) {
        $size = ' modal-sm';
    } elseif ($size == 2) {
        $size = ' modal-lg';
    } elseif ($size == 3) {
        $size = ' modal-fluid';
    }
    if ($extra == 1) {
      $no_pad = ' style="padding: 0px;"';
    } else {
      $no_pad = '';
      $extra = $extra;
    }
    
    $button = '
    <button type="button" class="close" aria-label="Close" onclick="modal_destroyer(\''.$modal.'Modal\')">
      <span aria-hidden="true">&times;</span>
    </button>';

    $title = $title ? 
    '<div class="modal-header">
      <h5 class="modal-title" id="'.$modal.'ModalLabel">'.$title.'</h5>
      '.$button.'
    </div>' : '<div class="modal-header" style="border-bottom: none; padding: 0px;">'.$button.'</div>';

    $footer_content = $footer ? '<div class="modal-footer">'.$footer.'</div>' : '';
    $modal_menu ='
    <div class="modal fade" id="'.$modal.'Modal" tabindex="-1" role="dialog" aria-labelledby="'.$modal.'ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered'.$size.$extra.'" role="document">
        <div class="modal-content"> 
          '.$title.'  
          <div class="modal-body"'.$no_pad.'>
            '.$content.'
          </div>
            '.$footer_content.'
        </div>
      </div>
    </div>';
    return $modal_menu;
}


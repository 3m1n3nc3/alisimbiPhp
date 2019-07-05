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
        $video = $SETT['url'].'/uploads/videos/';
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
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
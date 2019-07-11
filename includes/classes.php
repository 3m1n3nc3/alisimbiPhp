<?php
//======================================================================\\
// Passengin 1.0 - Php templating engine and framewordk                 \\
// Copyright © Passcontest. All rights reserved.                        \\
//----------------------------------------------------------------------\\
// http://www.passcontest.com/                                          \\
//======================================================================\\

$framework = new framework; 

//Fetch settings from database
function configuration() {
	global $framework;
	$sql = "SELECT * FROM ".TABLE_CONFIG; 
    return $framework->dbProcessor($sql, 1)[0]; 
} 

/**
 * This class holds all major functions of this framework
 */
class framework {
	
	public $username; 
	public $password;
	public $email;
	public $remember;

	public $firstname;
	public $lastname;

	public $city;
	public $state;
	public $country;
	public $phone;


	function userData($user = NULL, $type = NULL) {
		// If type = 0, get all users e.g userData() and Use costom querries
		// If type = 1, get a particular user by id e.g userData(NULL, 0)
		// 2 instance = get a particular user by id e.g userData($id, 1)
		// 3 instance = get a particular user by username e.g userData(king)

	    global $configuration;

	    // Limit clause to enable pagination
		if (isset($this->limit)) { 
			$limit = sprintf('ORDER BY date DESC LIMIT %s, %s', $this->start, $this->limit);
		} else {
			$limit = '';
		} 

		$filter = (isset($this->filter)) ? $this->filter : '' ;  

	    if (isset($this->search)) {			
	    	//Search instance
	    	$search = $this->search; 	
	    	$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE username LIKE '%s' OR concat_ws(' ', `f_name`, `l_name`) LIKE '%s' OR country LIKE '%s' OR role LIKE '%s' LIMIT %s", '%'.$search.'%', '%'.$search.'%', '%'.$search.'%', '%'.$search.'%', $configuration['data_limit']);  
	    } elseif ($type == 0) {
	    	$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE %s %s", $filter, $limit); 
	    } elseif ($type == 1) {
	    	$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE id = '%s'", $user); 
	    } else {
	    	// if the username is an email address
	    	if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
	    		$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE email = '%s'", $username); 	//3 instance
	    	} else {
	    		$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE username = '%s'", $username); 	//3 instance
	    	}
	    }
	    try {
	        $stmt = $DB->prepare($sql); 
	        $stmt->execute();
	        $results = $stmt->fetchAll();
	    } catch (Exception $ex) {
	        return errorMessage($ex->getMessage());
	    } 
	    if (count($results)>0) {
	    	if ($username == NULL) {
	    		return $results;
	    	} else {
	    		return $results[0];
	    	}
	    }
	}

	/**
	* List all available languages
	*/
	function list_languages($type) {
		global $SETT, $LANG, $configuration;
		
		if ($type == 0) {
			$languages = scandir('./languages/');
			
			$LANGS = $LANG;
			$by = $LANG['writter'];
			$default = $LANG['default'];
			$make = $LANG['make_default'];

			$sort = '';
			foreach($languages as $language) {
				if($language != '.' && $language != '..' && substr($language, -4, 4) == '.php') {
					$language = substr($language, 0, -4);
					$system_languages[] = $language;
					
					include('./languages/'.$language.'.php');
					
					if($configuration['language'] == $language) {
						$state = '<a class="pass-btn">'.$default.'</a>';
					} else {
						$state = '<a class="pass-btn" href="'.$SETT['url'].'/index.php?a=settings&b=languages&language='.$language.'">'.$make.'</a>';
					}
					
					$sort .= 
						'<div class="padding-5">
							'.$state.'
							<div>
								<div>
									<strong><a href="'.$url.'" target="_blank">'.$name.'</a></strong>
								</div>
								<div>
									'.$by.': <a href="'.$url.'" target="_blank">'.$author.'</a>
								</div>
							</div>
						</div>';
				}
			}
			
			$LANG = $LANGS;
			return array($system_languages, $sort);
		} else {
			$sql = sprintf("UPDATE " . TABLE_CONFIG . " SET `language` = '%s'", $this->language); 
        	return dbProcessor($sql, 0, 1);
		}
	}

	/**
	* Manage language settings for your website
	* Type 1: Show available languages
	* Type 2: Update the language settings
	*/
	function getLanguage($url, $ln = null, $type = null) {
		global $configuration; 
		
		// Define the languages folder
		$lang_folder = __DIR__ .'/../languages/';
		
		// Open the languages folder
		if($handle = opendir($lang_folder)) {
			// Read the files (this is the correct way of reading the folder)
			while(false !== ($entry = readdir($handle))) {
				// Excluse the . and .. paths and select only .php files
				if($entry != '.' && $entry != '..' && substr($entry, -4, 4) == '.php') {
					$name = pathinfo($entry);
					$languages[] = $name['filename'];
				}
			}
			closedir($handle);
		}
		
		if($type == 1) {
			// Add to array the available languages
	        $available = '';
			foreach($languages as $lang) {
				// The path to be parsed
				$path = pathinfo($lang);
				
				// Add the filename into $available array
				$available .= '<span><a href="'.$url.'/index.php?lang='.$path['filename'].'">'.ucfirst(mb_strtolower($path['filename'])).'</a></span>';
			}
			return $available;  
		} else {
			// If get is set, set the cookie and stuff
			$lang = $configuration['language']; // Default Language
			
			if(isset($_GET['lang'])) {
				if(in_array($_GET['lang'], $languages)) {
					$lang = $_GET['lang'];
					// Set to expire in one month
					setcookie('lang', $lang, time() + (10 * 365 * 24 * 60 * 60), COOKIE_PATH); 
				} else {
					// Set to expire in one month
					setcookie('lang', $lang, time() + (10 * 365 * 24 * 60 * 60), COOKIE_PATH); 
				}
			} elseif(isset($_COOKIE['lang'])) {
				if(in_array($_COOKIE['lang'], $languages)) {
					$lang = $_COOKIE['lang'];
				}
			} else {
				// Set to expire in one month
				setcookie('lang', $lang, time() + (10 * 365 * 24 * 60 * 60), COOKIE_PATH);
			}

			// If the language file doens't exist, fall back to an existent language file
			if(!file_exists($lang_folder.$lang.'.php')) {
				$lang = $languages[0];
			}
			return $lang_folder.$lang.'.php';
		}
	} 

	/**
	/* generate safelinks from strings E.g: Where is Tommy (where-is-tommy)
	**/
	function safeLinks($string) { 
		// Replace spaces and special characters with a -
	    $return = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	 
	    // If the link is not safe add a random string
	    ($string == $return) ? $safelink = $return.'-'.rand(100,900) : $safelink = $return; 
	    
	    return $safelink;
	}

	/**
	/* generate clean urls, this is similar to safeLinks()
	**/
	function cleanUrl($url) {
		$url = str_replace(' ', '-', $url);
		$url = preg_replace('/[^\w-+]/u', '', $url);
		$url = preg_replace('/\-+/u', '-', $url);
		return mb_strtolower($url);
	}

	/**
	/* Encryption function
	**/
	function easy_crypt($string, $type = 0) {
	    if ($type == 0) {
	        return base64_encode($string . "_@#!@/");
	    } else {
	        $str = base64_decode($string);
	        return str_replace("_@#!@/", "", $str);        
	    }
	    
	} 

	/**
	/*  Sanitize text input function
	**/
	function db_prepare_input($string) {
	    return trim(addslashes($string));
	}

	/**
	/*  Generate a random token (MD5 or password_hash)
	**/
	function accountToken($length = 10, $type = 0) {
	    $str = '';
	    $characters = array_merge(range('A','Z'), range('a','z'), range(0,9));
	    for($i=0; $i < $length; $i++) {
	        $str .= $characters[array_rand($characters)];
	    }
	    if ($type == 1) {
	        return password_hash($str.time(), PASSWORD_DEFAULT);
	    } else {
	        return hash('md5', $str.time());
	    }
	}

	function seo_plugin($title, $desc, $image = null, $twitter = null, $facebook = null) {
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

	/** 
	/* Generate a random secure password 
	**/
	function securePassword($length) {
		// Allowed characters
		$chars = str_split("abcdefghijklmnopqrstuvwxyz0123456789");
		
		// Generate password
	    $password = '';
		for($i = 1; $i <= $length; $i++) {
			// Get a random character
			$n = array_rand($chars, 1);
			
			// Store random char
			$password .= $chars[$n];
		}
		return $password;
	}

	/**
	/* Generate a 13 digit random coupon code
	**/
	function coupon_generator() {
		global $configuration, $user;
		
		// Generate a random 13 digit numeric string
	  	$key = rand(4000000000000,9000000000000);
	  	// Fetch already created tokens
	  	$this->token = $key;
	  	$get_token = $this->manage_gift_cards(2)[0];
	  	$token = $get_token['token'];
	  	// Generate a new key if it has already been Generated
	  	if ($token == $key) {
	  		$coupon = rand(4000000000000,9000000000000);
	  	} else {
	  		$coupon = $key;
	  	}
	  	return $coupon;
	}

	/**
	/*  Fetch url content via curl
	**/
	function fetch($url) {
	    if(function_exists('curl_exec')) {
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36');
	        $response = curl_exec($ch);
	    }
	    if(empty($response)) {
	        $response = file_get_contents($url);
	    }
	    return $response;
	}

	/* 
	* Find tags in a string
	*/
	function tag_finder($str, $x=0) {
	    if ($x == 1) {
	        // find an @
	        if (preg_match('/(^|[^a-z0-9_\/])@([a-z0-9_]+)/i', $str)) {
	           return 2;
	        } 
	    } else {
	        // find a #
	        if (preg_match('/(^|[^a-z0-9_\/])#(\w+)/u', $str)) {
	           return 1;
	        }
	    }
	    return false;
	}

	/* 
	* Truncate text
	*/
	function myTruncate($str, $limit, $break=" ", $pad="...") {

	    // return with no effect if string is shorter than $limit
	    if(strlen($str) <= $limit) return $str;

	    // is $break is present between $limit and the strings end?
	    if(false !== ($break_pos = strpos($str, $break, $limit))) {
	        if($break_pos < strlen($str) - 1) {
	            $str = substr($str, 0, $break_pos) . $pad;
	        }
	    } 
	    return $str;
	}

	/* 
	* Remove special html tags from string
	*/
	function rip_tags($string) { 
	    // ----- remove HTML TAGs ----- 
	    $string = preg_replace ('/<[^>]*>/', ' ', $string); 
	    // $string = filter_var($string, FILTER_SANITIZE_STRING);
	    
	    // ----- remove control characters ----- 
	    $string = str_replace("\r", '', $string);    // --- replace with empty space
	    $string = str_replace("\n", ' ', $string);   // --- replace with space
	    $string = str_replace("\t", ' ', $string);   // --- replace with space
	    
	    // ----- remove multiple spaces ----- 
	    $string = trim(preg_replace('/ {2,}/', ' ', $string));
	    
	    return $string; 
	} 

	/* 
	* Create url referer to safely redirect users
	*/
	function urlReferrer($url, $type) {
	    if ($type == 0) {
	        $url = str_replace('/', '@', $url); 
	    } else {
	        $url = str_replace('@', '/', $url); 
	    }
	 
	    return $url;
	} 

	/* 
	* redirect page
	*/
	function redirect($location = '', $type = 0) {
	    global $SETT;
	    if ($type) {
	        header('Location: '.$location);
	    } else {
	        if($location) {
	            header('Location: '.permalink($SETT['url'].'/index.php?a='.$location));
	        } else {
	            header('Location: '.permalink($SETT['url'].'/index.php'));
	        }        
	    }

	    exit;
	}

	/**
	 * Create click-able links from texts
	 */	
	function decodeText($message, $x=0) { 
		global $LANG, $SETT;

		// Decode the links
		$extractUrl = preg_replace_callback('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', "decodeLink", $message);
		
		$y = $x==1 ? 'secondary' : 'primary';
		// Decode link from #hashtags and @mentions
		$extractMessage = preg_replace(array('/(^|[^a-z0-9_\/])@([a-z0-9_]+)/i', '/(^|[^a-z0-9_\/])#(\w+)/u'), array('$1<a class="'.$y.'-color" href="/$2" rel="loadpage">@$2</a>', '$1<a class="'.$y.'-color" href="/$2" rel="loadpage">#$2</a>'), $extractUrl);

		return $extractMessage;
	} 

	/**
	/* Determine if the text is a link or a file
	**/

	function determineLink($string) {
		if(substr($string, 0, 4) == 'www.' || substr($string, 0, 5) == 'https' || 
			substr($string, 0, 4) == 'http') {
			if (substr($string, 0, 4) == 'www.') {
				return 'http://'.$string;
			} else {
				return $string;
			}
		} else {
			return false;
		}	
	}
	/**
	* Check if this request is being made from ajax
	*/
	function trueAjax() { 
	    if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	        return true;
	    } else {
	        return false;
	    }
	}

	/**
	 * send sms text message with twillio
	 */
	function sendSMS($text, $phone, $test=0) {
	    global $configuration;
	    $success = true;
	    $fail = false;
	    if ($test==1) {
	    	$phone = $configuration['site_phone'];
	    	$text = 'Test SMS from '.$configuration['site_name'];
	    	$return = 'Test SMS successfully sent';
	    	$fail = 'Failed to send Test SMS';
	    }
	    $client = new Twilio\Rest\Client($configuration['twilio_sid'], $configuration['twilio_token']);
	    $message = $client->account->messages->create(
	        $phone,
	        array(
	            'from' => $configuration['twilio_phone'],
	            'body' => $text
	        )
	    );
	    if($message->sid) {
	    	return $success;
	    }
	    return $fail;
	}

	/**
	/* Function to process all database calls
	**/
	function dbProcessor($sql=0, $type=0, $response='') {
		// Type 0 = Insert, Update, Delete
		// Type 1 = Select 
		// Type 100 = Just return the response

		global $DB;
		if ($type == 100) {
			$response = $response;
		} else {
			try {
				$stmt = $DB->prepare($sql);	 	
				$stmt->execute();
			} catch (Exception $ex) {
			   $error = errorMessage($ex->getMessage());
			}
			if ($type == 0) {
				if ($stmt->rowCount() > 0) {  
					return $response;
				} elseif (isset($error)) {
					return $error;
				} else {
					return 'No changes were made';
				}		 
			} elseif ($type == 1) {
				$results = $stmt->fetchAll();
			    if (count($results)>0) { 
			    	return $results; 
			    } elseif (isset($error)) {
			    	return $error;
			    }
			}		
		} 
	}
}


/* 
* Callback for decodeText()
*/
function decodeLink($text, $x=0) { 
    // If www. is found at the beginning add http in front of it to make it a valid html link
    $y = $x==1 ? 'primary-color' : 'secondary-color';

    if(substr($text[1], 0, 4) == 'www.') {
        $link = 'http://'.$text[1];
    } else {
        $link = $text[1];
    }
    return '<a class="'.$y.'" href="'.$link.'" target="_blank" rel="nofollow">'.$link.'</a>'; 
}
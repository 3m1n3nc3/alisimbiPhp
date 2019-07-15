<?php
//======================================================================\\
// Passengin 1.0 - Php templating engine and framewordk                 \\
// Copyright © Passcontest. All rights reserved.                        \\
//----------------------------------------------------------------------\\
// http://www.passcontest.com/                                          \\
//======================================================================\\

$framework = new framework; 
$user_role = $framework->userRoles();

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
	public $email;
    public $password;
	public $remember;
	public $firstname;
	public $lastname;
	public $city;
	public $state;
	public $country;
	public $phone;
    public $user;

	function userData($user = NULL, $type = NULL) {
        // if type = 0 fetch all users, and use filter to add custom query
        // if type = 1 users by their user ids
        // if type = 2 fetch users by thier usernames

	    global $configuration;

	    // Limit clause to enable pagination
        if (isset($this->limit)) {
            $limit = sprintf('ORDER BY date DESC LIMIT %s, %s', $this->start, $this->limit);
        } else {
            $limit = '';
        }
        $filter = isset($this->filter) ? $this->filter : '';

        if (isset($this->search)) {            //Search instance
	    	$search = $this->search; 	
	    	$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE username LIKE '%s' OR concat_ws(' ', `f_name`, `l_name`) LIKE '%s' OR country LIKE '%s' OR role LIKE '%s' LIMIT %s", '%'.$search.'%', '%'.$search.'%', '%'.$search.'%', '%'.$search.'%', $configuration['data_limit']);
        } elseif ($type === 0) {
            $sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE id <> '' %s %s", $filter, $limit);
        } elseif ($type === 1) {
	    	$sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE id = '%s'", $user); 
	    } else {
	    	// if the username is an email address
	    	if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
                $sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE email = '%s'", $user);
	    	} else {
                $sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE username = '%s'", $user);
	    	}
	    }
        // Process the information
        $results = $this->dbProcessor($sql, 1);
        if ($type !== 0) {
            return $results[0];
        } else {
            return $results;
        }
    }

    function authenticateUser($type = null) {
        global $LANG;
        if (isset($_COOKIE['username']) && isset($_COOKIE['usertoken'])) {
            $this->username = $_COOKIE['username'];
            $auth = $this->userData($this->username, 2);

            if ($auth['username']) {
                $logged = true;
            } else {
                $logged = false;
            }
        } elseif (isset($this->username)) {
            $username = $this->username;
            $auth = $this->userData($username);

            if ($auth['username']) {
                if ($this->remember == 1) {
                    setcookie("username", $auth['username'], time() + 30 * 24 * 60 * 60, COOKIE_PATH);
                    setcookie("usertoken", $auth['token'], time() + 30 * 24 * 60 * 60, COOKIE_PATH);

                    $_SESSION['username'] = $auth['username'];

                    $logged = true;
                    session_regenerate_id();
                } else {
                    $_SESSION['username'] = $auth['username'];
                    $_SESSION['password'] = $auth['password'];
                    $logged = true;
                }
            }
            return $username;

        } elseif ($type) {
            $auth = $this->userData($this->username);

            if ($this->remember == 1) {
                setcookie("username", $auth['username'], time() + 30 * 24 * 60 * 60, COOKIE_PATH);
                setcookie("usertoken", $auth['token'], time() + 30 * 24 * 60 * 60, COOKIE_PATH);

                $_SESSION['username'] = $auth['username'];

                $logged = true;
                session_regenerate_id();
            } else {
                return $LANG['data_unmatch'];
            }
        }

        if (isset($logged) && $logged == true) {
            return $auth;
        } elseif (isset($logged) && $logged == false) {
            $this->sign_out();
            return $LANG['data_unmatch'];
        }

        return false;
    }

    // Registeration function
    function registrationCall() {
        // Prevents bypassing the FILTER_VALIDATE_EMAIL
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

        $token = $this->generateToken();
        $password = hash('md5', $_POST['password']);
        $sql = sprintf("INSERT INTO " . TABLE_USERS . " (`email`, `username`, `password`, `f_name`, `l_name`,
		 `country`, `state`, `city`, `token`) VALUES 
	        ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $this->email, $this->username,
            $this->password, $this->firstname, $this->lastname, $this->country, $this->state, $this->city, $token);
        $response = $this->dbProcessor($sql, 0, 1);

        if ($response == 1) {
            $_SESSION['username'] = $this->username;
            $_SESSION['password'] = $password;
            $process = 1;
        }
        return $response;
    }

    function updateProfile() {
        global $user, $LANG;
        $firstname = $this->db_prepare_input($this->firstname);
        $lastname = $this->db_prepare_input($this->lastname);
        $phone = $this->db_prepare_input($this->phone);
        $xql = '';
        if (isset($this->social)) {
            $facebook = $this->facebook;
            $twitter = $this->twitter;
            $instagram = $this->instagram;
            $xql = sprintf(", `facebook` = '%s', `twitter` = '%s', `instagram` = '%s'", $facebook, $twitter, $instagram);
        }
        $country = $this->db_prepare_input($this->country);
        $state = $this->db_prepare_input($this->state) == 'undefined' ? '' : $this->db_prepare_input($this->state);
        $city = $this->db_prepare_input($this->city) == 'undefined' ? '' : $this->db_prepare_input($this->city);
        $about = $this->db_prepare_input($this->about);

        if ($firstname == '' || $lastname == '' || $phone == '' || $country == '' ||
            $state == '' || $city == '' || $about == '') {
            $response = errorMessage($LANG['_all_required']);
        } else {
            $sql = sprintf("UPDATE " . TABLE_USERS . " SET `f_name` = '%s', `l_name` = '%s', " .
                "`phone` = '%s', `country` = '%s', `state` = '%s', `city` = '%s', `about` = '%s'%s WHERE " .
                "`id` = '%s'", $firstname, $lastname, $phone, $country, $state, $city, $about, $xql, $user['id']);
            return $this->dbProcessor($sql, 0);
            $header = cleanUrls($SETT['url'] . '/index.php?page=account&profile=home');
        }
    }

    function sign_out($reset = null) {
        if ($reset == true) {
            $this->resetToken();
        }
        setcookie("usertoken", '', time() - 3600, COOKIE_PATH);
        setcookie("username", '', time() - 3600, COOKIE_PATH);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
    }

    function checkEmail($email = NULL, $type = 0) {
        $sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE 1 AND email = '%s'", mb_strtolower($email));
        // Process the information
        $results = $this->dbProcessor($sql, 1);
        if ($type == 1) {
            return $results[0];
        } else {
            return $results[0]['email'];
        }
    }

    function captchaVal($captcha) {
        global $settings;
        if ($settings['captcha']) {
            if ($captcha == "{$_SESSION['captcha']}" && !empty($captcha)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function phoneVal($phone, $type = 0) {
        global $settings;
        $phone = $this->db_prepare_input($phone);

        if ($type) {
            $sql = sprintf("SELECT phone FROM " . TABLE_USERS . " WHERE phone = '%s'", $phone);
            $rs = $this->dbProcessor($sql, 1)[0];
            return $rs ? false : true;
        } else {
            if (mb_strlen($phone) < 9 OR !preg_match('/^[0-9]+$/', $phone)) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Set user roles to determine what user can do
    function userRoles() {
        global $user;
        if ($user) {
            if ($user['role'] == 'learner') {
                $role = 0;
            } elseif ($user['role'] == 'teacher') {
                $role = 1;
            } elseif ($user['role'] == 'mod') {
                $role = 2;
            } elseif ($user['role'] == 'admin') {
                $role = 3;
            } elseif ($user['role'] == 'sudo') {
                $role = 4;
            }
        } else {
            $role = 0;
        }
        return $role;
	}

	/**
	* Manage the editing and creation of courses and modules
	*/
	function courseModuleEntry($type = 0) {
		global $SETT, $LANG, $configuration, $user;
		// if type == 0: Add new course
		// if type == 1: Add new course
		// if type == 2: Add new Module
		// if type == 3: Update Module

		if ($type == 0 || $type == 1) {
			$title = $this->course_title;
			$price = $this->course_price;
			$intro = $this->introduction;
			$benefits = $this->benefits;
			$status = $this->status;
			$cover = $this->cover_photo;
			$badge = $this->badge;
			$start = $this->start ? $this->start : date('Y-m-d H:m:i', strtotime('today'));
		} elseif ($type == 2 || $type == 3) {
			$module_title = $this->module_title;
			$transcript = $this->transcript;
			$introduction = $this->introduction;
			$duration = $this->duration;
			$cover = $this->cover_photo;
			$badge = $this->badge;
			$secure_key = $this->secure_key;
		}

		if ($type == 0) {
			$sql = sprintf("INSERT INTO " . TABLE_COURSES . " (`title`, `intro`, `cover`, `badge`, `benefits`,"
				. " `status`, `price`, `start`, `creator_id`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', "
				. " '%s', '%s')", $title, $intro, $cover, $badge, $benefits, $status, $price, $start, $user['id']);
		} elseif ($type == 1) {
			$sql = sprintf("UPDATE " . TABLE_COURSES . " SET `title` = '%s', `intro` = '%s', `cover` = '%s'," 
				. " `badge` = '%s', `benefits` = '%s', `status` = '%s', `price` = '%s', `start` = '%s'"
				. " WHERE id = '%s'", $title, $intro, $cover, $badge, $benefits, $status, $price, $start, 
				$this->course_id); 
		} elseif ($type == 2) {
			$sql = sprintf("INSERT INTO " . TABLE_MODULES . " (`title`, `transcript`, `intro`, `duration`,"
				. " `cover`, `badge`, `secure_code`, `creator_id`) VALUES ('%s', '%s', '%s', '%s', '%s',"
				. " '%s', '%s', '%s')", $module_title, $transcript, $introduction, $duration, $cover, 
				$badge, $secure_key, $user['id']);
		} elseif ($type == 3) {
			$sql = sprintf("UPDATE " . TABLE_MODULES . " SET `title` = '%s', `transcript` = '%s', `intro`"
				. " = '%s', `duration` = '%s', `cover` = '%s', `badge` = '%s', `secure_code` = '%s'"
				. " WHERE id = '%s'", $module_title, $transcript, $introduction, $duration, $cover, 
				$badge, $secure_key, $this->module_id);
		}
		$results = $this->dbProcessor($sql, 0, 1);
		 
		if ($results == 1 && ($type == 0 || $type == 2)) {
			$order = sprintf(" WHERE creator_id = '%s' ORDER BY id DESC", $user['id']);
			$m = getCourses(null, null, $order)[0]; 
			$this->addInstructor($user['id'], $m['id']);
		}
		return $results;
	}

	/*
	Add an instructor, when you create a new course
	And when you link a module to a course
	 */
	function addInstructor($uid, $courseid, $type = null) {
		global $SETT, $LANG, $configuration, $user;
		if ($type == null) {
			$sql = sprintf("INSERT INTO " . TABLE_INSTRUCTORS . " (`course_id`, `user_id`) VALUES ('%s', '%s')",
				$courseid, $uid);
		}
		$results = $this->dbProcessor($sql, 0, 1);
		return $results;
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

                    $sort .= '
                    <div class="padding-5">
						' . $state . '
						<div>
							<div>
								<strong><a href="' . $url . '" target="_blank">' . $name . '</a></strong>
							</div>
							<div>
								' . $by . ': <a href="' . $url . '" target="_blank">' . $author . '</a>
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
    function generateToken($length = 10, $type = 0)
    {
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
                header('Location: ' . cleanUrls($SETT['url'] . '/index.php?page=' . $location));
	        } else {
                header('Location: ' . cleanUrls($SETT['url'] . '/index.php'));
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
	/* this function controls file uploads	
	 **/	
	function uploader($file = null, $type = 0, $eck = null) {
		// File arguments
		$errors = array();
		$uploade_type = '';

		// Generate the image properties  
		if ($type == 0 && isset($file['name'])) { 
			$_FILE = $file;
			$allowed = array("jpeg","jpg","png");
			$size = 1097152;
			$uploade_type .= 'Cover Photo';
			$error = $file['name'] == '' ? "Please select an image for cover photo. " : 
			$error = "File type not allowed for Cover Photo, use a JPEG, JPG or PNG file. ";
			$w = 3200; $h = 2000;
    		$dir = 'img'; 
		} elseif ($type == 1 && isset($file['name'])) {
			$_FILE = $file;
			$allowed = array("png");
			$size = 1097152;
			$uploade_type .= 'Badge';
			$error = $file['name'] == '' ? "Please select an image for badge. " : 
			$error = "File type not allowed for Badge, use a PNG file. ";
			$w = 3200; $h = 2000;
    		$dir = 'img'; 
		} 
		$file_name = $_FILE['name'];
		$file_size = $_FILE['size'];
		$file_tmp = $_FILE['tmp_name'];
		$file_type= $_FILE['type'];
		$lower = explode('.',$_FILE['name']);
		$file_ext = strtolower(end($lower));
		  
	    $new_image = mt_rand().'_'.mt_rand().'_'.mt_rand().'_n.'.$file_ext; 

	    // Check if file is allowed for upload type
		if(in_array($file_ext,$allowed)=== false){
		    $errors[] = $error;
		}
		if($file_size > $size){
    		$errors[].= $uploade_type.' should not be more than '.$size.'MB';
		}

		/*
		// Check for errors in the file upload before uploading, 
		// To avoid multiple waste of storage
		 */
		if ($eck) {
			if (in_array($file_ext,$allowed) && empty($errors)==true) { 
				return 1;
			} else {
				return $errors[0];
			}
		} else {
			// Crop and compress the image
			if (in_array($file_ext,$allowed) && empty($errors)==true) {
				// Create a new ImageResize object
	      		$image = new \Gumlet\ImageResize($file_tmp);
	      		$cd = getcwd();
	        	// Manipulate the image
	        	$image->crop($w, $h);
	        	$image->save($cd.'/uploads/'.$dir.'/'.$new_image);    
				return $new_image;
			} else {
				return $errors[0];
			}
		}		
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

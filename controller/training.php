<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user, $contact_;
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);
	$PTMPL['site_url'] = $SETT['url'];

	$PTMPL['currency'] = $configuration['currency'];

	$PTMPL['copyrights_'] = '&copy; '. date('Y').' '.$contact_['c_line'];
	$PTMPL['site_title_'] = $configuration['site_name'];
	//$ac = courseAccess(1); print_r($ac);

	if ($user) {
		// Create course and module links
        $PTMPL['add_course_link'] = secureButtons('background_green2 bordered', 'Add Course', 3, null, null);
        $PTMPL['add_module_link'] = secureButtons('background_green2 bordered', 'Add Module', 2, null, null);

		if (isset($_GET['course'])) {
			if (isset($_GET['courseid']) && $_GET['courseid'] != '') {
		    	$course = getCourses(1, $_GET['courseid'])[0];
	    		$PTMPL['course_title'] = $course['title'];
	    		$PTMPL['course_cover'] = '<p><img style="width: 250px; float: left; padding: 10px;" src="'.getImage($course['cover'], 1).'" class="image_class"></p>';
	    		$PTMPL['course_cover_url'] = getImage($course['cover'], 1);
	    		$PTMPL['course_intro'] = $course['intro'];

			    //Show user role
			    $PTMPL['user_priviledge'] = ucfirst($user['role']);

	    		$moduleArr = getModules(1, $_GET['courseid']);
	    		$modules = '';
				$edit_modules = '';
	    		if ($moduleArr) {
	       			foreach ($moduleArr as $mAr) {
		    			$modules .= courseModuleCard($mAr, 1);
						$edit_modules .= courseModuleCard($mAr, 2);
		    		}
	    		}

				// Get a list of instructors for the selected course
				$instructorsArr = getInstructors($_GET['courseid']);

				$instructor = '';
				$course_instructor = '';

				if ($instructorsArr) {
					foreach ($instructorsArr as $ins) {
						$instructor .= instructorCard($ins);
						$course_instructor .= instructorCard($ins, 1);
					}
					$PTMPL['instructor'] = $instructor;
					$PTMPL['_course_instructors'] = $course_instructor;
				}

	    		$get = cleanUrls($SETT['url'].'/index.php?page=training&course=get&courseid='.$_GET['courseid']);
	    		$PTMPL['course_modules'] = $PTMPL['course_modules_new'] = $modules;
				$PTMPL['edit_course_modules'] = $edit_modules;
	    		$PTMPL['course_get_btn_url'] = $get;
				$PTMPL['course_edit_btn'] = secureButtons('background_green2 bordered', 'Edit Course', 1, $_GET['courseid'], null);
	    		$PTMPL['course_toggle_descr'] = '<a href="#course_descr" class="action_toggle" data-toggle="collapse">Toggle description</a>';

				if (isset($_GET['unlink_module']) && $_GET['unlink_module'] != '') {
					deleteItems(1, $_GET['courseid'], $_GET['unlink_module']);
					$framework->redirect('training&course=edit&courseid=' . $_GET['courseid']);
				}
			}

			// $PTMPL['course_'] = $course[''];
			if (isset($_GET['courseid']) && $_GET['courseid'] != '' && $_GET['course'] != 'add' && $_GET['course'] != 'edit') {
			    $course = getCourses(1, $_GET['courseid'])[0];

			    // Set the page title
			    $PTMPL['page_title'] = ucfirst($_GET['page']).' - '.$course['title'];

	    		$PTMPL['course_title'] = $course['title'];
	    		$PTMPL['course_cover'] = '<p><img style="width: 250px; float: left; padding: 10px;" src="'.getImage($course['cover'], 1).'" class="image_class"></p>';
	    		$PTMPL['course_intro'] = $course['intro'];
	    		$moduleArr = getModules(1, $_GET['courseid']);
	    		$modules = '';
	    		if ($moduleArr) {
	    			foreach ($moduleArr as $mAr) {
		    			$modules .= courseModuleCard($mAr, 1);
		    		}
	    		}

	    		$get = cleanUrls($SETT['url'].'/index.php?page=training&course=get&courseid='.$_GET['courseid']);
	    		$PTMPL['course_modules'] = $modules;
	    		$PTMPL['course_get_btn'] = '<a href="'.$get.'" class="btn btn-md btn-success"><i class="fa fa-credit-card"></i>Get Course</a>';
	    		// $PTMPL['course_'] = $course[''];
			}

    		/*if you are viewing the course details*/
			if ($_GET['course'] == 'view') {
			    $theme = new themer('training/course_info'); $account = '';
		        // $OLD_THEME = $PTMPL; $PTMPL = array();

			    // Set the page title
			    $PTMPL['page_title'] = ucfirst($_GET['page']).' - '.$course['title'];
			    $PTMPL['benefits'] = fetchBenefits($_GET['courseid']);

    		/*if you are paying for the course details*/
			} elseif ($_GET['course'] == 'get') {
		      	$theme = new themer('training/course_get'); $account = '';

			    // Set the page title
			    $PTMPL['page_title'] = ucfirst($_GET['page']).' - Checkout '.$course['title'];

    			$PTMPL['raveverified'] = getImage('raveverified.png');
    			$PTMPL['course_price'] = $course['price'].' NGN';

    			/* Rave checkout variables*/
    			 // Rave API Public key
				 	$public_key = $configuration['rave_public_key'];
				 	 // Rave API Private key
					$private_key = $configuration['rave_private_key'];
					// Check if sandbox is enabled
					$ravemode = ($configuration['rave_mode'] ? 'api.ravepay.co' : 'ravesandboxapi.flutterwave.com');
					 // Currency Code
					$currency_code 	= $configuration['currency'];
					// Url to redirect to to verify rave
					$successful_url	= $SETT['url'].'/connection/raveAPI.php';
					isset($_SESSION['txref']) ? $reference = $_SESSION['txref'] : $reference = '';

				/*if you are adding or editing courses*/
			} elseif ($_GET['course'] == 'add' || $_GET['course'] == 'edit') {
		    	$theme = new themer('training/course_add_edit'); $account = '';

		    	$PTMPL['course_create_btn'] = 'Create Course';
				$PTMPL['course_create_header'] = 'Create a new course';

			    // Set the page title
			    $PTMPL['page_title'] = 'Create new course';

	    		// If you are editing this course, use the db values as value
	    		if (isset($_GET['courseid'])) {
	    			$course = getCourses(1, $_GET['courseid'])[0];
	    			if ($course) {

					    // Set the page title
					    $PTMPL['page_title'] = 'Update Course: '.$course['title'];

						$PTMPL['course_title'] = $course['title'];
						$PTMPL['course_price'] = $course['price'];
						$PTMPL['introduction'] = $course['intro'];
						$PTMPL['date'] = $course['start'];
						$PTMPL['status'] = $course['status'];
						$PTMPL['course_create_btn'] = 'Update Course';
						$PTMPL['course_create_header'] = 'Update Course: '.$course['title'];
	    			}

	    			// This link will enable you link a course and a module
	    			$link_module_link = cleanUrls($SETT['url'].'/index.php?page=training&course=link_module&courseid='.$_GET['courseid']);
	    			$PTMPL['link_module_link'] = '<a href="'.$link_module_link.'" class="btn">Link with module</a>';
	    		}

	    		// Save the course info
				if (isset($_POST['save'])) {
		    		$PTMPL['course_title'] = $_POST['course_title'];
					$PTMPL['course_price'] = $_POST['price'];
					$PTMPL['introduction'] = $_POST['introduction'];
					$PTMPL['date'] = $_POST['date'];
					$PTMPL['status'] = $_POST['status'];

					$framework->course_title = $framework->db_prepare_input($_POST['course_title']);
					$framework->course_price = $framework->db_prepare_input($_POST['price']);
					$framework->introduction = $framework->db_prepare_input($_POST['introduction'], 1);
					$framework->benefits = $framework->db_prepare_input($_POST['benefits']);
					$date = date('Y-m-d H:m:i', strtotime($framework->db_prepare_input($_POST['date'])));
					$framework->start = $date;
					$framework->status = $framework->db_prepare_input($_POST['status']);
					$framework->files = $_FILES;

					if ($_POST['course_title'] == '') {
						$msg = messageNotice($LANG['no_empty_title'], 3);
					} elseif ($_POST['introduction'] == '') {
						$msg = messageNotice($LANG['no_empty_intro'], 3);
					} elseif ($_POST['benefits'] == '') {
						$msg = messageNotice($LANG['no_empty_benefit'], 3);
					} elseif (empty($_FILES['cover_photo'])) {
						$msg = messageNotice($LANG['no_empty_cover'], 3);
					} else {
						// Check if images uploaded without errors
						$eck_1 = $framework->uploader($_FILES['badge'], 1, 1);
						$eck_2 = $framework->uploader($_FILES['cover_photo'], 0, 1);
						$eck_err = ' ';
						if (!isset($_GET['courseid']) && ($eck_1 !== 1 || $eck_2 !== 1)) {
							$eck_err .= $eck_1 !==1 ? ' '.$eck_1 : '';
							$eck_err .= $eck_2 !==1 ? ' '.$eck_2 : '';
							$msg = messageNotice($eck_err, 3);
						} else {
							// If files uploaded without errors, proceed to save.
							if (isset($_GET['courseid'])) {
								$framework->cover_photo = empty($_FILES['cover_photo']['name']) ? $course['cover'] :
								$framework->uploader($_FILES['cover_photo'], 0);
								$framework->badge = empty($_FILES['badge']['name']) ? $course['badge'] :
								$framework->uploader($_FILES['badge'], 0);
							} else {
								$framework->cover_photo = $framework->uploader($_FILES['cover_photo'], 0);
								$framework->badge = $framework->uploader($_FILES['badge'], 1);
							}

							// Save the input
							if ($_GET['course'] == 'add') {
								$response = $framework->courseModuleEntry(0);
								$resp = messageNotice($LANG['course_added'], 1);
							} elseif ($_GET['course'] == 'edit') {
								$framework->course_id = $framework->db_prepare_input($_GET['courseid']);
								$response = $framework->courseModuleEntry(1);
								$resp = messageNotice($LANG['course_updated'], 1);
							}
							if ($response == 1) {
								$msg = $resp;
							} else {
								$msg = messageNotice($response);
							}
						}
					}
					$PTMPL['course_message'] = $msg;
				}
			} elseif (isset($_GET['course']) && $_GET['course'] == 'link_module') {
		        $theme = new themer('training/link_module'); $account = '';
				// $OLD_THEME = $PTMPL; $PTMPL = array();

			    // Set the page title
			    $PTMPL['page_title'] = 'Link Modules to '.$course['title'];

				$PTMPL['module_create_header'] = 'Link Modules to '.$course['title'];
				$get_modules = getModules();
				$get_modules = array_reverse($get_modules);
				$options = '';
				if ($get_modules) {
					foreach ($get_modules as $module) {
						$options .= '<option value="' . $module['id'] . '">' . $module['title'] . '</option>';
					}
				}
		        $PTMPL['select_options'] = $options;
		        if (isset($_POST['module'])) {
		        	$process = linkModule($_POST['module'], $_GET['courseid']);
		        	if ($process == 1) {
						$PTMPL['link_message'] = successMessage('Module has been successfully linked with ' . $course['title']);
		        	} else {
		        		$PTMPL['link_message'] = infoMessage($process);
		        	}
		        } elseif (isset($_POST['link_module'])) {
		        	$PTMPL['link_message'] = infoMessage('You have not selected any module');
		        }
			} elseif (isset($_GET['course']) && $_GET['course'] == 'now_learning') {
		        $theme = new themer('training/now_learning'); $account = '';
				// $OLD_THEME = $PTMPL; $PTMPL = array();
				//
				$get_modules = getModules(2, isset($_GET['moduleid']) ? $_GET['moduleid'] : '')[0];
		        $PTMPL['title_header'] = $course['title'];
				$PTMPL['list_modules'] = studyModules($_GET['courseid'], isset($_GET['moduleid']) ? $_GET['moduleid'] : '');
		        // $vid = $get_modules['video'] ? $get_modules['video'] :
		        $PTMPL['video_log'] = getVideo($get_modules['video']);
		        $PTMPL['transcript'] = $get_modules['transcript'];
				$PTMPL['course_edit_btn'] = secureButtons('background_green2 bordered', 'Edit Course', 1, $_GET['courseid'], isset($_GET['moduleid']) ? $_GET['moduleid'] : '');
				$PTMPL['percent_complete'] = courseDuration($_GET['courseid']);
			}
		} elseif (isset($_GET['module']) && $_GET['module'] == 'edit' && isset($_GET['action'])) {
			// Add Video to the lesson
			if ($_GET['action'] == 'add_video') {
				$theme = new themer('training/upload_video');
				$account = '';
				// $OLD_THEME = $PTMPL; $PTMPL = array();
				// Page to upload and link video
				//
				$get_modules = getModules(2, $_GET['moduleid'])[0];

				// Set the page title
				$PTMPL['page_title'] = 'Upload video for ' . $get_modules['title'];

				$PTMPL['vid_processor'] = $SETT['url'] . '/connection/upload_video.php';
				$PTMPL['animation_link'] = $SETT['url'] . '/' . $SETT['template_url'] . '/img/loader.gif';
				$PTMPL['module_create_header'] = 'Upload video for ' . $get_modules['title'];
				$PTMPL['module_id'] = $get_modules['id'];
				$PTMPL['youtube_url'] = strpos($get_modules['video'], "youtube.com") == true ? $get_modules['video'] : '';
				if (isset($_POST['youtube_url'])) {
					$post_url = $framework->db_prepare_input($_POST['youtube_url']);
					$mid = $framework->db_prepare_input($_GET['moduleid']);
					$PTMPL['display_val'] = '';
					if ($_POST['youtube_url'] == '') {
						$msg = infoMessage('Youtube Embed URL cannot be empty');
					} elseif (!filter_var($post_url, FILTER_VALIDATE_URL)) {
						$msg = infoMessage('You have provided an invalid URL');
					} elseif (strpos($post_url, "youtube.com") == false) {
						$msg = infoMessage('Only Youtube URLs are allowed');
					} elseif (strpos($post_url, "/embed/") == false) {
						$msg = infoMessage('This is not a valid embed URL, a valid one would look like: https://www.youtube.com/embed/AbcD3Fgh1Jk');
					} else {
						$x = getModules(2, $mid)[0];
						deleteFile(1, $x['video'], 1);
						$sql = sprintf("UPDATE " . TABLE_MODULES . " SET `video` = '%s' WHERE id = '%s'", $post_url, $mid);
						$results = $framework->dbProcessor($sql, 0, 1);
						if ($results == 1) {
							$msg = successMessage('Video uploaded successfully');
							$x = getModules(2, $mid)[0];
							$PTMPL['preview'] = '
							<div class="col-md-4">
								<iframe width="420" height="315"
									src="' . getVideo($x['video']) . '">
								</iframe>
							</div>';
						} else {
							$msg = errorMessage($results);
						}
					}
					$PTMPL['module_message'] = $msg;
				} else {
					$PTMPL['display_val'] = 'style="display:none"';
				}
			} elseif ($_GET['action'] == 'add_question') {
				$theme = new themer('training/add_questions');
				$account = '';

				$get_modules = getModules(2, $_GET['moduleid'])[0];

				// Set the page title
				$PTMPL['page_title'] = $PTMPL['question_create_header'] = 'Add test questions for ' . $get_modules['title'];

				if (isset($_GET['question'])) {
					$get_q = getQuestions($_GET['question'], 1)[0];
					$get_a = getAnswers($get_q['id']);
					$PTMPL['question'] = $get_q['question'];
					$framework->question_id = $framework->db_prepare_input($_GET['question']);

					// Set the page title
					$PTMPL['page_title'] = $PTMPL['question_create_header'] = 'Update question with ID ' . $get_q['id'];

					$PTMPL['edit_notice'] = '<small class="text-info">You can only update the question, to change options delete this question and create a new one</small>';
				} elseif (isset($_GET['delete'])) {
					$sql = sprintf("DELETE FROM " . TABLE_QUESTION . " WHERE id = '%s'", $_GET['delete']);
					$del = $framework->dbProcessor($sql, 0, 1);
					if ($del == 1) {
						$sql = sprintf("DELETE FROM " . TABLE_ANSWER . " WHERE question_id = '%s'", $_GET['delete']);
						$del = $framework->dbProcessor($sql, 0, 1);
					}
					$framework->redirect('training&module=edit&moduleid=' . $_GET['moduleid'] . '&action=add_question');
				}

				// Fetch Questions
				$list_questions = getQuestions($_GET['moduleid']);
				$list_q = '
			    		<div class="m-2">';
				if ($list_questions) {
					foreach ($list_questions AS $ques) {
						$list_q .= '<a href="' . cleanUrls($SETT['url'] . '/index.php?page=training&module=edit&moduleid=' . $_GET['moduleid'] . '&action=add_question&question=' . $ques['id']) . '">' . $framework->myTruncate($ques['question'], 45) . '</a> ';
						$list_q .= '<a href="' . cleanUrls($SETT['url'] . '/index.php?page=training&module=edit&moduleid=' . $_GET['moduleid'] . '&action=add_question&delete=' . $ques['id']) . '">DELETE</a>
			    		</div>';
					}
					$PTMPL['question_list'] = $list_q;
				}

				// Save the question to db
				if (isset($_POST['save'])) {
					$PTMPL['question'] = $_POST['question'];
					$PTMPL['answer1'] = $_POST['answer1'];
					$PTMPL['answer2'] = $_POST['answer2'];
					$PTMPL['answer3'] = $_POST['answer3'];
					$PTMPL['answer4'] = $_POST['answer4'];

					$framework->module_id = $framework->db_prepare_input($_GET['moduleid']);
					$framework->question = $framework->db_prepare_input($_POST['question'], 1);
					$framework->answer1 = $framework->db_prepare_input($_POST['answer1']);
					$framework->answer2 = $framework->db_prepare_input($_POST['answer2']);
					$framework->answer3 = $framework->db_prepare_input($_POST['answer3']);
					$framework->answer4 = $framework->db_prepare_input($_POST['answer4']);
					$framework->correct = $framework->db_prepare_input($_POST['correct']);

					$get_q = getQuestions($_GET['moduleid'])[0];
					if ($_POST['question'] = '') {
						$msg = errorMessage("A question is required to save");
					} elseif (!isset($_GET['question']) && ($_POST['answer1'] == '' || $_POST['answer2'] == '' || $_POST['answer3'] == '' || $_POST['answer4'] == '')) {
						$msg = errorMessage("Sorry, there is no option for an empty option");
					} elseif ($get_q['question'] == $framework->question) {
						$msg = infoMessage("This question is similar to one you had earlier added!");
					} else {
						if (isset($_GET['question'])) {
							$save = $framework->addQuestions(1);
						} else {
							$save = $framework->addQuestions();
						}
						if ($save == 1) {
							$msg = successMessage("Your question has been added successfully");
						} else {
							$msg = infoMessage($save);
						}
					}
					$PTMPL['question_message'] = $msg;
				}
			}
		} elseif (isset($_GET['module'])) {
			if ($_GET['module'] == 'add' || $_GET['module'] == 'edit') {
		        $theme = new themer('training/module_add_edit'); $account = '';
				// $OLD_THEME = $PTMPL; $PTMPL = array();

		    	$PTMPL['module_create_btn'] = 'Create module';
				$PTMPL['module_create_header'] = 'Create a new module';
				$PTMPL['module_id'] = isset($_GET['moduleid']) ? $_GET['moduleid'] : '';

				isset($_GET['moduleid']) ? $PTMPL['video_pre_notice'] = 'style="display: none;"' : 
				$PTMPL['video_post_notice'] = 'style="display: none;"';

			    // Set the page title
			    $PTMPL['page_title'] = 'Create new module';			    

			   	if ($_GET['module'] == 'edit' && isset($_GET['moduleid'])) {
			    	$get_modules = getModules(2, $_GET['moduleid'])[0];

			    	if ($get_modules) {
					    // Set the page title
					    $PTMPL['page_title'] = 'Update Module: '.$get_modules['title'];

						$PTMPL['module_create_header'] = 'Update Module: '.$get_modules['title'];

						$PTMPL['module_title'] = $get_modules['title'];
						$PTMPL['transcript'] = $get_modules['transcript'];
						$PTMPL['introduction'] = $get_modules['intro'];
						$PTMPL['duration'] = $get_modules['duration'];
						$PTMPL['module_create_btn'] = 'Update Module';

						$PTMPL['mast_cover_photo'] = '
		                    <div class="course-banner">
		                        <img alt="Cover photo" class="img-fluid" src="'.getImage($get_modules['cover'], 1).'"/>
		                    </div>';

						/*
						Link to add video to the updated created module
						 */
						$add_video_btn = cleanUrls($SETT['url'].'/index.php?page=training&module=edit&moduleid='.$_GET['moduleid'].'&action=add_video');
						$PTMPL['add_video_btn'] = '<a href="'.$add_video_btn.'" class="btn">Proceed to upload video</a>';

						$add_question = cleanUrls($SETT['url'] . '/index.php?page=training&module=edit&moduleid=' . $_GET['moduleid'] . '&action=add_question');
						$PTMPL['add_question_btn'] = '<a href="' . $add_question . '" class="btn">Add test question</a>';
			    	}
				}

			    // Save the profile info
				if (isset($_POST['save'])) {
					$response = null;
		    		$PTMPL['module_title'] = $_POST['module_title'];
					$PTMPL['transcript'] = $_POST['transcript'];
					$PTMPL['introduction'] = $_POST['introduction'];
					$PTMPL['duration'] = $_POST['duration'];

					$framework->module_title = $framework->db_prepare_input($_POST['module_title']);
					$framework->transcript = $framework->db_prepare_input($_POST['transcript'], 1);
					$framework->introduction = $framework->db_prepare_input($_POST['introduction'], 1);
					$framework->duration = $_POST['duration'] < 1 ? 1 : $framework->db_prepare_input($_POST['duration']);
					$framework->files = $_FILES;

					if ($_POST['module_title'] == '') {
						$msg = messageNotice($LANG['no_empty_title'], 3);
					} elseif ($_POST['introduction'] == '') {
						$msg = messageNotice($LANG['no_empty_intro'], 3);
					} elseif (empty($_FILES['cover_photo'])) {
						$msg = messageNotice($LANG['no_empty_cover'], 3);
					} else {
						// Check if images will be uploaded without errors
						$eck_1 = $framework->uploader($_FILES['badge'], 1, 1);
						$eck_2 = $framework->uploader($_FILES['cover_photo'], 0, 1);
						$eck_err = ' ';
						if ($eck_1 !== 1 || $eck_2 !== 1) {
							$eck_err .= $eck_1 !==1 ? ' '.$eck_1 : '';
							$eck_err .= $eck_2 !==1 ? ' '.$eck_2 : '';
							$msg = messageNotice($eck_err, 3);
						} else {
							// If files uploaded without errors, proceed to save.
							if (isset($_GET['moduleid'])) {
								$framework->cover_photo = empty($_FILES['cover_photo']['name']) ? $get_modules['cover']
									: $framework->uploader($_FILES['cover_photo'], 0);
								$framework->badge = empty($_FILES['badge']['name']) ? $get_modules['badge'] :
									$framework->uploader($_FILES['badge'], 0);
								$framework->secure_key = $get_modules['secure_code'] ? $get_modules['secure_code'] : $framework->generateToken();
							} else {
								$framework->cover_photo = $framework->uploader($_FILES['cover_photo'], 0);
								$framework->badge = $framework->uploader($_FILES['badge'], 1);
								$framework->secure_key = $framework->generateToken();
							}

							// Save the input
							if ($_GET['module'] == 'add') {
								$response = $framework->courseModuleEntry(2);
								$resp = messageNotice($LANG['module_added'], 1);
							} elseif ($_GET['module'] == 'edit') {
								$framework->module_id = $framework->db_prepare_input($_GET['moduleid']);
								$response = $framework->courseModuleEntry(3);
								$resp = messageNotice($LANG['module_updated'], 1);
							}
							if ($response == 1) {
								$msg = $resp;
							} else {
								$msg = messageNotice($response);
							}
						}
					}

				    /*
				    Link to add video to the newly created module
				     */
				    if ($_GET['module'] == 'add' && $response == 1) {
					    $order = sprintf(" WHERE creator_id = '%s' ORDER BY id DESC", $user['id']);
					    $m = getModules(null, null, $order)[0];
					    $add_video_btn = cleanUrls($SETT['url'].'/index.php?page=training&module=edit&moduleid='.$m['id'].'&action=add_video');
						$PTMPL['add_video_btn'] = '<a href="'.$add_video_btn.'">Proceed to upload video</a>';
				    }

					$PTMPL['module_message'] = $msg;
				}
			}

		} else {
	        $theme = new themer('training/home'); $account = '';
			// $OLD_THEME = $PTMPL; $PTMPL = array();

	        $courseArr = getCourses();
	        $course = '';
	        foreach ($courseArr as $rslt) {
	        	$course .= courseModuleCard($rslt);
			}
	        $PTMPL['course'] = $course;
		}
	} else {
		$framework->redirect();
	}
	if (isset($_GET['view'])) {

	}

	// Dont touch anything below this line
	$render = $theme->make();
    // $PTMPL = $OLD_THEME; unset($OLD_THEME);
	return $render;
}
?>

<?php
/*  Admin Quiz Management Functions
--------------------------------------------------------*/
defined('WPSS_URL') or die('Restricted access');


/**
 *  Creates new quiz with default settings
 *  Stores new quiz in DB with new :id
 */
function wpss_createNewQuiz(){
  global $wpdb;
  // grab logged-user's info for prefill
  global $current_user; get_currentuserinfo();
  
  // create new quiz with default new quiz values
  $defaults = array('submit_button_txt'=>'Click to Submit','store_results'=>'1','store_results'=>'1','send_admin_email'=>'1','admin_email_addr'=>$current_user->user_email,'user_email_from_name'=>'WP-Simple-Survey','integrate_wplogin'=>'1','record_submit_info'=>'1','send_user_email'=>'1','user_email_from_address'=>$current_user->user_email,'user_email_content'=>'<p>Thank you for taking our [quiztitle]</p><p>You scored [score] and were routed to:<br />[routed]</p><p>Summary:</p>[answers]');  
  $wpdb->insert(WPSS_QUIZZES_DB,$defaults);
  $new_quiz_id = $wpdb->insert_id;
  
  // create first 3 questions, 2 answers each
  for($i=0;$i<3; $i++) {
    $wpdb->insert(WPSS_QUESTIONS_DB, array('question'=>'Insert New Question','quiz_id'=>$new_quiz_id,'type'=>'radio'));
    $new_question_id = $wpdb->insert_id;
    $wpdb->insert(WPSS_ANSWERS_DB, array('answer'=>'Insert New Answer','quiz_id'=>$new_quiz_id ,'question_id'=>$new_question_id,'weight'=>1 ) );
    $wpdb->insert(WPSS_ANSWERS_DB, array('answer'=>'Insert New Answer','quiz_id'=>$new_quiz_id ,'question_id'=>$new_question_id,'weight'=>1 ) );
  }
  
  // create 3 ranges for new quiz
  $wpdb->insert(WPSS_ROUTES_DB, array('from_score'=>0,'to_score'=>69,'url'=>'Insert a URL to a page for this scoring range','quiz_id'=>$new_quiz_id ) );
  $wpdb->insert(WPSS_ROUTES_DB, array('from_score'=>70,'to_score'=>95,'url'=>'Ex: '.get_bloginfo('url').'/passing','quiz_id'=>$new_quiz_id ) );
  $wpdb->insert(WPSS_ROUTES_DB, array('from_score'=>96,'to_score'=>100,'url'=>'Ex: '.get_bloginfo('url').'/excellent', 'quiz_id'=>$new_quiz_id) ); 
 
  // create default fields for new quiz
  $wpdb->insert(WPSS_FIELDS_DB, array('name'=>'Name:','required'=>1,'quiz_id'=>$new_quiz_id ) );
  $wpdb->insert(WPSS_FIELDS_DB, array('name'=>'Email:','required'=>1,'quiz_id'=>$new_quiz_id) ); 
 
  $wpdb->flush();
}





/**
 *  Get lowest quiz ID
 *  @return int
 */
function wpss_get_firstQuizID(){
  global $wpdb;
  $quizzes = $wpdb->get_results( "SELECT * FROM ".WPSS_QUIZZES_DB,ARRAY_A);
  // insert first question
  if(count($quizzes)===0){
    wpss_createNewQuiz();               
    $quizzes = $wpdb->get_results( "SELECT * FROM ".WPSS_QUIZZES_DB,ARRAY_A);
  }
  return $quizzes[0]['id'];
}





/**
 *  HTML list elements foreach quiz link and puts class on current
 *  @return string/html
 */
function print_quizIDList($id,$page){
  global $wpdb;
  $quizzes = $wpdb->get_results("SELECT * FROM ".WPSS_QUIZZES_DB, ARRAY_A);

  $list = '';
  foreach($quizzes as $q){
    $name = !empty($q['quiz_title'])? stripslashes(strip_tags($q['quiz_title'])) : "Quiz-".$q['id'];
    if($q['id']==$id){
      $list .= '<li class="current"><a href="?page='.$page.'&quiz='.$q['id'].'">'.$name.'</a>|</li>';
    }
    else{
      $list .= '<li><a href="?page='.$page.'&quiz='.$q['id'].'">'.$name.'</a>|</li>';
    }
  }  
  echo $list;
}





/**
 *  Current quiz ID, newest quiz id for new quiz request or
 *  $_GET's current quiz, or fresh open id
 *
 *  @return int current quiz_id
 */
function wpss_get_currentQuizID(){
  global $wpdb;
  if(!empty($_GET['quiz']) && is_numeric($_GET['quiz'])) return $_GET['quiz'];
  if(!empty($_GET['quiz']) && $_GET['quiz']=="new"){
    $newest_quiz = $wpdb->get_row("SELECT `id` FROM `".WPSS_QUIZZES_DB."` ORDER BY `id` DESC LIMIT 1",ARRAY_A );
    return $newest_quiz['id'];
  }
  return wpss_get_firstQuizID();
}





/**
 *  Quiz options for quiz with ID = $id
 *  @return array quiz row from DB 
 */
function wpss_getQuizOptions($id){
  global $wpdb;
  $row = $wpdb->get_results("SELECT * FROM ".WPSS_QUIZZES_DB." WHERE id = '$id'",ARRAY_A);
  return stripslashes_deep($row[0]);
}





/**
 *  Questions with matchin quiz_id
 *  @return array
 */
function wpss_get_Questions($quiz_id){
  global $wpdb;    
  $q_s = $wpdb->get_results("SELECT * FROM ".WPSS_QUESTIONS_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC;",ARRAY_A);
  return stripslashes_deep($q_s);
}





/**
 *  Answers with matching quiz_id
 *  @return array
 */
function wpss_get_Answers($quiz_id){
  global $wpdb;    
  $a_s = $wpdb->get_results("SELECT * FROM ".WPSS_ANSWERS_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC",ARRAY_A);
  return stripslashes_deep($a_s);
}




/**
 *  Fields with matching quiz_id
 *  @return array
 */
function wpss_get_Fields($quiz_id){
  global $wpdb;    
  $f_s = $wpdb->get_results("SELECT * FROM ".WPSS_FIELDS_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC",ARRAY_A);
  return stripslashes_deep($f_s);
}





/**
 *  Answers grouped by submission
 *  @return array 
 */
function wpss_get_Submissions($quiz_id){
  global $wpdb;    
  $answers =   $wpdb->get_results( "SELECT * FROM ".WPSS_RESULTS_DB." WHERE quiz_id='$quiz_id'",ARRAY_A);
  $unique_ids = $wpdb->get_results( "SELECT DISTINCT submitter_id FROM ".WPSS_RESULTS_DB." WHERE quiz_id='$quiz_id'",ARRAY_A);

  foreach($unique_ids as $id){
    foreach($answers as $answer){
      if($answer['submitter_id']==$id['submitter_id']) $answer_group[] = $answer;
    }
    $submissions[] = $answer_group;
    $answer_group = array();    
  }
  return $submissions;
}





/**
 *  Answers for a particular question
 *  @return array 
 */
function wpss_get_answer(&$answers,$question_id){
  foreach($answers as $answer){
    if($answer['question_id'] == $question_id) $ans[] = $answer;
  }
  return $ans;
}





/**
 *  @return array Routes with matching quiz_id
 */
function wpss_get_Routes($quiz_id){
  global $wpdb;    
  $routes = $wpdb->get_results("SELECT * FROM ".WPSS_ROUTES_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC;",ARRAY_A);
  return $routes;
}





/*  Admin Save Quiz Functions from Backend
----------------------------------------------------------------------------*/

/**
 *  Save Current Quiz Questions, Answers, Fields, and Routes
 *  NOTE: $wpdb cannot accept multi-update statements
 *        therefore function cannot be simplified using WP API
 */
function wpss_save_quiz($quiz_id){
  global $wpdb;
  foreach($_POST as $name => $value){
  
    // questions (question, question_type)
    if(substr($name,0,7)=="wpss_q_"){
      $this_id = substr($name,7);
      $multiselect_field = 'wpss_multianswers_'.$this_id;
      if(array_key_exists($multiselect_field,$_POST)) $type = 'checkbox';
      else $type = 'radio';

      $wpdb->update(WPSS_QUESTIONS_DB,array('question'=>$value,'quiz_id'=>$quiz_id,'type'=>$type),array('id'=>$this_id));
    }
    
    // answers (answer_text, weight)
    elseif(substr($name,0,7)=="wpss_a_"){
      // get question and answer is from 
      $this_ans_id = substr($name,7);
      $wpdb->update(WPSS_ANSWERS_DB,array('answer'=>$value,'quiz_id'=>$quiz_id),array('id'=>$this_ans_id));
    }
    elseif(substr($name,0,8)=="wpss_aw_"){
      $this_ans_id = substr($name,8);
      $wpdb->update(WPSS_ANSWERS_DB,array('weight'=>$value),array('id'=>$this_ans_id));
    }    
    
    // fields (field_name, required)
    if(substr($name,0,11)=="wpss_field_"){
      $field_id = substr($name,11);
      $wpdb->update(WPSS_FIELDS_DB,array('name'=>$value),array('id'=>$field_id));
      
      $required = empty($_POST['wpss_field_required_'.$field_id])? 0 : ((int) $_POST['wpss_field_required_'.$field_id]);
      $wpdb->update(WPSS_FIELDS_DB,array('required'=>$required),array('id'=>$field_id));
    }      
    
    // routes (to's, from's, and url's using route id)
    elseif(substr($name,0,10)=="wpss_r_to_"){
      $route_id = substr($name,10);
      $wpdb->update(WPSS_ROUTES_DB,array('to_score'=>$value),array('id'=>$route_id));
    }
    elseif(substr($name,0,12)=="wpss_r_from_"){
      $route_id = substr($name,12);
      $wpdb->update(WPSS_ROUTES_DB,array('from_score'=>$value),array('id'=>$route_id));  
    }
    elseif(substr($name,0,11)=="wpss_r_url_"){
      $route_id = substr($name,11);
      $wpdb->update(WPSS_ROUTES_DB,array('url'=>$value),array('id'=>$route_id));   
    }    
  }
  $wpdb->flush();
}





/**
 *  Save Current Quiz from $_POST
 */
function wpss_save_quiz_options($quiz_id){
  global $wpdb;
  $update = array('quiz_title'=>$_POST['wpss_quizTitle'], 'submit_txt'=>$_POST['wpss_quizOutro'], 'store_results'=>$_POST['wpss_quizTrack'], 'send_admin_email'=>$_POST['wpss_adminEmail'], 'admin_email_addr'=>$_POST['wpss_adminEmailAddress'], 'send_user_email'=>$_POST['wpss_autoRespond'], 'user_email_content'=>$_POST['wpss_emailResponce'], 'user_email_from_name'=>$_POST['wpss_mailfrom'], 'user_email_from_address'=>$_POST['wpss_mailfromaddress'], 'submit_button_txt'=>$_POST['wpss_quizButtontxt'], 'record_submit_info'=>$_POST['wpss_requireData']);
  $wpdb->update(WPSS_QUIZZES_DB,$update,array('id'=>$quiz_id)); 
}





/**
 *  Adds new question to quiz when requested, adds first answer
 *  and stores in the database
 */
function wpss_add_newQuestion($quiz_id){
  global $wpdb;  
  $wpdb->insert(WPSS_QUESTIONS_DB, array('question'=>'Insert New Question','quiz_id'=>$quiz_id) );
  
  // add first answer for new question, associate with previous question_id for new question
  $new_question_id = $wpdb->insert_id;
  $wpdb->insert(WPSS_ANSWERS_DB, array('answer'=>'Insert New Answer','quiz_id'=>$quiz_id,'question_id'=>$new_question_id,'weight'=>1 ) );
}





/**
 *  Adds new answer for question in a quiz
 *  and stores in the database
 */
function wpss_add_newAnswer($quiz_id){
  global $wpdb;
  foreach($_POST as $name => $question_id ){
    // get question and answer is from 
    if(substr($name,0,10)=="addanswer_"){     
      $for_question_id = substr($name,10); 
      $wpdb->insert(WPSS_ANSWERS_DB, array('answer'=>'Insert New Answer','quiz_id'=>$quiz_id,'question_id'=>$for_question_id,'weight'=>1 ) );
    }
  }
}





/**
 *  Adds new range-route for quiz scores
 *  and stores in the database
 */
function wpss_add_newRange($quiz_id){
  global $wpdb;
  $wpdb->insert(WPSS_ROUTES_DB, array('from_score'=>'','to_score'=>'','url'=>'Insert a URL to a page for this scoring range','quiz_id'=>$quiz_id ) );
}





/**
 *  Cycles through all $_POST names 
 *  looking for delete key: "wpss_del_"
 *  wpss_del_{question,answer,route,quiz}_{id}
 */
function wpss_delete_unwanted(){
  global $wpdb;
  foreach($_POST as $name => $value){
    if(substr($name,0,9)=="wpss_del_"){   
      
      if(substr($name,0,18)=="wpss_del_question_"){   
        $delete_sql = 'DELETE FROM '.WPSS_QUESTIONS_DB.' WHERE id='.substr($name,18).';';
      }
      elseif(substr($name,0,16)=="wpss_del_answer_"){   
        $delete_sql = 'DELETE FROM '.WPSS_ANSWERS_DB.' WHERE id='.substr($name,16).';';      
      }
      elseif(substr($name,0,15)=="wpss_del_route_"){   
        $delete_sql = 'DELETE FROM '.WPSS_ROUTES_DB.' WHERE id='.substr($name,15).';';      
      }
      elseif(substr($name,0,15)=="wpss_del_field_"){   
        $delete_sql = 'DELETE FROM '.WPSS_FIELDS_DB.' WHERE id='.substr($name,15).';';
        $wpdb->query($delete_sql);   
      }      
      elseif(substr($name,0,14)=="wpss_del_quiz_"){   
        $delete_sql = 'DELETE FROM '.WPSS_QUIZZES_DB.' WHERE id='.substr($name,14).';';
        $wpdb->query($delete_sql);die("<h2>Quiz Deleted</h2>");      
      }
      $wpdb->query($delete_sql);      
    }
  }
}





/**
 *  Cycles through all $_POST names 
 *  looking delete key: "wpss_del_result_{id}"
 *  and deletes results row with associate id
 */
function wpss_delete_Results(){
  global $wpdb;
  foreach($_POST as $name => $value){
    if(substr($name,0,16)=="wpss_del_result_"){ 
      $delete_sql = 'DELETE FROM '.WPSS_RESULTS_DB.' WHERE submitter_id="'.substr($name,16).'" ;';
      $wpdb->query($delete_sql);      
    }
    elseif(substr($name,0,18)=="wpss_result_clear_"){ 
      $delete_sql = 'DELETE FROM '.WPSS_RESULTS_DB.' WHERE quiz_id="'.substr($name,18).'" ;';
      $wpdb->query($delete_sql);      
    }    
  }
}





/**
 *  Gets array row by key=>value
 *  @return array
 */
function wpss_array_trim($key,$value,&$array){
  foreach($array as $n => $row){
    if($row[$key] == $value) return $array[$n];
  }
}





/**
 *  Calculate average score and percentage
 *  @return array
 */
function wpss_averageScore(&$submissions,$num_submissions,$num_questions,&$answers){
  $total_possible_points = 0;
  $total_points_earned = 0;
  foreach($answers as $answer){
    $total_possible_points += $answer['weight'];
  }
  if(!empty($submissions)){
    foreach($submissions as $submission){
      foreach($submission as $result){
        $total_points_earned += $result['weight'];
      }
    }  
  }
  if($num_submissions > 0){
    $avg_points = $total_points_earned/$num_submissions;
    $avg_score = $total_points_earned/($num_submissions*$total_possible_points);
  }
  else{
    $avg_points = 0; $avg_score = 0;
  }

  return array('avg_points'=>$avg_points,'avg_score'=>$avg_score);
}



/*  Output Quiz Functions
--------------------------------------------------------*/
$wpss_priority = get_option('wpss_filter_priority');


/**
 *  Filter out special strings and replace
 *  with data for outputted quizzes and emails
 */
// Filter Content for quiz string: [wp-simple-survey-{id}]
function wpss_QuizzesFilter($content) {
  global $wpdb;
  $quiz_ids = $wpdb->get_results('SELECT id FROM '.WPSS_QUIZZES_DB,ARRAY_A);
  foreach($quiz_ids as $quiz){
    $content = str_replace('[wp-simple-survey-'.$quiz['id'].']',wpss_getQuiz($quiz['id']),$content);  
  }
  return $content;
}add_filter('the_content', 'wpss_QuizzesFilter',empty($wpss_priority)? 10 : $wpss_priority);

// Filter Content for score string: [wp-simple-survey-score]
function wpss_results_score_filter($content) {
  return str_replace('[wp-simple-survey-score]',wpss_results_getScore(),$content);
}add_filter('the_content', 'wpss_results_score_filter');

// Filter Content for answer string: [wp-simple-survey-answers]
function wpss_results_answer_filter($content) {
  return str_replace('[wp-simple-survey-answers]',wpss_results_getAnswers(),$content);
}add_filter('the_content', 'wpss_results_answer_filter');

// Replace '[wp-simple-survey-score]' with user's score
function wpss_results_getScore(){
  global $wpdb;
  if( empty($_COOKIE['wpss-submitter']) ) return 0;
  $this_score = $wpdb->get_results('SELECT total_score FROM '.WPSS_RESULTS_DB.' WHERE submitter_id="'.$_COOKIE['wpss-submitter'].'" LIMIT 1;',ARRAY_A);
  return $this_score[0]['total_score'];
}

// Replace '[wp-simple-survey-answers]' with user's answers
function wpss_results_getAnswers(){
  global $wpdb;    
  if( empty($_COOKIE['wpss-submitter']) ) return '';
  $answers = $wpdb->get_results('SELECT question_txt, choice_txt, weight FROM '.WPSS_RESULTS_DB.' WHERE submitter_id="'.$_COOKIE['wpss-submitter'].'" AND type="answer" ORDER BY question_id ASC;',ARRAY_A);

  $submission_summary = '<!-- WordPress Simple Survey | Copyright Steele Agency, Inc -->';    
  $submission_summary .= '<div id="wpss_user_results">';  
  foreach($answers as $answer){
    $submission_summary .= 
            '<p>
              <span class="wpss_results_question">'.$answer['question_txt'].'</span><br />
              <span class="wpss_results_answer">'.$answer['choice_txt'].'</span><br />
              <span class="wpss_results_points">Points: '.$answer['weight'].'</span><br />                              
             </p>';
  }
  $submission_summary .= '</div>';
    
  return $submission_summary;
}


?>

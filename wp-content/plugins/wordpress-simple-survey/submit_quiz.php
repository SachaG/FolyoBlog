<?php
// No Direct Access
defined('WPSS_URL') or die('Restricted access');
$submit_quiz = (int) $_POST['wpss_submit_quiz'];


/**  
 *  Calculate Score, Route User, Store, and email results in database if requested
 */           
if($submit_quiz){
  global $wpdb;
  
  $quiz_id = (int) $_POST['quiz_id'];
  $submitter_id = $_POST['submitter_id'];
  
  // get this quiz and associated questions and answers
  $quiz = stripslashes_deep($wpdb->get_results("SELECT * FROM ".WPSS_QUIZZES_DB." WHERE id='$quiz_id' LIMIT 1;",ARRAY_A));
  $quiz = $quiz[0];
  $questions  = stripslashes_deep($wpdb->get_results("SELECT * FROM ".WPSS_QUESTIONS_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC",ARRAY_A));
  $answer_set = stripslashes_deep($wpdb->get_results("SELECT * FROM ".WPSS_ANSWERS_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC",ARRAY_A));
  $field_set  = stripslashes_deep($wpdb->get_results("SELECT * FROM ".WPSS_FIELDS_DB." WHERE quiz_id='$quiz_id' ORDER BY id ASC",ARRAY_A));
  
  $selected_ids = wpss_get_submitted_ids();
  $score = wpss_calculateScore($selected_ids,$answer_set);
  
  $redirect_to = $wpdb->get_row("SELECT url FROM ".WPSS_ROUTES_DB." WHERE $score>=from_score AND $score<=to_score AND quiz_id='".$quiz_id."' ORDER BY id ASC",ARRAY_A);
  
  
  
 /**  
  *  Optionally put results into RESULTS table, each row respresents an answer or a user data field
  */   
  if($quiz['store_results']){
  
    // store answers, weight, etc
    foreach($selected_ids as $choice_id){

      $this_choice = wpss_array_trim('id',$choice_id,$answer_set);
      $this_question = wpss_array_trim('id',$this_choice['question_id'],$questions);
      
      $wpdb->insert(WPSS_RESULTS_DB,array('type'=>'answer','submitter_id'=>$submitter_id,'quiz_id'=>$quiz['id'],'question_id'=>$this_choice['question_id'],'answer_id'=>$this_choice['id'],'weight'=>$this_choice['weight'],'question_txt'=>$this_question['question'],'choice_txt'=>$this_choice['answer'],'answer_type'=>$this_question['type'],'ip_address'=>$_SERVER['REMOTE_ADDR'],'total_score'=>$score));
      $quiz_summary[] = array('question'=>$this_question['question'], 'answer'=>$this_choice['answer'], 'weight'=>$this_choice['weight']);
    }
  
  
    // Stores fields from $_POST data
    foreach($_POST as $name => $value){
      if(substr($name,0,11)=="wpss_field_"){
        $this_field_id = substr($name,11);
        foreach($field_set as $field){
          if($field['id'] == $this_field_id){
            $wpdb->insert(WPSS_RESULTS_DB,array('type'=>'field','submitter_id'=>$submitter_id,'quiz_id'=>$quiz['id'],'field_name'=>$field['name'],'field_value'=>$value,'field_id'=>$this_field_id,'required'=>$field['required'],'ip_address'=>$_SERVER['REMOTE_ADDR'],'total_score'=>$score));
            $field_summary[] = array('name'=>$field['name'],'value'=>$value);
          }
        }          
      }   
    }
    
  }

 /**  
  *  Optionally Send admin email with summary and all answers
  */  
  if($quiz['send_admin_email']){
    $message = '
      <p>Quiz Title: '.$quiz['quiz_title'].'<br />
         Quiz ID: '.$quiz['id'].'<br />
         Score: '.$score.'<br />
         Routed To: '.$redirect_to['url'].'<br />
         Time: '.date('Y-m-d H:i').'<br />
         IP Address: '.$_SERVER['REMOTE_ADDR'].'
      </p>
      <hr />
    '; 
    
    if(!empty($quiz_summary)){
      foreach($quiz_summary as $qa){
        $message .= '<p>'.$qa['question'].'<br />'.$qa['answer'].'<br />Points: '.$qa['weight'].'</p>';    
      }
    }
    $message .= '<hr />';    
    if(!empty($field_summary)){
      foreach($field_summary as $user_data){
        $message .= '<p>'.$user_data['name'].' '.$user_data['value'].'</p>';    
      }
    }
    $headers = array('MIME-Version: 1.0','Content-type: text/html; charset="'.get_option('blog_charset').'"','From: '.$quiz['admin_email_addr'],'Reply-To: '.$quiz['admin_email_addr'],'X-Mailer: PHP/'. phpversion());
   
    wp_mail($quiz['admin_email_addr'],'New Quiz Submitted | '.$quiz['quiz_title'],$message,implode("\r\n",$headers)); 
  }
  

 /**  
  *   Optionally Send auto response to user
  *   checks all fields for a valid email address 
  */     
  if($quiz['send_user_email'] && $quiz['user_email_content']!=''){

    $auto_response = $quiz['user_email_content'];
    $subject = "Thanks for taking the ".$quiz['quiz_title'];
    
    
    if(!empty($quiz_summary)){
      foreach($quiz_summary as $qa){
        $recorded_qa .= '<p>'.$qa['question'].'<br />'.$qa['answer'].'<br />Points: '.$qa['weight'].'</p>';    
      }    
    }
    
    // replace tag strings with user's data
    $auto_response = str_replace(array('[routed]','[score]','[quiztitle]','[answers]'),array($redirect_to['url'],$score,$quiz['quiz_title'],$recorded_qa),$auto_response);
    
    $wpss_from_name  = $quiz['user_email_from_name'];
    $wpss_from_email  = $quiz['user_email_from_address']; 
    $wpss_from = $wpss_from_name.' <'.$wpss_from_email.'>';
    $headers = array('MIME-Version: 1.0','Content-type: text/html; charset="'.get_option('blog_charset').'"','From: '.$wpss_from,'Reply-To: '.$wpss_from,'X-Mailer: PHP/'. phpversion());
    
    // Email all valid email addresses
    foreach($_POST as $type => $email){
      if(substr($type,0,11)=="wpss_field_"){
        if(is_email($email)) mail($email,$subject,$auto_response,implode("\r\n",$headers));
      }
    }
  }
   
   
  // NOTE: SYSTEM DEPENDENT HEADACHE
  //ob_start();
  setcookie("wpss-submitter",$submitter_id);
  wp_redirect(esc_url($redirect_to['url']));
  //ob_flush();
  
  
  
  exit;  die(); // ensure stop execution
}
die();
?>

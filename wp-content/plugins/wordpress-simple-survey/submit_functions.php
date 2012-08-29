<?php
/*  Submit Quiz Functions
--------------------------------------------------------*/
defined('WPSS_URL') or die('Restricted access');



/**
 *  Gets answer ids from submitted quiz
 *  expects $value = "wpss_ans_{answer_id}"
 *
 *  @return array submitted choice ids
 */
function wpss_get_submitted_ids(){
  foreach($_POST as $name => $value){
    if(substr($name,0,17)=="wpss_ans_check_a_" || substr($name,0,17)=="wpss_ans_radio_q_"){
      $selected_ids[] = substr($value,9);
    }
  }
  return $selected_ids;
}





/**
 *  @return   float  weight of an answer
 */
function wpss_get_weight($answer_id,&$answers){
  if(empty($answer_id)) return 0;
  foreach($answers as $answer){
    if($answer['id']==$answer_id) return $answer['weight'];
  }
}





/**
 *  @return user's score
 */
function wpss_calculateScore(&$selected_ids,&$answer_set){
  if(empty($selected_ids)) return 0;
  foreach($selected_ids as $choice_id){
    $score += wpss_get_weight($choice_id,$answer_set);
  }
  return $score;
}

?>

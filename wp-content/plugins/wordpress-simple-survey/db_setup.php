<?php

/**
 *  Setup database tables on plugin activation
 */
function wpss_plugin_install() {
  global $wpdb;

  // setup database structure for Quizzes
  if($wpdb->get_var("show tables like '".WPSS_QUIZZES_DB."'") != WPSS_QUIZZES_DB){
    $sql =  "CREATE TABLE ".WPSS_QUIZZES_DB." (".
              "id int NOT NULL AUTO_INCREMENT, ".
              "quiz_title text NOT NULL, ".
              "submit_txt text NOT NULL, ".
              "submit_button_txt text NOT NULL, ".
              "store_results tinyint NOT NULL, ".              
              "send_admin_email tinyint NOT NULL, ".
              "admin_email_addr text NOT NULL, ".
              "record_submit_info tinyint NOT NULL, ".
              "record_fields text NOT NULL, ".
              "send_user_email tinyint NOT NULL, ".
              "user_email_content text NOT NULL, ".
              "user_email_from_name text NOT NULL, ".
              "user_email_from_address text NOT NULL, ".               
              "quiz_questions text NOT NULL, ".
              "score_routes text NOT NULL, ".
              "integrate_wplogin tinyint NOT NULL, ".
              "UNIQUE KEY id (id) ) ".
              "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }  
  
  // setup db for results
  if($wpdb->get_var("show tables like '".WPSS_RESULTS_DB."'") != WPSS_RESULTS_DB){
    $sql =  "CREATE TABLE ".WPSS_RESULTS_DB." (".
              "id int NOT NULL AUTO_INCREMENT, ".
              "type text NOT NULL, ".
              "submitter_id text NOT NULL, ".
              "quiz_id int NOT NULL, ".
              "question_id int, ".
              "answer_id int, ".
              "all_choices_id text, ".
              "weight float, ".
              "question_txt text, ".
              "choice_txt text, ".
              "answer_type text, ".                            
              "all_choices_txt text, ".
              "field_name text, ".
              "field_value text, ".
              "field_id int, ".
              "required int, ".
              "ip_address text, ".
              "submitted_at TIMESTAMP DEFAULT now(), ".
              "total_score float, ".
              "UNIQUE KEY id (id) ) ".
              "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }
  
  // setup database structure for Questions
  if($wpdb->get_var("show tables like '".WPSS_QUESTIONS_DB."'") != WPSS_QUESTIONS_DB){
    $sql =  "CREATE TABLE ".WPSS_QUESTIONS_DB." (".
               "id int NOT NULL AUTO_INCREMENT, ".
               "question text, ".
               "type text, ".               
               "quiz_id int, ".
               "UNIQUE KEY id (id) ) ".
               "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }  
  
  // setup database structure for Answers
  if($wpdb->get_var("show tables like '".WPSS_ANSWERS_DB."'") != WPSS_ANSWERS_DB){
    $sql =  "CREATE TABLE ".WPSS_ANSWERS_DB." (".
               "id int NOT NULL AUTO_INCREMENT, ".
               "answer text, ".
               "weight float, ".
               "quiz_id int, ".
               "question_id int, ".
               "UNIQUE KEY id (id) ) ".
               "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }  
  
  // setup database structure for Questions
  if($wpdb->get_var("show tables like '".WPSS_QUESTIONS_DB."'") != WPSS_QUESTIONS_DB){
    $sql =  "CREATE TABLE `".WPSS_QUESTIONS_DB."` (".
               "id int NOT NULL AUTO_INCREMENT, ".
               "question text, ".
               "quiz_id int, ".
               "UNIQUE KEY id (id) ) ".
               "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }  

  // setup database structure for Routes
  if($wpdb->get_var("show tables like '".WPSS_ROUTES_DB."'") != WPSS_ROUTES_DB){
    $sql =  "CREATE TABLE `".WPSS_ROUTES_DB."` (".
              "id int NOT NULL AUTO_INCREMENT, ".
              "from_score float, ".
              "to_score float, ".
              "url text, ".
              "quiz_id int, ".
              "UNIQUE KEY id (id) ) ".
              "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }  

  // setup database structure for User Info (form), Field Manager
  if($wpdb->get_var("show tables like '".WPSS_FIELDS_DB."'") != WPSS_FIELDS_DB){
    $sql =  "CREATE TABLE `".WPSS_FIELDS_DB."` (".
               "id int NOT NULL AUTO_INCREMENT, ".
               "name text, ".
               "required tinyint, ".
               "quiz_id int, ".
               "UNIQUE KEY id (id) ) ".
               "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
    dbDelta($sql);
  }  


  // create first quiz and question upon activation
  $quizzes = $wpdb->get_results("SELECT * FROM ".WPSS_QUIZZES_DB, ARRAY_A);
  if(!count($quizzes)) wpss_createNewQuiz();

  add_option("wpss_extended_db_version",WPSS_EXTENDED_DB_VERSION);
}
?>

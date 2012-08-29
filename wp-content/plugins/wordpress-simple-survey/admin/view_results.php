<?php
   // No Direct Access
   defined('WPSS_URL') or die('Restricted access');
  if (!current_user_can('publish_posts')) wp_die( __('You do not have sufficient permissions to access this page.') );
  global $wpdb;
  
  //$wpdb->show_errors(); 
    
  // delete unwanted results
  wpss_delete_Results();
  
  // grab current quiz by unique id
  $cur_quizID = wpss_get_currentQuizID();
  
  // grab current Quiz from database
  $cur_quiz = wpss_getQuizOptions($cur_quizID);
  $questions  = wpss_get_Questions($cur_quizID);
  $answers  = wpss_get_Answers($cur_quizID);  

  /* grab array containing current quiz submissions */
  $submissions = wpss_get_Submissions($cur_quizID);
  $num_submissions = count($submissions);
  $num_questions = count($questions);
  $avg_score = wpss_averageScore($submissions,$num_submissions,$num_questions,$answers);
?>
<div class="wpss_results wrap">

  <div id="icon-edit-pages" class="icon32"></div><h2>Wordpress Simple Survey Results</h2>
  <br clear="all" />
  <hr />

  <div id="quiz_switcher">
    <p class="select">Select Quiz to View and Export Results</p>
    <ul id="quiz_tabs">
      <?php print_quizIDList($cur_quizID,'wpss-results');?>
    </ul>
    <br clear="all" />
  </div>
  
  <!-- Quiz Sidebar -->
  <div class="quiz_summary_sidebar">
    <h2 style="padding-top:0;">Quiz-<?php echo $cur_quiz['id'];?> Summary</h2>
    <p>Quiz Title: <strong><?php echo $cur_quiz['quiz_title'];?></strong></p>
    <p>Number of questions: <?php echo $num_questions;?></p>
    <p>Number of submissions: <?php echo $num_submissions;?></p>
    <p>Average Points: <?php echo round($avg_score['avg_points'],2);?></p>
    <p>Average Score: <?php echo round(100*$avg_score['avg_score'],2);?>%</p>
    <br clear="all" />
    <form action="" method="POST">  
      <div><input class="wpss_export wpss_upgraderequired" type="submit" name="wpss_export_full_results_<?php echo $cur_quizID;?>" value="" /><h2 class="exports">Export Complete Results</h2></div>
      <br clear="all" />
      <div><input class="wpss_export wpss_upgraderequired" type="submit" name="wpss_export_userdata_<?php echo $cur_quizID;?>" value="" /><h2 class="exports">Export User Data</h2></div> 
    </form>
    <br clear="all" />
    <form action="" method="POST">  
      <div><input class="wpss_clear_results wpss_upgraderequired" type="submit" name="wpss_result_clear_<?php echo $cur_quizID;?>" value="" /><h2 class="exports">Clear Results</h2></div>
    </form>     
  </div><!-- End Right Sidebar -->  


  <!-- Quiz Results -->
  <div id="quiz_summary_main">

    <div id="quiz_summary_holder">    
    <?php if(!empty($submissions)): ?>    
    
      <?php foreach($submissions as $submission){ ?>
        
        <h2><a href="#">WPSS Result | Score: <?php echo $submission[0]['total_score'];?>, Time: <?php echo $submission[0]['submitted_at'];?></a></h2><div>
               
        <!-- Questions and Answers -->
        <h2 class="summary">User's Answers</h2>
        <form style="float:right" action="" method="POST">
          <input class="wpss_remove" type="submit" style="float:right" name="wpss_del_result_<?php echo $submission[0]['submitter_id'];?>" value="Delete this Result" onClick="return confirm('Are you sure you want to delete this submission?')" />
        </form> 
        <?php foreach($submission as $answer_field){ ?>
          <ul>
          <?php if($answer_field['type']=='answer'){ ?>
            <li><?php echo _wpss_filter($answer_field['question_txt']);?>
              <ul>
                <li><?php echo $answer_field['choice_txt'].' '.$answer_field['weight'];?></li>
              </ul>
            </li><?php
          } ?>
          </ul><?php
        } ?>
        <!-- End Q&A's -->      
        
        <!-- User's Info -->
        <h2 class="summary">User's Data</h2>
        <?php foreach($submission as $answer_field){ ?>
          <ul>
          <?php if($answer_field['type']=='field'){ ?>
            <li><?php echo $answer_field['field_name'].' '.htmlspecialchars($answer_field['field_value']);?></li><?php
          } ?>
          </ul><?php
        } ?> 
        <!-- End User's Info -->
         
        <!-- Quiz Info --> 
        <ul>
          <li>Score: <?php echo $submission[0]['total_score'];?></li>
          <li>Taken: <?php echo $submission[0]['submitted_at'];?></li>
          <li>IP Address: <?php echo $submission[0]['ip_address'];?></li>        
        </ul>
        <!-- End Quiz Info -->   
                
        </div> 
      <?php } ?>
    
    <?php endif;?>

    </div> 
    
  </div><!-- End Results -->
  
 

   

</div>



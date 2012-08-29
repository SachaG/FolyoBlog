<?php
defined('WPSS_URL') or die('Restricted access');
if (!current_user_can('publish_posts')) wp_die( __('You do not have sufficient permissions to access this page.') );


global $wpdb;

// grab current quiz by unique id
$cur_quizID = wpss_get_currentQuizID();

/* create new question, answer, and route when requested */
if(!empty($_POST['addquestion']) && $_POST['addquestion'] == 'add new question') wpss_add_newQuestion($cur_quizID);
wpss_add_newAnswer($cur_quizID);
if(!empty($_POST['addrange']) && $_POST['addrange'] == 'add new range') wpss_add_newRange($cur_quizID);

/* delete questions, answers and routes when requested */
wpss_delete_unwanted();

// Update Options if submitted and changed
if(!empty($_POST['wpss_submit']) && ($_POST['wpss_submit'] == 'submit' || $_POST['wpss_submit'] == 'Save Current Quiz')) {
  
  // update questions, answers, routes, and fields
  wpss_save_quiz($cur_quizID);       

  // update database with quiz options
  wpss_save_quiz_options($cur_quizID);
  ?>
  <div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
  <?php
  $wpdb->flush(); // flush MySQL Cache
}

// grab current Quiz from database after update as Array
$cur_quiz = wpss_getQuizOptions($cur_quizID);

/* grab arrays containing current data for current quiz */
$questions  = wpss_get_Questions($cur_quizID);
$answers    = wpss_get_Answers($cur_quizID);
$routes     = wpss_get_Routes($cur_quizID);
$fields     = wpss_get_Fields($cur_quizID);
?>

<div class="wrap">
  <div id="icon-tools" class="icon32"></div><h2>Wordpress Simple Survey - Setup Quizzes</h2>

  <div id="quiz_switcher">
    <p class="select"><a class="wpss_upgraderequired" href="?page=wpss-setup&quiz=new"><img src="<?php echo WPSS_URL;?>images/add.png" />add new quiz</a> | Select Quiz to Edit:</p>
    <ul id="quiz_tabs">
      <?php print_quizIDList($cur_quizID,'wpss-setup');?>
    </ul>
    <br clear="all" />
  </div>
  
  <form id="wpss_optionsForm" name="wpss_optionsForm" method="post" action="admin.php?page=wpss-setup&quiz=<?php echo $cur_quizID;?>">
    <input type="hidden" name="wpss_submit" value="submit">

    <div class="wpss_table_wrap">
    <p class="editing">Currently editing Quiz-<?php echo $cur_quizID;?><input class="button-primary" style="float:right;" type="submit" name="Submit" value="Save Current Quiz" /><input class="button-secondary wpss_upgraderequired" style="float:right;" type="submit" name="wpss_del_quiz_<?php echo $cur_quizID;?>" value="Delete Current Quiz" /></p>
    <table id="wpss_admin_table">
      <tr>
        <td id="wpss_setup" class="admin_head">
          <h2>Quiz Options</h2>
          <p>Quiz Title:
          <img title="Example:<br />Investments Survey" class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>
          <input type="text" name="wpss_quizTitle" value="<?php echo $cur_quiz['quiz_title']; ?>" />          

          <p>Quiz Submit Text:
          <img title="Example:<br />Click submit and be taken to the investment style that is right for you." class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>
          <input type="text" name="wpss_quizOutro" value="<?php echo $cur_quiz['submit_txt']; ?>" />
          
          <p>Quiz Submit Button Text:
          <img title="Example:<br />Click to Submit" class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>
          <input type="text" name="wpss_quizButtontxt" value="<?php echo $cur_quiz['submit_button_txt']; ?>" />
        </td>

        <td id="wpss_tracking" class="admin_head">
          <h2>Tracking</h2>
          <p>Store Quiz Results in the Database? <input type="checkbox" name="wpss_quizTrack" value="1" <?php if($cur_quiz['store_results'] != 0) echo 'checked';?> />&nbsp;&nbsp;
          <img title="Admins can see and export results in the WordPress backend under 'WPSS Option' -> 'WPSS Results" class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>
          
          <p>Send Results to Admin Email Address?&nbsp;<input type="checkbox" name="wpss_adminEmail" value="1" <?php if($cur_quiz['send_admin_email'] != 0) echo 'checked';?> />&nbsp;&nbsp;
            <img title="Sends submissions to this email address. Leave blank to receive no emails." class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" />
          </p>
          <input type="text" name="wpss_adminEmailAddress" size="40" value="<?php echo $cur_quiz['admin_email_addr']; ?>" />

        </td>
      </tr>
      <tr>
        <td id="required_info" class="admin_head">
          <h2>Require Info to Submit a Quiz</h2>
          <p>Show user data fields before quiz submission? <input type="checkbox" name="wpss_requireData" value="1" <?php if($cur_quiz['record_submit_info'] != 0) echo 'checked';?> />&nbsp;&nbsp;
          <img title="Require user to input personal info like name, address, or special code." class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p><br />
          <!-- Custom Fileds Table -->
          <table class="widefat">
            <thead><tr>
              <th>Field Name</th><th style="width:70px">Required?</th><th style="width:30px">Delete</th>
            </tr></thead>
            <tfoot><tr>
              <th>Field Name</th><th style="width:70px">Required?</th><th style="width:30px">Delete</th>
            </tr></tfoot>
            <tbody>
            <?php
            // output wpss_Field editing fields
            foreach($fields as $field){ ?>
              <tr>   
                <td><input type="text" name="wpss_field_<?php echo $field['id'];?>" value="<?php echo $field['name'];?>" /></td>
                <td style="width:70px;text-align:center"><input type="checkbox" name="wpss_field_required_<?php echo $field['id'];?>" value="1" <?php if($field['required'] != 0) echo 'checked';?> /></td>
                <td style="width:30px;text-align:center"><input type="submit" class="delete_field" name="wpss_del_field_<?php echo $field['id'];?>" value="" /></td>
              </tr>
              <?php
            }
            ?>
            <tr><td colspan="3" style="text-align:right"><input class="addfield_button wpss_upgraderequired" type="submit" name="addfield" value="add new field" /></td></tr>
            </tbody>
          </table><!-- End Field Manager Table -->

        </td>

        <td id="wpss_autorespond" class="admin_head">
          <h2>Auto Respond</h2>
          <p>Auto-Respond to Users? <input type="checkbox" name="wpss_autoRespond" value="1" <?php if($cur_quiz['send_user_email'] != 0) echo 'checked';?> />&nbsp;&nbsp;
          <img title="Turning this on will send an email to quiz takers. It will also require users to input their name and email." class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>
          
          <p>Auto-Respond Email Content:
          <img title="Use:<br />[routed], [score], [quiztitle], and [answers], for data." class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>

          <?php if(function_exists('wp_editor')): ?>
            <?php wp_editor($cur_quiz['user_email_content'], "wpss_emailResponce", array('textarea_rows'=>8, 'teeny'=>true)); ?>
          <?php else: ?>
            <textarea id="wpss_tinyedit" rows="8" name="wpss_emailResponce"><?php echo $cur_quiz['user_email_content'];?></textarea>
          <?php endif;?>

    
          <p>Mail From Name:
          <img title="Attempt to use special mail from name.<br />Example:<br />Investment Quizzer" class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>
          <input type="text" name="wpss_mailfrom" value="<?php echo $cur_quiz['user_email_from_name'];?>" />
          <p class="wpss_note">Not allowed on all shared hosting platforms.</p>

    
          <p>Mail From Email Address:
          <img title="Sets Mail-From and Reply-To address for auto-response" class="wpss_info" src="<?php echo WPSS_URL.'images/wpss_info.png';?>" /></p>          
          <input type="text" name="wpss_mailfromaddress" value="<?php echo $cur_quiz['user_email_from_address'];?>" />

          </div>
        </td>
      </tr>
    </table>

    <div id="edit_questions"><div id="icon-edit-pages" class="icon32"></div><h2><?php _e("Questions: " ); ?></h2>
    <p>Enter questions, answers and weights in the fields. Add questions and answers as need. Also, only paste from basic text editor.</p>

    <table id="wpss_question_table" class="widefat">
    
      <thead><tr>
        <th>Question</th>
        <th>Answers</th>
        <th style="text-align:right;">Delete</th>
      </tr></thead>
      <tfoot><tr>
        <th>Question</th>
        <th>Answers</th>
        <th style="text-align:right;">Delete</th>
      </tr></tfoot>    
    
      <?php
      // output Question, Answer, and Weight Form as table rows
      foreach($questions as $n => $question){ ?>
      <tr>
        <td class="quest_col">
          <p class="quest_label">Question</p>
          <textarea rows="5" class="wpss_q" name="wpss_q_<?php echo $question['id'];?>"><?php echo $question['question'];?></textarea>
        </td>

        <td class="ans_col">

        <table class="ans_weights">
        <tr>
          <th style="text-align:left">&nbsp;Answers <span style="float:right">Weights</span></th>
        </tr>
        <tr><td class="ans">
        <!-- Output Answers Table-->
          <table class="wpss_admin_answers_table">
          <?php 
            $ans_group = wpss_get_answer($answers,$question['id']);          
            foreach($ans_group as $ans_array => $answer){ ?>
              <tr>
                <!-- Answer -->
                <td><input type="text" class="ans" name="wpss_a_<?php echo $answer['id'];?>" value="<?php echo $answer['answer'];?>" /></td>                
                <!-- Delete Answer -->
                <td width="40px"><input type="submit" class="delete_ans" name="wpss_del_answer_<?php echo $answer['id'];?>" value="" /></td>
                <!-- Weight -->
                <td width="40px"><input type="text" size="2" maxlength="2" class="weights" name="wpss_aw_<?php echo $answer['id'];?>" value="<?php echo $answer['weight'];?>" /></td>
              
              </tr>
              <?php
            }
          ?>
          </table>
        </td></tr>
        <tr>
          <td class="add_ans" colspan="3">
            Allow Multiple Answers? <input type="checkbox" class="wpss_upgraderequired" name="wpss_multianswers_<?php echo $question['id'];?>" value="1" <?php if($question['type'] == "checkbox") echo 'checked';?> />&nbsp;|&nbsp;
            <input class="addans_button" type="submit" name="addanswer_<?php echo $question['id'];?>" value="add new answer" />
          </td>
        </tr>
        </table>
        </td>
        <td class="delete_col"><input type="submit" name="wpss_del_question_<?php echo $question['id'];?>" class="delete_quest" value="Delete" /></td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td id="add_new_question" colspan="4">
        <input type="submit" id="<?php echo $cur_quizID;?>" class="addquestion" style="margin-left:10px;" name="addquestion" value="add new question" />
      </td>
    </tr>
    </table>

    <hr />
    <br clear="all" />

    <div id="icon-link-manager" class="icon32"></div><h2>Scoring Ranges and Routing:</h2>
    <p>Enter inclusive score ranges followed by the URL associated with the particular range. Quiz takers are routed to and URL based on their score.</p>

    <table id="wpss_routes" class="widefat">
      <thead><tr>
        <th class="from">From&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;To</th>
        <th class="route">Location</th>
        <th class="remove">Remove</th>
      </tr></thead>
      <tbody>
      <?php
        // output routing fields
        foreach($routes as $route){ ?>
        <tr id="range_row">
          <td class="range"><input type="text" name="wpss_r_from_<?php echo $route['id'];?>" value="<?php echo $route['from_score'];?>" />
          -
          <input type="text" name="wpss_r_to_<?php echo $route['id'];?>" value="<?php echo $route['to_score'];?>" />&nbsp;&nbsp;&raquo;
          </td>
          <td class="route">
            <input type="text" name="wpss_r_url_<?php echo $route['id'];?>" value="<?php echo $route['url'];?>" />
          </td>
          <td class="remove">
            <input type="submit" class="remove_range" name="wpss_del_route_<?php echo $route['id'];?>" value="Remove" />
          </td>
        </tr>  
        <?php
        }
      ?>
      <tr id="addRangeRow">
        <td>
        <input type="submit" id="addRange" name="addrange" class="addranges" value="add new range" />
        </td>
      </tr>
      </tbody>

      <tfoot><tr>
        <th class="from">From&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;To</th>
        <th class="route">Location</th>
        <th class="remove">Remove</th>
      </tr></tfoot>
    </table>
    </div><!-- Question and Route Container -->

    <div class="wpss_saveoptions">

      <p>Update settings, input questions and insert:<br /><br />[wp-simple-survey-<?php echo $cur_quizID;?>]<br /><br />into your content, where you want the quiz to appear.</p>
      <p class="submit">
      <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Options', 'wpss_trdom' ) ?>" />
      </p>
    </div>
    
  </form>
</div>

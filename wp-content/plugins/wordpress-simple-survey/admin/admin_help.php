<?php
defined('WPSS_URL') or die('Restricted access');
if (!current_user_can('publish_posts')) die( __('You do not have sufficient permissions to access this page.') );

?>


<div id="wpss_help" class="wpss_results wrap">
  <div id="icon-plugins" class="icon32"></div>

  <h2>Wordpress Simple Survey - Help</h2>
  <br clear="all" />  
  <hr />
  
  <div id="quiz_switcher">
    <p class="select">WordPress Simple Survey</p>
    <ul id="quiz_tabs">
      <li><a target="_blank" href="http://labs.saidigital.co/products/wordpress-simple-survey/">Project Home Page</a>|</li>
      <li><a target="_blank" href="http://wordpress.org/extend/plugins/wordpress-simple-survey/">WordPress Plugins Directory Page</a>|</li>
      <li><a target="_blank" href="http://saidigital.co/">&copy;SAI Digital</a></li> 
    </ul>
    <br clear="all" />
  </div>  

  
  <!-- Help Sidebar -->
  <div class="quiz_summary_sidebar">
    <div class="donate"> 
      <p>Make a small donation to further the development of this project.</p>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
        <input type="hidden" name="cmd" value="_s-xclick"> 
        <input type="hidden" name="hosted_button_id" value="N2JZSSGG6HFB2"> 
        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> 
        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> 
      </form> 
    </div>  
    <div style="clear:all"></div>
   
  </div><!-- End Right Sidebar -->  
  
    
    
  <!-- Quiz Results -->
  <div id="quiz_summary_main">
    <p><strong>WordPress Simple Survey</strong> is a plugin that allows for the creation of a survey, quiz, poll, or questionnaire and the tracking of user submissions.</p>
    </p>Scores, Names, and Results can be recorded, emailed, and displayed in the WordPress backend. Custom fields can be created to allow tracking of custom information. The plugin is jQuery based which allows users to seamlessly and in a graphically appealing manner, take the quiz without reloading the page. The survey answers are weighted so that some questions or answers can count more than others. Once a quiz is submitted, the user is taken to a predefined URL based on their score range. This URL can be a previously setup page within WordPress or to a third party website containing pertinent information related to the user's score. Users can also be routed to WordPress pages that have their score and answers.</p>
    <p>The Extended version can be purchased <a href="http://labs.saidigital.co/products/wordpress-simple-survey/wordpress-simple-survey-extended-version/">here</a>.</p>
  
    <h2>Features</h2>
    <br clear="all" />
    <table class="widefat" style="width:92%;margin:auto;">
      <thead><tr>
        <th>Feature</th>
        <th>WordPress Simple Survey</th>
        <th>WordPress Simple Survey - Extended</th>
      </tr></thead>
      <tfoot><tr>
        <th>Feature</th>
        <th>WordPress Simple Survey</th>
        <th>WordPress Simple Survey - Extended</th>
      </tr></tfoot>
      <tbody>
        <tr>
          <td>Store Quiz Results In Database</td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr>
        <tr>
          <td>View Quiz Results Summary</td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr> 
        <tr>
          <td>Email Each Quiz Result To Admin</td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr> 
        <tr>
          <td>Auto-Respond to users</td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr>                           
        <tr>
          <td>Multiple answers per question</td>
          <td align="center"></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr>
        <tr>
          <td>Multiple Quizzes</td>
          <td align="center"></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr>
        <tr>
          <td>TinyMCE Editor and Media Uploader on question forms</td>
          <td align="center"></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr>
        <tr>
          <td>Put users score on routed-to page</td>
          <td align="center"></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr>
        <tr>
          <td>Export Results</td>
          <td align="center"></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr> 
        <tr>
          <td>Delete/Clear Results</td>
          <td align="center"></td>
          <td align="center"><img src="<?php echo WPSS_URL;?>images/check.png" /></td>
        </tr> 
      </tbody>
    </table>  
    <br clear="all" />    
  
  
    <h2>Creating A Quiz</h2>
    <ul class="wpss_adminlist">
      <li>Click 'WPSS - Setup' and fill out a new quiz including the Quiz Options, Questions and Answers, and Routing-To information.</li>    
      <li>Put [wp-simple-survey-N] into a WordPress page or post, where N is the quiz ID given at the top and bottom of the quiz setup page.</li>
      <li>Routes can be split up in numerous ways:
        <ul>
          <li>Multiple pages and multiple ranges.</li>      
          <li>Two pages and two ranges (Pass or Fail).</li>                
          <li>One page (Thanks for taking our survey).</li>                
        </ul>
    </ul>
    <br clear="all" />
    
    <h2>Tracking data</h2>
    <ul class="wpss_adminlist">
      <li>Each submission can be sent to an admin email address.</li>    
      <li>An Auto-Respond can be setup for each submission so that if a user enters a valid email address, they can be sent a message along with their score and answers.</li>         
      <li>Results can be stored in the database for later examination and export.</li>
    </ul>    
    <br clear="all" />
    
    <h2>Displaying Results to the User</h2>
    <ul class="wpss_adminlist">
      <li>The auto-response email can contain the user's score and anwsers by using the tags:
        <ul>
          <li>[score] for the user's score</li>
          <li>[answers] for the user's question and answer summary</li>
          <li>[quiztitle] for the title of the quiz that the user took</li>
          <li>[routed] for the location that the user was routed to based on their score</li>                            
        </ul>
      </li>    
      <li>The user's landing page (the routed-to page after quiz completion) can contain the user's score adn quiz summary by using the tags:
        <ul>
          <li>[wp-simple-survey-score]</li>
          <li>[wp-simple-survey-answers]</li>
        </ul>
      </li>         
    </ul>  
    <br clear="all" />    
    
    
    <h2>Common Issues</h2>
    <ol>
      <li>Multiple jQuery's being loaded - check your page source and look for multiple jquery.js being loaded. Web apps like WordPress have functions to ensure that only one version of a particular Javascript library is loaded. Unfortunately plugin and theme developers can't seem to understand this! See <a href="http://codex.wordpress.org/Function_Reference/wp_enqueue_script">http://codex.wordpress.org/Function_Reference/wp_enqueue_script</a></li>
    </ol>
    
    <br clear="all" />        
  
  
  </div>    

</div><!-- End wrap -->

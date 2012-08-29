<?php
defined('WPSS_URL') or die('Restricted access');
if (!current_user_can('publish_posts')) die( __('You do not have sufficient permissions to access this page.') );

global $wpdb;

// save jQuery Changes
if(!empty($_POST['savejquery']) && $_POST['savejquery']=='Save'){
  if(!empty($_POST['wpss_turnoffjquery']) && $_POST['wpss_turnoffjquery'] == 'turned_on') update_option('wpss_queue_jquery','checked');
  else update_option('wpss_queue_jquery','unchecked');

  if(!empty($_POST['wpss_turnoffjqueryui']) && $_POST['wpss_turnoffjqueryui'] == 'turned_on') update_option('wpss_queue_jqueryui','checked');
  else update_option('wpss_queue_jqueryui','unchecked');
}



// Save Priority Changes
if(!empty($_POST['savepriority']) && $_POST['savepriority']=='Save'){
  $priority = empty( $_POST['wpss_filterpriority'])? 10 : $_POST['wpss_filterpriority'];  
  update_option('wpss_filter_priority',$priority);
}



$jquery = get_option('wpss_queue_jquery');
$jqueryui = get_option('wpss_queue_jqueryui');
$priority = get_option('wpss_filter_priority');

?>


<div id="wpss_help" class="wpss_results wrap">
  <div id="icon-plugins" class="icon32"></div>

  <h2>Wordpress Simple Survey - Global Options</h2>
  <br clear="all" />  
  <hr />
  
  <div id="quiz_switcher">
    <p class="select">WordPress Simple Survey</p>
    <ul id="quiz_tabs">
      <li><a target="_blank" href="http://labs.saidigital.co/products/wordpress-simple-survey/">Project Home Page</a>|</li>
      <li><a target="_blank" href="http://wordpress.org/extend/plugins/wordpress-simple-survey/">WordPress Plugins Directory Page</a>|</li>
      <li><a target="_blank" href="http://saidigital.co/">&copy;Steele Agency, Inc.</a></li>                 
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
  
    
    
  <!-- Global Options -->
  <div id="quiz_summary_main">
  
  
  
    <!-- jQuery Situation -->
    <h2>The jQuery Situation</h2>
    <p>A problem people sometimes have with plugins that require jQuery, like WP Simple Survey, is having multiple jQuery and jQuery-UI JavaScript libraries being loaded. Having multiple instances of the same library is a major problem.</p>
    <p>WordPress has a built-in system to prevent this (In fact all Plug-able Web Application Frameworks and CMSs have this), but theme and plugin designers fail to use it due to their lack of understanding of an API/plugin driven system.<br />See <a target="_blank" href="http://codex.wordpress.org/Function_Reference/wp_enqueue_script">http://codex.wordpress.org/Function_Reference/wp_enqueue_script</a> for more detailed information.</p>
    <p>If you're testing out WP Simple Survey and notice that the sliding features and progress bar are not working, and the quiz submits when you click next, this is probably your issue. You can verify this by checking your page source (HTML) and looking for multiple jquery.js or jquery-ui.js. Note: some theme and plugin designers call the file jquery-(version).js</p>
    <p><strong>Possible "solution"</strong>: turn off the properly imported libraries in this plugin and use the hardcoded ones from your genius theme/plugin designers.</p>
    <form action="" id="wpss_togglejquery"class="wpss_global_options_form" method="post">
      <input type="submit" style="float:right;margin-top:10px" class="button-primary" name="savejquery" value="Save" />
      <p>Properly import jQuery (toggle this): <input type="checkbox" name="wpss_turnoffjquery" value="turned_on" <?php echo $jquery=='checked'? 'checked':'';?> /></p>
      <div style="clear:both"></div>
    </form>
    
    <p><strong>Other solutions</strong>:</p>
    <ol>
      <li>Heckle your theme/plugin designers to import jQuery the right way and release a patch. Feel free to use harsh language.</li>
      <li>Hire someone to go through your files and fix the situation. Warning: You may be surprised at the hourly rates for legitimate software engineers.</li>
      <li>Only use properly written plugins and themes. If they can't get this right, what makes you think they haven't completely compromised your site security.</li>
    </ol>



    <hr />



    <!-- Filter Priority -->

    <h2>Add Filter Priority Conflicts</h2>
    
    <p>Many plugins use the WordPress <a target="_blank" href="http://codex.wordpress.org/Function_Reference/add_filter">add_filter</a> API. Sometimes two plugins conflict when running a filter at the same time. If your progress bar isn't displaying correctly and the form submits on clicking Next, check your HTML source and see if WordPress is wrapping the WordPress Simple Survey JavaScript and division tags in HTML paragraph tags. If so, toggle the priority of the add_filter. The default is 10 which is probably when other plugins are running their filters, therefore decrease WordPress Simple Survey to 100.</p>
    
    <form action="" id="wpss_togglepriority" class="wpss_global_options_form" method="post">
      <p>WP Simple Survey add_filter priority: <input type="text" name="wpss_filterpriority" value="<?php echo empty($priority)? 10 : $priority;?>" />
      <input type="submit" style="float:right" class="button-primary" name="savepriority" value="Save" /></p>
      <div style="clear:both"></div>
    </form>

  </div>



</div><!-- End wrap -->

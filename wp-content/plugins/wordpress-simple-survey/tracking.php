<?php
  global $wpdb;
//  $table_name = $wpdb->prefix . 'wpss_quizTracking';
  $table_name = $wpdb->prefix . 'wpssExtended_quizTracking';

  // Delete all if requested
  if($_POST['kill_button'] == "Delete") {
    $wpdb->query("TRUNCATE TABLE $table_name");
  }

  // remove deleted results
  foreach($_POST as $this_id => $value){
    $wpdb->query("DELETE FROM $table_name WHERE id = '$this_id'");
  }
  flush(); 

  // Grab results from database sans deleted
  $results = $wpdb->get_results( "SELECT id, name, score, email, routed_to, qa_full, time FROM ".$table_name );
?>

<div class="wrap">

  <div id="wpss_export">
    <form id="wpss_exportForm" action="<?php bloginfo('url');?>/?wpss-routing=export" method="POST">
      <div id="export_info">

        <input type="checkbox" name="ex_data[]" value="name"> Name<br />
        <input type="checkbox" name="ex_data[]" value="email"> Email<br />
        <input type="checkbox" name="ex_data[]" value="score"> Score<br />
        <input type="checkbox" name="ex_data[]" value="routed"> Routed to<br />
        <input type="checkbox" name="ex_data[]" value="extra_data"> Extra Data<br />
        <input type="checkbox" name="ex_data[]" value="time"> Time

      </div>
      <div id="export_type">
        <input type="radio" name="ex_qa" value="qa">Q&A<br />
        <input type="radio" name="ex_qa" value="a">Choices&nbsp;<br />
        <input type="radio" name="ex_qa" value="q">Questions<br />
        <input type="radio" name="ex_qa" value="ans">Answers<br />
      </div>
      <input type="submit" id="export_button" name="export_button" value="Export" />
    </form>
    <form id="wpss_resultsForm" action="" method="POST">
      <input type="submit" id="kill_button" name="kill_button" value="Delete" />
    </form>
  </div>
  <div id="icon-edit-pages" class="icon32"></div><h2>Wordpress Simple Survey Results</h2>
  <br clear="all" />
  <hr />

  <div id="wpss_results">

  <?php
  foreach($results as $res){
    ?>
    <div class="wpss_res_wrap">
      <form id="wpss_removeOne" action="" method="POST">
        <input class="wpss_remove" type="submit" name="<?php echo $res->id;?>" value="[X]" />
      </form>
      <div class="toggle_head">
        
        <p class="result_head">Results - <?php echo $res->time;?></p>
        <p class="results_name">Name: <?php echo str_replace("{wpss_comma}"," ",$res->name);?></p>
        
      </div>  

      <div class="togglebox1"> 
        <div class="block"> 
            <p><strong>Quiz Results</strong></p>
            <?php
              $name = $res->name;
              $fname = substr($name,0,strpos($name,"{wpss_comma}"));
              $lname = str_replace('{wpss_comma}','',substr($name,strpos($name,"{wpss_comma}")));
            ?>
            <p>First Name: <?php echo $fname;?><br />
            Last Name: <?php echo $lname;?><br />
            Email: <?php echo $res->email;?><br />
            Score: <?php echo $res->score;?><br />
            Location: <?php echo $res->routed_to;?></p>
                      
            <p><strong>Q&A</strong></p>
            <p><?php echo str_replace(array("{ss_commaQ}","{ss_commaA}"),array("<br />", "<br /><br />"),$res->qa_full);?></p>
          <!--Content--> 
        </div> 
      </div> 
      
    
    </div>

  <?php }
  ?>

  </div>

</div>

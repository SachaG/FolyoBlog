<?php

/**
 *  Javascript for quiz, controls progressbar,
 *  visible panel, and next/previous button action
 *
 *  @return string:html:javascript
 */
function wpss_slide_panels($numQuest){

  $slide_js = '
    <script type="text/javascript">
  
      // current question number
      var wpss_curRadio = 0;
  
      (function($) { 
        $(function() {
  
          // call progress bar constructor
          $("#progress").progressbar({ change: function() {
            //update amount label when value changes      
            $("#amount").text(Math.round($("#progress").progressbar("option", "value")) + "%");
          } });
          
          // disable all next/prev buttons on load
          $("#next").attr("disabled", "disabled");
          $("#back").attr("disabled", "disabled");      

          //set click handler for next button
          $("#next").click(function(e) {  
          
            e.preventDefault();    
            wpss_curRadio++;  

            $("#next").attr("disabled", "disabled");
            $("#back").removeAttr("disabled");
                  
            if(wpss_getCheckedValue(document.wpssform.elements["wpss_ans_radio_q_"+wpss_curRadio]) != ""){
              $("#next").removeAttr("disabled");
            }
          
        
            //look at each panel
            $(".form-panel").each(function() {
                  
              //if the panel is visible fade it out
              ($(this).hasClass("ui-helper-hidden")) ? null : $(this).fadeOut("fast", function() {
                
                //add hidden class and show the next panel
                $(this).addClass("ui-helper-hidden").next().fadeIn("fast", function() {
                  
                  //if it is the last panel disable the next button
                  ($(this).attr("id") != "thanks") ? null : $("#next").attr("disabled", "disabled");  
                
                  //remove hidden class from new panel
                  $(this).removeClass("ui-helper-hidden");
                
                  //update progress bar
                  $("#progress").progressbar("option", "value", $("#progress").progressbar("option", "value") + '.(100/$numQuest).');
                });                
              });
            });
          });      
        
          //set click handler for back button
          $("#back").click(function(e) {
            
            // stop form submission
            e.preventDefault();
            
            // decrement cur question count
            wpss_curRadio-=1;
            
            
            $("#next").removeAttr("disabled");
            $("#back").removeAttr("disabled");

            if(wpss_curRadio == 0){
              $("#back").attr("disabled", "disabled");
            }
        

            // look at each panel
            $(".form-panel").each(function() {
              
              // if the panel is visible fade it out
              ($(this).hasClass("ui-helper-hidden")) ? null : $(this).fadeOut("fast", function() {
                
                // add hidden class and show the next panel
                $(this).addClass("ui-helper-hidden").prev().fadeIn("fast", function() {
                    
                  // remove hidden class from new panel
                  $(this).removeClass("ui-helper-hidden");
                
                  // update progress bar
                  $("#progress").progressbar("option", "value", $("#progress").progressbar("option", "value") - '.(100/$numQuest).');
                });
              });
            });
          });

          // enable next button when value is selected
          $("#wpssform .wpss_radio").click(function() {
          
            $("#next").removeAttr("disabled");
            
           });
          
        });
      })(jQuery);
      
    </script>';
        
  return $slide_js;
}

?>

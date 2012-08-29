(function($) { 
  $(function() {

    /* Tooltip for admin backend examples */
		$(".wpss_info").tooltip({position: "center right", opacity: 1.0});

    /* Sliding results for admin view of submissions */
    $("#quiz_summary_holder").accordion();
    
    
    $(".wpss_upgraderequired").click(function(e){
      e.preventDefault();
      alert("You must upgrade to WordPress Simple Survey-Extended to use this feature.");    
    });    
    
    
  });
})(jQuery);

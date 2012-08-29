// Form input validation
function wpss_checkform(form){

	if (form.name.value == "") {
		alert( "Please enter your name." );
		form.name.focus();
		return false ;
	}
	if (form.lname.value == "") {
		alert( "Please enter your name." );
		form.lname.focus();
		return false ;
	}
	if (form.email.value == "") {
		alert( "Please enter a valid email address." );
		form.email.focus();
		return false ;
	}

	str = form.email.value;
	var at="@";
	var dot=".";
	var lat=str.indexOf(at);
	var lstr=str.length;
	var ldot=str.indexOf(dot);
	if (str.indexOf(at)==-1){
		alert("Please enter a valid email address.");
		return false;
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		alert("Please enter a valid email address.");
		return false;
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Please enter a valid email address.");
		return false;
	}

	if (str.indexOf(at,(lat+1))!=-1){
		alert("Please enter a valid email address.");
		return false;
	}

	if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Please enter a valid email address.");
		return false;
	}

	if (str.indexOf(dot,(lat+2))==-1){
		alert("Please enter a valid email address.");
		return false;
	}

	if (str.indexOf(" ")!=-1){
		alert("Please enter a valid email address.");
		return false;
	}

	if (form.telephone.value == "") {
		alert( "Please enter a valid telephone number." );
		form.telephone.focus();
		return false ;
	}
	if (form.city.value == "") {
		alert( "Please enter your current city." );
		form.city.focus();
		return false ;
	}

	return true;
}

// returns value selected from radio set
function wpss_getCheckedValue(radioObj) {
	if(!radioObj){
  	return "true";
	}
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
		  return true;
		}
	}
	return "";
}


(function($) { 
  $(function() {
  
    // make sure all required fields are not empty
    $("#wpssform").submit(function(e){
      $("#wpssform .infoForm input.wpss_required").each( function() {
        if($(this).val() == ""){
          alert($(this).attr('alt')+" cannot be blank.");
          e.preventDefault();
          return false;
        }
   	  });
    });
    
  });
})(jQuery);

/*
	Any site-specific scripts you might have.
	Note that <html> innately gets a class of "no-js".
	This is to allow you to react to non-JS users.
	Recommend removing that and adding "js" as one of the first things your script does.
	Note that if you are using Modernizr, it already does this for you. :-)
*/
jQuery(document).ready(function($){
	$("html").removeClass("no-js");
	
	$(document).ready(function() {
		$(".wp-caption a").each(function(){
			var href=$(this).attr("href")
			var ext=href.substr(href.length-3,3);
			if(ext=="jpg" || ext=="png" || ext=="gif"){
				$(this).fancybox({
					closeClick: true
				});
			}
		});
	});
	
	$("#selectmenu-primary").change(function(){
		window.location=$(this).val();
	});
	
	$(".menu-item-792").append('<a id="rss-link" href="http://sachagreif.com/feed/atom/">Subscribe to the RSS feed</a>');
	
	$("h1.entry-title").each(function(){
		var title=$(this);
		var height=title.height();
		// console.log("1 "+height);
		if(title.height()>=40){
			title.css("font-size","30px");
			// console.log("2 "+title.height());
			if(title.height()>=40){
				title.css("font-size","24px");
				// console.log("3 "+title.height());
			}
			title.css("line-height","36px");
		}
	});
	
	currentPageTitle=encodeURIComponent($(this).attr('title').replace(" | SachaGreif.com",""));
	currentPageURL=encodeURIComponent(window.location);
	if($('#twitter').length){
		$('#twitter').sharrre({
		  share: {
		    twitter: true
		  },
		  title: 'Tweet',
		  text: currentPageTitle,
		  enableHover: false,
		  shorterTotal: false,
		  buttons: { twitter: {via: 'SachaGreif'}},
		  click: function(api, options){
			api.openPopup('twitter');
		  }
		});
	}
	if($('#facebook').length){
		$('#facebook').sharrre({
		  share: {
		    facebook: true
		  },
		  title: 'Like',
		  text: currentPageTitle,
		  enableHover: false,
		  shorterTotal: false,
		  click: function(api, options){
			api.openPopup('facebook');
		  }
		});
	}
	if($('#googleplus').length){
		$('#googleplus').sharrre({
		  share: {
		    googlePlus: true
		  },
		  title: '+1',
		  text: currentPageTitle,
		  enableHover: false,
		  shorterTotal: false,
		  urlCurl: '/wp-content/themes/sgv3/sharrre.php',
		  click: function(api, options){
			api.openPopup('googlePlus');
		  }
		});
	}
});

function disqus_config() {
	if($('#disqus_thread').length){
	    this.callbacks.afterRender = [function() {
		        $('#disqus_thread li[style="margin-left:46px;"]').addClass("dsq-comment-child");
				$('.dsq-trackback-url').next().addClass("dsq-trackbacks");
	    }];
	}
}
$(function(){
	$("ul li:first-child").addClass("first");
	$("ul li:last-child").addClass("last");
	
	$("ul#agrilife-agency-tabs li span").click(function(){ 
		var $nextDiv = $(this).next("ul");
		var $visibleSiblings = $("ul#agrilife-agency-tabs li ul:visible");
		
		if ($visibleSiblings.length ) {
			$visibleSiblings.slideUp("fast", function() {
				$nextDiv.not(this).slideToggle("fast");
			});
		} else {
			$nextDiv.slideToggle("fast");
		}
		
		return false;
	});
	
	$("*").not("ul#agrilife-agency-tabs li span").click(function(){ 
		$("ul#agrilife-agency-tabs li ul:visible").slideUp("fast");
	});
	
	$("ul#agrilife-agency-tabs li ul").hoverIntent({    
		sensitivity: 50,      
		over: function(){},    
		timeout: 500,     
		out: function(){
				$(this).slideUp("fast");
			}    
	});
	
	//Init Children
	$("#sitenav ul li ul").not('#sitenav ul li ul li ul').parent("li").addClass("accordion").children("a").before(' <a class="expand"><span class="expand-arrow"></span></a>');
	//Init Grandchildren
	$('#sitenav ul li ul li ul').parent("li").addClass("accordion").children("a").before(' <a class="expand"><span class="expand-arrow-sub"></span></a>');
	//Set Default Open
	$('.current_page_item').parents('ul').addClass('open');
	$('.current_page_item ul').not('.current_page_item ul li ul').addClass('open');
	
	//Site-level Navigation
	$("#sitenav ul li.accordion ul").not("#sitenav ul li.accordion ul.open").hide();
	// toggle defaults
	$("#sitenav ul li.accordion ul.open li.current_page_item").parent("ul").siblings("a.expand").children("span").addClass("expanded").parent("a").parent("li").parent("ul").siblings("a.expand").children("span").addClass("expanded");		
	//toggle top-level parent selected
	$("#sitenav ul li.accordion ul.open li").not("#sitenav ul li.accordion ul.open li.current_page_item").parent("ul.open").siblings("a.expand").children("span").addClass("expanded");
	
	$("#sitenav ul li a.expand").click(function(){
		$(this).next("a").next("ul").slideToggle("slow").parent("li").siblings("li").children("ul:visible").slideUp("slow").siblings("a").children("span").removeClass("expanded"); 	
		$(this).children("span").toggleClass("expanded");
		return false;
	});


	// Home Slideshow (phase out: Q1 '11
	if(jQuery().cycle) {
		$('.pics p,.pics-nav').show();
		$('.pics').cycle({
			timeout: 6000,
			delay:  -2000,
			next: '#next',
			prev: '#prev'
		});
	};
	
	
	// Home Scrollers (phase out: Q1 '11)
	$("#news-scroll").jScrollPane();	
	$("#topics-scroll-box ul").width($("#topics-scroll-box ul li").width() * $("#topics-scroll-box ul").children().size());
	$("#topics-scroll-box").jScrollHorizontalPane();

	
	$(".tabs a").click(function(){
		$(".tabs a, .tab, #featuresnav").toggleClass("active");
		return false;
	});

	// Header-Nav
	$("div#agrilife-header-nav li a").not("div#agrilife-header-nav li li a").click(function(){ 
		$("div#agrilife-header-nav li a.sub").not(this).parent("li").removeClass("active");
		
		var $nextDiv = $(this).next("div.sub").children("ul");
		var $visibleSiblings = $("div#agrilife-header-nav li div.sub ul:visible");
		
		if ($visibleSiblings.length ) {
			$visibleSiblings.slideUp("fast", function() {
				$nextDiv.not(this).slideToggle("fast");
			});
		} else {
			$nextDiv.slideToggle("fast");
		}
		
		$(this).parent("li").toggleClass("active");
		
		return false;
	});
	
	$("*").not("div#agrilife-header-nav li a").click(function(){ 
		$("div#agrilife-header-nav li div.sub ul:visible").slideUp("fast");
		$("div#agrilife-header-nav li div.sub ul:visible").parent("div.sub").prev("a.sub").parent("li").removeClass("active");
	});
	
	$("div#agrilife-header-nav li div.sub ul").hoverIntent({    
		sensitivity: 50,      
		over: function(){},    
		timeout: 500,     
		out: function(){
				$(this).slideUp("fast");
				$(this).parent("div.sub").prev("a.sub").parent("li").removeClass("active");
			}    
	});
	
	

});

